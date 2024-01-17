<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class InfoLineCodeController extends Controller
{
    public function index($id)
    {
        $output = "";

        $q = "SELECT a.fullname, a.badge_id, c.name_vlookup AS pt, b.dept_name, a.line_code, a.join_date, IF(a.password IS NULL, 'Tidak Terdaftar', 'Terdaftar') AS statusdaftar FROM tbl_karyawan a, tbl_deptcode b, tbl_vlookup c 
        WHERE a.dept_code  = b.dept_code AND a.pt = c.id_vlookup AND  a.line_code = '{$id}' ORDER BY fullname";
        $dataLine = DB::select($q);

        $data = array(
            'userInfo' => DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser'))->first(),
            'data' => $dataLine, 
            'positionName' => DB::table('tbl_vlookup')->select('name_vlookup')->where('id_vlookup', session()->get('loggedInUser')['session_roles'])->first()->name_vlookup,
            'userRole' => (int)session()->get('loggedInUser')['session_roles'],
        );
        return view('karyawan.infolinecode', $data);
    }
}
