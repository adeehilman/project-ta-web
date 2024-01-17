<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;


class ProfilKaryawanController extends Controller
{
    public function index()
    {

        $data = [
            'userInfo' => DB::table('tbl_useradmin')->where('badge_id', session('loggedInUser'))->first(), 
            'userRole' => (int)session()->get('loggedInUser')['session_roles'], 
            'positionName' => DB::table('tbl_vlookup')->select('name_vlookup')->where('id_vlookup', session()->get('loggedInUser')['session_roles'])->first()->name_vlookup,
        ];

        return view('karyawan.profil', $data);
    }


    public function update_rfid(Request $req)
    {

        $badge = trim($req->post('badge'));
        $name = strtoupper($req->post('nama'));
        $rfid = strtoupper($req->post('rfidNo'));
        $txNoHp = $req->post('txNoHp');
        $txNoHp2 = $req->post('txNoHp2');
        $txNoTelp = $req->post('txNoTelp');
        $txEmail = $req->post('txEmail');
        $txRt = $req->post('txRt');
        $txRw = $req->post('txRw');
        $selectKecamatan = $req->post('selectKecamatan');
        $selectKelurahan = $req->post('selectKelurahan');
        $deskripsi = $req->post('deskripsi');
        
    
        DB::beginTransaction();
        try {
            //code...

            $checkCount = DB::table('tbl_alamat')->where('badge_id', $badge)->count();

            // Untuk tab Informasi Karyawan

            $karyawan = DB::table('tbl_karyawan')->where('badge_id', $badge)->first();

            // Periksa apakah nilai 'fullname' berbeda
            if ($karyawan->fullname !== $name) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Nama' ,
                    'tipe' => 'Nama' ,
                    'olddata' => $karyawan->fullname,
                    'newdata' => $name,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }

             // Periksa apakah nilai 'rfid' berbeda
             if ($karyawan->rfid_no !== $rfid) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'No. RFID' ,
                    'tipe' => 'No. RFID',
                    'olddata' => $karyawan->rfid_no,
                    'newdata' => $rfid,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }


            // Untuk tab Kontak dan Domisili
            
            // Periksa apakah nilai 'email' berbeda
            if ($karyawan->email !== $txEmail) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Kontak',
                    'tipe' => 'Email',
                    'olddata' => $karyawan->email,
                    'newdata' => $txEmail,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }

            // Periksa apakah nilai 'no hp' berbeda
            if ($karyawan->no_hp !== $txNoHp) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Kontak',
                    'tipe' => 'No Hp' ,
                    'olddata' => $karyawan->no_hp,
                    'newdata' => $txNoHp,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }

            // Periksa apakah nilai 'no hp 2' berbeda
            if ($karyawan->no_hp2 !== $txNoHp2) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Kontak',
                    'tipe' => 'No Hp 2' ,
                    'olddata' => $karyawan->no_hp2,
                    'newdata' => $txNoHp2,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }

            
            // Periksa apakah nilai 'home_telp' berbeda
            if ($karyawan->home_telp !== $txNoTelp) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Kontak',
                    'tipe' => 'No Home Telpon' ,
                    'olddata' => $karyawan->home_telp,
                    'newdata' => $txNoTelp,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }

            $domisili = DB::table('tbl_alamat')->where('badge_id', $badge)->first();

            // Periksa apakah nilai 'Alamat' berbeda
             if ($domisili->alamat !== $deskripsi) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Domisili',
                    'tipe' => 'Alamat' ,
                    'olddata' => $domisili->alamat,
                    'newdata' => $deskripsi,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }

            // Periksa apakah nilai 'RT' berbeda
            if ($domisili->rt != $txRt) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Domisili',
                    'tipe' => 'RT' ,
                    'olddata' => $domisili->rt,
                    'newdata' => $txRt,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }

            // Periksa apakah nilai 'RW' berbeda
             if ($domisili->rw != $txRw) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Domisili',
                    'tipe' => 'RW' ,
                    'olddata' => $domisili->rw,
                    'newdata' => $txRw,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }

            // Periksa apakah nilai 'Kecamatan' berbeda
            if ($domisili->kecamatan != $selectKecamatan) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Domisili',
                    'tipe' => 'Kecamatan' ,
                    'olddata' => $domisili->kecamatan,
                    'newdata' => $selectKecamatan,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }

            // Periksa apakah nilai 'Kelurahan' berbeda
            if ($domisili->kelurahan != $selectKelurahan) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Domisili',
                    'tipe' => 'Kelurahan' ,
                    'olddata' => $domisili->kelurahan,
                    'newdata' => $selectKelurahan,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }

            
            $data = array(
                'fullname' => $name,
                'rfid_no' => $rfid,
                'no_hp' => $txNoHp,
                'no_hp2' => $txNoHp2,
                'home_telp' => $txNoTelp,
                'email' => $txEmail,
                'updatedate' => date('Y-m-d H:i:s'), 
                'updateby' => session('loggedInUser')['session_badge']
            );

            DB::table('tbl_karyawan')->where('badge_id', $badge)->update($data);


            if($checkCount > 0){

                $dataAlamat = array(
                    'alamat' => $deskripsi, 
                    'kecamatan' => $selectKecamatan,
                    'kelurahan' => $selectKelurahan,
                    'rt' => $txRt,
                    'rw' => $txRw
                );

                DB::table('tbl_alamat')->where('badge_id', $badge)->update($dataAlamat);
                

            }else{

                
                $dataAlamat = array(
                    'badge_id' => $badge,
                    'alamat' => $deskripsi, 
                    'kecamatan' => $selectKecamatan,
                    'kelurahan' => $selectKelurahan,
                    'rt' => $txRt,
                    'rw' => $txRw
                );

                DB::table('tbl_alamat')->insert($dataAlamat);
            }  
        

            DB::commit();
            return response()->json([
                'status'    => 200, 
                'message'   => 'Data berhasil diupdate'
            ]);
            
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status'    => 401, 
                'message'   => 'gagal menyimpan' . $ex->getMessage()
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status'    => 401, 
                'message'   => 'gagal menyimpan' . $th->getMessage()
            ]);
        }

    }

    public function update_privasi(Request $req)
    {
        $badge = trim($req->post('badge'));
        $nokk = $req->post('nokk');
        $pendidikan = $req->post('pendidikan');
        $pernikahan = $req->post('pernikahan');
        $jurusan = $req->post('jurusan');
        $agama = $req->post('agama');
        $tahunLulus = $req->post('tahunLulus');
        
                              
        DB::beginTransaction();
        try {
            //code...

            $karyawan = DB::table('tbl_detailkaryawan')->where('badgeid', $badge)->first();

            $oldnokk = $karyawan->nokk;
            $decryptedNokkOld = Crypt::decryptString($oldnokk);


            // Periksa apakah nilai 'no kk' berbeda
            if ($decryptedNokkOld !== $nokk) {

                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'No. KK' ,
                    'tipe' => 'No.Kk' ,
                    'olddata' => $karyawan->nokk,
                    'newdata' => Crypt::encryptString($nokk),
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);

            }


             // Periksa apakah nilai 'Pendidikan Terakhir' berbeda
             if ($karyawan->pendidikan !== $pendidikan) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Pendidikan Terakhir' ,
                    'tipe' => 'Pendidikan Terakhir',
                    'olddata' => $karyawan->pendidikan,
                    'newdata' => $pendidikan,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }

             // Periksa apakah nilai 'Status Pernikahan' berbeda
             if ($karyawan->statusnikah !== $pernikahan) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Status Pernikahan' ,
                    'tipe' => 'Status Pernikahan',
                    'olddata' => $karyawan->statusnikah,
                    'newdata' => $pernikahan,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }

            // Periksa apakah nilai 'Jurusan' berbeda
            if ($karyawan->jurusan !== $jurusan) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Pendidikan Terakhir' ,
                    'tipe' => 'Jurusan',
                    'olddata' => $karyawan->jurusan,
                    'newdata' => $jurusan,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }

             // Periksa apakah nilai 'Agama' berbeda
             if ($karyawan->agama !== $agama) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Agama' ,
                    'tipe' => 'Agama',
                    'olddata' => $karyawan->agama,
                    'newdata' => $agama,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }

             // Periksa apakah nilai 'Tahun Lulus' berbeda
             if ($karyawan->tahunlulus !== $tahunLulus) {
                // Jika berbeda, tambahkan data ke tbl_logupdatedatakaryawan
                DB::table('tbl_logupdatedatakaryawan')->insert([
                    'badge_id' => $badge,
                    'kategori' => 'Pendidikan Terakhir' ,
                    'tipe' => 'Tahun Lulus',
                    'olddata' => $karyawan->tahunlulus,
                    'newdata' => $tahunLulus,
                    'createdate' => now(),
                    'createby' => session('loggedInUser')['session_badge']
                ]);
            }



            $data = array(
                'nokk' => Crypt::encryptString($nokk),
                'pendidikan' => $pendidikan,
                'statusnikah' => $pernikahan,
                'jurusan' => $jurusan,
                'agama' => $agama,
                'tahunlulus' => $tahunLulus,
                'updatedate' => date('Y-m-d H:i:s'), 
                'updateby' => session('loggedInUser')['session_badge']
            );

            DB::table('tbl_detailkaryawan')->where('badgeid', $badge)->update($data);
            

            DB::commit();
            return response()->json([
                'status'    => 200, 
                'message'   => 'Data berhasil diupdate'
            ]);
            
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status'    => 401, 
                'message'   => 'gagal menyimpan' . $ex->getMessage()
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status'    => 401, 
                'message'   => 'gagal menyimpan' . $th->getMessage()
            ]);
        }

    }

    public function cek_password(Request $req)
    {
                              
        $employeeNo = session('loggedInUser')['session_badge'];
        $password = trim($req->input('txPassword')) ?: trim($req->input('txPasswordDok'));

        // $badge = trim($req->get('badge'));

        $dataUser = DB::table('tbl_useradmin')
            ->where('badge_id', $employeeNo)
            ->first();

        if ($dataUser) {
            $userPassword = $dataUser->password_msa;
            $validPassword = Hash::check($password, $userPassword);
            if ($validPassword) {

                $req->session()->put('loggedInUser', ['session_badge' => $dataUser->badge_id, 'session_roles' => $dataUser->user_level]);
                return response()->json([
                    'status' => 200,
                    'messages' => 'Password Anda Benar !',
                    'role' => $dataUser->user_level
                ]);
            } else {
                return response()->json([
                    'status' => 401,
                    'messages' => 'Password Anda Salah !',
                ]);
            }
        } else {
            return response()->json([
                'status' => 401,
                'messages' => 'Badge number not found',
            ]);
        }

    }


    public function kelurahan_list(Request $req)
    {

        $id = $req->get('id');
        $q = "SELECT id, kelurahan FROM `tbl_kelurahan` WHERE id_kecamatan='$id'";
        $result = DB::select($q);

        if($result){
            return response()->json([
                'status' => 200, 
                'data' => $result
            ]);
        }
    }

    public function kecamatan_list()
    {
        $q = "SELECT id, kecamatan FROM `tbl_kecamatan`";
        $result = DB::select($q);

        if($result){
            return response()->json([
                'status' => 200, 
                'data' => $result
            ]);
        }
    }

    public function alamat_by_badge(Request $req)
    {
        $badge = $req->get('badge');

        $q = "SELECT * FROM `tbl_alamat` WHERE badge_id='$badge'";
        $result = DB::select($q);

        if($result){
            return response()->json([
                'status' => 200, 
                'data' => $result
            ]);
        }
    }

    public function mms_list_by_badge(Request $req)
    {
        $badge = $req->get('badge');

        $output = "";

        $q = "SELECT a.tipe_hp, (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=a.merek_hp) as brand, (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=a.os) as os, a.versi_aplikasi FROM `tbl_mms` a WHERE badge_id='$badge'";
        $result = DB::select($q);

        $output .= 
        '
        <table id="tablePerangkatKaryawan" class="table table-responsive table-hover" style="font-size: 15px;">
            <thead>
                <tr style="color: #CD202E; height: -10px;" class="table-danger">
                <th class="p-3" scope="col">Model</th>
                <th class="p-3" scope="col">Brand</th>
                <th class="p-3" scope="col">OS</th>
                <th class="p-3" scope="col">Versi Aplikasi</th>
                </tr>
            </thead>
            <tbody>
        ';


        if($result){

            foreach($result as $row){

                // $dataOs = $row->os == 'ANDROID' ? '<i class="bx bxl-android"></i> ANDROID' : '<i class="bx bxl-apple"></i> IOS';

                if($row->os == 'ANDROID'){
                    $dataOs = '<i class="bx bxl-android"></i> ANDROID';
                }elseif($row->os == 'IOS'){
                    $dataOs = '<i class="bx bxl-apple"></i> IOS';
                }else{
                    $dataOs = '';
                }

                $output .= 
                '
                <tr>
                    <td class="p-3">' . $row->tipe_hp . '</td>
                    <td class="p-3">' . $row->brand . '</td>
                    <td class="p-3">
                        <span class="text-muted">' . $dataOs . '</span>
                    </td>
                    <td class="p-3">' . $row->versi_aplikasi . '</td>
                </tr>
                ';
            }

            $output .= "</tbody></table>";


            return $output;
        }

    }

    public function reset_password_profile(Request $req)
    {
        $badge = $req->get('badge');
        
        if($badge){
            DB::beginTransaction();
            try{

                DB::table('tbl_karyawan')->where('badge_id', $badge)->update(['password' => Hash::make('Passw0rd')]);

                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => 'Password berhasil direset'
                ]);
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json([
                    'status'    => 400, 
                    'message'   => 'gagal direset' . $ex->getMessage()
                ]);
            }
        }
    }

    public function updateMasaKontrak(Request $req)
    {

        $tglMulai = $req->get('dateMulai');
        $tglSelesai = $req->get('dateSelesai');
        $badge = $req->get('badge');

        if($badge){
            DB::beginTransaction();
            try{

		$dataMMS = DB::table('tbl_mms')->where('badge_id', $badge)->select('id')->get();
                if($dataMMS){
                    foreach($dataMMS as $row){

                        $idMMS = $row->id;

                        DB::table('tbl_mms')->where('id', $idMMS)->update([
                            'status_pendaftaran_mms' => '15', 
                            'updatedate' => date('Y-m-d H:i:s'), 
                            'updateby' => session('loggedInUser')['session_badge'], 
                            'is_active' => '1'
                        ]);

                        $riwayatData = array(
                            'id_mms' => $idMMS,
                            'status_mms' => 15,
                            'createby' => session('loggedInUser')['session_badge'],
                            'createdate' => date('Y-m-d H:i:s'),
                        );

    
                        DB::table('tbl_riwayatstatusmms')->insert($riwayatData);
                    }
                }
                
                DB::table('tbl_karyawan')->where('badge_id', $badge)->update([
                    'mulai_kontrak' => date('Y-m-d', strtotime($tglMulai)), 
                    'selesai_kontrak' => date('Y-m-d', strtotime($tglSelesai)), 
                    'is_active' => '1'
                ]);
                
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => 'Masa kontrak telah diperpanjang'
                ]);
            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json([
                    'status'    => 400, 
                    'message'   => 'gagal di update' . $ex->getMessage()
                ]);
            }


        }


    }

  
}
