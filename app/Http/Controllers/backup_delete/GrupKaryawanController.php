<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class GrupKaryawanController extends Controller
{
    public function index()
    {

        $data = [
            'userInfo' => DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser'))->first(), 
            'userRole' => (int)session()->get('loggedInUser')['session_roles'], 
            'positionName' => DB::table('tbl_vlookup')->select('name_vlookup')->where('id_vlookup', session()->get('loggedInUser')['session_roles'])->first()->name_vlookup,
            'userRole' => (int)session()->get('loggedInUser')['session_roles'],
        ];
        return view('karyawan.grup', $data);
    }


    public function dept_list()
    {

        $output = "";

        $q = "SELECT dept_code, dept_name, pt, total_dept FROM (
            SELECT DISTINCT 
            kt.dept_code, 
            (SELECT dept_name FROM tbl_deptcode WHERE dept_code=kt.dept_code) AS dept_name, 
            (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=kt.pt) AS pt, 
            COUNT(kt.dept_code) total_dept FROM `tbl_karyawan` kt GROUP BY kt.dept_code, kt.pt) AS a WHERE dept_code <> '-'";

        $dataDept = DB::select($q);

        $output .= 
        '
        <table style="font-size: 18px;" id="tableDeptCode" class="table table-responsive table-hover">
            <thead>
                <tr style="color: #CD202E; height: -10px;" class="table-danger">
                    <th class="p-3" scope="col">Dept. Code</th>
                    <th class="p-3" scope="col">Nama</th>
                    <th class="p-3" scope="col">PT</th>
                    <th class="p-3" scope="col">Jumlah Anggota</th>
                </tr>
            </thead>
            <tbody>
        ';

        if($dataDept){

            foreach($dataDept as $row){

                $output .= 
                '
                <tr style="font-size: 18px;" onclick="showGrupInfo(\'' . $row->dept_code . '\', \'' . $row->dept_name . '\', \'' . $row->pt . '\', ' . $row->total_dept . ')" 
                data-bs-toggle="modal" data-bs-target="#modalDataTableDepart">
                    <td class="p-3">' . $row->dept_code . '</td>
                    <td class="p-3">' . $row->dept_name . '</td>
                    <td class="p-3">' . $row->pt . '</td>
                    <td class="p-3">' . $row->total_dept . '</td>
                </tr>
                ';

            }
            $output .= "</tbody></table>";
        }
        return $output;        
    }


    public function line_list()
    {
        $output = "";

        $q = "select line_code, total, dept_name from (
            select distinct 
            kt.line_code, 
            count(line_code) as total, 
            (select dept_name from tbl_deptcode where dept_code=kt.dept_code) as dept_name 
            from `tbl_karyawan` kt GROUP BY kt.line_code, kt.dept_code) as a WHERE line_code <> '-' ";

        $dataLine = DB::select($q);

        $output .= 
        '
        <table style="font-size: 18px;" id="tableLineCode" class="table table-responsive table-hover">
            <thead>
                <tr style="color: #CD202E; height: -10px;" class="table-danger">
                    <th class="p-3" scope="col">Line Code</th>                    
                    <th class="p-3" scope="col">Department</th>
                    <th class="p-3" scope="col">Jumlah Anggota</th>
                </tr>
            </thead>
            <tbody>
        ';

        if($dataLine){

            foreach($dataLine as $row){

                $output .= 
                '
                <tr onclick="showLineInfo(\'' . $row->line_code . '\', \'' . $row->total . '\', \'' . $row->dept_name . '\')"
                data-bs-toggle="modal" data-bs-target="#modalDataTableLineCode">
                    <td class="p-3">' . $row->line_code . '</td>
                    <td class="p-3">' . $row->dept_name . '</td>
                    <td class="p-3">' . $row->total . '</td>
                </tr>
                ';
            }
            $output .= "</tbody></table>";
        }
        return $output;        
    }
}
