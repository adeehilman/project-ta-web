<?php

namespace App\Http\Controllers;
use App\Exports\DetailSummaryMeetingExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class DetailMeetingSummaryContoller extends Controller
{
    // function index return view
    public function index(Request $request)
    {
        $participant = $request->input('participant');
        $date = $request->input('date');

        // dd($date);
        $dateArray = explode(', ', $date);
        $DateStr = "'" . implode("','", $dateArray) . "'";

        if (count($dateArray) > 1) {
            $months = array_unique(
                array_map(function ($d) {
                    return date('F Y', strtotime($d));
                }, $dateArray),
            );

            if (count($months) > 1) {
                $startMonth = 'January ' . date('Y', strtotime(reset($dateArray)));
                $endMonth = date('F Y', strtotime(end($dateArray)));
                $formattedDate = $startMonth . ' s/d ' . $endMonth;
            } else {
                $formattedDate = reset($months);
            }
        } else {
            $formattedDate = date('F Y', strtotime($dateArray[0]));
        }

        // dd($formattedDate);

        // query untuk data diatas tabel
        $query_total = "SELECT
                p.participant,
                k.fullname,
                k.dept_code,
                dept.dept_name,
                GROUP_CONCAT(DISTINCT tm.meeting_date ORDER BY tm.meeting_date ASC SEPARATOR ', ') AS meeting_dates,
                COUNT(*) AS tot_meeting,
                SUM(CASE WHEN p.kehadiran = '1' THEN 1 ELSE 0 END) AS kehadiran,
                SUM(CASE WHEN p.kehadiran = '0' THEN 1 ELSE 0 END) AS absent
            FROM
                tbl_participant p
            INNER JOIN
                tbl_karyawan k ON k.badge_id = p.participant
            INNER JOIN
                tbl_deptcode dept ON dept.dept_code = k.dept_code
            INNER JOIN
                tbl_meeting tm ON tm.id = p.meeting_id
            WHERE p.participant = '$participant'
            AND tm.meeting_date IN ($DateStr)
            AND statusmeeting_id = '5'
            GROUP BY
                p.participant,
                k.fullname,
                k.dept_code,
                dept.dept_name
            ORDER BY
                k.fullname ASC
        ";
        $list_total = DB::select($query_total);

        // query untuk list tabel
        $query_detail = "SELECT * , tm.id AS meetingId
        , (SELECT room_name FROM tbl_roommeeting r WHERE r.id = tm.roommeeting_id)AS room_name
        FROM tbl_meeting tm
        INNER JOIN tbl_participant p ON p.meeting_id = tm.id
        WHERE p.participant = '$participant'
        AND meeting_date IN ($DateStr)
        AND statusmeeting_id = '5'
        ";
        $list_data = DB::select($query_detail);
        // dd($participant, $date);
        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')
                ->select('name_vlookup')
                ->where('id_vlookup', session()->get('loggedInUser')['session_roles'])
                ->first()->name_vlookup,
            'list_data' => $list_data,
            'total' => $list_total[0],
            'time' => $formattedDate,
        ];

        return view('meetingreport.meetingsummary.detailsummary.detailSummary', $data);
    }

    // function export meeting di detail summary meeting
    public function exportDetail(Request $request)
    {
        $ParticipantBadge = $request->ParticipantBadge;
        $Fullname = $request->Fullname;
        $DeptName = $request->DeptName;
        $TimeDetail = $request->TimeDetail;
        $date = $request->TimeDB;
        $TotMeeting = $request->TotMeeting;
        $Kehadiran = $request->Kehadiran;
        $Absent = $request->Absent;

        $dateArray = explode(', ', $date);
        $timeDB = "'" . implode("','", $dateArray) . "'";

        return Excel::download(new DetailSummaryMeetingExport($ParticipantBadge, $Fullname, $TimeDetail, $DeptName, $timeDB, $TotMeeting, $Kehadiran, $Absent), 'Detail_Meeting_Summary_Report.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
