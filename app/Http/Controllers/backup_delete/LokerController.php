<?php

namespace App\Http\Controllers;

use App\Models\JobVacancy;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;

class LokerController extends Controller
{

    public function index()
    {

        // $loggedInUser = User::loggedIn()->first();
        // $data = ['userInfo' => $loggedInUser];
        $data = [
		'userInfo' => DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser'))->first(),
		'userRole' => (int)session()->get('loggedInUser')['session_roles'], 
		'positionName' => DB::table('tbl_vlookup')->select('name_vlookup')->where('id_vlookup', session()->get('loggedInUser')['session_roles'])->first()->name_vlookup,
	];

        return view('loker.loker', $data);
    }

    /**
     * @teguhkrniawan
     * untuk digunakan pada tampil data lowongan kerja di datatable
     */
    public function list(Request $request)
    {
        $txSearch   = "%" . strtoupper($request->get('txSearch')) . "%";
        $txMulaiBerlaku    = $request->get('txBerlakuDari');
        $txBerlakuSampai   = $request->get('txBerlakuSampai');

        // $query      = "SELECT * FROM tbl_lowongankerja WHERE posisi LIKE '$txSearch' ORDER BY id DESC";
        $query      = "SELECT a.id, posisi, mulai_berlaku, berlaku_sampai, a.createby, b.fullname FROM tbl_lowongankerja a
                        JOIN tbl_karyawan b ON b.badge_id = a.createby
                        WHERE posisi LIKE '$txSearch' OR fullname LIKE '$txSearch' ORDER BY a.id DESC";
        if ($txMulaiBerlaku && $txBerlakuSampai) {
            $query      = "SELECT * FROM tbl_lowongankerja WHERE posisi LIKE '$txSearch' AND mulai_berlaku >= '$txMulaiBerlaku' AND berlaku_sampai <= '$txBerlakuSampai' ORDER BY id DESC";
        }
        $data       = DB::select($query);


        /**
         * insialisasi output untuk render ke view
         */
        $output     = "";
        $output    .= '
            <table style="font-size: 18px;" id="tableLoker" class="table table-responsive table-hover">
                <thead>
                    <tr style="color: #CD202E; height: 10px;" class="table-danger">
                        <th class="p-3" scope="col">Posisi</th>
                        <th class="p-3" scope="col">Mulai Berlaku</th>
                        <th class="p-3" scope="col">Berlaku Sampai</th>
                        <th class="p-3" scope="col">Di Buat Oleh</th>
                        <th class="p-3" scope="col">Status</th>
                        <th class="p-3" scope="col">Detail</th>
                    </tr>
                </thead>
                <tbody>
        ';

        foreach ($data as $key => $item) {

            $today = date('Y-m-d');
            $status = "<i class='bx bxs-x-circle' style='color: red;'></i> Belum Di Umumkan";
            if ($today >=  $item->berlaku_sampai) {
                $status = "<i class='bx bxs-check-circle' style='color: green;'></i> Sudah Di Umumkan";
            } else if ($today >=  $item->mulai_berlaku && $today <= $item->berlaku_sampai) {
                $status = "<i class='bx bxs-check-circle' style='color: green;'></i> Sudah Di Umumkan";
            }

            $output .= '
                <tr style="font-size: 18px;" class="detail-loker" style="color: gray; cursor: pointer;" data-id="' . $item->id . '" data-bs-toggle="modal" data-bs-target="#modalDetail" >
                    <td style="cursor: pointer;" >' . $item->posisi . '</td>
                    <td>' . Carbon::parse($item->mulai_berlaku)->format('d F Y') . '</td>
                    <td>' . Carbon::parse($item->berlaku_sampai)->format('d F Y') . '</td>
                    <td>' . $this->getUserInfo($item->createby)->fullname . '</td>
                    <td>' . $status . '</td>
                    <td><i style="font-size: 24px;" class="bx bx-file-find text-muted"></i></td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
        return $output;
    }

    /**
     * @teguhkrniawan
     * untuk digunakan pada get detail modal, saat row tabel di klik makan akan show modal,
     * dan datanya diambil dari function ini
     */
    public function getDetailLoker(Request $request)
    {

        $id_loker = $request->id_loker;
        $data = DB::table('tbl_lowongankerja')
            ->where('id', $id_loker)
            ->first();
        $today = date('Y-m-d');
        $status = "<i class='bx bxs-x-circle' style='color: red; font-size:14px;'></i> Belum Di Umumkan";
        if ($today >=  $data->berlaku_sampai) {
            $status = "<i class='bx bxs-check-circle' style='color: green; font-size:14px;'></i> Sudah Di Umumkan";
        } else if ($today >=  $data->mulai_berlaku && $today <= $data->berlaku_sampai) {
            $status = "<i class='bx bxs-check-circle' style='color: green; font-size:14px;'></i> Sudah Di Umumkan";
        }

        $data->mulai_berlaku_asli = $data->mulai_berlaku;
        $data->berlaku_sampai_asli     = $data->berlaku_sampai;

        $data->createdate = Carbon::parse($data->createdate)->format('d F Y');
        $data->mulai_berlaku = Carbon::parse($data->mulai_berlaku)->format('d F Y');
        $data->berlaku_sampai = Carbon::parse($data->berlaku_sampai)->format('d F Y');

        $data->createby = $this->getUserInfo($data->createby)->fullname;
        if($data->updateby){
            $data->updateby = $this->getUserInfo($data->updateby)->fullname;
        }

        $data->status_new = $status;
        return response()->json($data);
    }

    /**
     * @teguhkrniawan
     * untuk di insert ke database saat melakukan insert ke database
     */
    public function insert(Request $request)
    {

        $request->validate([
            'posisi' => 'required',
            'deskripsi' => 'required',
            'mulai_berlaku' => 'required',
            'berlaku_sampai' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $img     = $request->file('gambar');
        $imgName = time() . '.' . $img->extension();

        $upload = $img->move(public_path('lokerimg'), $imgName);
        if ($upload) {
            DB::beginTransaction();
            try {
                $usersaya =  DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser'))->first();
                DB::table('tbl_lowongankerja')
                    ->insert([
                        'posisi' => $request->posisi,
                        'desc'   => $request->deskripsi,
                        'mulai_berlaku' => $request->mulai_berlaku,
                        'berlaku_sampai' => $request->berlaku_sampai,
                        "file_upload" => $imgName,
                        "createby" => $usersaya->badge_id,
                        "createdate" => date("Y-m-d H:i:s")
                    ]);

                DB::commit();

                
                // URL Endpoint API OneSignal
                $url = 'https://onesignal.com/api/v1/notifications';

                // Data untuk dikirim dalam permintaan
                $data = [
                    'app_id' => 'ef44a0e1-1de9-48a0-b4c5-9e045d45c0cf',
                    'included_segments' => ['All'],
                    'headings' => [
                        'en' => 'Lowongan Kerja : ' .$request->posisi,
                    ],
                    'contents' => [
                        'en' => 'Tap untuk baca lebih lanjut informasi ini.',
                        'name' => 'John Doe' // Tambahkan nama pengirim di sini
                    ],
                    'data' => [
                        'Category' => 'Lowongan Kerja'
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

                // Menampilkan respons
                // echo 'HTTP Status Code: ' . $httpCode . PHP_EOL;
                // echo 'Response: ' . $response . PHP_EOL;



                return response()->json([
                    "message" => "Sukses Insert Data",
                    "response_push_notification" => $response
                ]);

                
                // return response()->json([
                //     "message" => "Sukses Insert Data"
                // ]);
            } catch (\Throwable $th) {
                DB::rollBack();
                return response()->json([
                    'message' => $th->getMessage()
                ], 400);
            }
        }
    }

    // function hapus
    public function hapus(Request $request)
    {
        try {
            DB::table('tbl_lowongankerja')->where('id', $request->id)->delete();
            return response()->json([
                "message" => "Delete data sukses"
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Delete data sukses"
            ], 400);
        }
    }

    /**
     * @teguhkrniawan
     * untuk update ke database saat melakukan proses update
     */
    public function update(Request $request)
    {
        $request->validate([
            'posisi' => 'required',
            'deskripsi' => 'required',
            'mulai_berlaku' => 'required',
            'berlaku_sampai' => 'required',
            'gambar' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->file('gambar')) {

            $img     = $request->file('gambar');
            $imgName = time() . '.' . $img->extension();

            $upload = $img->move(public_path('lokerimg'), $imgName);
          

            if ($upload) {
                DB::beginTransaction();
                try {
                    $usersaya =  DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser'))->first();
                    DB::table('tbl_lowongankerja')
                        ->where('id', $request->id_lowongan)
                        ->update([
                            'posisi' => $request->posisi,
                            'desc'   => $request->deskripsi,
                            'mulai_berlaku' => $request->mulai_berlaku,
                            'berlaku_sampai' => $request->berlaku_sampai,
                            "file_upload" => $imgName,
                            "updateby"    => $usersaya->badge_id,
                            "update_date" => date('Y-m-d H:i:s')
                        ]);
                    DB::commit();
                    return response()->json([
                        "message" => "Sukses Update Data"
                    ]);
                } catch (\Throwable $th) {
                    DB::rollBack();
                    return response()->json([
                        'message' => $th->getMessage()
                    ], 400);
                }
            }
        }

        DB::beginTransaction();
        try {
            $usersaya =  DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser'))->first();
            DB::table('tbl_lowongankerja')
                ->where('id', $request->id_lowongan)
                ->update([
                    'posisi' => $request->posisi,
                    'desc'   => $request->deskripsi,
                    'mulai_berlaku' => $request->mulai_berlaku,
                    'berlaku_sampai' => $request->berlaku_sampai,
                    "updateby"    => $usersaya->badge_id,
                    "update_date" => date('Y-m-d H:i:s')
                ]);
            DB::commit();
            return response()->json([
                "message" => "Sukses Update Data"
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'message' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * function untuk get user info
     */
    private function getUserInfo($badge_id)
    {
        $data = DB::table('tbl_karyawan')
            ->where('badge_id', $badge_id)
            ->first();
        return $data;
    }
}
