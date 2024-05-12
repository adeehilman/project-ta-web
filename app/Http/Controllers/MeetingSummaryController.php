<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\SummaryMeetingExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Client;

class MeetingSummaryController extends Controller
{
    public function index(Request $request)
    {
        $q = 'SELECT * FROM tbl_deptcode ORDER BY dept_name';
        $list_dept = DB::select($q);

        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_rolemeeting')
                ->select('name')
                ->where('id', session()->get('loggedInUser')['session_roles'])
                ->first()->name,

            'list_dept' => $list_dept,
        ];

        return view('meetingreport.meetingsummary.index', $data);
    }

    public function getList(Request $request)
    {
        $txSearch = '%' . trim($request->txSearch) . '%';

        // filter by tahun

        $tahun = $request->tahunDropdown;
        // dd($tahun);

        $month = $request->monthFilter;
        $deptCode = $request->deptFilter;

        $timestamp = strtotime($month);

        if ($timestamp !== false) {
            $monthNumber = date('n', $timestamp);
        } else {
            $monthNumber = '';
        }

        $yFilter = '';
        // filter tahun
        if ($tahun > 0) {
            $yFilter .= " AND YEAR(meeting_date) = '$tahun'";
        } else {
            $yFilter .= '';
        }

        $mFilter = '';
        // filter bulan
        if ($monthNumber > 0) {
            $mFilter .= " AND MONTH(tm.meeting_date) = '$monthNumber'";
        } else {
            $mFilter .= '';
        }

        // filter Departemen
        $dFilter = '';
        if ($deptCode > 0) {
            $dFilter .= " AND k.dept_code = '$deptCode'";
        } else {
            $dFilter .= '';
        }

        $query = "
            SELECT
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
                WHERE (fullname LIKE '$txSearch' OR participant LIKE '$txSearch' OR dept_name LIKE '$txSearch') $yFilter $mFilter $dFilter
                AND statusmeeting_id = '5'
            GROUP BY
                p.participant,
                k.fullname,
                k.dept_code,
                dept.dept_name
            ORDER BY
                k.fullname ASC;";
        $data = DB::select($query);
        // dd($data);
        $output = '';
        $output .= '
            <table id="tableSummary" class="table table-responsive table-hover" style="font-size: 16px">
                <thead>
                    <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                            <th class="p-3" scope="col">Name</th>
                            <th class="p-3" scope="col">Employee No</th>
                            <th class="p-3" scope="col">Department</th>
                            <th class="p-3" scope="col">Total Meetings</th>
                            <th class="p-3" scope="col">Total Attendance</>
                            <th class="p-3" scope="col">Total Absent</th>
                            <th class="p-3" scope="col">Action</th>
                        </tr>
                </thead>
                <tbody>
        ';
        $no = 1;
        foreach ($data as $key => $item) {
            // $statusBadge = $item->status_name_eng == 'Canceled' ? '<p class="badge bg-danger">' . $item->status_name_eng . '</p>' : $item->status_name_eng;

            $output .=
                '
                <tr>
                    <td class="p-3">' .
                $item->fullname .
                '</td>
                    <td class="p-3">' .
                $item->participant .
                '</td>
                    <td class="p-3">' .
                $item->dept_name .
                '</td>
                    <td class="p-3">' .
                $item->tot_meeting .
                '</td>
                <td class="p-3">' .
                $item->kehadiran .
                '</td>
                <td class="p-3">' .
                $item->absent .
                '</td>
                <td>
                            <a href="' .
                url('/meetingsummary/detailSummary?participant=' . $item->participant . '&date=' . $item->meeting_dates) .
                '" id="btnInfo" class="btn btnInfo"><img src="' .
                asset('icons/eye.svg') .
                '"></a>
                        </td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
        return $output;
    }

    public function export(Request $request)
    {
        $txSearch = '%' . trim($request->txSearch) . '%';

        // dd($txSearch);
        // dd($request);
        $sessionLogin = session('loggedInUser');
        $divisiId = $sessionLogin['session_badge'];

        $tahun = $request->tahunDropdown;
        // dd($tahun);

        $month = $request->monthFilter;
        $deptCode = $request->deptFilter;

        $timestamp = strtotime($month);

        if ($timestamp !== false) {
            $monthNumber = date('n', $timestamp);
        } else {
            $monthNumber = '';
        }

        $yFilter = '';
        // filter tahun
        if ($tahun > 0) {
            $yFilter .= " AND YEAR(meeting_date) = '$tahun'";
        } else {
            $yFilter .= '';
        }

        $mFilter = '';
        // filter bulan
        if ($monthNumber > 0) {
            $mFilter .= " AND MONTH(tm.meeting_date) = '$monthNumber'";
        } else {
            $mFilter .= '';
        }

        // filter Departemen
        $dFilter = '';
        if ($deptCode > 0) {
            $dFilter .= " AND k.dept_code = '$deptCode'";
        } else {
            $dFilter .= '';
        }

        // dd($yFilter, $monthNumber, $dFilter, $mFilter);
        return Excel::download(new SummaryMeetingExport($txSearch, $divisiId, $yFilter, $monthNumber, $dFilter, $mFilter), 'Meeting_Summary_Report.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
