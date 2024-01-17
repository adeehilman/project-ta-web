<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Exports\DetailPersonExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class DetailInternshipController extends Controller
{
    public function index(Request $request)
    {
        $badge_id = $request->input('badge_id');
        $date = date('m', strtotime($request->input('date')));

        $monthfilter = $request->monthFilter;
   
        // dd($monthfilter);
        if($monthfilter){
            $monthFilter = $request->monthFilter;
        }else{
            $monthfilter = $date;
        }

        /**
         * Data Total Attend, Nama ,Dept dll
         * **/
        $InfoData = "SELECT
            k.badge_id,
            k.fullname,
            (SELECT dept_name FROM tbl_deptcode dc WHERE dc.dept_code = k.dept_code) AS dept_name,
            COUNT(*) AS total_records,
            SUM(CASE WHEN a.status = 'Present' THEN 1 ELSE 0 END) AS total_present,
            SUM(CASE WHEN a.status = 'Absent' THEN 1 ELSE 0 END) AS total_absent,
            SUM(CASE WHEN a.status = 'Sick' THEN 1 ELSE 0 END) AS total_sick,
            SUM(CASE WHEN a.status = 'Permission' THEN 1 ELSE 0 END) AS total_permission,
            SUM(
                CASE
                    WHEN a.status IN ('Absent', 'Sick', 'Permission') THEN 1
                    ELSE 0
                END
            ) AS total_not_attend
        FROM tbl_absensiinternship a
        JOIN tbl_karyawan k ON a.badge_id = k.badge_id
        WHERE MONTH(a.submit_date) = '$date'
        AND a.badge_id = '$badge_id'
        GROUP BY k.badge_id, k.fullname, k.dept_code
        ORDER BY total_records DESC, total_present DESC, total_absent DESC, total_sick DESC, total_permission DESC;
        ";
        $attend_name = DB::SELECT($InfoData);

        // Kirim kembali ke sisi client
        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')
                ->select('name_vlookup')
                ->where('id_vlookup', session()->get('loggedInUser')['session_roles'])
                ->first()->name_vlookup,
            'attend' => $attend_name[0],
        ];

        return view('internship.detailinternship.detailInternship', $data);
    }

    public function getList(Request $request)
    {
        $badge_id = $request->badge_id;
        $monthFilter = $request->monthFilter ? $request->monthFilter : date('m');
        $yearFilter = $request->yearFilter ? $request->yearFilter : date('Y');

        /**
         * Data table per Monthly
         **/
        $query = "SELECT a.*, k.fullname  AS updatebyname from tbl_absensiinternship a LEFT JOIN tbl_karyawan k ON a.updateby = k.badge_id
        WHERE a.badge_id = '$badge_id'
        AND MONTH(submit_date) = $monthFilter
        AND YEAR(submit_date) = $yearFilter
        ORDER BY submit_date ASC, scanin ASC";
        $data = DB::SELECT($query);

        $output = '';
        $output .= '
            <table id="tableDetailIntern" class="table table-responsive table-hover" style="font-size: 16px">
                <thead>
                            <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                                <th class="p-3" scope="col">Tanggal</th>
                                <th class="p-3" scope="col">Time In</th>
                                <th class="p-3" scope="col">Time Out</th>
                                <th class="p-3" scope="col">Status</th>
                                <th class="p-3" scope="col">Update By</th>
                                <th class="p-3" scope="col">Action</th>
                            </tr>
                        </thead>
                <tbody>
        ';
        foreach ($data as $key => $item) {
            $attachment = $item->attachment
                ? '<a id="btnAttach" class="btn btnAttach" data-id=' .
                    $item->badge_id .
                    ' data-date=' .
                    $item->submit_date .
                    ' data-date=' .
                    $item->submit_date .
                    '><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M14 2.26953V6.40007C14 6.96012 14 7.24015 14.109 7.45406C14.2049 7.64222 14.3578 7.7952 14.546 7.89108C14.7599 8.00007 15.0399 8.00007 15.6 8.00007H19.7305M16 13H8M16 17H8M10 9H8M14 2H8.8C7.11984 2 6.27976 2 5.63803 2.32698C5.07354 2.6146 4.6146 3.07354 4.32698 3.63803C4 4.27976 4 5.11984 4 6.8V17.2C4 18.8802 4 19.7202 4.32698 20.362C4.6146 20.9265 5.07354 21.3854 5.63803 21.673C6.27976 22 7.11984 22 8.8 22H15.2C16.8802 22 17.7202 22 18.362 21.673C18.9265 21.3854 19.3854 20.9265 19.673 20.362C20 19.7202 20 18.8802 20 17.2V8L14 2Z" stroke="#60625D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg></a>  '
                : '';

            $scanin = $item->scanin ? date('H:i', strtotime($item->scanin)) : '-';
            $scanout = $item->scanout ? date('H:i', strtotime($item->scanout)) : '-';
            $highlightClass = $item->status == 'OFF' ? 'style="background-color: #f8d7da;"' : '';
            $highlightStatus = $item->status == 'Absent' ? '<p class="badge bg-danger">' . $item->status . '</p>' : $item->status;

            $output .=
                '
                <tr>
                    <td class="p-3"'.$highlightClass.'>' .
                date('d F Y', strtotime($item->submit_date)) .
                '</td>
                <td class="p-3" '.$highlightClass.'>' .
                $scanin .
                '</td>
                <td class="p-3" '.$highlightClass.'>' .
                $scanout .
                '</td>
                <td class="p-3" '.$highlightClass.'>' .
                $highlightStatus .
                '</td>
                <td class="p-3" '.$highlightClass.'>' .
                    $item->updateby.' - '.$item->updatebyname.
                '</td>
                <td '.$highlightClass.'>
                    <a id="btnEdit" class="btn btnEdit" data-id=' .
                $item->badge_id . ' data-date=' .
                $item->submit_date . 
                '><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 22.525C3.45 22.525 2.979 22.3293 2.587 21.938C2.195 21.5467 1.99934 21.0757 2 20.525V6.525C2 5.975 2.196 5.504 2.588 5.112C2.98 4.72 3.45067 4.52433 4 4.525H12.925L10.925 6.525H4V20.525H18V13.575L20 11.575V20.525C20 21.075 19.804 21.546 19.412 21.938C19.02 22.33 18.5493 22.5257 18 22.525H4ZM15.175 5.1L16.6 6.5L10 13.1V14.525H11.4L18.025 7.9L19.45 9.3L12.825 15.925C12.6417 16.1083 12.429 16.2543 12.187 16.363C11.945 16.4717 11.691 16.5257 11.425 16.525H9C8.71667 16.525 8.479 16.429 8.287 16.237C8.095 16.045 7.99934 15.8077 8 15.525V13.1C8 12.8333 8.05 12.579 8.15 12.337C8.25 12.095 8.39167 11.8827 8.575 11.7L15.175 5.1ZM19.45 9.3L15.175 5.1L17.675 2.6C18.075 2.2 18.5543 2 19.113 2C19.6717 2 20.1423 2.2 20.525 2.6L21.925 4.025C22.3083 4.40833 22.5 4.875 22.5 5.425C22.5 5.975 22.3083 6.44167 21.925 6.825L19.45 9.3Z" fill="#60625D"/>
                        </svg></a>' .
                $attachment .
                '
                        </td>
                </tr>
            ';
        }
        $output .= '</tbody></table>';
        return $output;
    }

    public function filterDesc(Request $request){
        $yearFilter = $request->yearFilter;
        $monthfilter = $request->monthFilter;
        $badge_id = $request->badge_id;
        // dd($monthfilter);

        /**
         * Data Total Attend, Nama ,Dept dll
         * **/
        $InfoData = "SELECT
            k.badge_id,
            k.fullname,
            (SELECT dept_name FROM tbl_deptcode dc WHERE dc.dept_code = k.dept_code) AS dept_name,
            COUNT(*) AS total_records,
            SUM(CASE WHEN a.status = 'Present' THEN 1 ELSE 0 END) AS total_present,
            SUM(CASE WHEN a.status = 'Absent' THEN 1 ELSE 0 END) AS total_absent,
            SUM(CASE WHEN a.status = 'Sick' THEN 1 ELSE 0 END) AS total_sick,
            SUM(CASE WHEN a.status = 'Permission' THEN 1 ELSE 0 END) AS total_permission,
            SUM(
                CASE
                    WHEN a.status IN ('NSI', 'Sick', 'Permission') THEN 1
                    ELSE 0
                END
            ) AS total_not_attend
        FROM tbl_absensiinternship a
        JOIN tbl_karyawan k ON a.badge_id = k.badge_id
        WHERE MONTH(a.submit_date) = '$monthfilter'
        AND YEAR(a.submit_date) = '$yearFilter'
        AND a.badge_id = '$badge_id'
        GROUP BY k.badge_id, k.fullname, k.dept_code
        ORDER BY total_records DESC, total_present DESC, total_absent DESC, total_sick DESC, total_permission DESC;
        ";
        $attend_name = DB::SELECT($InfoData);
        return response()->json([
            'viewValue' => $attend_name[0],
        ]);
    }

    public function personExport(Request $request){
        // dd($request->all());
        $badge_id = $request->badge_id;
        $monthFilter = $request->monthFilter;
        $yearFilter = $request->yearFilter;
       
        // ambil total present dll
        $InfoData = "SELECT
            k.badge_id,
            k.fullname,
            (SELECT dept_name FROM tbl_deptcode dc WHERE dc.dept_code = k.dept_code) AS dept_name,
            COUNT(*) AS total_records,
            SUM(CASE WHEN a.status = 'Present' THEN 1 ELSE 0 END) AS total_present,
            SUM(CASE WHEN a.status = 'Absent' THEN 1 ELSE 0 END) AS total_absent,
            SUM(CASE WHEN a.status = 'Sick' THEN 1 ELSE 0 END) AS total_sick,
            SUM(CASE WHEN a.status = 'Permission' THEN 1 ELSE 0 END) AS total_permission,
            SUM(
                CASE
                    WHEN a.status IN ('Absent', 'Sick', 'Permission') THEN 1
                    ELSE 0
                END
            ) AS total_not_attend
        FROM tbl_absensiinternship a
        JOIN tbl_karyawan k ON a.badge_id = k.badge_id
        WHERE MONTH(a.submit_date) = '$monthFilter'
        AND YEAR(a.submit_date) = '$yearFilter'
        AND a.badge_id = '$badge_id'
        GROUP BY k.badge_id, k.fullname, k.dept_code
        ORDER BY total_records DESC, total_present DESC, total_absent DESC, total_sick DESC, total_permission DESC;
        ";
        $attend_name = DB::SELECT($InfoData);
        
        // dd($attend_name[0]->total_absent);

        $badge_id = $attend_name[0]->badge_id;
        $name = $attend_name[0]->fullname;
        $dept = $attend_name[0]->dept_name;
        $total_absent = $attend_name[0]->total_absent;
        $total_not_attend = $attend_name[0]->total_not_attend;
        $total_present = $attend_name[0]->total_present;

        return Excel::download(new DetailPersonExport($badge_id,$name,$dept,$total_absent,$total_not_attend,$total_present, $monthFilter, $yearFilter), 'Employee_Internship.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
