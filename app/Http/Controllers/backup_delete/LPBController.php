<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LPBController extends Controller
{
    public function index()
    {
          $data = [
            'userInfo' => DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser'))->first(), 
            'userRole' => (int)session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')->select('name_vlookup')->where('id_vlookup', session()->get('loggedInUser')['session_roles'])->first()->name_vlookup,
        ];

        return view('device.lpb', $data);
    }

    public function list_pb(Request $req)
    {


        $txSearch = "%" . strtoupper($req->get('txSearch')) . "%";
    

        $output = "";
      

        $q = "SELECT fullname,badge_id,pt,dept_name,dept_code,line_code,position_name,jumlah_perangkat FROM (
            SELECT DISTINCT
            (SELECT fullname from tbl_karyawan WHERE badge_id=a.badge_id LIMIT 1) AS fullname, 
            (SELECT dept_code FROM tbl_karyawan WHERE badge_id=a.badge_id LIMIT 1) as dept_code, 
            a.badge_id,  
            (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=(SELECT pt FROM tbl_karyawan WHERE badge_id=a.badge_id LIMIT 1)) As pt, 
            (SELECT position_name FROM tbl_position WHERE position_code=(SELECT position_code FROM tbl_karyawan WHERE badge_id=a.badge_id LIMIT 1)) AS position_name, 
            (SELECT dept_name FROM tbl_deptcode WHERE dept_code=(SELECT dept_code FROM tbl_karyawan WHERE badge_id=a.badge_id LIMIT 1)) AS dept_name, 
            (SELECT line_code FROM tbl_karyawan WHERE badge_id=a.badge_id LIMIT 1) as line_code, 
            (SELECT COUNT(badge_id) FROM (SELECT badge_id, uuid_new, tipe_hp, merek_hp FROM tbl_device_temp WHERE badge_id=a.badge_id GROUP BY badge_id, uuid_new, tipe_hp, merek_hp ) AS a) AS jumlah_perangkat 
            from tbl_device_temp a) as c WHERE (UPPER(badge_id) LIKE '$txSearch' OR UPPER(fullname) 
            LIKE '$txSearch' OR UPPER(dept_code) LIKE '$txSearch' OR UPPER(dept_name) 
            LIKE '$txSearch' OR UPPER(line_code) LIKE '$txSearch' OR UPPER(pt) 
            LIKE '$txSearch' OR UPPER(jumlah_perangkat) LIKE '$txSearch') LIMIT 100";

        // $q = "SELECT * FROM tbl_karyawan_temp LIMIT 100";
        $pbData = DB::select($q);

        

        $output .= 
        '
        <table style="font-size: 18px;" id="tableListPB" class="table table-responsive table-hover">
            <thead>
                <tr style="color: #CD202E; height: 10px;" class="table-danger">
                    <th class="p-3" scope="col">Nama Lengkap Karyawan</th>
                    <th class="p-3" scope="col">Badge No.</th>
                    <th class="p-3" scope="col">PT</th>
                    <th class="p-3" scope="col">Department</th>
                    <th class="p-3" scope="col">Line Code</th>
                    <th class="p-3" scope="col">Jumlah Perangkat</th>
                    <th class="p-3" scope="col">Detail</th>
                </tr>
            </thead>
            <tbody>
            ';

        if($pbData){

            foreach($pbData as $row){

                $pt = $row->pt == "" ? '-' : $row->pt;
                $dept_name = $row->dept_name == "" ? '-' : $row->dept_name;
                $line_code = $row->line_code == "" ? '-' : $row->line_code;

                $output .= 
                '            
                <tr style="font-size: 18px;" class="viewProfile" data-id="' . $row->badge_id . '">
                    <th class="p-3">' . $row->fullname . '</th>
                    <td class="p-3">' . $row->badge_id . '</td>
                    <td class="p-3">' . $pt . '</td>
                    <td class="p-3">' . $dept_name . '</td>
                    <td class="p-3">' . $line_code . '</td>
                    <td class="p-3">' . $row->jumlah_perangkat . '</td>
                    <td class="p-3">
                        <a class="btn btnView" data-id="' . $row->badge_id . '"><i style="font-size: 24px;" class="bx bx-file-find text-muted"></i></a>
                    </td>
                </tr>
                ';
            }

            $output .= '</tbody></table>';

        }else{
            $output = '<div class="text-center mt-5">Data tidak ditemukan</div>';
        }


        return $output;
    
    }

    public function get_list_pb_by_badge(Request $req)
    {
        $badge = $req->get('badge');

        if($badge){

            $q = "SELECT badge_id, uuid_new, tipe_hp, merek_hp FROM tbl_device_temp WHERE badge_id='$badge' GROUP BY badge_id, uuid_new, tipe_hp, merek_hp ";
            $dataPB = DB::select($q);

            // old data
            $qOld = "SELECT tm.id, tm.uuid, tm.tipe_hp,
             (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=tm.merek_hp) AS merek_hp, 
             tm.imei1 FROM tbl_mms tm WHERE tm.badge_id='$badge' AND is_new_uuid='0'";
            $dataOld = DB::select($qOld);

            if($dataPB){
                return response()->json([
                    'status' => 200, 
                    'data' => $dataPB, 
                    'dataOld' => $dataOld
                ]);
            }
        }
    }

    public function update_pb(Request $req)
    {
        $idNew = $req->post('idNew');
        $newUuid = $req->post('newUuid');
        $idOld = $req->post('idOld');
        $oldUuid = $req->post('oldUuid');
        $badge = $req->post('badge');

        DB::beginTransaction();
        try {

            $dataOsTemp = DB::table('tbl_device_temp')->where('id', $idNew)->first();
            if($dataOsTemp){
                DB::table('tbl_mms')->where('id', $idOld)->update(['uuid' => $newUuid, 'is_new_uuid' => '1', 'versi_aplikasi' => $dataOsTemp->versi_aplikasi]);
            }else{
                DB::table('tbl_mms')->where('id', $idOld)->update(['uuid' => $newUuid, 'is_new_uuid' => '1']);
            }

            // DB::table('tbl_device_temp')->where('id', $idNew)->delete();
            DB::table('tbl_device_temp')->where(['badge_id' => $badge, 'uuid_new' => $newUuid])->delete();


            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Perangkat berhasil diupdate'
            ]);
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status'    => 400, 
                'message'   => 'gagal diupdate' . $ex->getMessage()
            ]);
        }
        
    }
}
