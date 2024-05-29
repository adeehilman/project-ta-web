<?php

namespace App\Http\Controllers;

use App\Exports\DetailSummaryRoomExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Client;

class DetailRoomSummaryController extends Controller
{
    // function index return view
    public function index(Request $request)
    {
        $id = $request->input('id');
        $date = $request->input('date');

        // convert string to array
        $dateArray = explode(', ', $date);
        $DateStr = "'" . implode("','", $dateArray) . "'";
        if (count($dateArray) > 1) {
            $startMonth = 'January ' . date('Y', strtotime(reset($dateArray)));
            $endMonth = date('F Y', strtotime(end($dateArray)));
            $formattedDate = $startMonth . ' s/d ' . $endMonth;
        } else {
            $formattedDate = date('F Y', strtotime($dateArray[0]));
        }

        // query untuk data diatas tabel
        $query_detail = "SELECT rm.room_name, rm.id, COUNT(*) as meeting_count,  GROUP_CONCAT(DISTINCT tm.meeting_date ORDER BY tm.meeting_date ASC SEPARATOR ', ') AS meeting_dates
        FROM tbl_roommeeting rm
        LEFT JOIN tbl_meeting tm ON rm.id = tm.roommeeting_id
        WHERE tm.statusmeeting_id = '5'
        AND rm.id = '$id'
        AND tm.meeting_date IN ($DateStr)
        GROUP BY rm.room_name, rm.id
        ORDER BY
                CAST(SUBSTRING_INDEX(room_name, ' ', -1) AS UNSIGNED), room_name

        ";
        $list_data = DB::select($query_detail);

        // query untuk data table
        $datatable = "SELECT * , tm.id AS meetingId
        , (SELECT room_name FROM tbl_roommeeting r WHERE r.id = tm.roommeeting_id)AS room_name
        FROM tbl_meeting tm
        where statusmeeting_id = '5'
        AND roommeeting_id ='$id'
        AND meeting_date IN ($DateStr)
        ";
        $query_datatable = DB::select($datatable);

        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_rolemeeting')
                ->select('name')
                ->where('id', session()->get('loggedInUser')['session_roles'])
                ->first()->name,
            'total' => $list_data[0],
            'time' => $formattedDate,
            'table' => $query_datatable,
        ];

        return view('meetingreport.roomsummary.detailsummary.detailSummary', $data);
    }

    // function export meeting di detail summary room
    public function exportDetail(Request $request)
    {
        $HeadDataRoom = $request->HeadDataRoom;
        $TimeDetail = $request->TimeDetail;
        $date = $request->TimeDB;
        $TotMeeting = $request->TotMeeting;
        $IdRoom = $request->IdRoom;

        $dateArray = explode(', ', $date);
        $timeDB = "'" . implode("','", $dateArray) . "'";

        // dd($HeadDataRoom, $TimeDetail, $timeDB, $TotMeeting, $dateArray);
        // dd($timeDB);

        return Excel::download(new DetailSummaryRoomExport($HeadDataRoom, $TimeDetail, $timeDB, $TotMeeting, $IdRoom), 'Detail_Room_Summary_Report.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
