<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MMSController extends Controller
{
    public function index(Request $req)
    {
        $filter = $req->get('filter');

        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')
                ->select('name_vlookup')
                ->where('id_vlookup', session()->get('loggedInUser')['session_roles'])
                ->first()->name_vlookup,
            'filterData' => $filter ? $filter : null,
        ];

        return view('device.mms', $data);
    }

    public function mms_list(Request $req)
    {
        // dd(date('Y-m-d', strtotime('-7 day')));

        $output = '';

        $qFilter = '';

        $txSearch = '%' . strtoupper($req->get('txSearch')) . '%';
        $merkHP = intval($req->get('merkHP'));
        $permohonan = intval($req->get('permohonan'));
        $statusPermohonan = intval($req->get('statusPermohonan'));
        $waktuPengajuan = intval($req->get('waktuPengajuan'));
        $fStatus = intval($req->get('fStatus'));

        if ($merkHP > 0) {
            $qFilter .= " AND merek_hp_id=$merkHP";
        }
        if ($permohonan > 0) {
            $qFilter .= " AND jenis_permohonan_id=$permohonan";
        }
        if ($statusPermohonan > 0) {
            $qFilter .= " AND status_pendaftaran_mms_id=$statusPermohonan";
        }

        // filter notifikasi
        if ($fStatus > 0) {
            $qFilter .= ' AND status_pendaftaran_mms_id < 12';
        }

        if ($waktuPengajuan > 0) {
            if ($waktuPengajuan == 1) {
                $startDate = date('Y-m-d H:i:s', strtotime('-1 day'));
                $endDate = date('Y-m-d H:i:s');
                $qFilter .= " AND (waktu_pengajuan BETWEEN '$startDate' AND '$endDate')";
            }

            if ($waktuPengajuan == 7) {
                $startDate = date('Y-m-d H:i:s', strtotime('-7 day'));
                $endDate = date('Y-m-d H:i:s');
                $qFilter .= " AND (waktu_pengajuan BETWEEN '$startDate' AND '$endDate')";
            }

            if ($waktuPengajuan == 30) {
                $startDate = date('Y-m-d H:i:s', strtotime('-30 day'));
                $endDate = date('Y-m-d H:i:s');
                $qFilter .= " AND (waktu_pengajuan BETWEEN '$startDate' AND '$endDate')";
            }
        }

        // dd($qFilter);

        $q = "SELECT badge_id, fullname, dept_name, id, merek_hp, merek_hp_id, tipe_hp, imei1, imei2, barcode_label, waktu_pengajuan, jenis_permohonan, jenis_permohonan_id, status_pendaftaran_mms, status_pendaftaran_mms_id FROM (SELECT
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=mms.merek_hp) AS merek_hp,
        mms.merek_hp as merek_hp_id,
        (SELECT fullname FROM tbl_karyawan WHERE badge_id=mms.badge_id) AS fullname,
        (SELECT (SELECT dept_name FROM tbl_deptcode WHERE dept_code=a.dept_code) FROM tbl_karyawan a WHERE a.badge_id=mms.badge_id) AS dept_name,
        mms.badge_id,
        mms.id,
        mms.tipe_hp,
        mms.`imei1`,
        mms.`imei2`,
        mms.barcode_label,
        mms.`status_pendaftaran_mms` as status_pendaftaran_mms_id,
        mms.waktu_pengajuan as waktu_pengajuan,
        (SELECT kategori FROM tbl_kategorimms WHERE id=mms.jenis_permohonan) AS jenis_permohonan,
        mms.jenis_permohonan AS jenis_permohonan_id,
        (SELECT stat_title FROM `tbl_statusmms` WHERE id=mms.`status_pendaftaran_mms`) AS status_pendaftaran_mms
        FROM `tbl_mms` mms) AS a WHERE
        (UPPER(badge_id) LIKE '$txSearch' OR UPPER(fullname) LIKE '$txSearch' OR UPPER(dept_name) LIKE '$txSearch' OR UPPER(merek_hp) LIKE '$txSearch' OR UPPER(imei1) LIKE '$txSearch' OR UPPER(imei2) LIKE '$txSearch' OR UPPER(jenis_permohonan) LIKE '$txSearch' OR UPPER(status_pendaftaran_mms) LIKE '$txSearch' OR UPPER(barcode_label) LIKE '$txSearch' OR UPPER(tipe_hp) LIKE '$txSearch') $qFilter
        ORDER BY waktu_pengajuan DESC limit 100";
        $data = DB::select($q);

        // dd($q);

        $output .= '
        <table style="font-size: 18px;" id="tableMMS" class="table table-responsive table-hover">
            <thead>
                <tr style="color: #CD202E; height: -10px;" class="table-danger">
                    <th class="p-3" scope="col">Badge</th>
                    <th class="p-3" scope="col">Full Name</th>
                    <th class="p-3" scope="col">Department</th>
                    <th class="p-3" scope="col">Merek HP</th>
                    <th class="p-3" scope="col">Type HP</th>
                    <th class="p-3" scope="col">Nomor IMEI 1</th>
                    <th class="p-3" scope="col">Jenis Permohonan</th>
                    <th class="p-3" scope="col">Waktu Pengajuan</th>
                    <th class="p-3" scope="col">Status Pengajuan</th>
                    <th class="p-3" scope="col"></th>
                </tr>
            </thead>
            <tbody>
        ';

        if ($data) {
            foreach ($data as $row) {
                $output .=
                    '
                <tr class="viewMMS" data-id="' .
                    $row->id .
                    '" style="color: black;">
                    <td class="p-3">' .
                    $row->badge_id .
                    '</td>
                    <td class="p-3">' .
                    $row->fullname .
                    '</td>
                    <td class="p-3">' .
                    $row->dept_name .
                    '</td>
                    <td class="p-3">' .
                    $row->merek_hp .
                    '</td>
                    <td class="p-3">' .
                    $row->tipe_hp .
                    '</td>
                    <td class="p-3">' .
                    $row->imei1 .
                    '</td>
                    <td class="p-3">' .
                    $row->jenis_permohonan .
                    '</td>
                    <td class="p-3">' .
                    date('d M Y', strtotime($row->waktu_pengajuan)) .
                    '</td>
                    <td class="p-3">' .
                    $row->status_pendaftaran_mms .
                    '</td>
                    <td>
                        <a class="btn btnView" href="javascript:void(0)" data-id="' .
                    $row->id .
                    '"><i style="font-size: 24px;" class="bx bx-file-find text-muted"></i></a>
                    </td>
                </tr>
                ';
            }

            $output .= '</tbody></table>';
        } else {
            $output = '<div class="text-center mt-5">Data tidak ditemukan</div>';
        }

        return $output;
    }

    public function get_mms_by_id(Request $req)
    {
        $dataId = $req->get('dataId');
        $qMMS = "SELECT mms.id, mms.badge_id,  
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=mms.merek_hp) AS merek_hp, 
        mms.tipe_hp, 
        mms.imei1, 
        mms.imei2, 
        mms.barcode_label, 
        mms.uuid, 
        mms.is_active, 
        (SELECT kategori FROM tbl_kategorimms WHERE id=mms.jenis_permohonan) AS jenis_permohonan, 
        mms.waktu_pengajuan, 
        (SELECT stat_title FROM tbl_statusmms WHERE id=mms.status_pendaftaran_mms) AS status_pendaftaran_mms, 
        mms.status_pendaftaran_mms AS status_pendaftaran_mms_id, 
        mms.img_dpn, 
        mms.img_blk 
        FROM tbl_mms mms WHERE mms.id='$dataId'";
        $dataMMS = DB::select($qMMS);
        $idStatusPendaftaranMMS = '';

        $badge_id = '';
        if ($dataMMS) {
            $badge_id = $dataMMS[0]->badge_id;

            $idStatusPendaftaranMMS = $dataMMS[0]->status_pendaftaran_mms_id;
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
        (SELECT stat_title FROM tbl_statusmms WHERE id=rw.status_mms) AS stat_title,
        (SELECT stat_desc FROM tbl_statusmms WHERE id=rw.status_mms) AS stat_desc,
        rw.createby, 
        rw.createdate 
        FROM tbl_riwayatstatusmms rw WHERE rw.id_mms = '$dataId' ORDER BY rw.id ASC";
        $dataRiwayat = DB::select($qRiwayat);

        $qRiwayat2 = "SELECT * FROM tbl_statusmms WHERE id > $idStatusPendaftaranMMS AND (UPPER(stat_title) LIKE 'SE%')";
        $dataRiwayat2 = DB::select($qRiwayat2);
        $qDataTanggapan = "SELECT
        (SELECT fullname FROM tbl_karyawan WHERE badge_id=tt.badge_id) as fullname, 
        (SELECT img_user FROM tbl_karyawan WHERE badge_id=tt.badge_id) as photo, 
        tt.respon, 
        tt.waktu  
        FROM tbl_tanggapanmms tt WHERE tt.id_mms=$dataId ORDER BY tt.id DESC";
        $dataTanggapan = DB::select($qDataTanggapan);

        if ($dataMMS) {
            return response()->json([
                'status' => 200,
                'dataMMS' => $dataMMS,
                'dataKaryawan' => $dataKaryawan,
                'dataRiwayat' => $dataRiwayat,
                'dataTanggapan' => $dataTanggapan,
                'dataRiwayat2' => $dataRiwayat2,
            ]);
        }
    }

    public function karyawan_by_id(Request $req)
    {
        $badgeId = $req->get('badgeId');

        if ($badgeId) {
            $q = "SELECT 
            tk.fullname, 
            tk.dept_code, 
            (SELECT dept_name FROM tbl_deptcode WHERE dept_code=tk.dept_code) AS dept_name, 
            (SELECT position_name FROM tbl_position WHERE position_code=tk.position_code) AS position_name, 
            tk.join_date 
            FROM tbl_karyawan tk WHERE tk.badge_id='$badgeId'";
            $data = DB::select($q);

            if ($data) {
                foreach ($data as $row) {
                    $dataKaryawan = [
                        'fullname' => $row->fullname,
                        'dept_code' => $row->dept_code,
                        'dept_name' => $row->dept_name,
                        'position_name' => $row->position_name,
                        'join_date' => date('d M Y', strtotime($row->join_date)),
                    ];

                    return response()->json([
                        'status' => 200,
                        'data' => $dataKaryawan,
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'Data tidak ditemukan',
                ]);
            }
        }
    }

    public function merek_hp_list()
    {
        $q = "SELECT id_vlookup, name_vlookup FROM tbl_vlookup WHERE category='BRD'";
        $data = DB::select($q);

        if ($data) {
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        }
    }

    // permohonan_list
    public function permohonan_list()
    {
        $q = 'SELECT id, kategori FROM tbl_kategorimms';
        $data = DB::select($q);

        if ($data) {
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        }
    }

    // os list
    public function os_list()
    {
        $q = "SELECT id_vlookup, name_vlookup FROM tbl_vlookup WHERE category='OS'";
        $data = DB::select($q);

        if ($data) {
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        }
    }

    // permohonan_list
    public function status_permohonan_list()
    {
        $q = 'SELECT id, stat_title FROM tbl_statusmms';
        $data = DB::select($q);

        if ($data) {
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        }
    }

    public function check_imei(Request $req)
    {
        // check imei
        $imei = $req->get('imei');

        $qImei = "SELECT COUNT(*) as count FROM tbl_mms WHERE (imei1='$imei' OR imei2='$imei') AND is_active='1'";
        $countImei = DB::select($qImei);

        if ($countImei[0]->count > 0) {
            return response()->json([
                'status' => 400,
                'message' => 'Imei 1 sudah terdaftar atau duplikat',
            ]);
        }
    }

    public function check_uuid(Request $req)
    {
        // check imei
        $uuid = $req->get('uuid');

        $qUuid = "SELECT COUNT(*) as count FROM tbl_mms WHERE uuid='$uuid' AND is_active = '1'";
        $countUuid = DB::select($qUuid);

        if ($countUuid[0]->count > 0) {
            return response()->json([
                'status' => 400,
                'message' => 'Imei 1 sudah terdaftar atau duplikat',
            ]);
        }
    }

    public function check_barcode_label(Request $req)
    {
        // check imei
        $barcodeLabel = $req->get('barcodeLabel');

        // $qBarcodeLabel = "SELECT COUNT(*) as count FROM tbl_mms WHERE barcode_label='$barcodeLabel'";
        // $countqBarcodeLabel = DB::select($qBarcodeLabel);

        $countqBarcodeLabel = DB::table('tbl_mms')
            ->where('barcode_label', $barcodeLabel)
            ->where('is_active', '1')
            ->count();

        // dd($countqBarcodeLabel);

        if ($countqBarcodeLabel > 0) {
            return response()->json([
                'status' => 400,
                'message' => 'Barcode label sudah terdaftar atau duplikat',
                'ad' => $countqBarcodeLabel,
            ]);
        }
    }

    public function simpan_mms(Request $req)
    {
        // dd($req);

        $roles = intval(session()->get('loggedInUser')['session_roles']);

        $base64String1 = null;
        $base64String2 = null;
        $base64StringCamera1 = null;
        $base64StringCamera2 = null;

        $file1 = $req->file('gambarDpn');
        $file2 = $req->file('gambarBlkng');
        $file1Camera = $req->post('gambarDpnCamera');
        $file2Camera = $req->post('gambarBlkngCamera');

        if ($file1) {
            // $fileName1 = time() . '_' . $file1->getClientOriginalName();
            // $file1->move('img/', $fileName1);
            // $fileContent = public_path('img/' . $fileName1);
            // $fileContent1 = file_get_contents($fileContent);
            // $base64String1 = 'data:image/png;base64,' . base64_encode($fileContent1);
            $fileContent = file_get_contents($file1->getRealPath());
            $base64String1 = 'data:image/png;base64,' . base64_encode($fileContent);
        }

        if ($file2) {
            // $fileName2 = time() . '_' . $file2->getClientOriginalName();
            // $file2->move('img/', $fileName2);
            // $fileContent = public_path('img/' . $fileName2);
            // $fileContent2 = file_get_contents($fileContent);
            $fileContent = file_get_contents($file2->getRealPath());
            $base64String2 = 'data:image/png;base64,' . base64_encode($fileContent);
        }

        if ($file1Camera) {
            $binary1 = base64_decode($file1Camera);
            // $fileName1Camera = uniqid() . '.jpeg';
            // $result1 = file_put_contents('img/'.$fileName1Camera, $binary1);
            $base64StringCamera1 = 'data:image/png;base64,' . base64_encode($binary1);
        }

        if ($file2Camera) {
            $binary2 = base64_decode($file2Camera);
            // $fileName2Camera = uniqid() . '.jpeg';
            // $result2 = file_put_contents('img/'.$fileName2Camera, $binary2);
            $base64StringCamera2 = 'data:image/png;base64,' . base64_encode($binary2);
        }

        // dd($req->post('checkUploadFoto') == "on");
        // dd($base64StringCamera1);

        DB::beginTransaction();
        try {
            // staff hrd
            if ($roles == 63) {
                $data = [
                    'badge_id' => $req->post('txBadge'),
                    'uuid' => $req->post('txUUID'),
                    'barcode_label' => $req->post('txBarcodeLabel'),
                    'jenis_permohonan' => $req->post('rdPermohonan'),
                    'merek_hp' => $req->post('selectMerekHP'),
                    'merek_hp_lain' => $req->post('txMerekHpLain'),
                    'os' => $req->post('selectOs'),
                    'tipe_hp' => $req->post('txTipeHP'),
                    'imei1' => $req->post('txImei1'),
                    'imei2' => $req->post('txImei2'),
                    'serial_no' => $req->post('txNoSerial'),
                    'img_dpn' => $req->post('checkUploadFoto') == 'on' ? $base64String1 : $base64StringCamera1,
                    'img_blk' => $req->post('checkUploadFoto') == 'on' ? $base64String2 : $base64StringCamera2,
                    'versi_aplikasi' => $req->post('selectOs'),
                    'status_pendaftaran_mms' => 4,
                    'waktu_pengajuan' => date('Y-m-d H:i:s'),
                    'createby' => session('loggedInUser')['session_badge'],
                    'createdate' => date('Y-m-d H:i:s'),
                ];

                $idMMS = DB::table('tbl_mms')->insertGetId($data);

                if ($idMMS) {
                    $riwayat = [
                        [
                            'id_mms' => $idMMS,
                            'status_mms' => 1,
                            'createby' => session('loggedInUser')['session_badge'],
                            'createdate' => date('Y-m-d H:i:s'),
                        ],
                        [
                            'id_mms' => $idMMS,
                            'status_mms' => 2,
                            'createby' => session('loggedInUser')['session_badge'],
                            'createdate' => date('Y-m-d H:i:s'),
                        ],
                        [
                            'id_mms' => $idMMS,
                            'status_mms' => 4,
                            'createby' => session('loggedInUser')['session_badge'],
                            'createdate' => date('Y-m-d H:i:s'),
                        ],
                    ];

                    DB::table('tbl_riwayatstatusmms')->insert($riwayat);


                    // CHECK IMEI WITH MIS API
                        /**
                         * XIAOMI
                         */
                        // IMEI 1 XIAOMI
                        $client = new Client();
                        $response = $client->post('http://snws07:8000/api/MES/Ext/IMEIVerification?plant=MI11&IMEI=' . $req->post('txImei1'));
                        $statusCode = $response->getStatusCode();
                        if($statusCode == 200){
                            $data = json_decode($response->getBody(), true);
                            if($data['MESSAGETYPE'] == 'S'){
                                $isShipData = json_decode($data['DATA']);
                                if($isShipData->is_shipped == null || $isShipData->is_shipped == "" || $isShipData->is_shipped == false){

                                    $countOldMMS = DB::table('tbl_mms')->where('id', $idMMS)->where('status_pendaftaran_mms', 13)->count();
                                    if($countOldMMS < 1){

                                        DB::table('tbl_mms')->where('id', $idMMS)->where('imei1', $req->post('txImei1'))->update(['status_pendaftaran_mms' => 13, 'status_imei' => 2]);
    
                                        // RIWAYAT
                                        $countRiwayat = [
                                            'id_mms' => $idMMS,
                                            'status_mms' => 13,
                                            'createby' => session('loggedInUser')['session_badge'],
                                            'createdate' => date('Y-m-d H:i:s'),
                                        ];
                                        DB::table('tbl_riwayatstatusmms')->insert($countRiwayat);
    
                                        $dataLog = array(
                                            'imei' => $req->post('txImei1'), 
                                            'message_type' => $data['MESSAGETYPE'],
                                            'message' => 'BRAND: XIAOMI - HRD STAFF ' . session('loggedInUser')['session_badge'] . ' CREATING DATA: ' . $data['MESSAGE'],
                                            'data' => $data['DATA'],
                                            'created_at' => date('Y-m-d H:i:s')
                                        );
                                        DB::table('tbl_logcheckimei')->insert($dataLog);
                                    }
                                }
                            }
                        }
                        // END IMEI 1 XIAOMI
                        // IMEI 2 XIAOMI
                        $client = new Client();
                        $response = $client->post('http://snws07:8000/api/MES/Ext/IMEIVerification?plant=MI11&IMEI=' . $req->post('txImei2'));
                        $statusCode = $response->getStatusCode();
                        if($statusCode == 200){
                            $data = json_decode($response->getBody(), true);
                            if($data['MESSAGETYPE'] == 'S'){
                                $isShipData = json_decode($data['DATA']);
                                if($isShipData->is_shipped == null || $isShipData->is_shipped == "" || $isShipData->is_shipped == false){

                                    $countOldMMS = DB::table('tbl_mms')->where('id', $idMMS)->where('status_pendaftaran_mms', 13)->count();
                                    if($countOldMMS < 1){
                                        DB::table('tbl_mms')->where('id', $idMMS)->where('imei1', $req->post('txImei2'))->update(['status_pendaftaran_mms' => 13, 'status_imei' => 2]);
    
                                        $dataLog = array(
                                            'imei' => $req->post('txImei2'), 
                                            'message_type' => $data['MESSAGETYPE'],
                                            'message' => 'BRAND: XIAOMI - HRD STAFF ' . session('loggedInUser')['session_badge'] . ' CREATING DATA: ' . $data['MESSAGE'],
                                            'data' => $data['DATA'],
                                            'created_at' => date('Y-m-d H:i:s')
                                        );
                                        DB::table('tbl_logcheckimei')->insert($dataLog);
                                    }
                                }
                            }
                        }
                        // END IMEI 2 XIAOMI
                            /**
                             * END XIAOMI
                             */
                            /**
                             * ASUS
                             */
                            // IMEI 1 ASUS
                            $client = new Client();
                            $response = $client->post('http://snws07:8000/api/MES/Ext/IMEIVerification?plant=IS13&IMEI=' . $req->post('txImei1'));
                            $statusCode = $response->getStatusCode();
                            if($statusCode == 200){
                                $data = json_decode($response->getBody(), true);
                                if($data['MESSAGETYPE'] == 'S'){
                                    $isShipData = json_decode($data['DATA']);
                                    if($isShipData->is_shipped == null || $isShipData->is_shipped == "" || $isShipData->is_shipped == false){

                                        $countOldMMS = DB::table('tbl_mms')->where('id', $idMMS)->where('status_pendaftaran_mms', 13)->count();
                                        if($countOldMMS < 1){
                                            DB::table('tbl_mms')->where('id', $idMMS)->where('imei1', $req->post('txImei1'))->update(['status_pendaftaran_mms' => 13, 'status_imei' => 2]);
    
                                            // RIWAYAT
                                            $countRiwayat = [
                                                'id_mms' => $idMMS,
                                                'status_mms' => 13,
                                                'createby' => session('loggedInUser')['session_badge'],
                                                'createdate' => date('Y-m-d H:i:s'),
                                            ];
                                            DB::table('tbl_riwayatstatusmms')->insert($countRiwayat);
    
                                            $dataLog = array(
                                                'imei' => $req->post('txImei1'), 
                                                'message_type' => $data['MESSAGETYPE'],
                                                'message' => 'BRAND: ASUS - HRD STAFF ' . session('loggedInUser')['session_badge'] . ' CREATING DATA: ' . $data['MESSAGE'],
                                                'data' => $data['DATA'],
                                                'created_at' => date('Y-m-d H:i:s')
                                            );
                                            DB::table('tbl_logcheckimei')->insert($dataLog);
                                        }
                                    }
                                }
                            }
                            // END IMEI 1 ASUS
                            // IMEI 2 ASUS
                            $client = new Client();
                            $response = $client->post('http://snws07:8000/api/MES/Ext/IMEIVerification?plant=IS13&IMEI=' . $req->post('txImei2'));
                            $statusCode = $response->getStatusCode();
                            if($statusCode == 200){
                                $data = json_decode($response->getBody(), true);
                                if($data['MESSAGETYPE'] == 'S'){
                                    $isShipData = json_decode($data['DATA']);
                                    if($isShipData->is_shipped == null || $isShipData->is_shipped == "" || $isShipData->is_shipped == false){

                                        $countOldMMS = DB::table('tbl_mms')->where('id', $idMMS)->where('status_pendaftaran_mms', 13)->count();
                                        if($countOldMMS < 1){
                                            DB::table('tbl_mms')->where('id', $idMMS)->where('imei1', $req->post('txImei2'))->update(['status_pendaftaran_mms' => 13, 'status_imei' => 2]);

                                            // RIWAYAT
                                            $countRiwayat = [
                                                'id_mms' => $idMMS,
                                                'status_mms' => 13,
                                                'createby' => session('loggedInUser')['session_badge'],
                                                'createdate' => date('Y-m-d H:i:s'),
                                            ];
                                            DB::table('tbl_riwayatstatusmms')->insert($countRiwayat);


                                            $dataLog = array(
                                                'imei' => $req->post('txImei2'), 
                                                'message_type' => $data['MESSAGETYPE'],
                                                'message' => 'BRAND: ASUS - HRD STAFF ' . session('loggedInUser')['session_badge'] . ' CREATING DATA: ' . $data['MESSAGE'],
                                                'data' => $data['DATA'],
                                                'created_at' => date('Y-m-d H:i:s')
                                            );
                                            DB::table('tbl_logcheckimei')->insert($dataLog);
                                        }
                                    }
                                }
                            }
                            // END IMEI 2 ASUS
                        /**
                         * END ASUS
                         */
                    // END CHECK IMEI


                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'MMS gagal tersimpan',
                    ]);
                }

                // manager
            } elseif ($roles == 64) {
                $data = [
                    'badge_id' => $req->post('txBadge'),
                    'uuid' => $req->post('txUUID'),
                    'barcode_label' => $req->post('txBarcodeLabel'),
                    'jenis_permohonan' => $req->post('rdPermohonan'),
                    'merek_hp' => $req->post('selectMerekHP'),
                    'merek_hp_lain' => $req->post('txMerekHpLain'),
                    'os' => $req->post('selectOs'),
                    'tipe_hp' => $req->post('txTipeHP'),
                    'imei1' => $req->post('txImei1'),
                    'imei2' => $req->post('txImei2'),
                    'serial_no' => $req->post('txNoSerial'),
                    'img_dpn' => $req->post('checkUploadFoto') == 'on' ? $base64String1 : $base64StringCamera1,
                    'img_blk' => $req->post('checkUploadFoto') == 'on' ? $base64String2 : $base64StringCamera2,
                    'versi_aplikasi' => $req->post('selectOs'),
                    'status_pendaftaran_mms' => 7,
                    'waktu_pengajuan' => date('Y-m-d H:i:s'),
                    'createby' => session('loggedInUser')['session_badge'],
                    'createdate' => date('Y-m-d H:i:s'),
                ];

                // dd($data);

                $idMMS = DB::table('tbl_mms')->insertGetId($data);

                if ($idMMS) {
                    $merek_hp_lain = $req->post('txMerekHpLain');
                    if ($merek_hp_lain != '') {
                        DB::table('tbl_vlookup')->insert([
                            'category' => 'BRD',
                            'name_vlookup' => strtoupper($merek_hp_lain),
                            'desc' => 'merek_hp',
                        ]);
                    }

                    $riwayat = [
                        [
                            'id_mms' => $idMMS,
                            'status_mms' => 1,
                            'createby' => session('loggedInUser')['session_badge'],
                            'createdate' => date('Y-m-d H:i:s'),
                        ],
                        [
                            'id_mms' => $idMMS,
                            'status_mms' => 6,
                            'createby' => session('loggedInUser')['session_badge'],
                            'createdate' => date('Y-m-d H:i:s'),
                        ],
                        [
                            'id_mms' => $idMMS,
                            'status_mms' => 7,
                            'createby' => session('loggedInUser')['session_badge'],
                            'createdate' => date('Y-m-d H:i:s'),
                        ],
                    ];

                    DB::table('tbl_riwayatstatusmms')->insert($riwayat);


                    // CHECK IMEI WITH MIS API
                        /**
                         * XIAOMI
                         */
                        // IMEI 1 XIAOMI
                        $client = new Client();
                        $response = $client->post('http://snws07:8000/api/MES/Ext/IMEIVerification?plant=MI11&IMEI=' . $req->post('txImei1'));
                        $statusCode = $response->getStatusCode();
                        if($statusCode == 200){
                            $data = json_decode($response->getBody(), true);
                            if($data['MESSAGETYPE'] == 'S'){
                                $isShipData = json_decode($data['DATA']);
                                if($isShipData->is_shipped == null || $isShipData->is_shipped == "" || $isShipData->is_shipped == false){

                                    $countOldMMS = DB::table('tbl_mms')->where('id', $idMMS)->where('status_pendaftaran_mms', 13)->count();
                                    if($countOldMMS < 1){
                                        DB::table('tbl_mms')->where('id', $idMMS)->where('imei1', $req->post('txImei1'))->update(['status_pendaftaran_mms' => 13, 'status_imei' => 2]);
    
                                        // RIWAYAT
                                        $countRiwayat = [
                                            'id_mms' => $idMMS,
                                            'status_mms' => 13,
                                            'createby' => session('loggedInUser')['session_badge'],
                                            'createdate' => date('Y-m-d H:i:s'),
                                        ];
                                        DB::table('tbl_riwayatstatusmms')->insert($countRiwayat);
    
                                        $dataLog = array(
                                            'imei' => $req->post('txImei1'), 
                                            'message_type' => $data['MESSAGETYPE'],
                                            'message' => $data['MESSAGE'],
                                            'data' => 'BRAND: ASUS - HRD MGR ' . session('loggedInUser')['session_badge'] . ' CREATING DATA: ' . $data['DATA'],
                                            'created_at' => date('Y-m-d H:i:s')
                                        );
                                        DB::table('tbl_logcheckimei')->insert($dataLog);
                                    }
                                }
                            }
                        }
                        // END IMEI 1 XIAOMI
                        // IMEI 2 XIAOMI
                        $client = new Client();
                        $response = $client->post('http://snws07:8000/api/MES/Ext/IMEIVerification?plant=MI11&IMEI=' . $req->post('txImei2'));
                        $statusCode = $response->getStatusCode();
                        if($statusCode == 200){
                            $data = json_decode($response->getBody(), true);
                            if($data['MESSAGETYPE'] == 'S'){
                                $isShipData = json_decode($data['DATA']);
                                if($isShipData->is_shipped == null || $isShipData->is_shipped == "" || $isShipData->is_shipped == false){

                                    $countOldMMS = DB::table('tbl_mms')->where('id', $idMMS)->where('status_pendaftaran_mms', 13)->count();
                                    if($countOldMMS < 1){
                                        DB::table('tbl_mms')->where('id', $idMMS)->where('imei1', $req->post('txImei2'))->update(['status_pendaftaran_mms' => 13, 'status_imei' => 2]);
    
                                        $dataLog = array(
                                            'imei' => $req->post('txImei2'), 
                                            'message_type' => $data['MESSAGETYPE'],
                                            'message' => $data['MESSAGE'],
                                            'data' => 'BRAND: ASUS - HRD MGR ' . session('loggedInUser')['session_badge'] . ' CREATING DATA: ' . $data['DATA'],
                                            'created_at' => date('Y-m-d H:i:s')
                                        );
                                        DB::table('tbl_logcheckimei')->insert($dataLog);
                                    }
                                }
                            }
                        }
                        // END IMEI 2 XIAOMI
                            /**
                             * END XIAOMI
                             */
                            /**
                             * ASUS
                             */
                            // IMEI 1 ASUS
                            $client = new Client();
                            $response = $client->post('http://snws07:8000/api/MES/Ext/IMEIVerification?plant=IS13&IMEI=' . $req->post('txImei1'));
                            $statusCode = $response->getStatusCode();
                            if($statusCode == 200){
                                $data = json_decode($response->getBody(), true);
                                if($data['MESSAGETYPE'] == 'S'){
                                    $isShipData = json_decode($data['DATA']);
                                    if($isShipData->is_shipped == null || $isShipData->is_shipped == "" || $isShipData->is_shipped == false){

                                        $countOldMMS = DB::table('tbl_mms')->where('id', $idMMS)->where('status_pendaftaran_mms', 13)->count();
                                        if($countOldMMS < 1){
                                            DB::table('tbl_mms')->where('id', $idMMS)->where('imei1', $req->post('txImei1'))->update(['status_pendaftaran_mms' => 13, 'status_imei' => 2]);
    
                                            // RIWAYAT
                                            $countRiwayat = [
                                                'id_mms' => $idMMS,
                                                'status_mms' => 13,
                                                'createby' => session('loggedInUser')['session_badge'],
                                                'createdate' => date('Y-m-d H:i:s'),
                                            ];
                                            DB::table('tbl_riwayatstatusmms')->insert($countRiwayat);
    
                                            $dataLog = array(
                                                'imei' => $req->post('txImei1'), 
                                                'message_type' => $data['MESSAGETYPE'],
                                                'message' => $data['MESSAGE'],
                                                'data' => 'BRAND: ASUS - HRD MGR ' . session('loggedInUser')['session_badge'] . ' CREATING DATA: ' . $data['DATA'],
                                                'created_at' => date('Y-m-d H:i:s')
                                            );
                                            DB::table('tbl_logcheckimei')->insert($dataLog);
                                        }
                                    }
                                }
                            }
                            // END IMEI 1 ASUS
                            // IMEI 2 ASUS
                            $client = new Client();
                            $response = $client->post('http://snws07:8000/api/MES/Ext/IMEIVerification?plant=IS13&IMEI=' . $req->post('txImei2'));
                            $statusCode = $response->getStatusCode();
                            if($statusCode == 200){
                                $data = json_decode($response->getBody(), true);
                                if($data['MESSAGETYPE'] == 'S'){
                                    $isShipData = json_decode($data['DATA']);
                                    if($isShipData->is_shipped == null || $isShipData->is_shipped == "" || $isShipData->is_shipped == false){

                                        $countOldMMS = DB::table('tbl_mms')->where('id', $idMMS)->where('status_pendaftaran_mms', 13)->count();
                                        if($countOldMMS < 1){
                                            DB::table('tbl_mms')->where('id', $idMMS)->where('imei1', $req->post('txImei2'))->update(['status_pendaftaran_mms' => 13, 'status_imei' => 2]);
    
                                            // RIWAYAT
                                            $countRiwayat = [
                                                'id_mms' => $idMMS,
                                                'status_mms' => 13,
                                                'createby' => session('loggedInUser')['session_badge'],
                                                'createdate' => date('Y-m-d H:i:s'),
                                            ];
                                            DB::table('tbl_riwayatstatusmms')->insert($countRiwayat);
    
    
                                            $dataLog = array(
                                                'imei' => $req->post('txImei2'), 
                                                'message_type' => $data['MESSAGETYPE'],
                                                'message' => $data['MESSAGE'],
                                                'data' => 'BRAND: ASUS - HRD MGR ' . session('loggedInUser')['session_badge'] . ' CREATING DATA: ' . $data['DATA'],
                                                'created_at' => date('Y-m-d H:i:s')
                                            );
                                            DB::table('tbl_logcheckimei')->insert($dataLog);
                                        }
                                    }
                                }
                            }
                            // END IMEI 2 ASUS
                        /**
                         * END ASUS
                         */
                    // END CHECK IMEI


                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'MMS gagal tersimpan',
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil tersimpan',
            ]);
        } catch (\Exception $ex) {
            DB::rollback();

            return response()->json([
                'status' => 400,
                'message' => 'gagal menyimpan' . $ex->getMessage(),
            ]);
        }

        // $data = array(
        //     'badge_id' => $req->post('txBadge'),
        //     'uuid' => $req->post('txUUID'),
        //     'barcode_label' => $req->post('txBarcodeLabel'),
        //     'jenis_permohonan' => $req->post('rdPermohonan'),
        //     'merek_hp' => $req->post('selectMerekHP'),
        //     'os' => 31,
        //     'tipe_hp' => $req->post('txTipeHP'),
        //     'imei1' => $req->post('txImei1'),
        //     'imei2' => $req->post('txImei2'),
        //     'serial_no' => $req->post('txNoSerial'),
        //     'img_dpn' => $fileName1,
        //     'img_blk' => $fileName2,
        //     'versi_aplikasi' => $req->post('selectOs'),
        //     'status_pendaftaran_mms' => 1,
        //     'waktu_pengajuan' => date('Y-m-d H:i:s')
        // );

        // $result = DB::table('tbl_mms')->insert($data);

        // ambil roles session
        // $qRoles = DB::table('tbl_useradmin')->select('user_level')->where('badge_id', session('loggedInUser'));

        // dd($qRoles);

        //
        // $roles = 1;

        // if($roles == 1){
        //     $data = array(
        //         'badge_id' => $req->post('txBadge'),
        //         'brand' => $req->post('selectMerekLaptop'),
        //         'tipe_laptop' => $req->post('txTipeLaptop'),
        //         'device_number' => $req->post('txNoSerial'),
        //         'alasan' => $req->post('selectAlasanPermintaan'),
        //         'desc_alasan' => $req->post('selectAlasanPermintaan') != '62' ? NULL : $req->post('txAlasanDeskripsi'),
        //         'asset_number' => $req->post('txAssetNumber'),
        //         'durasi' => $req->post('selectDurasiPemakaian'),
        //         'start_date' => $req->post('selectDurasiPemakaian') != '58' ? date('Y-m-d', strtotime($req->post('txMulaiMemakai'))) : NULL,
        //         'end_date' => $req->post('selectDurasiPemakaian') != '58' ? date('Y-m-d', strtotime($req->post('txSelesaiMemakai'))) : NULL,
        //         'img_dpn' => $fileName1,
        //         'img_blk' => $fileName2,
        //         'tanggal_pengajuan' => date('Y-m-d'),
        //         'status_pendaftaran_mms' => 7
        //     );

        //     $idLMS = DB::table('tbl_mms')->insertGetId($data);

        //     $riwayat = [
        //         [
        //             'id_lms' => $idLMS,
        //             'status_lms' => 1,
        //             'createby' => session('loggedInUser'),
        //             'createdate' => date('Y-m-d H:i:s'),
        //         ],
        //         [
        //             'id_lms' => $idLMS,
        //             'status_lms' => 6,
        //             'createby' => session('loggedInUser'),
        //             'createdate' => date('Y-m-d H:i:s'),
        //         ],
        //         [
        //             'id_lms' => $idLMS,
        //             'status_lms' => 7,
        //             'createby' => session('loggedInUser'),
        //             'createdate' => date('Y-m-d H:i:s'),
        //         ],
        //     ];

        //     $result = DB::table('tbl_riwayatstatuslms')->insert($riwayat);

        //     if($result){
        //         return response()->json([
        //             'status' => 200,
        //             'message' => 'Data berhasil tersimpan'
        //         ]);
        //     }

        // }else{
        //     $data = array(
        //         'badge_id' => $req->post('txBadge'),
        //         'brand' => $req->post('selectMerekLaptop'),
        //         'tipe_laptop' => $req->post('txTipeLaptop'),
        //         'device_number' => $req->post('txNoSerial'),
        //         'alasan' => $req->post('selectAlasanPermintaan'),
        //         'desc_alasan' => $req->post('selectAlasanPermintaan') != '62' ? NULL : $req->post('txAlasanDeskripsi'),
        //         'asset_number' => $req->post('txAssetNumber'),
        //         'durasi' => $req->post('selectDurasiPemakaian'),
        //         'start_date' => $req->post('selectDurasiPemakaian') != '58' ? date('Y-m-d', strtotime($req->post('txMulaiMemakai'))) : NULL,
        //         'end_date' => $req->post('selectDurasiPemakaian') != '58' ? date('Y-m-d', strtotime($req->post('txSelesaiMemakai'))) : NULL,
        //         'img_dpn' => $fileName1,
        //         'img_blk' => $fileName2,
        //         'tanggal_pengajuan' => date('Y-m-d'),
        //         'status_pendaftaran_mms' => 4
        //     );

        //     $idLMS = DB::table('tbl_mms')->insertGetId($data);

        //     $riwayat = [
        //         [
        //             'id_lms' => $idLMS,
        //             'status_lms' => 1,
        //             'createby' => session('loggedInUser'),
        //             'createdate' => date('Y-m-d H:i:s'),
        //         ],
        //         [
        //             'id_lms' => $idLMS,
        //             'status_lms' => 4,
        //             'createby' => session('loggedInUser'),
        //             'createdate' => date('Y-m-d H:i:s'),
        //         ],
        //     ];

        //     $result = DB::table('tbl_riwayatstatuslms')->insert($riwayat);

        //     if($result){
        //         return response()->json([
        //             'status' => 200,
        //             'message' => 'Data berhasil tersimpan'
        //         ]);
        //     }

        // }

        // if($result){
        //     return response()->json([
        //         'status' => 200,
        //         'message' => 'Data berhasil tersimpan'
        //     ]);
        // }
    }

    public function simpan_tanggapan_mms(Request $req)
    {
        $dataTanggapan = $req->post('dataTanggapan');
        $mmsId = $req->post('mmsId');

        DB::beginTransaction();
        try {
            $data = [
                'id_mms' => $mmsId,
                'badge_id' => session('loggedInUser')['session_badge'],
                'respon' => $dataTanggapan,
                'waktu' => date('Y-m-d H:i:s'),
            ];

            // dd($data);

            DB::table('tbl_tanggapanmms')->insert($data);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Tanggapan berhasil tersimpan',
            ]);
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status' => 400,
                'message' => 'gagal menyimpan' . $ex->getMessage(),
            ]);
        }
    }

    // handle update
    public function update_pengajuan_mms(Request $req)
    {
        $setStatus = $req->post('setStatus');
        $pesan = 'Ada pembaruan pada pengajuan MMS Kamu';
        $send = false;

        // dd($setStatus);

        $mmsId = $req->post('mmsId');
        $roles = intval(session()->get('loggedInUser')['session_roles']);

        $oldDataStatusMMS = DB::table('tbl_mms')
            ->select('status_pendaftaran_mms', 'player_id', 'badge_id')
            ->where('id', $mmsId)
            ->first();
        $oldStatusMMS = '';
        $player_id_user = $oldDataStatusMMS->player_id;
        $badge_id = $oldDataStatusMMS->badge_id;
        if ($oldDataStatusMMS) {
            $oldStatusMMS = intval($oldDataStatusMMS->status_pendaftaran_mms);
        }

        if ($setStatus != '') {
            DB::beginTransaction();
            try {
                if ($setStatus == 'tolak') {
                    // hrd staff
                    if ($roles == 63) {
                        if ($oldStatusMMS == 2) {
                            DB::table('tbl_mms')
                                ->where('id', $mmsId)
                                ->update(['status_pendaftaran_mms' => 3]);

                            $riwayat = [
                                [
                                    'id_mms' => $mmsId,
                                    'status_mms' => 3,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                                // [
                                //     'id_mms' => $mmsId,
                                //     'status_mms' => 15,
                                //     'createby' => session('loggedInUser')['session_badge'],
                                //     'createdate' => date('Y-m-d H:i:s'),
                                // ],
                            ];

                            DB::table('tbl_riwayatstatusmms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menolak pengajuan ini',
                            ]);
                        }
                    }

                    // hrd manager
                    if ($roles == 64) {
                        $send = true;
                        $pesan = 'MMS Telah di Tolak HRD Manager';
                        if ($oldStatusMMS == 4 || $oldStatusMMS == 2) {
                            DB::table('tbl_mms')
                                ->where('id', $mmsId)
                                ->update(['status_pendaftaran_mms' => 5]);
                            $riwayat = [
                                [
                                    'id_mms' => $mmsId,
                                    'status_mms' => 5,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                                // [
                                //     'id_mms' => $mmsId,
                                //     'status_mms' => 15,
                                //     'createby' => session('loggedInUser')['session_badge'],
                                //     'createdate' => date('Y-m-d H:i:s'),
                                // ],
                            ];

                            DB::table('tbl_riwayatstatusmms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menolak pengajuan ini',
                            ]);
                        }
                    }

                    // qhse staff
                    if ($roles == 65) {
                        if ($oldStatusMMS == 7) {
                            DB::table('tbl_mms')
                                ->where('id', $mmsId)
                                ->update(['status_pendaftaran_mms' => 8]);
                            $riwayat = [
                                [
                                    'id_mms' => $mmsId,
                                    'status_mms' => 8,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                                // [
                                //     'id_mms' => $mmsId,
                                //     'status_mms' => 15,
                                //     'createby' => session('loggedInUser')['session_badge'],
                                //     'createdate' => date('Y-m-d H:i:s'),
                                // ],
                            ];

                            DB::table('tbl_riwayatstatusmms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menolak pengajuan ini',
                            ]);
                        }
                    }

                    // qhse manager
                    if ($roles == 66) {
                        if ($oldStatusMMS == 9 || $oldStatusMMS == 7) {
                            $send = true;
                            $pesan = 'MMS Telah di Tolak QHSE Manager';
                            DB::table('tbl_mms')
                                ->where('id', $mmsId)
                                ->update(['status_pendaftaran_mms' => 10]);
                            $riwayat = [
                                [
                                    'id_mms' => $mmsId,
                                    'status_mms' => 10,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                                // [
                                //     'id_mms' => $mmsId,
                                //     'status_mms' => 12,
                                //     'createby' => session('loggedInUser')['session_badge'],
                                //     'createdate' => date('Y-m-d H:i:s'),
                                // ],
                            ];

                            DB::table('tbl_riwayatstatusmms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menolak pengajuan ini',
                            ]);
                        }
                    }

                    // MIS manager
                    if ($roles == 67) {
                        //     if($oldStatusMMS == 12){

                        //         DB::table('tbl_mms')->where('id', $mmsId)->update(['status_pendaftaran_mms' => 13]);
                        //         $riwayat = [
                        //             [
                        //                 'id_lms' => $mmsId,
                        //                 'status_lms' => 13,
                        //                 'createby' => session('loggedInUser')['session_badge'],
                        //                 'createdate' => date('Y-m-d H:i:s'),
                        //             ],
                        //             [
                        //                 'id_lms' => $mmsId,
                        //                 'status_lms' => 15,
                        //                 'createby' => session('loggedInUser')['session_badge'],
                        //                 'createdate' => date('Y-m-d H:i:s'),
                        //             ],
                        //         ];

                        //         DB::table('tbl_riwayatstatuslms')->insert($riwayat);

                        //     }else{
                        return response()->json([
                            'status' => 400,
                            'message' => 'Kamu tidak boleh menolak pengajuan ini',
                        ]);
                        //     }
                    }
                } elseif ($setStatus == 'terima') {
                    // hrd staff
                    if ($roles == 63) {
                        if ($oldStatusMMS == 2) {
                            DB::table('tbl_mms')
                                ->where('id', $mmsId)
                                ->update(['status_pendaftaran_mms' => '4']);

                            $riwayat = [
                                [
                                    'id_mms' => $mmsId,
                                    'status_mms' => 4,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                            ];

                            DB::table('tbl_riwayatstatusmms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menerima pengajuan ini',
                            ]);
                        }
                    }

                    // hrd manager
                    if ($roles == 64) {
                        if ($oldStatusMMS == 2 || $oldStatusMMS == 4) {
                            DB::table('tbl_mms')
                                ->where('id', $mmsId)
                                ->update(['status_pendaftaran_mms' => 7]);
                            $riwayat = [
                                [
                                    'id_mms' => $mmsId,
                                    'status_mms' => 6,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                                [
                                    'id_mms' => $mmsId,
                                    'status_mms' => 7,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                            ];

                            DB::table('tbl_riwayatstatusmms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menerima pengajuan ini',
                            ]);
                        }
                    }

                    // qhse staff
                    if ($roles == 65) {
                        if ($oldStatusMMS == 7) {
                            DB::table('tbl_mms')
                                ->where('id', $mmsId)
                                ->update(['status_pendaftaran_mms' => 9]);
                            $riwayat = [
                                [
                                    'id_mms' => $mmsId,
                                    'status_mms' => 9,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                            ];

                            DB::table('tbl_riwayatstatusmms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menerima pengajuan ini',
                            ]);
                        }
                    }

                    // qhse manager
                    if ($roles == 66) {
                        if ($oldStatusMMS == 7 || $oldStatusMMS == 9) {
                            $send = true;
                            $pesan = 'MMS Telah di Approve';
                            DB::table('tbl_mms')
                                ->where('id', $mmsId)
                                ->update(['status_pendaftaran_mms' => 12, 'is_active' => '1']);
                            $riwayat = [
                                [
                                    'id_mms' => $mmsId,
                                    'status_mms' => 11,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                                [
                                    'id_mms' => $mmsId,
                                    'status_mms' => 12,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                            ];

                            DB::table('tbl_riwayatstatusmms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menerima pengajuan ini',
                            ]);
                        }
                    }
                }

                DB::commit();
                if ($send) {
                    // $this->sendNotifMMS($player_id_user, $pesan);
                    $this->sendNotifMMS($badge_id, $pesan);
                }

                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil tersimpan',
                ]);
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json([
                    'status' => 400,
                    'message' => 'gagal menyimpan' . $ex->getMessage(),
                ]);
            }
        }
    }

    // list tanggapan
    public function tanggapan_list(Request $req)
    {
        $idMMS = $req->get('idMMS');

        $qDataTanggapan = "SELECT
        (SELECT fullname FROM tbl_karyawan WHERE badge_id=tt.badge_id) as fullname, 
        (SELECT img_user FROM tbl_karyawan WHERE badge_id=tt.badge_id) as photo, 
        tt.respon, 
        tt.waktu  
        FROM tbl_tanggapanmms tt WHERE tt.id_mms=$idMMS ORDER BY tt.id DESC";
        $dataTanggapan = DB::select($qDataTanggapan);

        return response()->json([
            'status' => 200,
            'dataTanggapan' => $dataTanggapan,
        ]);
    }

    public function set_inactive_mobile(Request $req)
    {
        $valMMSId = $req->get('valMMSId');
        $status = (int) $req->get('status');

        // dd($status);

        DB::beginTransaction();
        try {
            // dd($valMMSId);
            DB::table('tbl_mms')
                ->where('id', $valMMSId)
                ->update([
                    'is_active' => $status,
                    'is_new_uuid' => 1,
                    'updateby' => session('loggedInUser')['session_badge'],
                    'updatedate' => date('Y-m-d H:i:s'),
                ]);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil tersimpan',
            ]);
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status' => 400,
                'message' => 'gagal menyimpan' . $ex->getMessage(),
            ]);
        }
    }

    // update barcode label
    public function update_barcode_label(Request $req)
    {
        $valMMSId = $req->get('valMMSId');
        $txUpdateBarcodeLabel = $req->get('txUpdateBarcodeLabel');

        // checkbarcode label
        DB::beginTransaction();
        try {
            $check = DB::table('tbl_mms')
                ->where('barcode_label', $txUpdateBarcodeLabel)
                ->count();

            if ($check > 0) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Barcode label sudah terpakai pada mobile yang lain',
                ]);
            } else {
                DB::table('tbl_mms')
                    ->where('id', $valMMSId)
                    ->update([
                        'barcode_label' => $txUpdateBarcodeLabel,
                        'updateby' => session('loggedInUser')['session_badge'],
                        'updatedate' => date('Y-m-d H:i:s'),
                    ]);
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Barcode Label berhasil di update',
                'barcode' => $txUpdateBarcodeLabel,
            ]);
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status' => 400,
                'message' => 'gagal menyimpan' . $ex->getMessage(),
            ]);
        }
    }

    // fungsi decrypt uuid
    public function decrypt_uuid(Request $req)
    {
        $uuid = $req->get('uuid');
        $key = env('AES_KEY');
        $iv = env('AES_IV');

        if ($uuid) {
            $decryptedData = openssl_decrypt(base64_decode($uuid), 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

            if ($decryptedData != false) {
                $explode = explode(';', $decryptedData);
                $uuidIndex = $explode[0];

                return response()->json([
                    'status' => 200,
                    'message' => $uuidIndex,
                ]);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Gagal membaca UUID',
                ]);
            }
        }
    }

    public function update_uuid(Request $req)
    {
        $valMMSId = $req->get('valMMSId');
        $txUpdateUUID = $req->get('txUpdateUUID');

        // checkbarcode label
        DB::beginTransaction();
        try {
            $check = DB::table('tbl_mms')
                ->where('uuid', $txUpdateUUID)
                ->count();

            if ($check > 0) {
                return response()->json([
                    'status' => 400,
                    'message' => 'UUID sudah terpakai pada mobile yang lain',
                ]);
            } else {
                DB::table('tbl_mms')
                    ->where('id', $valMMSId)
                    ->update([
                        'uuid' => $txUpdateUUID,
                        'updateby' => session('loggedInUser')['session_badge'],
                        'updatedate' => date('Y-m-d H:i:s'),
                    ]);
            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'UUID berhasil di update',
                'barcode' => $txUpdateUUID,
            ]);
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status' => 400,
                'message' => 'gagal menyimpan' . $ex->getMessage(),
            ]);
        }
    }

    // update barcode label
    public function update_tipe_hp(Request $req)
    {
        $valMMSId = $req->get('valMMSId');
        $txUpdateTipeHp = $req->get('txUpdateTipeHp');

        // checkbarcode label
        DB::beginTransaction();
        try {
            // }
            DB::table('tbl_mms')
                ->where('id', $valMMSId)
                ->update([
                    'tipe_hp' => $txUpdateTipeHp,
                    'updateby' => session('loggedInUser')['session_badge'],
                    'updatedate' => date('Y-m-d H:i:s'),
                ]);

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Tipe Hp berhasil di update',
            ]);
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status' => 400,
                'message' => 'gagal menyimpan' . $ex->getMessage(),
            ]);
        }
    }

    // send notifikasi dengan mms
    public function sendNotifMMS($badge_id, $pesan)
    {
        $query_player_id = "SELECT player_id FROM tbl_mms WHERE badge_id = '$badge_id'";
        $data_player_id = DB::select($query_player_id);

        $arr_playerId = [];
        foreach ($data_player_id as $key => $value) {
            if ($value->player_id != null) {
                array_push($arr_playerId, $value->player_id);
            }
        }

        // URL Endpoint API OneSignal
        $url = 'https://onesignal.com/api/v1/notifications';

        // Data untuk dikirim dalam permintaan
        $data = [
            'app_id' => 'ef44a0e1-1de9-48a0-b4c5-9e045d45c0cf',
            'include_player_ids' => $arr_playerId,
            'headings' => [
                'en' => $pesan,
            ],
            'contents' => [
                'en' => 'Tap untuk membaca informasi lebih lanjut',
            ],
            'data' => [
                'Category' => 'MMS',
            ],
        ];

        // Konversi data ke format JSON
        $dataJson = json_encode($data);

        // Pengaturan opsi cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Basic NmQ2ODI0YjEtNjZhYy00ZDA3LWJkMDEtY2ViZDJjZWNmMTk5', 'Content-Type: application/json']);
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

        DB::table('tbl_notification')->insert([
            'title' => $pesan,
            'description' => 'Ada status terbaru mengenai pengajuan MMS kamu. Ketuk untuk lihat detailnya.',
            'category' => 'MMS',
            'createdate' => now(),
            'badge_id' => $badge_id,
            'isread' => 0,
        ]);
        return true;
    }


    // // send notifikasi dengan mms
    // public function sendNotifMMS1($badge_id, $title, $pesan, $category)
    // {

    //     // $query_player_id = "SELECT player_id FROM tbl_mms WHERE badge_id = '$badge_id'";
    //     // $data_player_id = DB::select($query_player_id);

    //     // $arr_playerId = [];
    //     // foreach ($data_player_id as $key => $value) {
    //     //    if($value->player_id != null){
    //     //         array_push($arr_playerId, $value->player_id);
    //     //    }
    //     // }


    //     // URL Endpoint API OneSignal
    //     $url = 'https://192.168.88.62:7005/api/notifikasi/send';

    //     // Data untuk dikirim dalam permintaan
    //     $data = [
    //         'badge_id' => $badge_id,
    //         'message' => $title,
    //         'sub_message' => $pesan,
    //         'category' => $category,
    //         'tag' => 'MEETING', 
    //     ];

    //     // Konversi data ke format JSON
    //     $dataJson = json_encode($data);

    //     // Pengaturan opsi cURL
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, []);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    //     // Eksekusi permintaan cURL
    //     $response = curl_exec($ch);

    //     // Periksa jika ada kesalahan dalam permintaan
    //     if (curl_errno($ch)) {
    //         $error = curl_error($ch);
    //         // Lakukan penanganan kesalahan yang sesuai
    //         // ...
    //     }

    //     // Mendapatkan informasi respons
    //     $info = curl_getinfo($ch);
    //     $httpCode = $info['http_code'];

    //     // Menutup koneksi cURL
    //     curl_close($ch);

    //     // Menampilkan respons
    //     // echo 'HTTP Status Code: ' . $httpCode . PHP_EOL;
    //     // echo 'Response: ' . $response . PHP_EOL;



    //     return true;
    // }
}
