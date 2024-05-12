<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\RoomSummaryExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Client;

class RoomSummaryController extends Controller
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

        return view('meetingreport.roomsummary.index', $data);
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
                SELECT rm.room_name, rm.id, COUNT(tm.id) as meeting_count,
                GROUP_CONCAT(DISTINCT tm.meeting_date ORDER BY tm.meeting_date ASC SEPARATOR ', ') AS meeting_dates
        FROM tbl_roommeeting rm
        LEFT JOIN tbl_meeting tm ON rm.id = tm.roommeeting_id
        WHERE (room_name LIKE '$txSearch') AND tm.statusmeeting_id = '5' $yFilter $mFilter $dFilter
        GROUP BY rm.room_name, rm.id
        ORDER BY
                CAST(SUBSTRING_INDEX(room_name, ' ', -1) AS UNSIGNED), room_name
";
        $data = DB::select($query);
        // dd($data);
        $output = '';
        $output .= '
        <table id="tableSummary" class="table table-responsive table-hover" style="font-size: 16px">
            <thead>
                <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                        <th class="p-3" scope="col">Room</th>
                        <th class="p-3" scope="col">Total Meetings</th>
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
                $item->room_name .
                '</td>
            <td class="p-3">' .
                $item->meeting_count .
                '</td>
                <td>
                            <a href="' .
                url('/roomsummary/detailSummary?id=' . $item->id . '&date=' . $item->meeting_dates) .
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

        // dd($yFilter, $monthNumber, $mFilter, $txSearch);
        return Excel::download(new RoomSummaryExport($txSearch, $divisiId, $yFilter, $monthNumber, $mFilter), 'Room_Summary_Report.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
