<?php

namespace App\Http\Controllers;

use App\Models\SuggestionCriticism;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Completion\Suggestion;

class KritikController extends Controller
{
    // private function validateRequest(Request $request)
    // {
    //     return Validator::make($request->all(), [
    //         'kategori' => 'required',
    //         'deskripsi' => 'required',
    //         'mode' => 'required',
    //         'area' => 'required',
    //         'file_upload' => 'mimes:jpeg,png,jpg|max:1024',
    //     ], [
    //         'kategori.required' => 'Kategori tidak boleh kosong',
    //         'mode.required' => 'mode tidak boleh kosong',
    //         'area.required' => 'area tidak boleh kosong',
    //         'deskripsi.required' => 'Deskripsi tidak boleh kosong',
    //         'file_upload.mimes' => 'Format image harus jpeg, png, atau jpg',
    //         'file_upload.max' => 'Ukuran image tidak boleh lebih dari 1 mb',
    //     ]);
    // }

    public function index(Request $req)
    {
        
        $filter = $req->get('filter');

        $data = [
            'userInfo' => DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser'))->first(),
            'userRole' => (int)session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')->select('name_vlookup')->where('id_vlookup', session()->get('loggedInUser')['session_roles'])->first()->name_vlookup, 
            'filterData' => $filter ? $filter : null
        ];

        return view('kritik.kritik', $data);
    }

    public function kritik_list(Request $req)
    {
        $roles = (int)session()->get('loggedInUser')['session_roles'];
        
        $txSearch = '%' . strtoupper($req->get('txSearch')) . '%';
        $sKategori = intval($req->get('sKategori'));
        $sWaktu = intval($req->get('sWaktu'));
        $sStatus = intval($req->get('sStatus'));
        $fStatus = intval($req->get('fStatus'));

        

        $qFilter = '';

        if($sKategori == 41){
            $qFilter .= " AND kategori_id='41'";
        }
        if($sKategori == 42){
            $qFilter .= " AND kategori_id='42'";
        }

        // rentang waktu
        if($sWaktu == 1){
            $startDate = date('Y-m-d H:i:s', strtotime('-1 day'));
            $endDate = date('Y-m-d H:i:s');
            $qFilter .= " AND (createdate BETWEEN '$startDate' AND '$endDate')";
        }
        if($sWaktu == 7){
            $startDate = date('Y-m-d H:i:s', strtotime('-7 day'));
            $endDate = date('Y-m-d H:i:s');
            $qFilter .= " AND (createdate BETWEEN '$startDate' AND '$endDate')";
        }
        if($sWaktu == 30){
            $startDate = date('Y-m-d H:i:s', strtotime('-30 day'));
            $endDate = date('Y-m-d H:i:s');
            $qFilter .= " AND (createdate BETWEEN '$startDate' AND '$endDate')";
        }

        // filter tanggapi
        if($sStatus == 1 OR $fStatus == 1){
            $qFilter .= " AND status_kritiksaran < 4";
        }
        if($sStatus == 2){
            $qFilter .= " AND status_kritiksaran > 2";
        }
        
        $filterHide = "";
        if($roles != 64){
            $filterHide = "AND hidden = 0";
        }


        $output = '';
        $q = "SELECT id, status_kritiksaran, status_kritiksaran_name, fullname, kategori_id, kategori, description, file_upload, AREA, is_anonymous, createdate, createtime, hidden FROM (
            SELECT 
            tk.id, 
            tk.kategori as kategori_id, 
            (SELECT fullname FROM tbl_karyawan WHERE badge_id=tk.badge_id) AS fullname, 
            (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=tk.kategori) AS kategori, 
            tk.description, 
            tk.file_upload, 
            tk.area, 
            tk.status_kritiksaran, 
            (SELECT stat_title FROM tbl_statuskritiksaran WHERE id=tk.status_kritiksaran) AS status_kritiksaran_name, 
            tk.is_anonymous, 
            DATE(tk.createdate) as createdate, 
            TIME(tk.createdate) as createtime, 
            tk.hidden 
            FROM tbl_kritiksaran tk) AS a WHERE (UPPER(fullname) LIKE '$txSearch' OR UPPER(kategori) LIKE '$txSearch' OR UPPER(description) LIKE '$txSearch' OR UPPER(createdate) LIKE '$txSearch' OR UPPER(createtime) LIKE '$txSearch' OR UPPER(status_kritiksaran_name) LIKE '$txSearch') $qFilter $filterHide ORDER BY id DESC LIMIT 100";
        $data = DB::select($q);

        
        $colHide = "";
        $valHide = "";
        if($roles == 64){
            $colHide = '<th class="p-3 text-center" scope="col">Hide</th>';
        }

        $output .= 
        '
        <table id="tableKritik" class="table table-responsive table-hover" style="font-size: 18px;">
            <thead>
                <tr style="color: #CD202E; height: 10px;" class="table-danger">
                    <th class="p-3" scope="col">Pengirim</th>
                    <th class="p-3" scope="col">Kategori</th>
                    <th class="p-3" scope="col">Kritik dan Saran</th>
                    <th class="p-3" scope="col">Waktu Submit</th>
                    <th class="p-3" scope="col">Jam</th>
                    <th class="p-3" scope="col">Status</th>
                    ' . $colHide . '
                    <th class="p-3 text-center" scope="col">Detail</th>
                </tr>
            </thead>
            <tbody>
        ';

        if($data){

            foreach($data as $row){

                if($roles == 64){

                    $isCheck = intval($row->hidden) > 0 ? 'checked' : '';

                    $valHide = '<td class="p-3 text-center"><input data-id="' . $row->id . '" type="checkbox" class="form-check-input cKritikHide" ' . $isCheck . '></td>';
                }

                $name = intval($row->is_anonymous) > 0 ? 'Dirahasiakan' : $row->fullname;
                $statusKritik = intval($row->status_kritiksaran) == 4 ? '<i class="bx bxs-check-circle text-success"></i>' . $row->status_kritiksaran_name : $row->status_kritiksaran_name;

                $output .= 
                '
                <tr style="font-size: 18px;">
                    <td class="p-3">' . $name . '</td>
                    <td class="p-3">' . $row->kategori . '</td>
                    <td class="p-3" style="word-wrap: break-word !important; max-width:200px">' . $row->description . '</td>
                    <td class="p-3">' . date('d M Y', strtotime($row->createdate)) . '</td>
                    <td class="p-3">' . date('H:i', strtotime($row->createtime)) . '</td>
                    <td class="p-3">
                        ' . $statusKritik . '
                    </td>
                    ' . $valHide . '
                    <td class="text-center">
                        <a class="btn btnView" href="javascript:void(0)" data-id="' . $row->id . '"><i style="font-size: 24px;" class="bx bx-file-find text-muted"></i></a>
                    </td>
                </tr>
                ';
            }
        }else{
            $output = '<div class="text-center mt-5">Data tidak ditemukan</div>';
        }

        $output .= '</tbody></table>';

        return $output;
    }

    public function simpan_tanggapan_kritik(Request $req)
    {
        $dataTanggapan = $req->post('dataTanggapan');
        $kritikId = $req->post('kritikId');

        DB::beginTransaction();
        try {

            $data = array(
                'id_kritik' => $kritikId,
                'badge_id' => session('loggedInUser')['session_badge'],
                'respon' => $dataTanggapan,
                'waktu' => date('Y-m-d H:i:s')
            );

            // update status tbl_kritiksaran
            DB::table('tbl_kritiksaran')->where('id', $kritikId)->update(['status_kritiksaran' => 3]);

            DB::table('tbl_tanggapankritiksaran')->insert($data);
            
            // check data  riwayat
            $countData = DB::table('tbl_riwayatkritiksaran')->where(['id_kritiksaran' => $kritikId, 'status_riwayat' => 3])->count();

            $dataRiwayat = array(
                'id_kritiksaran' => $kritikId, 
                'status_riwayat' => 3, 
                'createby' => session('loggedInUser')['session_badge'],
                'createdate' => date('Y-m-d H:i:s')
            );
            if($countData < 1){
                DB::table('tbl_riwayatkritiksaran')->insert($dataRiwayat);
            }

            
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Tanggapan berhasil tersimpan'
            ]);

        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status'    => 400, 
                'message'   => 'gagal menyimpan' . $ex->getMessage()
            ]);
        }
    }


    // list tanggapan
    public function tanggapan_list_kritik(Request $req)
    {

        $idKritik = $req->get('idKritik');

        $qDataTanggapan = "SELECT
        (SELECT fullname FROM tbl_karyawan WHERE badge_id=tt.badge_id) as fullname, 
        (SELECT img_user FROM tbl_karyawan WHERE badge_id=tt.badge_id) as photo, 
        tt.respon, 
        tt.waktu  
        FROM tbl_tanggapankritiksaran tt WHERE tt.id_kritik=$idKritik ORDER BY tt.id DESC";
        $dataTanggapan = DB::select($qDataTanggapan);

        return response()->json([
            'status' => 200, 
            'dataTanggapan'=> $dataTanggapan
        ]);
    }


    // get kritik by id
    public function get_kritik_by_id(Request $req)
    {
        $dataId = $req->get('dataId');
        $qKritik = "SELECT 
        tk.id, 
        tk.kategori, 
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=tk.kategori) AS kategori_name, 
        tk.description, 
        tk.file_upload, 
        tk.badge_id, 
        tk.area, 
        tk.status_kritiksaran, 
        (SELECT stat_title FROM tbl_statuskritiksaran WHERE id=tk.status_kritiksaran) AS status_title, 
        tk.createdate, 
        tk.is_anonymous
        FROM tbl_kritiksaran AS tk WHERE tk.id = '$dataId'";
        $dataKritik = DB::select($qKritik);
        $idStatusPendaftaranMMS = '';

        $badge_id = '';
        if($dataKritik){
            $badge_id = $dataKritik[0]->badge_id;

            $idStatusPendaftaranMMS = $dataKritik[0]->status_kritiksaran;
        }

        $qKaryawan = "SELECT 
        tk.fullname, 
        tk.badge_id, 
        (SELECT dept_name from tbl_deptcode WHERE dept_code=tk.dept_code) AS dept_code, 
        (SELECT position_name FROM tbl_position WHERE position_code=tk.position_code) AS position_code, 
        tk.join_date 
        FROM tbl_karyawan AS tk WHERE tk.badge_id='$badge_id';
        ";
        $dataKaryawan = DB::select($qKaryawan);

        $qRiwayat = "SELECT 
        rw.id, 
        (SELECT stat_title FROM tbl_statuskritiksaran WHERE id=rw.status_riwayat) AS stat_title,
        (SELECT stat_desc FROM tbl_statuskritiksaran WHERE id=rw.status_riwayat) AS stat_desc,
        rw.createby, 
        rw.createdate 
        FROM tbl_riwayatkritiksaran rw WHERE rw.id_kritiksaran = '$dataId' ORDER BY rw.id ASC";
        $dataRiwayat = DB::select($qRiwayat);

        $qRiwayat2 = "SELECT * FROM tbl_statuskritiksaran WHERE id > $idStatusPendaftaranMMS";
        $dataRiwayat2 = DB::select($qRiwayat2);


        $qDataTanggapan = "SELECT
        (SELECT fullname FROM tbl_karyawan WHERE badge_id=tt.badge_id) as fullname, 
        (SELECT img_user FROM tbl_karyawan WHERE badge_id=tt.badge_id) as photo, 
        tt.respon, 
        tt.is_anonymous, 
        tt.waktu  
        FROM tbl_tanggapankritiksaran tt WHERE tt.id_kritik=$dataId ORDER BY tt.id DESC";
        $dataTanggapan = DB::select($qDataTanggapan);


        // if($dataMMS){

            return response()->json([
                'status' => 200, 
                'dataKritik' => $dataKritik, 
                'dataKaryawan' => $dataKaryawan, 
                'dataRiwayat' => $dataRiwayat,
                'dataTanggapan' => $dataTanggapan,
                'dataRiwayat2' => $dataRiwayat2
            ]);
        // }
    }


    public function selesai_kritik_saran(Request $req)
    {
        $valKritikId = $req->post('valKritikId');

        DB::beginTransaction();
        try {

            // check data  riwayat
            $dataKritik = DB::table('tbl_kritiksaran')->where(['id' => $valKritikId])->first();

            

            if($dataKritik){
                $statusKritikSaran = $dataKritik->status_kritiksaran;

                

                if($statusKritikSaran == 3){

                    // dd($valKritikId);
                    // set status kritik saran selesai
                    DB::table('tbl_kritiksaran')->where('id', $valKritikId)->update(['status_kritiksaran' => 4]);

                    $dataRiwayat = array(
                        'id_kritiksaran' => $valKritikId, 
                        'status_riwayat' => 4, 
                        'createby' => session('loggedInUser')['session_badge'],
                        'createdate' => date('Y-m-d H:i:s')
                    );

                    DB::commit();

                    DB::table('tbl_riwayatkritiksaran')->insert($dataRiwayat);

                    return response()->json([
                        'status' => 200,
                        'message' => 'Kritik Saran telah diselesaikan'
                    ]);

                }else{
                    return response()->json([
                        'status' => 400,
                        'message' => 'And belum menanggapi kritik dan saran ini'
                    ]);
                }

            
            }

            
            

        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status'    => 400, 
                'message'   => 'gagal menyimpan' . $ex->getMessage()
            ]);
        }

    }


    // fungsi update set hide kritik dan saran
    public function setHideKritik(Request $req)
    {
        try {
            DB::beginTransaction();

            $id = $req->post('id');
            $m = $req->post('m');

            if($m == "hide"){
                DB::table('tbl_kritiksaran')->where('id', $id)->update([
                    'hidden' => 1
                ]);
            }else{
                DB::table('tbl_kritiksaran')->where('id', $id)->update([
                    'hidden' => 0
                ]);
            }

            DB::commit();
            return response()->json([
                'status' => 200, 
                'response' => [
                    'message' => 'Kritik Saran telah disembunyikan'
                ]
            ]);
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status'    => 400, 
                'response' => [
                    'message'   => $ex->getMessage()
                ]
            ]);
        }
        
    }
}
