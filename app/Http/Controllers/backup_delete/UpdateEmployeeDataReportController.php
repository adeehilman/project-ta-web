<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DataReport;

use Illuminate\Http\Request;

class UpdateEmployeeDataReportController extends Controller
{
    //  
    public function index()
    {

        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')
                ->select('name_vlookup')
                ->where('id_vlookup', session()->get('loggedInUser')['session_roles'])
                ->first()->name_vlookup,
            'listdept' => DB::table('tbl_deptcode')
                ->select('dept_name')
                ->where('dept_name', 'not like', '%-%')
                ->orderBy('dept_name', 'asc')
                ->get()
        ];



        return view('updateEmpData.dataReport.indexdatareport', $data);
    }

    public function getlisreport(Request $request)
    {
        $txSearch = '%' . strtoupper(trim($request->txSearch)) . '%';
        $dept = $request->input('dept');
        $filter = $request->input('filter');
       
        // Jika $filter adalah null, gunakan tahun dan bulan saat ini
        if ($filter === null) {
            $tahunBulanSekarang = date('Y-m');
            list($tahun, $bulan) = explode('-', $tahunBulanSekarang);
        } else {
            list($tahun, $bulan) = explode('-', $filter);
        }


        $q = "SELECT
                    b.id,
                    b.badgeid,
                    b.namakaryawan,
                    b.deptcode,
                    b.deptname,
                    b.linecode,
                    b.kategori,
                    DATE_FORMAT(b.createdate, '%e %M %Y %h:%i %p') AS formatted_createdate,
                    DATE_FORMAT(b.updatedate, '%e %M %Y %h:%i %p') AS formatted_updatedate,
                    b.status
                FROM (
                    SELECT
                        a.id,
                        a.badgeid,
                        (SELECT fullname FROM tbl_karyawan WHERE badge_id = a.badgeid) AS namakaryawan,
                        (SELECT dept_code FROM tbl_karyawan WHERE badge_id = a.badgeid) AS deptcode,
                        (SELECT dept_name FROM tbl_deptcode WHERE dept_code = (SELECT dept_code FROM tbl_karyawan WHERE badge_id = a.badgeid)) AS deptname,
                        (SELECT line_code FROM tbl_karyawan WHERE badge_id = a.badgeid) AS linecode,
                        a.kategori,
                        a.createdate,
                        a.updatedate,
                        (SELECT stat_title FROM tbl_statuspengkinian WHERE id = a.status) AS status
                    FROM tbl_pengkiniandata a
                ) AS b
                WHERE
                    YEAR(b.createdate) = $tahun AND MONTH(b.createdate) = $bulan
                    AND (
                        UPPER(b.deptname) LIKE UPPER('%$dept%')
                        AND (
                            UPPER(b.badgeid) LIKE '%$request->txSearch%'
                            OR UPPER(b.namakaryawan) LIKE '%$request->txSearch%'
                            OR UPPER(b.deptcode) LIKE '%$request->txSearch%'
                            OR UPPER(b.deptname) LIKE '%$request->txSearch%'
                            OR UPPER(b.linecode) LIKE '%$request->txSearch%'
                            OR UPPER(b.kategori) LIKE '%$request->txSearch%'
                            OR UPPER(b.status) LIKE '%$request->txSearch%'
                        )
                    )
                ORDER BY
                    CASE
                        WHEN b.status = 'Data diperbarui' THEN 1
                        WHEN b.status = 'Ditolak' THEN 2
                        WHEN b.status = 'Selesai' THEN 3
                        ELSE 4
                    END;
                ";

            //  dd($q);


        $data = DB::select($q); 

        $output = '';
        $output .= '
            <table id="tablereportpengkinian" class="table table-responsive table-hover" style="font-size: 16px">
                <thead>
                    <tr style="color: #CD202E; height: 10px;" class="table-danger ">  
                        <th class="p-3" scope="col">No Badge</th>
                        <th class="p-3" scope="col">Nama karyawan</th>
                        <th class="p-3" scope="col">Dept Code</th>
                        <th class="p-3" scope="col">Departemen</th>
                        <th class="p-3" scope="col">Line Code</th>
                        <th class="p-3" scope="col">Kategori</th>
                        <th class="p-3" scope="col">Waktu Pengajuan</th>
                        <th class="p-3" scope="col">Waktu Pembaruan</th>
                        <th class="p-3" scope="col">Status</th>
                        <th class="p-3" scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
        ';
    
        foreach ($data as $key => $item) {

            $statusColor = '';
            switch ($item->status) {
                case 'Data diperbarui':
                    $statusColor = 'background-color: #B2D7F0; color: #000000;';
                    break;
                case 'Selesai':
                    $statusColor = 'background-color: #B9E9C8; color: #000000;';
                    break;
                case 'Ditolak':
                    $statusColor = 'background-color: ##F0BABE; color: #000000;';
                    break;
                default:
                    $statusColor = '';
            }

            $output .=
                '
                <tr>
                    <td class="p-3">' . ($item->badgeid ) .'</td>
                    <td class="p-3">' . ($item->namakaryawan ) .'</td>
                    <td class="p-3">' . ($item->deptcode ) .'</td>
                    <td class="p-3">' . ($item->deptname ) .'</td>
                    <td class="p-3">' . ($item->linecode ) .'</td>
                    <td class="p-3">' . ($item->kategori ) .'</td>
                    <td class="p-3">' . ($item->formatted_createdate ) .'</td>
                    <td class="p-3">' . ($item->formatted_updatedate ) .'</td>
                    <td class="p-3"><span style="' . $statusColor . ' border-radius: 5px; padding: 5px;">' . ($item->status) . '</span></td>
                    <td>
                    <a class="btn btnDetailSumDriver" data-id="' . $item->id . '" onclick="redirectToDetailPengkiniandata(' . $item->id . ')">
                       <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M23.0136 11.7722C22.9817 11.6991 22.2017 9.96938 20.4599 8.2275C18.8436 6.61313 16.0667 4.6875 11.9999 4.6875C7.93299 4.6875 5.15611 6.61313 3.53986 8.2275C1.79799 9.96938 1.01799 11.6962 0.986113 11.7722C0.954062 11.8442 0.9375 11.9221 0.9375 12.0009C0.9375 12.0798 0.954062 12.1577 0.986113 12.2297C1.01799 12.3019 1.79799 14.0316 3.53986 15.7734C5.15611 17.3878 7.93299 19.3125 11.9999 19.3125C16.0667 19.3125 18.8436 17.3878 20.4599 15.7734C22.2017 14.0316 22.9817 12.3047 23.0136 12.2297C23.0457 12.1577 23.0622 12.0798 23.0622 12.0009C23.0622 11.9221 23.0457 11.8442 23.0136 11.7722ZM11.9999 18.1875C9.05799 18.1875 6.48924 17.1169 4.36393 15.0066C3.473 14.1211 2.71908 13.1078 2.12705 12C2.71891 10.8924 3.47285 9.87932 4.36393 8.99438C6.48924 6.88313 9.05799 5.8125 11.9999 5.8125C14.9417 5.8125 17.5105 6.88313 19.6358 8.99438C20.5269 9.87932 21.2808 10.8924 21.8727 12C21.2755 13.1447 18.2811 18.1875 11.9999 18.1875ZM11.9999 7.6875C11.1469 7.6875 10.3132 7.94042 9.60397 8.41429C8.89478 8.88815 8.34204 9.56167 8.01563 10.3497C7.68923 11.1377 7.60383 12.0048 7.77023 12.8413C7.93663 13.6779 8.34735 14.4463 8.95047 15.0494C9.55358 15.6525 10.322 16.0632 11.1585 16.2296C11.9951 16.396 12.8622 16.3106 13.6502 15.9842C14.4382 15.6578 15.1117 15.1051 15.5856 14.3959C16.0594 13.6867 16.3124 12.8529 16.3124 12C16.3109 10.8567 15.856 9.76067 15.0476 8.95225C14.2392 8.14382 13.1432 7.68899 11.9999 7.6875ZM11.9999 15.1875C11.3694 15.1875 10.7532 15.0006 10.229 14.6503C9.7048 14.3001 9.29625 13.8022 9.055 13.2198C8.81374 12.6374 8.75062 11.9965 8.87361 11.3781C8.9966 10.7598 9.30018 10.1919 9.74596 9.7461C10.1917 9.30032 10.7597 8.99674 11.378 8.87375C11.9963 8.75076 12.6372 8.81388 13.2197 9.05513C13.8021 9.29639 14.2999 9.70494 14.6502 10.2291C15.0004 10.7533 15.1874 11.3696 15.1874 12C15.1874 12.8454 14.8515 13.6561 14.2538 14.2539C13.656 14.8517 12.8452 15.1875 11.9999 15.1875Z" fill="#60625D"/>
                        </svg>
                       </a>
                   </td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
        return $output;
    }


    public function exportreport(Request $request)
    {
       
        try {
            
            $search = $request->input('searchexportpengkinianreport');
            $dept = $request->input('deptexportpengkinianreport');
            $date = $request->input('dateexportpengkinianreport');

            if ($date === null) {
                $tahunBulanSekarang = date('Y-m');
                list($tahun, $bulan) = explode('-', $tahunBulanSekarang);
            } else {
                list($tahun, $bulan) = explode('-', $date);
            }

            return Excel::download(new DataReport( $search,$dept,$tahun,$bulan), 'Pengkinian_Data_Report.xlsx');
        } catch (\Throwable $th) {
            return dd($th);
        }
    }
}