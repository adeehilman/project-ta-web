<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LMSController extends Controller
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

        return view('device.lms', $data);
    }

    public function lms_list(Request $req)
    {
        $txSearch = '%' . strtoupper($req->get('txSearch')) . '%';
        $output = '';

        $qFilter = '';

        $alasan = intval($req->get('alasan'));
        $durasi = intval($req->get('durasi'));
        $pengajuan = intval($req->get('pengajuan'));
        $waktuPengajuan = intval($req->get('waktuPengajuan'));
        $sStatus = intval($req->get('sStatus'));
        $fStatus = intval($req->get('fStatus'));

        // filter by filterData Button
        if ($alasan > 0) {
            $qFilter .= " AND alasan_id=$alasan";
        }
        if ($durasi > 0) {
            $qFilter .= " AND durasi_id=$durasi";
        }
        if ($pengajuan > 0) {
            $qFilter .= " AND status_pendaftaran_lms_id=$pengajuan";
        }

        // filter notifikasi
        if ($fStatus > 0) {
            $qFilter .= ' AND status_pendaftaran_lms_id < 15';
        }

        if ($waktuPengajuan > 0) {
            if ($waktuPengajuan == 1) {
                $startDate = date('Y-m-d H:i:s', strtotime('-1 day'));
                $endDate = date('Y-m-d H:i:s');
                $qFilter .= " AND (tanggal_pengajuan BETWEEN '$startDate' AND '$endDate')";
            }

            if ($waktuPengajuan == 7) {
                $startDate = date('Y-m-d H:i:s', strtotime('-7 day'));
                $endDate = date('Y-m-d H:i:s');
                $qFilter .= " AND (tanggal_pengajuan BETWEEN '$startDate' AND '$endDate')";
            }

            if ($waktuPengajuan == 30) {
                $startDate = date('Y-m-d H:i:s', strtotime('-30 day'));
                $endDate = date('Y-m-d H:i:s');
                $qFilter .= " AND (tanggal_pengajuan BETWEEN '$startDate' AND '$endDate')";
            }
            if ($waktuPengajuan == 365) {
                $startDate = date('Y-m-d H:i:s', strtotime('-365 day'));
                $endDate = date('Y-m-d H:i:s');
                $qFilter .= " AND (tanggal_pengajuan BETWEEN '$startDate' AND '$endDate')";
            }
        }

        $q = "SELECT brand, fullname, badge_id, dept_name, id, tipe_laptop, barcode_label, alasan, alasan_id, durasi, durasi_id, tanggal_pengajuan, status_pendaftaran_lms, status_pendaftaran_lms_id FROM
        (SELECT
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=lms.brand) AS brand,
        (SELECT fullname FROM tbl_karyawan WHERE badge_id=lms.badge_id) AS fullname,
        (SELECT (SELECT dept_name FROM tbl_deptcode WHERE dept_code=a.dept_code) FROM tbl_karyawan a WHERE a.badge_id=lms.badge_id) AS dept_name,
        lms.id,
        lms.tipe_laptop,
        lms.badge_id,
        lms.barcode_label,
        lms.alasan AS alasan_id,
        lms.durasi AS durasi_id,
        lms.status_pendaftaran_lms AS status_pendaftaran_lms_id,
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=lms.alasan) AS alasan,
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=lms.durasi) AS durasi,
        lms.tanggal_pengajuan,
        (SELECT stat_title FROM `tbl_statuslms` WHERE id=lms.`status_pendaftaran_lms`) AS status_pendaftaran_lms
        FROM `tbl_lms` lms) AS a
        WHERE (UPPER(fullname) LIKE '$txSearch' OR UPPER(badge_id) LIKE '$txSearch' OR UPPER(dept_name) LIKE '$txSearch' OR UPPER(brand) LIKE '$txSearch' OR UPPER(tipe_laptop) LIKE '$txSearch' OR UPPER(barcode_label) LIKE '$txSearch' OR UPPER(alasan) LIKE '$txSearch' OR UPPER(durasi) LIKE '$txSearch' OR UPPER(tanggal_pengajuan) LIKE '$txSearch' OR UPPER(status_pendaftaran_lms) LIKE '$txSearch') $qFilter ORDER BY id DESC LIMIT 100;";

        $data = DB::select($q);

        $output .= '
        <table style="font-size: 18px;" id="tableLMS" class="table table-responsive table-hover">
            <thead>
                <tr style="color: #CD202E; height: -10px;" class="table-danger">
                    <th class="p-3" scope="col">Badge</th>
                    <th class="p-3" scope="col">Full Name</th>
                    <th class="p-3" scope="col">Department</th>
                    <th class="p-3" scope="col">Merek Laptop</th>
                    <th class="p-3" scope="col">Type Laptop</th>
                    <th class="p-3" scope="col">Device Number</th>
                    <th class="p-3" scope="col">Alasan Permintaan</th>
                    <th class="p-3" scope="col">Durasi Pemakaian</th>
                    <th class="p-3" scope="col">Waktu Pengajuan</th>
                    <th class="p-3" scope="col">Status Pengajuan</th>
                    <th class="p-3 text-center" scope="col">Detail</th>
                </tr>
            </thead>
            <tbody>
        ';

        if ($data) {
            foreach ($data as $row) {
                $output .=
                    '
                <tr style="font-size: 18px;">
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
                    $row->brand .
                    '</td>
                    <td class="p-3">' .
                    $row->tipe_laptop .
                    '</td>
                    <td class="p-3">' .
                    $row->barcode_label .
                    '</td>
                    <td class="p-3">' .
                    $row->alasan .
                    '</td>
                    <td class="p-3">' .
                    $row->durasi .
                    '</td>
                    <td class="p-3">' .
                    date('d M Y', strtotime($row->tanggal_pengajuan)) .
                    '</td>
                    <td class="p-3">' .
                    $row->status_pendaftaran_lms .
                    '</td>
                    <td class="text-center">
                        <a class="btn btnView" href="javascript:void(0)" data-id="' .
                    $row->id .
                    '"><i style="font-size: 24px;" class="bx bx-file-find text-muted"></i></a>
                    </td>
                </tr>
                ';
            }
        } else {
            $output = '<div class="text-center mt-5">Data tidak ditemukan</div>';
        }

        $output .= '</tbody></table>';

        return $output;
    }

    public function merek_laptop_list()
    {
        $q = "SELECT id_vlookup, name_vlookup FROM tbl_vlookup WHERE category='BRL'";
        $data = DB::select($q);

        if ($data) {
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        }
    }

    public function durasi_pemakaian_list()
    {
        $q = "SELECT id_vlookup, name_vlookup FROM tbl_vlookup WHERE category='DL'";
        $data = DB::select($q);

        if ($data) {
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        }
    }

    public function alasan_list()
    {
        $q = "SELECT id_vlookup, name_vlookup FROM tbl_vlookup WHERE category='ALP'";
        $data = DB::select($q);

        if ($data) {
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        }
    }

    // permohonan_list
    public function status_permohonan_list_laptop()
    {
        $q = 'SELECT id, stat_title FROM tbl_statuslms';
        $data = DB::select($q);

        if ($data) {
            return response()->json([
                'status' => 200,
                'data' => $data,
            ]);
        }
    }

    public function get_lms_by_id(Request $req)
    {
        $dataId = $req->get('dataId');
        $qLMS = "SELECT
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=lms.brand) AS brand,
        lms.tipe_laptop,
        lms.badge_id,
        lms.id,
        lms.barcode_label,
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=alasan) AS alasan,
        lms.desc_alasan,
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=durasi) AS durasi,
        lms.tanggal_pengajuan,
        (SELECT stat_title FROM tbl_statuslms WHERE id=lms.status_pendaftaran_lms) AS status_pendaftaran_lms,
        lms.status_pendaftaran_lms AS status_pendaftaran_lms_id,
        lms.img_dpn,
        lms.img_blk
        FROM tbl_lms lms WHERE lms.id='$dataId'";
        $dataLMS = DB::select($qLMS);
        $idStatusPendaftaranLMS = '';

        $badge_id = '';
        if ($dataLMS) {
            $badge_id = $dataLMS[0]->badge_id;

            $idStatusPendaftaranLMS = $dataLMS[0]->status_pendaftaran_lms_id;
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
        (SELECT stat_title FROM tbl_statuslms WHERE id=rw.status_lms) AS stat_title,
        (SELECT stat_desc FROM tbl_statuslms WHERE id=rw.status_lms) AS stat_desc,
        rw.createby,
        rw.createdate
        FROM tbl_riwayatstatuslms rw WHERE id_lms = '$dataId' ORDER BY rw.id ASC";
        $dataRiwayat = DB::select($qRiwayat);

        $qRiwayat2 = "SELECT * FROM tbl_statuslms WHERE id > $idStatusPendaftaranLMS AND (UPPER(stat_title) LIKE 'SE%')";
        $dataRiwayat2 = DB::select($qRiwayat2);

        $qDataTanggapan = "SELECT
        (SELECT fullname FROM tbl_karyawan WHERE badge_id=tt.badge_id) as fullname,
        (SELECT img_user FROM tbl_karyawan WHERE badge_id=tt.badge_id) as photo,
        tt.respon,
        tt.waktu
        FROM tbl_tanggapanlms tt WHERE tt.id_lms=$dataId ORDER BY tt.id DESC";
        $dataTanggapan = DB::select($qDataTanggapan);

        return response()->json([
            'status' => 200,
            'dataLMS' => $dataLMS,
            'dataKaryawan' => $dataKaryawan,
            'dataRiwayat' => $dataRiwayat,
            'dataTanggapan' => $dataTanggapan,
            'dataRiwayat2' => $dataRiwayat2,
        ]);
    }

    public function simpan_lms(Request $req)
    {
        // ambil roles
        $roles = intval(session()->get('loggedInUser')['session_roles']);

        // init gambar
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
            // $base64String2 = 'data:image/png;base64,' . base64_encode($fileContent2);
            $fileContent = file_get_contents($file2->getRealPath());
            $base64String2 = 'data:image/png;base64,' . base64_encode($fileContent);
        }
        if ($file1Camera) {
            // $binary1 = base64_decode($file1Camera);
            // $fileName1Camera = uniqid() . '.jpeg';
            // $result1 = file_put_contents('img/'.$fileName1Camera, $binary1);
            $binary1 = base64_decode($file1Camera);
            $base64StringCamera1 = 'data:image/png;base64,' . base64_encode($binary1);
        }

        if ($file2Camera) {
            // $binary2 = base64_decode($file2Camera);
            // $fileName2Camera = uniqid() . '.jpeg';
            // $result2 = file_put_contents('img/'.$fileName2Camera, $binary2);
            $binary2 = base64_decode($file2Camera);
            $base64StringCamera2 = 'data:image/png;base64,' . base64_encode($binary2);
        }

        DB::beginTransaction();
        try {
            // staff HRD
            if ($roles == 63) {
                $data = [
                    'badge_id' => $req->post('txBadge'),
                    'brand' => $req->post('selectMerekLaptop'),
                    'tipe_laptop' => $req->post('txTipeLaptop'),
                    'barcode_label' => $req->post('txNoSerial'),
                    'alasan' => $req->post('selectAlasanPermintaan'),
                    'desc_alasan' => $req->post('selectAlasanPermintaan') != '62' ? null : $req->post('txAlasanDeskripsi'),
                    'asset_number' => $req->post('txAssetNumber'),
                    'durasi' => $req->post('selectDurasiPemakaian'),
                    'start_date' => $req->post('selectDurasiPemakaian') != '58' ? date('Y-m-d', strtotime($req->post('txMulaiMemakai'))) : null,
                    'end_date' => $req->post('selectDurasiPemakaian') != '58' ? date('Y-m-d', strtotime($req->post('txSelesaiMemakai'))) : null,
                    'img_dpn' => $req->post('checkUploadFoto') == 'on' ? $base64String1 : $base64StringCamera1,
                    'img_blk' => $req->post('checkUploadFoto') == 'on' ? $base64String2 : $base64StringCamera2,
                    'status_pendaftaran_lms' => 4,
                    'tanggal_pengajuan' => date('Y-m-d'),
                ];

                $idLMS = DB::table('tbl_lms')->insertGetId($data);

                if ($idLMS) {
                    $riwayat = [
                        [
                            'id_lms' => $idLMS,
                            'status_lms' => 1,
                            'createby' => session('loggedInUser')['session_badge'],
                            'createdate' => date('Y-m-d H:i:s'),
                        ],
                        [
                            'id_lms' => $idLMS,
                            'status_lms' => 2,
                            'createby' => session('loggedInUser')['session_badge'],
                            'createdate' => date('Y-m-d H:i:s'),
                        ],
                        [
                            'id_lms' => $idLMS,
                            'status_lms' => 4,
                            'createby' => session('loggedInUser')['session_badge'],
                            'createdate' => date('Y-m-d H:i:s'),
                        ],
                    ];

                    DB::table('tbl_riwayatstatuslms')->insert($riwayat);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'LMS gagal tersimpan',
                    ]);
                }

                // Manager HRD
            } elseif ($roles == 64) {
                $data = [
                    'badge_id' => $req->post('txBadge'),
                    'brand' => $req->post('selectMerekLaptop'),
                    'tipe_laptop' => $req->post('txTipeLaptop'),
                    'barcode_label' => $req->post('txNoSerial'),
                    'alasan' => $req->post('selectAlasanPermintaan'),
                    'desc_alasan' => $req->post('selectAlasanPermintaan') != '62' ? null : $req->post('txAlasanDeskripsi'),
                    'asset_number' => $req->post('txAssetNumber'),
                    'durasi' => $req->post('selectDurasiPemakaian'),
                    'start_date' => $req->post('selectDurasiPemakaian') != '58' ? date('Y-m-d', strtotime($req->post('txMulaiMemakai'))) : null,
                    'end_date' => $req->post('selectDurasiPemakaian') != '58' ? date('Y-m-d', strtotime($req->post('txSelesaiMemakai'))) : null,
                    'img_dpn' => $req->post('checkUploadFoto') == 'on' ? $base64String1 : $base64StringCamera1,
                    'img_blk' => $req->post('checkUploadFoto') == 'on' ? $base64String2 : $base64StringCamera2,
                    'status_pendaftaran_lms' => 7,
                    'tanggal_pengajuan' => date('Y-m-d'),
                ];

                $idLMS = DB::table('tbl_lms')->insertGetId($data);

                if ($idLMS) {
                    $riwayat = [
                        [
                            'id_lms' => $idLMS,
                            'status_lms' => 1,
                            'createby' => session('loggedInUser')['session_badge'],
                            'createdate' => date('Y-m-d H:i:s'),
                        ],
                        [
                            'id_lms' => $idLMS,
                            'status_lms' => 6,
                            'createby' => session('loggedInUser')['session_badge'],
                            'createdate' => date('Y-m-d H:i:s'),
                        ],
                        [
                            'id_lms' => $idLMS,
                            'status_lms' => 7,
                            'createby' => session('loggedInUser')['session_badge'],
                            'createdate' => date('Y-m-d H:i:s'),
                        ],
                    ];

                    DB::table('tbl_riwayatstatuslms')->insert($riwayat);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'LMS gagal tersimpan',
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
    }

    public function simpan_tanggapan_lms(Request $req)
    {
        $dataTanggapan = $req->post('dataTanggapan');
        $lmsId = $req->post('lmsId');

        DB::beginTransaction();
        try {
            $data = [
                'id_lms' => $lmsId,
                'badge_id' => session('loggedInUser')['session_badge'],
                'respon' => $dataTanggapan,
                'waktu' => date('Y-m-d H:i:s'),
            ];

            DB::table('tbl_tanggapanlms')->insert($data);

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

        // if($dataTanggapan){

        //     $data = array(
        //         'id_lms' => $lmsId,
        //         'badge_id' => session('loggedInUser'),
        //         'respon' => $dataTanggapan,
        //         'waktu' => date('Y-m-d H:i:s')
        //     );

        //     $result = DB::table('tbl_tanggapanlms')->insert($data);

        //     if($result){
        //         return respose()->json([
        //             'status' => 200,
        //             'message' => 'Tanggapan berhasil tersimpan'
        //         ]);
        //     }

        // }
    }

    // handle check device number
    public function check_barcode_label_lms(Request $req)
    {
        // check imei
        $deviceNumber = $req->get('deviceNumber');

        $qDeviceNumber = "SELECT COUNT(*) as count FROM tbl_lms WHERE barcode_label='$deviceNumber'";
        $countDeviceNumber = DB::select($qDeviceNumber);

        if ($countDeviceNumber[0]->count > 0) {
            return response()->json([
                'status' => 400,
                'message' => 'Device number sudah terdaftar atau duplikat',
            ]);
        }
    }

    // handle check barcode label
    public function check_asset_number(Request $req)
    {
        // check imei
        $assetNumber = $req->get('assetNumber');

        $qAssetNumber = "SELECT COUNT(*) as count FROM tbl_lms WHERE asset_number='$assetNumber'";
        $countAssetNumber = DB::select($qAssetNumber);

        if ($countAssetNumber[0]->count > 0) {
            return response()->json([
                'status' => 400,
                'message' => 'Asset number sudah terdaftar atau duplikat',
            ]);
        }
    }

    // handle update
    public function update_pengajuan_lms(Request $req)
    {
        $setStatus = $req->post('setStatus');
        $pesan = 'Ada pembaruan pada pengajuan MMS Kamu';
        $send = false;

        // dd($setStatus);

        $lmsId = $req->post('lmsId');
        $roles = intval(session()->get('loggedInUser')['session_roles']);

        $oldDataStatusLMS = DB::table('tbl_lms')
            ->select('status_pendaftaran_lms', 'badge_id')
            ->where('id', $lmsId)
            ->first();
        $oldStatusLMS = '';
        $badge_id = $oldDataStatusLMS->badge_id;
        if ($oldDataStatusLMS) {
            $oldStatusLMS = intval($oldDataStatusLMS->status_pendaftaran_lms);
        }

        if ($setStatus != '') {
            DB::beginTransaction();
            try {
                if ($setStatus == 'tolak') {
                    // hrd staff
                    if ($roles == 63) {
                        if ($oldStatusLMS == 2) {
                            DB::table('tbl_lms')
                                ->where('id', $lmsId)
                                ->update(['status_pendaftaran_lms' => 3]);

                            $riwayat = [
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 3,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 15,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                            ];

                            DB::table('tbl_riwayatstatuslms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menolak pengajuan ini',
                            ]);
                        }
                    }

                    // hrd manager
                    if ($roles == 64) {
                        if ($oldStatusLMS == 4 || $oldStatusLMS == 2) {
                            $send = true;
                            $pesan = 'LMS Telah di Tolak HRD Manager';

                            DB::table('tbl_lms')
                                ->where('id', $lmsId)
                                ->update(['status_pendaftaran_lms' => 5]);
                            $riwayat = [
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 5,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 15,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                            ];

                            DB::table('tbl_riwayatstatuslms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menolak pengajuan ini',
                            ]);
                        }
                    }

                    // qhse staff
                    if ($roles == 65) {
                        if ($oldStatusLMS == 7) {
                            DB::table('tbl_lms')
                                ->where('id', $lmsId)
                                ->update(['status_pendaftaran_lms' => 8]);
                            $riwayat = [
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 8,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 15,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                            ];

                            DB::table('tbl_riwayatstatuslms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menolak pengajuan ini',
                            ]);
                        }
                    }

                    // qhse manager
                    if ($roles == 66) {
                        if ($oldStatusLMS == 9 || $oldStatusLMS == 7) {
                            $send = true;
                            $pesan = 'LMS Telah di Tolak QHSE Manager';

                            DB::table('tbl_lms')
                                ->where('id', $lmsId)
                                ->update(['status_pendaftaran_lms' => 10]);
                            $riwayat = [
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 10,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 12,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                            ];

                            DB::table('tbl_riwayatstatuslms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menolak pengajuan ini',
                            ]);
                        }
                    }

                    // MIS manager
                    if ($roles == 67) {
                        if ($oldStatusLMS == 12) {
                            $send = true;
                            $pesan = 'LMS Telah di Tolak MIS Manager';

                            DB::table('tbl_lms')
                                ->where('id', $lmsId)
                                ->update(['status_pendaftaran_lms' => 13]);
                            $riwayat = [
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 13,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 15,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                            ];

                            DB::table('tbl_riwayatstatuslms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menolak pengajuan ini',
                            ]);
                        }
                    }
                } elseif ($setStatus == 'terima') {
                    // hrd staff
                    if ($roles == 63) {
                        if ($oldStatusLMS == 2) {
                            DB::table('tbl_lms')
                                ->where('id', $lmsId)
                                ->update(['status_pendaftaran_lms' => '4']);

                            $riwayat = [
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 4,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                            ];

                            // dd($roles);

                            DB::table('tbl_riwayatstatuslms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menerima pengajuan ini',
                            ]);
                        }
                    }

                    // hrd manager
                    if ($roles == 64) {
                        if ($oldStatusLMS == 2 || $oldStatusLMS == 4) {
                            DB::table('tbl_lms')
                                ->where('id', $lmsId)
                                ->update(['status_pendaftaran_lms' => 7]);
                            $riwayat = [
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 6,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 7,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                            ];

                            DB::table('tbl_riwayatstatuslms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menerima pengajuan ini',
                            ]);
                        }
                    }

                    // qhse staff
                    if ($roles == 65) {
                        if ($oldStatusLMS == 7) {
                            DB::table('tbl_lms')
                                ->where('id', $lmsId)
                                ->update(['status_pendaftaran_lms' => 9]);
                            $riwayat = [
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 9,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                            ];

                            DB::table('tbl_riwayatstatuslms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menerima pengajuan ini',
                            ]);
                        }
                    }

                    // qhse manager
                    if ($roles == 66) {
                        if ($oldStatusLMS == 9 || $oldStatusLMS == 7) {
                            DB::table('tbl_lms')
                                ->where('id', $lmsId)
                                ->update(['status_pendaftaran_lms' => 12]);
                            $riwayat = [
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 11,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 12,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                            ];

                            DB::table('tbl_riwayatstatuslms')->insert($riwayat);
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Kamu tidak boleh menerima pengajuan ini',
                            ]);
                        }
                    }

                    // MIS manager
                    if ($roles == 67) {
                        if ($oldStatusLMS == 12) {
                            $send = true;
                            $pesan = 'LMS Telah diapprove';
                            DB::table('tbl_lms')
                                ->where('id', $lmsId)
                                ->update(['status_pendaftaran_lms' => 15, 'is_active' => '1']);
                            $riwayat = [
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 14,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                                [
                                    'id_lms' => $lmsId,
                                    'status_lms' => 15,
                                    'createby' => session('loggedInUser')['session_badge'],
                                    'createdate' => date('Y-m-d H:i:s'),
                                ],
                            ];

                            DB::table('tbl_riwayatstatuslms')->insert($riwayat);
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
                    $this->sendNotifLMS($badge_id, $pesan);
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
    public function tanggapan_list_lms(Request $req)
    {
        $idLMS = $req->get('idLMS');

        $qDataTanggapan = "SELECT
        (SELECT fullname FROM tbl_karyawan WHERE badge_id=tt.badge_id) as fullname,
        (SELECT img_user FROM tbl_karyawan WHERE badge_id=tt.badge_id) as photo,
        tt.respon,
        tt.waktu
        FROM tbl_tanggapanlms tt WHERE tt.id_lms=$idLMS ORDER BY tt.id DESC";
        $dataTanggapan = DB::select($qDataTanggapan);

        return response()->json([
            'status' => 200,
            'dataTanggapan' => $dataTanggapan,
        ]);
    }

    // recall lms
    public function recall_lms(Request $req)
    {
        $id = $req->post('id');

        DB::beginTransaction();
        if ($id) {
            try {
                DB::table('tbl_lms')
                    ->where('id', $id)
                    ->update(['is_active' => '0', 'status_pendaftaran_lms' => '16']);

                $dataRiwayat = [
                    'id_lms' => $id,
                    'status_lms' => 16,
                    'createby' => session('loggedInUser')['session_badge'],
                    'createdate' => date('Y-m-d H:i:s'),
                ];

                DB::table('tbl_riwayatstatuslms')->insert($dataRiwayat);

                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => 'LMS berhasil di Revoke',
                ]);
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json([
                    'status' => 400,
                    'message' => $ex->getMessage(),
                ]);
            }
        }
    }

    // update barcode label
    // update barcode label
    public function update_barcode_label_lms(Request $req)
    {
        $valLMSId = $req->get('valLMSId');
        $txUpdateBarcodeLabel = $req->get('txUpdateBarcodeLabel');

        // checkbarcode label
        DB::beginTransaction();
        try {
            $check = DB::table('tbl_lms')
                ->where('barcode_label', $txUpdateBarcodeLabel)
                ->count();

            if ($check > 0) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Barcode label sudah terpakai pada laptop yang lain',
                ]);
            } else {
                DB::table('tbl_lms')
                    ->where('id', $valLMSId)
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

    // send notifikasi dengan mms
    public function sendNotifLMS($badge_id, $pesan)
    {
        $query_player_id = "SELECT player_id FROM tbl_mms WHERE badge_id = '$badge_id'";
        $data_player_id = DB::select($query_player_id);

        $arr_playerId = [];
        foreach ($data_player_id as $key => $value) {
            if ($value->player_id != null) {
                array_push($arr_playerId, $value->player_id);
            }
        }

        if (COUNT($arr_playerId) == 0) {
            $query_player_id = "SELECT player_id FROM tbl_lms WHERE badge_id = '$badge_id'";
            $data_player_id = DB::select($query_player_id);
            foreach ($data_player_id as $key => $value) {
                if ($value->player_id != null) {
                    array_push($arr_playerId, $value->player_id);
                }
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
                'Category' => 'LMS',
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
            'description' => 'Ada status terbaru mengenai pengajuan LMS kamu. Ketuk untuk lihat detailnya.',
            'category' => 'LMS',
            'createdate' => now(),
            'badge_id' => $badge_id,
            'isread' => 0,
        ]);
        return true;
    }
}
