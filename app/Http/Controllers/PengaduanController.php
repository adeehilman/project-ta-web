<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index()
    {

        // $data = ['userInfo' => DB::table('tbl_user')->where('employee_no', session('loggedInUser'))->first()];
        $data = ['userInfo' => DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser'))->first()];

        return view('pengaduan.pengaduan', $data);
    }
}
