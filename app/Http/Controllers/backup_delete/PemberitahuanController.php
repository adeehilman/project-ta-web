<?php

namespace App\Http\Controllers;

use App\Models\EmployeeGroup;
use App\Models\Notification;
use App\Models\NotificationReceiver;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class PemberitahuanController extends Controller
{
    public function index()
    {
         $data = [
            'userInfo' => DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser'))->first(),
            'userRole' => (int)session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')->select('name_vlookup')->where('id_vlookup', session()->get('loggedInUser')['session_roles'])->first()->name_vlookup,
        ];

        return view('pemberitahuan.index', $data);
    }



    public function group_list()
    {
        $q = "SELECT * FROM tbl_grup";
        $data = DB::select($q);

        if($data){
            return response()->json([
                'status' => 200, 
                'data' => $data
            ]);
        }
    }

    public function simpan_pemberitahuan(Request $req)
    {

        
        $fileName = NULL;
        $file = $req->file('gambar');

        if($file){
            $fileName = time() . '.' . $file->extension();
            $file->move('img/', $fileName);
        }

        $kirimSkrng = $req->post('is_sent_now') == 'on' ? 1 : 0;

        DB::beginTransaction();

        try {

            $dateManual = $req->post('waktu_pemberitahuan') . ' ' . $req->post('jam_pemberitahuan') . ':00';

            if($kirimSkrng > 0){        
                $data = array(
                    'judul' => $req->post('txJudul'),
                    'waktu_pemberitahuan' => date('Y-m-d H:i:s'),
                    'deskripsi' => $req->post('txDeskripsi'),
                    'image' => $fileName,
                    'sent_by' => session('loggedInUser')['session_badge'],
                    'receive_by' => $req->post('selectGroup'),
                    'is_sent' => $kirimSkrng, 
                    'createdate' => date('Y-m-d H:i:s')
                );
                DB::table('tbl_pemberitahuan')->insert($data);
            }else{
                $data = array(
                    'judul' => $req->post('txJudul'),
                    'waktu_pemberitahuan' => date('Y-m-d H:i:s', strtotime($dateManual)),
                    'deskripsi' => $req->post('txDeskripsi'),
                    'image' => $fileName,
                    'sent_by' => session('loggedInUser')['session_badge'],
                    'receive_by' => $req->post('selectGroup'),
                    'is_sent' => $kirimSkrng, 
                    'createdate' => date('Y-m-d H:i:s')
                );
                DB::table('tbl_pemberitahuan')->insert($data);
            }


            // one signal


            // URL Endpoint API OneSignal
            $url = 'https://onesignal.com/api/v1/notifications';

            // Data untuk dikirim dalam permintaan
            $data = [
                'app_id' => 'ef44a0e1-1de9-48a0-b4c5-9e045d45c0cf',
                'included_segments' => ['All'],
                'headings' => [
                    'en' => $req->post('txJudul'),
                ],
                'contents' => [
                    'en' => 'Tap untuk baca lebih lanjut informasi ini.',
                    'name' => 'John Doe' // Tambahkan nama pengirim di sini
                ],
                'data' => [
                    'Category' => 'Pengumuman'
                ],
            ];

            // Konversi data ke format JSON
            $dataJson = json_encode($data);

            // Pengaturan opsi cURL
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Basic NmQ2ODI0YjEtNjZhYy00ZDA3LWJkMDEtY2ViZDJjZWNmMTk5',
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Eksekusi permintaan cURL
            $response = curl_exec($ch);

            // Periksa jika ada kesalahan dalam permintaan
            if (curl_errno($ch)) {
                $error = curl_error($ch);
                // Lakukan penanganan kesalahan yang sesuai
                // ...
            }

            // Mendapatkan informasi respons
            $info = curl_getinfo($ch);
            $httpCode = $info['http_code'];

            // Menutup koneksi cURL
            curl_close($ch);

            // end one signal

            DB::commit();
                return response()->json([
                        'status' => 200,
                        'message' => 'Data berhasil tersimpan', 
            ]);
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status'    => 401, 
                'message'   => 'gagal menyimpan' . $ex->getMessage(), 
            ]);

        }

        

        

        // $data = array(
        //     'judul' => $req->post('txJudul'),
        //     'waktu_pemberitahuan' => $req->post('is_sent_now') == 'on' ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($dateManual)),
        //     'deskripsi' => $req->post('txDeskripsi'),
        //     'image' => $fileName,
        //     'sent_by' => session('loggedInUser')['session_badge'],
        //     'receive_by' => $req->post('selectGroup'),
        //     'is_sent' => $req->post('is_sent_now') == 'on' ? '1' : '0', 
        //     'createdate' => date('Y-m-d H:i:s')
        // );

        // $result = DB::table('tbl_pemberitahuan')->insert($data);

        



        // return response()->json([
        //     "message" => "Sukses Insert Data",
        //     "response_push_notification" => $response
        // ]);

        // if($result){
        //     return response()->json([
        //         'status' => 200, 
        //         'message' => 'Data berhasil tersimpan'
        //     ]);
        // }

    }


    public function pemberitahuan_list(Request $req)
    {

        $txSearch = '%' . strtoupper($req->get('txSearch')) . '%';

        $output = '';
        $q = "SELECT id, judul, waktu_pemberitahuan, deskripsi, image, sent_by, receive_by, is_sent FROM 
        (SELECT 
        pm.id, 
        pm.judul, 
        pm.waktu_pemberitahuan, 
        pm.deskripsi, 
        pm.image, 
        (SELECT fullname FROM tbl_karyawan WHERE badge_id=pm.sent_by) AS sent_by, 
        (SELECT nama_grup FROM tbl_grup WHERE id=pm.receive_by) AS receive_by, 
        pm.is_sent
        FROM tbl_pemberitahuan pm) as b WHERE (UPPER(judul) LIKE '$txSearch' OR UPPER(waktu_pemberitahuan) LIKE '$txSearch' OR UPPER(deskripsi) LIKE '$txSearch' OR UPPER(sent_by) LIKE '$txSearch' OR UPPER(receive_by) LIKE '$txSearch' OR UPPER(is_sent) LIKE '$txSearch') ORDER BY id DESC LIMIT 100";

        $data = DB::select($q);


        $output .= 
        '
        <table id="tablePemberitahuan" class="table table-responsive table-hover" style="font-size: 18px;">
            <thead>
                <tr style="color: #CD202E; height: -10px;" class="table-danger">
                    <th class="p-3" scope="col">Judul</th>
                    <th class="p-3" scope="col">Penerima</th>
                    <th class="p-3" scope="col">Pengirim</th>
                    <th class="p-3" scope="col">Waktu Pemberitahuan</th>
                    <th class="p-3" scope="col">Status</th>
                    <th class="p-3 text-center" scope="col">Detail</th>
                    </tr>
            </thead>
            <tbody>
        ';

        if($data){
            foreach($data as $row){

                $statusPemberitahuan = $row->is_sent == '1' ? '<i class="bx bxs-check-circle text-success"></i> Sudah Diumumkan' : 'Belum Diumumkan';

                $output .= 
                '
                <tr style="font-size: 18px;">
                    <td class="p-3">' . $row->judul . '</td>
                    <td class="p-3">' . $row->receive_by . '</td>
                    <td class="p-3">' . $row->sent_by . '</td>
                    <td class="p-3">' . date('d M Y', strtotime($row->waktu_pemberitahuan)) . '</td>
                    <td class="p-3">' . $statusPemberitahuan . '</td>
                    <td class="text-center">
                        <a class="btn" href="' . url('/pemberitahuan') . '/' . $row->id . '"><i style="font-size: 24px;" class="bx bx-file-find text-muted"></i></a>
                        <a class="btn btnEdit" data-id="' . $row->id . '" href="javascript:void(0)"><i style="font-size: 24px;" class="bx bx-pencil"></i></a>
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


    public function detail($id){
        // print_r($id);

        // ambil
        $qReceive = "SELECT receive_by FROM tbl_pemberitahuan where id='$id'";
        $dataReceive = DB::select($qReceive);

        if($dataReceive){

            $receiveId = (int)$dataReceive[0]->receive_by;

            if($receiveId == 1){
                $qStatusBaca = "SELECT a.badge_id,a.fullname, IF((SELECT COUNT(*) FROM tbl_dibaca  WHERE id_pemberitahuan=$id AND badge_id=a.badge_id) > 0, 'DIBACA', 'BELUM') as status  
                FROM `tbl_karyawan` a WHERE a.pt='1'";
            }elseif($receiveId == 2){
                // dd('dawdwa');
                $qStatusBaca = "SELECT a.badge_id,a.fullname, IF((SELECT COUNT(*) FROM tbl_dibaca  WHERE id_pemberitahuan=$id AND badge_id=a.badge_id) > 0, 'DIBACA', 'BELUM') as status  
                FROM `tbl_karyawan` a WHERE a.id_grup = 2";
            }elseif($receiveId == 3){
                $qStatusBaca = "SELECT a.badge_id,a.fullname, IF((SELECT COUNT(*) FROM tbl_dibaca  WHERE id_pemberitahuan=$id AND badge_id=a.badge_id) > 0, 'DIBACA', 'BELUM') as status  
                FROM `tbl_karyawan` a WHERE a.id_grup = 3";
            }else{
                $qStatusBaca = "SELECT a.badge_id,a.fullname, IF((SELECT COUNT(*) FROM tbl_dibaca  WHERE id_pemberitahuan=$id AND badge_id=a.badge_id) > 0, 'DIBACA', 'BELUM') as status  
                FROM `tbl_karyawan` a WHERE a.pt in (1,2)";
            }


            $dataStatusBaca = DB::select($qStatusBaca);

            $jumlahPembaca = 0;
            foreach($dataStatusBaca as $row){
                if($row->status == 'DIBACA'){
                    $jumlahPembaca = $jumlahPembaca + 1;
                }
            }
        

        $qPemberitahuan = "SELECT 
        pm.id, 
        pm.judul, 
        pm.waktu_pemberitahuan, 
        pm.deskripsi, 
        pm.image, 
        (SELECT fullname FROM tbl_karyawan WHERE badge_id=pm.updateby) AS updateby, 
        (SELECT fullname FROM tbl_karyawan WHERE badge_id=pm.sent_by) AS sent_by, 
        (SELECT nama_grup FROM tbl_grup WHERE id=pm.receive_by) AS receive_by, 
        pm.is_sent
        FROM tbl_pemberitahuan pm WHERE pm.id=$id";
        $dataPemberitahuan = DB::select($qPemberitahuan);

        $dataStatusTerkirim = $dataPemberitahuan[0]->is_sent == '1' ? '<i class="bx bxs-check-circle text-success"></i> Sudah Diumumkan' : 'Belum Diumumkan';

            $data = array(
                'userInfo' => DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser')['session_badge'])->first(), 
		'positionName' => DB::table('tbl_vlookup')->select('name_vlookup')->where('id_vlookup', session()->get('loggedInUser')['session_roles'])->first()->name_vlookup,
                'dataPemberitahuan' => $dataPemberitahuan,
                'dataStatusBaca' => $dataStatusBaca, 
                'dataStatusTerkirim' => $dataStatusTerkirim, 
                'userRole' => (int)session()->get('loggedInUser')['session_roles'], 
                'jumlahPembaca' => $jumlahPembaca
            );
        }

            return view('pemberitahuan.detail', $data);
        // }

        // if($id){

        // $qStatusBaca = "SELECT a.badge_id,a.fullname, IF((SELECT COUNT(*) FROM tbl_dibaca  WHERE id_pemberitahuan=$id AND badge_id=a.badge_id) > 0, 'DIBACA', 'BELUM') as status  
        // FROM `tbl_karyawan` a WHERE a.pt in (select receive_by from tbl_pemberitahuan where id=$id)";
        // $dataStatusBaca = DB::select($qStatusBaca);
        

        // $qPemberitahuan = "SELECT 
        // pm.id, 
        // pm.judul, 
        // pm.waktu_pemberitahuan, 
        // pm.deskripsi, 
        // pm.image, 
        // (SELECT fullname FROM tbl_karyawan WHERE badge_id=pm.updateby) AS updateby, 
        // (SELECT fullname FROM tbl_karyawan WHERE badge_id=pm.sent_by) AS sent_by, 
        // (SELECT nama_grup FROM tbl_grup WHERE id=pm.receive_by) AS receive_by, 
        // pm.is_sent
        // FROM tbl_pemberitahuan pm WHERE pm.id=$id";
        // $dataPemberitahuan = DB::select($qPemberitahuan);

        // $dataStatusTerkirim = $dataPemberitahuan[0]->is_sent == '1' ? '<i class="bx bxs-check-circle text-success"></i> Sudah Diumumkan' : 'Belum Diumumkan';

        //     $data = array(
        //         'userInfo' => DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser')['session_badge'])->first(), 
        //         'dataPemberitahuan' => $dataPemberitahuan,
        //         'dataStatusBaca' => $dataStatusBaca, 
        //         'dataStatusTerkirim' => $dataStatusTerkirim
        //     );
        // }

        // return view('pemberitahuan.detail', $data);
    }




    public function get_pemberitahuan_by_id(Request $req)
    {
        $dataId = $req->get('dataId');

        if($dataId){

            $dataPemberitahuan = DB::table('tbl_pemberitahuan')->where('id', $dataId)->first();

            if($dataPemberitahuan){

                return response()->json([
                    'status' => 200,
                    'data' => $dataPemberitahuan
                ]);
            }


        }
    }

    public function update_pemberitahuan(Request $req)
    {

        $dataId = $req->post('pemberitahuanID');

        if($dataId){
            

            $file = $req->file('gambar');
            $fileName = null;

            if($file){
                $fileName = time() . '.' . $file->extension();
                $file->move('img/', $fileName);
            }

            $dateManual = $req->post('waktu_pemberitahuan') . ' ' . $req->post('jam_pemberitahuan') . ':00';

            if($file){
                $data = array(
                    'judul' => $req->post('txJudul'),
                    // 'waktu_pemberitahuan' => $req->post('is_sent_now') == 'on' ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($dateManual)),
                    'deskripsi' => $req->post('txDeskripsi'),
                    'image' => $fileName,
                    'updateby' => session('loggedInUser')['session_badge'],
                    'updatetime' => date('Y-m-d H:i:s'),
                );
            }else{
                $data = array(
                    'judul' => $req->post('txJudul'),
                    // 'waktu_pemberitahuan' => $req->post('is_sent_now') == 'on' ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($dateManual)),
                    'deskripsi' => $req->post('txDeskripsi'),
                    'updateby' => session('loggedInUser')['session_badge'],
                    'updatetime' => date('Y-m-d H:i:s'),
                );
            }
            

            DB::beginTransaction();
            try {

                DB::table('tbl_pemberitahuan')->where('id', $dataId)->update($data);

                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil tersimpan'
                ]);

            } catch (\Exception $ex) {
                DB::rollback();
    
                return response()->json([
                    'status'    => 400, 
                    'message'   => 'gagal menyimpan' . $ex->getMessage()
                ]);
    
            }


        }
    }


}
