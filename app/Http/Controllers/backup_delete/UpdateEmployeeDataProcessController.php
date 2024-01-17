<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\select;

class UpdateEmployeeDataProcessController extends Controller
{
    //
    public function index()
    {

        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')
                ->select('name_vlookup')
                ->where('id_vlookup', session()->get('loggedInUser')['session_roles'])
                ->first()->name_vlookup,
            'statusDept' => DB::table('tbl_deptcode')
                ->select('dept_name', 'dept_code')
                ->where('dept_name', '<>', '-') 
                ->get(),
        ];


        return view('updateEmpData.dataProcess.indexdataprocess', $data);
    }

    public function getListPengkinian(Request $request)
    {
        
        // $txSearch = '%' . strtoupper(trim($request->txSearch)) . '%';
        // $result = $request->result;
        // $sessionLogin = session('loggedInUser');
        
        
        // $name = $sessionLogin['name'];
        // $BadgeId = $sessionLogin['employee_no'];
        
        // if($result == null){
        //     $result = date('Y-m');
        // }else{
        //     $result = $request->result;
        // }

        $filterDept = $request->selectedDept;

        // dd($filterDept);
        $q = "SELECT 
                a.id, 
                a.badgeid, 
                a.nama, 
                a.kategori, 
                a.status,
                (SELECT CONCAT(d.fullname, ' (', a.badgeid, ') ') 
                    FROM tbl_karyawan d 
                    WHERE a.badgeid = d.badge_id) AS pemilik, 
                CONCAT(
                    (SELECT d.dept_code 
                        FROM tbl_karyawan d 
                        WHERE a.badgeid = d.badge_id),
                    ', ',
                    (SELECT e.position_name 
                        FROM tbl_karyawan d
                        JOIN tbl_position e ON d.position_code = e.position_code
                        WHERE a.badgeid = d.badge_id
                        LIMIT 1) 
                ) AS dept, 
                DATE_FORMAT(a.createdate, '%d %M %Y %H:%i') AS `create` 
                FROM tbl_pengkiniandata a 
                WHERE a.status = 1
                ORDER BY `create` ASC
                LIMIT 100;";

        if ($filterDept !== null) {
            $q = "SELECT 
                    a.id, 
                    a.badgeid, 
                    a.nama, 
                    a.kategori, 
                    a.status,
                    (SELECT CONCAT(d.fullname, ' (', a.badgeid, ') ') 
                        FROM tbl_karyawan d 
                        WHERE a.badgeid = d.badge_id) AS pemilik, 
                    CONCAT(
                        (SELECT d.dept_code 
                            FROM tbl_karyawan d 
                            WHERE a.badgeid = d.badge_id),
                        ', ',
                        (SELECT e.position_name 
                            FROM tbl_karyawan d
                            JOIN tbl_position e ON d.position_code = e.position_code
                            WHERE a.badgeid = d.badge_id
                            LIMIT 1) 
                    ) AS dept, 
                    DATE_FORMAT(a.createdate, '%d %M %Y %H:%i') AS `create` 
                    FROM tbl_pengkiniandata a 
                    WHERE a.status = 1
                    AND (SELECT d.dept_code 
                        FROM tbl_karyawan d 
                        WHERE a.badgeid = d.badge_id) = '$filterDept'
                    ORDER BY `create` ASC
                    LIMIT 100;";
        }
                
        $data = DB::select($q);

        $output = '';
        foreach ($data as $item) {

            $dokumenName = $item->kategori;

            $output .= '
            <li data-id="' . $item->id . '" class="card shadow-sm mb-3 total detailById">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="openlist border-0 rounded" style="font-size: 7px;">&nbsp;&nbsp;&nbsp;</p>
                            </div>
                        </div>                       
                        <div class="col card-detail"> 
                            <div class="d-flex justify-content-between">
                                <div class="cardtitle mt-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 450px;">'  . ($dokumenName ?? '-') . '</div>
                                <div class="text-end">
                                    <div class="cardlabel">' . ($item->create ?? '-') . '</div>  
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                              <div class="mt-1">
                                <!-- <div class="cardlabel" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 150px;">BP 1078 JK</div> -->
                                <div class="cardlabel">' . ($item->pemilik ?? '-') . '</div>
                                <div class="cardlabel">' . ($item->dept ?? '-') . '</div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            ';
        }
    
        return $output;
    } 

    public function getListClosed(Request $request)
    {
        
        // $txSearch = '%' . strtoupper(trim($request->txSearch)) . '%';
        // $result = $request->result;
        // $sessionLogin = session('loggedInUser');
        
        
        // $name = $sessionLogin['name'];
        // $BadgeId = $sessionLogin['employee_no'];
        
        // if($result == null){
        //     $result = date('Y-m');
        // }else{
        //     $result = $request->result;
        // }

        $filterDept = $request->selectedDept;
         
        $q = "SELECT 
                a.id, 
                a.badgeid, 
                a.nama, 
                a.kategori, 
                a.status,
                (SELECT CONCAT(d.fullname, ' (', a.badgeid, ') ') 
                    FROM tbl_karyawan d 
                    WHERE a.badgeid = d.badge_id) AS pemilik, 
                CONCAT(
                    (SELECT d.dept_code 
                        FROM tbl_karyawan d 
                        WHERE a.badgeid = d.badge_id),
                    ', ',
                    (SELECT e.position_name 
                        FROM tbl_karyawan d
                        JOIN tbl_position e ON d.position_code = e.position_code
                        WHERE a.badgeid = d.badge_id
                        LIMIT 1) 
                ) AS dept, 
                DATE_FORMAT(a.createdate, '%d %M %Y %H:%i') AS `create` 
                FROM tbl_pengkiniandata a 
                WHERE a.status IN (2, 3) 
                ORDER BY `create` ASC
                LIMIT 100;";

            if ($filterDept !== null) {
                $q = "SELECT 
                        a.id, 
                        a.badgeid, 
                        a.nama, 
                        a.kategori, 
                        a.status,
                        (SELECT CONCAT(d.fullname, ' (', a.badgeid, ') ') 
                            FROM tbl_karyawan d 
                            WHERE a.badgeid = d.badge_id) AS pemilik, 
                        CONCAT(
                            (SELECT d.dept_code 
                                FROM tbl_karyawan d 
                                WHERE a.badgeid = d.badge_id),
                            ', ',
                            (SELECT e.position_name 
                                FROM tbl_karyawan d
                                JOIN tbl_position e ON d.position_code = e.position_code
                                WHERE a.badgeid = d.badge_id
                                LIMIT 1) 
                        ) AS dept, 
                        DATE_FORMAT(a.createdate, '%d %M %Y %H:%i') AS `create` 
                        FROM tbl_pengkiniandata a 
                        WHERE a.status IN (2, 3) 
                        AND (SELECT d.dept_code 
                            FROM tbl_karyawan d 
                            WHERE a.badgeid = d.badge_id) = '$filterDept'
                        ORDER BY `create` ASC
                        LIMIT 100;";
            }
        $data = DB::select($q);


        $output = '';
        foreach ($data as $item) {

            $dokumenName = $item->kategori;
            $statusClass = $item->status == 2 ? 'reject' : 'approved';

            $output .= '
            <li data-id="' . $item->id . '" class="card shadow-sm mb-3 total detailById2">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="' . $statusClass . ' border-0 rounded" style="font-size: 7px;">&nbsp;&nbsp;&nbsp;</p>
                            </div>
                        </div>                       
                        <div class="col card-detail"> 
                            <div class="d-flex justify-content-between">
                                <div class="cardtitle mt-2" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 450px;">'  . ($dokumenName ?? '-') . '</div>
                                <div class="text-end">
                                    <div class="cardlabel">' . ($item->create ?? '-') . '</div>  
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                              <div class="mt-1">
                                <!-- <div class="cardlabel" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 150px;">BP 1078 JK</div> -->
                                <div class="cardlabel">' . ($item->pemilik ?? '-') . '</div>
                                <div class="cardlabel">' . ($item->dept ?? '-') . '</div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            ';
        }
    
        return $output;
    } 

    public function getModalPengkinian(Request $request)
    {
        $modalID = $request->modalID;
    
        // Ambil data di tbl_pengkiniandata berdasarkan ID
        $modalData = DB::table('tbl_pengkiniandata')
            ->where('id', $modalID)
            ->first();
    
        // Ambil dept berdasarkan Badge
        $deptData = DB::table('tbl_karyawan as a')
            ->leftJoin('tbl_position as b', 'a.position_code', '=', 'b.position_code')
            ->where('a.badge_id', $modalData->badgeid)
            ->first();

        $listDokumen = DB::select("
            SELECT * FROM (
            SELECT 'Nama' AS Kategori, 'Nama' AS Detail, a.fullname, b.nama AS newdata, b.dok_nama FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $modalID
            UNION
            SELECT 'No. KK' AS Kategori, 'No. KK' AS Detail, a.nokk, b.nokk AS newdata, b.dok_kk FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id = $modalID
            UNION
            SELECT 'Agama' AS Kategori, 'Agama' AS Detail, a.agama, b.agama AS newdata, b.dok_agama FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid AND b.id = $modalID
            UNION
            SELECT 'Status Pernikahan' AS Kategori, 'Status Pernikahan' AS Detail, a.statusnikah, b.statusnikah AS newdata, b.dok_nikah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id = $modalID
            UNION
            SELECT 'Pendidikan Terakhir' AS Kategori, 'Pendidikan Terakhir' AS Detail, a.pendidikan, b.pendidikan AS newdata, b.dok_ijazah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id = $modalID
            UNION
            SELECT 'Pendidikan Terakhir' AS Kategori, 'Jurusan' AS Detail, a.jurusan, b.jurusan AS newdata, b.dok_ijazah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id = $modalID
            UNION
            SELECT 'Pendidikan Terakhir' AS Kategori, 'Tahun Lulus' AS Detail, a.tahunlulus, b.tahunlulus AS newdata, b.dok_ijazah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid AND b.id = $modalID
            UNION
            SELECT 'Kontak' AS Kategori, 'Email' AS Detail, a.email, b.email AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $modalID
            UNION
            SELECT 'Kontak' AS Kategori, 'No. Hp' AS Detail, a.no_hp, b.no_hp AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $modalID
            UNION
            SELECT 'Kontak' AS Kategori, 'No. HP 2' AS Detail, a.no_hp2, b.no_hp2 AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $modalID
            UNION
            SELECT 'Kontak' AS Kategori, 'No. Telepon' AS Detail, a.home_telp, b.home_telp AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $modalID
            UNION
            SELECT 'Domisili' AS Kategori, 'Alamat' AS Detail, a.alamat, b.alamat AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $modalID
            UNION
            SELECT 'Domisili' AS Kategori, 'Kecamatan' AS Detail, c.kecamatan, b.kecamatan AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b, tbl_kecamatan c WHERE a.kecamatan = c.id AND a.badge_id = b.badgeid  AND b.id = $modalID
            UNION
            SELECT 'Domisili' AS Kategori, 'Kelurahan' AS Detail, c.kelurahan, b.kelurahan AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b, tbl_kelurahan c WHERE a.kelurahan = c.id AND a.badge_id = b.badgeid  AND b.id = $modalID
            UNION
            SELECT 'Domisili' AS Kategori, 'RT' AS Detail, a.rt, b.rt AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid  AND b.id = $modalID
            UNION
            SELECT 'Domisili' AS Kategori, 'RW' AS Detail, a.rw, b.rw AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid  AND b.id = $modalID) AS A WHERE newdata IS NOT NULL
        ");  

        
        foreach ($listDokumen as $item) {
            if (!empty($item->dok_nama)) {
                $item->dok_nama = Crypt::decryptString($item->dok_nama);
            }
        }

        foreach ($listDokumen as $item) {
            switch ($item->Detail == 'No. KK' ) {
                case 'No. KK':
                    $item->fullname = Crypt::decryptString($item->fullname);
                    $item->newdata = Crypt::decryptString($item->newdata);
                    break;
            }
        }

        return response()->json([
            'dataModalId' => $modalData,
            'dataModaldeptId' => $deptData,
            'dataListTable' => $listDokumen

        ]);
    }

    public function addApproved(Request $request){

        $modalID = $request->post('modalID');
        $reasonApprove = $request->post('reasonApprove');
                              
        DB::beginTransaction();
        try {
            //code...
            $badge = DB::table('tbl_pengkiniandata')->where('id', $modalID)->first();

            $datapengkinian = array(
                'status' => 3,
                'updatedate' => date('Y-m-d H:i:s'), 
                'updateby' => session('loggedInUser')['session_badge']
            );

            DB::table('tbl_pengkiniandata')->where('id', $modalID)->update($datapengkinian);

            $alasanapprove = array(
                'id_pengkinian' => $modalID ,
                'badge_id' => $badge->badgeid ,
                'status_pengkinian' => 3,
                'alasan' => $reasonApprove,
                'createdate' => date('Y-m-d H:i:s'), 
                'createby' => session('loggedInUser')['session_badge']
            );

            DB::table('tbl_riwayatpengkinian')->insert($alasanapprove);

            $selectdata = "SELECT * FROM (
                SELECT 'Nama' AS Kategori, 'Nama' AS Detail, a.fullname, b.nama AS newdata, b.dok_nama FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id =  $modalID
                UNION
                SELECT 'No. KK' AS Kategori, 'No. KK' AS Detail, a.nokk, b.nokk AS newdata, b.dok_kk FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id =  $modalID
                UNION
                SELECT 'Agama' AS Kategori, 'Agama' AS Detail, a.agama, b.agama AS newdata, b.dok_agama FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid AND b.id =  $modalID
                UNION
                SELECT 'Status Pernikahan' AS Kategori, 'Status Pernikahan' AS Detail, a.statusnikah, b.statusnikah AS newdata, b.dok_nikah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id =  $modalID
                UNION
                SELECT 'Pendidikan Terakhir' AS Kategori, 'Pendidikan Terakhir' AS Detail, a.pendidikan, b.pendidikan AS newdata, b.dok_ijazah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id =  $modalID
                UNION
                SELECT 'Pendidikan Terakhir' AS Kategori, 'Jurusan' AS Detail, a.jurusan, b.jurusan AS newdata, b.dok_ijazah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id =  $modalID
                UNION
                SELECT 'Pendidikan Terakhir' AS Kategori, 'Tahun Lulus' AS Detail, a.tahunlulus, b.tahunlulus AS newdata, b.dok_ijazah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid AND b.id =  $modalID
                UNION
                SELECT 'Kontak' AS Kategori, 'Email' AS Detail, a.email, b.email AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id =  $modalID
                UNION
                SELECT 'Kontak' AS Kategori, 'No. Hp' AS Detail, a.no_hp, b.no_hp AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id =  $modalID
                UNION
                SELECT 'Kontak' AS Kategori, 'No. HP 2' AS Detail, a.no_hp2, b.no_hp2 AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id =  $modalID
                UNION
                SELECT 'Kontak' AS Kategori, 'No. Telepon' AS Detail, a.home_telp, b.home_telp AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id =  $modalID
                UNION
                SELECT 'Domisili' AS Kategori, 'Alamat' AS Detail, a.alamat, b.alamat AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id =  $modalID
                UNION
                SELECT 'Domisili' AS Kategori, 'Kecamatan' AS Detail, c.kecamatan, b.kecamatan AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b, tbl_kecamatan c WHERE a.kecamatan = c.id AND a.badge_id = b.badgeid  AND b.id =  $modalID
                UNION
                SELECT 'Domisili' AS Kategori, 'Kelurahan' AS Detail, c.kelurahan, b.kelurahan AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b, tbl_kelurahan c WHERE a.kelurahan = c.id AND a.badge_id = b.badgeid  AND b.id =  $modalID
                UNION
                SELECT 'Domisili' AS Kategori, 'RT' AS Detail, a.rt, b.rt AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid  AND b.id =  $modalID
                UNION
                SELECT 'Domisili' AS Kategori, 'RW' AS Detail, a.rw, b.rw AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid  AND b.id =  $modalID) AS A WHERE newdata IS NOT NULL
            ";
            
            $result = DB::select($selectdata);
    
            foreach ($result as $row) {
                $kategori = $row->Kategori;
                $detail = $row->Detail;
                $newdata = $row->newdata;
                $olddata = $row->fullname;
                $dokumen = $row->dok_nama;
                
                // Pemeriksaan berdasarkan kategori atau $detail
                switch ($detail) {
                    case 'Nama':
                        // Update pada tabel tbl_karyawan kolom fullname
                        DB::table('tbl_karyawan')
                            ->where('badge_id',  $badge->badgeid)
                            ->update(['fullname' => $newdata]);
    
                        DB::table('tbl_dokumen')
                            ->where('badge_id',  $badge->badgeid)
                            ->where('kategori', 1)
                            ->delete();
                        
    
                        DB::table('tbl_dokumen')
                           ->insert([
                            'kategori'=> 1,
                            'badge_id' => $badge->badgeid,
                            'updateby'=> session('loggedInUser')['session_badge'],
                            'filename'=> $dokumen,
                            'updatedate'=> now(),
                           ]);
    
                    
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                'kategori'=> $kategori,
                                'dokumen'=> $dokumen,
                            ]);
                        break;
            
                    case 'No. KK':
                        // Update pada tabel tbl_detailkaryawan kolom nokk
                        DB::table('tbl_detailkaryawan')
                            ->where('badgeid', $badge->badgeid)
                            ->update(['nokk' => $newdata]);
    
                            DB::table('tbl_dokumen')
                            ->where('badge_id', $badge->badgeid)
                            ->where('kategori', 2)
                            ->delete();
    
                        DB::table('tbl_dokumen')
                            ->insert([
                             'kategori'=> 2,
                             'badge_id' => $badge->badgeid,
                             'updateby'=> session('loggedInUser')['session_badge'],
                             'filename'=> $dokumen,
                             'updatedate'=> now(),
                        ]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                 'kategori'=> $kategori,
                                'dokumen'=> $dokumen,
                            ]);
                        break;
            
                    case 'Agama':
                        // Update pada tabel tbl_detailkaryawan kolom agama
                        DB::table('tbl_detailkaryawan')
                            ->where('badgeid', $badge->badgeid)
                            ->update(['agama' => $newdata]);
    
                            DB::table('tbl_dokumen')
                            ->where('badge_id', $badge->badgeid)
                            ->where('kategori', 3)
                            ->delete();
    
                        DB::table('tbl_dokumen')
                            ->insert([
                             'kategori'=> 3,
                             'badge_id' => $badge->badgeid,
                             'updateby'=> session('loggedInUser')['session_badge'],
                             'filename'=> $dokumen,
                             'updatedate'=> now(),
                        ]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                 'kategori'=> $kategori,
                                'dokumen'=> $dokumen,
                            ]);
                        break;
            
                    case 'Status Pernikahan':
                        // Update pada tabel tbl_detailkaryawan kolom statusnikah
                        DB::table('tbl_detailkaryawan')
                            ->where('badgeid', $badge->badgeid)
                            ->update(['statusnikah' => $newdata]);
    
                        DB::table('tbl_dokumen')
                            ->where('badge_id', $badge->badgeid)
                            ->where('kategori', 5)
                            ->delete();
    
                        DB::table('tbl_dokumen')
                            ->insert([
                             'kategori'=> 5,
                             'badge_id' => $badge->badgeid,
                             'updateby'=> session('loggedInUser')['session_badge'],
                             'filename'=> $dokumen,
                             'updatedate'=> now(),
                        ]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                 'kategori'=> $kategori,
                                'dokumen'=> $dokumen,
                            ]);
                        break;
            
                    case 'Pendidikan Terakhir':
                        // Update pada tabel tbl_detailkaryawan kolom pendidikan
                        DB::table('tbl_detailkaryawan')
                            ->where('badgeid', $badge->badgeid)
                            ->update(['pendidikan' => $newdata]);
    
                            DB::table('tbl_dokumen')
                            ->where('badge_id', $badge->badgeid)
                            ->where('kategori', 4)
                            ->delete();
    
                        DB::table('tbl_dokumen')
                            ->insert([
                             'kategori'=> 4,
                             'badge_id' => $badge->badgeid,
                             'updateby'=> session('loggedInUser')['session_badge'],
                             'filename'=> $dokumen,
                             'updatedate'=> now(),
                        ]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                'kategori'=> $kategori,
                                'dokumen'=> $dokumen,
                            ]);
                        break;
            
                    case 'Jurusan':
                        // Update pada tabel tbl_detailkaryawan kolom jurusan
                        DB::table('tbl_detailkaryawan')
                            ->where('badgeid', $badge->badgeid)
                            ->update(['jurusan' => $newdata]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                 'kategori'=> $kategori,
                                'dokumen'=> $dokumen,
                            ]);
                        break;
            
                    case 'Tahun Lulus':
                        // Update pada tabel tbl_detailkaryawan kolom tahunlulus
                        DB::table('tbl_detailkaryawan')
                            ->where('badgeid', $badge->badgeid)
                            ->update(['tahunlulus' => $newdata]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                'kategori'=> $kategori,
                                'dokumen'=> $dokumen,
                            ]);
                        break;
            
                    case 'Email':
                        // Update pada tabel tbl_karyawan kolom email
                        DB::table('tbl_karyawan')
                            ->where('badge_id', $badge->badgeid)
                            ->update(['email' => $newdata]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                'kategori'=> $kategori,
                            ]);
                        break;
            
                    case 'No. Hp':
                        // Update pada tabel tbl_karyawan kolom no_hp
                        DB::table('tbl_karyawan')
                            ->where('badge_id', $badge->badgeid)
                            ->update(['no_hp' => $newdata]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=>  $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                 'kategori'=> $kategori,
                            ]);
                        break;
            
                    case 'No. HP 2':
                        // Update pada tabel tbl_karyawan kolom no_hp2
                        DB::table('tbl_karyawan')
                            ->where('badge_id', $badge->badgeid)
                            ->update(['no_hp2' => $newdata]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                 'kategori'=> $kategori,
                            ]);
                        break;
            
                    case 'No. Telepon':
                        // Update pada tabel tbl_karyawan kolom home_telp
                        DB::table('tbl_karyawan')
                            ->where('badge_id', $badge->badgeid)
                            ->update(['home_telp' => $newdata]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                 'kategori'=> $kategori,
                            ]);
                        break;
            
                    case 'Alamat':
                        // Update pada tabel tbl_alamat kolom alamat
                        DB::table('tbl_alamat')
                            ->where('badge_id', $badge->badgeid)
                            ->update(['alamat' => $newdata]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                'kategori'=> $kategori,
                                'dokumen'=> $dokumen,
                            ]);
                        break;
            
                    case 'Kecamatan':
                        $kecamatanId = DB::table('tbl_kecamatan')
                        ->where('kecamatan', $newdata)
                        ->value('id');
    
                        // Update pada tabel tbl_alamat kolom kecamatan
                        DB::table('tbl_alamat')
                            ->where('badge_id', $badge->badgeid)
                            ->update(['kecamatan' => $kecamatanId]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                'kategori'=> $kategori,
                                'dokumen'=> $dokumen,
                            ]);
                        break;
            
                    case 'Kelurahan':
                        $kelurahanId = DB::table('tbl_kelurahan')
                        ->where('kelurahan', $newdata)
                        ->value('id');
    
                        // Update pada tabel tbl_alamat kolom kelurahan
                        DB::table('tbl_alamat')
                            ->where('badge_id', $badge->badgeid)
                            ->update(['kelurahan' => $kelurahanId]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                'kategori'=> $kategori,
                                'dokumen'=> $dokumen,
                            ]);
                        break;
            
                    case 'RT':
                        // Update pada tabel tbl_alamat kolom rt
                        DB::table('tbl_alamat')
                            ->where('badge_id', $badge->badgeid)
                            ->update(['rt' => $newdata]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                'kategori'=> $kategori,
                                'dokumen'=> $dokumen,
                            ]);
                        break;
            
                    case 'RW':
                        // Update pada tabel tbl_alamat kolom rw
                        DB::table('tbl_alamat')
                            ->where('badge_id', $badge->badgeid)
                            ->update(['rw' => $newdata]);
            
                        // Insert ke tabel tbl_logupdatedatakaryawan
                        DB::table('tbl_logupdatedatakaryawan')
                            ->insert([
                                'id_pengkinian'=> $modalID,
                                'badge_id' => $badge->badgeid,
                                'tipe' => $detail,
                                'newdata' => $newdata,
                                'olddata' => $olddata,
                                'createdate' => now(),
                                'createby'=> session('loggedInUser')['session_badge'],
                                 'kategori'=> $kategori,
                                'dokumen'=> $dokumen,
                            ]);
                        break;
            
                    // Tambahkan case untuk setiap kolom yang sesuai
            
                    default:
                        // Default case jika kategori atau $detail tidak cocok dengan kasus yang dihandle
                        break;
                }
               
            }
            

            DB::commit();
            return response()->json([
                'status'    => 200, 
                'message'   => 'Pengkinian Data telah disetujui'
            ]);
            
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status'    => 401, 
                'message'   => 'gagal Terima' . $ex->getMessage()
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status'    => 401, 
                'message'   => 'gagal Terima' . $th->getMessage()
            ]);
        }
    }

    public function addReject(Request $request){

        $modalID = $request->post('modalID');
        $reasonReject = $request->post('reasonReject');
                              
        DB::beginTransaction();
        try {
            //code...
            $badge = DB::table('tbl_pengkiniandata')->where('id', $modalID)->first();

            $datapengkinian = array(
                'status' => 2,
                'updatedate' => date('Y-m-d H:i:s'), 
                'updateby' => session('loggedInUser')['session_badge']
            );

            DB::table('tbl_pengkiniandata')->where('id', $modalID)->update($datapengkinian);

            $alasanreject = array(
                'id_pengkinian' => $modalID ,
                'badge_id' => $badge->badgeid ,
                'status_pengkinian' => 2,
                'alasan' => $reasonReject,
                'createdate' => date('Y-m-d H:i:s'), 
                'createby' => session('loggedInUser')['session_badge']
            );

            DB::table('tbl_riwayatpengkinian')->insert($alasanreject);
            

            DB::commit();
            return response()->json([
                'status'    => 200, 
                'message'   => 'Pengkinian Data telah ditolak'
            ]);
            
        } catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status'    => 401, 
                'message'   => 'gagal Terima' . $ex->getMessage()
            ]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status'    => 401, 
                'message'   => 'gagal Terima' . $th->getMessage()
            ]);
        }
    }


    public function detail($id)
    {   

        $viewstatus = DB::table('tbl_pengkiniandata')
        ->where('id', $id)
        ->select('status')
        ->first()->status;

        $q = " SELECT 
                    tbl_riwayatpengkinian.*,
                    DATE_FORMAT(tbl_riwayatpengkinian.createdate, '%d %M %Y') AS `date`, 
                    DATE_FORMAT(tbl_riwayatpengkinian.createdate, '%h:%i %p') AS `time`,
                    tbl_statuspengkinian.stat_title AS `status`
                FROM 
                    tbl_riwayatpengkinian
                JOIN 
                    tbl_statuspengkinian ON tbl_riwayatpengkinian.status_pengkinian = tbl_statuspengkinian.id
                WHERE 
                    tbl_riwayatpengkinian.id_pengkinian = $id;
        ";
    
        $querry = "SELECT 
                        tbl_tanggapanpengkinian.*, 
                        tbl_karyawan.fullname,
                        DATE_FORMAT(tbl_tanggapanpengkinian.waktu, '%d %M %Y') AS `date`, 
                        DATE_FORMAT(tbl_tanggapanpengkinian.waktu, '%h:%i %p') AS `time`,
                        (SELECT img_user FROM tbl_karyawan WHERE badge_id = tbl_tanggapanpengkinian.badge_id) as photo
                    FROM 
                        tbl_tanggapanpengkinian
                    JOIN 
                        tbl_karyawan ON tbl_tanggapanpengkinian.badge_id = tbl_karyawan.badge_id
                    WHERE 
                        tbl_tanggapanpengkinian.id_pengkinian = $id
                    ORDER BY 
                        tbl_tanggapanpengkinian.waktu DESC;
    
                         
        ";

        $q1 = "SELECT * FROM (
            SELECT 'Nama' AS Kategori, 'Nama' AS Detail, a.fullname, b.nama AS newdata, b.dok_nama FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $id
            UNION
            SELECT 'No. KK' AS Kategori, 'No. KK' AS Detail, a.nokk, b.nokk AS newdata, b.dok_kk FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id = $id
            UNION
            SELECT 'Agama' AS Kategori, 'Agama' AS Detail, a.agama, b.agama AS newdata, b.dok_agama FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid AND b.id = $id
            UNION
            SELECT 'Status Pernikahan' AS Kategori, 'Status Pernikahan' AS Detail, a.statusnikah, b.statusnikah AS newdata, b.dok_nikah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id = $id
            UNION
            SELECT 'Pendidikan Terakhir' AS Kategori, 'Pendidikan Terakhir' AS Detail, a.pendidikan, b.pendidikan AS newdata, b.dok_ijazah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id = $id
            UNION
            SELECT 'Pendidikan Terakhir' AS Kategori, 'Jurusan' AS Detail, a.jurusan, b.jurusan AS newdata, b.dok_ijazah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id = $id
            UNION
            SELECT 'Pendidikan Terakhir' AS Kategori, 'Tahun Lulus' AS Detail, a.tahunlulus, b.tahunlulus AS newdata, b.dok_ijazah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid AND b.id = $id
            UNION
            SELECT 'Kontak' AS Kategori, 'Email' AS Detail, a.email, b.email AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $id
            UNION
            SELECT 'Kontak' AS Kategori, 'No. Hp' AS Detail, a.no_hp, b.no_hp AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $id
            UNION
            SELECT 'Kontak' AS Kategori, 'No. HP 2' AS Detail, a.no_hp2, b.no_hp2 AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $id
            UNION
            SELECT 'Kontak' AS Kategori, 'No. Telepon' AS Detail, a.home_telp, b.home_telp AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $id
            UNION
            SELECT 'Domisili' AS Kategori, 'Alamat' AS Detail, a.alamat, b.alamat AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $id
            UNION
            SELECT 'Domisili' AS Kategori, 'Kecamatan' AS Detail, c.kecamatan, b.kecamatan AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b, tbl_kecamatan c WHERE a.kecamatan = c.id AND a.badge_id = b.badgeid  AND b.id = $id
            UNION
            SELECT 'Domisili' AS Kategori, 'Kelurahan' AS Detail, c.kelurahan, b.kelurahan AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b, tbl_kelurahan c WHERE a.kelurahan = c.id AND a.badge_id = b.badgeid  AND b.id = $id
            UNION
            SELECT 'Domisili' AS Kategori, 'RT' AS Detail, a.rt, b.rt AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid  AND b.id = $id
            UNION
            SELECT 'Domisili' AS Kategori, 'RW' AS Detail, a.rw, b.rw AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid  AND b.id = $id) AS A WHERE newdata IS NOT NULL
        ";  

        $q2 = "SELECT kategori AS Kategori, tipe AS Detail, olddata AS fullname, newdata, dokumen AS dok_nama FROM tbl_logupdatedatakaryawan WHERE id_pengkinian =  $id
        ";

        $infotableQuery = ($viewstatus == 3) ? $q2 : $q1;
      
        
        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')
                ->select('name_vlookup')
                ->where('id_vlookup', session()->get('loggedInUser')['session_roles'])
                ->first()->name_vlookup,
            'detailpengkinian' => DB::table('tbl_pengkiniandata as a')
                ->select(
                    'a.id',
                    'a.badgeid',
                    'tbl_karyawan.fullname AS namakaryawan',
                    'tbl_karyawan.dept_code AS deptcode',
                    'tbl_deptcode.dept_name AS deptname',
                    'tbl_karyawan.line_code AS linecode',
                    'tbl_karyawan.position_code AS positioncode',
                    'a.kategori',
                    'a.createdate',
                    'a.updatedate',
                    'tbl_statuspengkinian.stat_title AS status',
                    'tbl_statuspengkinian.id AS id_status',
                )
                ->leftJoin('tbl_karyawan', 'tbl_karyawan.badge_id', '=', 'a.badgeid')
                ->leftJoin('tbl_deptcode', 'tbl_deptcode.dept_code', '=', 'tbl_karyawan.dept_code')
                ->leftJoin('tbl_statuspengkinian', 'tbl_statuspengkinian.id', '=', 'a.status')
                ->where('a.id', $id)
                ->first(),
            'dataRiwayat' => DB::select($q),
            'listtanggapan' => DB::select($querry),
            'infotable' => DB::select($infotableQuery)
        ];
        
        if (request()->ajax()) {
            return response()->json($data['listtanggapan']);
        }
    
        return view('updateEmpData.dataProcess.detailProcess', $data);
    }
    

    public function tambahtanggapan(Request $request )
    {   
        $id = $request->input('id');
        $badgeid = $request->input('badgeid');
        $tanggapan = $request->input('tanggapan');
        $waktu = now();

         $data = [
            'id_pengkinian' =>  $id,
            'badge_id' => $badgeid,
            'respon' => $tanggapan,
            'waktu'=> $waktu
        ];
    
        DB::table('tbl_tanggapanpengkinian')->insert($data);


        return response()->json(['success' => true, 'message' => 'Tanggapan Berhasil Ditambahkan.']);
    }
    

    public function tolakpengkinian(Request $request) {
        $id = $request->input('id');
        $badgeid = $request->input('badgeid');
        $adminbadge = $request->input('adminbadge');
        $alasan = $request->input('alasan');


        DB::table('tbl_pengkiniandata')->where('id', $id)->update([
            'status' => 2,
            'updateby'=> $adminbadge,
            'updatedate'=> now(),
        ]);

        DB::table('tbl_riwayatpengkinian')->insert([
            'id_pengkinian' => $id,
            'status_pengkinian' => 2,
            'badge_id' => $badgeid,
            'createby' => $adminbadge,
            'createdate' => now(),
            'alasan' => $alasan,
        ]);

        return response()->json(['success'=> true,'message'=> 'Berhasil Menolak Pengkinian']);
    }

    public function terimapengkinian(Request $request) {
        $id = $request->input('id');
        $badgeid = $request->input('badgeid');
        $adminbadge = $request->input('adminbadge');
        $alasan = $request->input('alasan');



        DB::table('tbl_pengkiniandata')->where('id', $id)->update([
            'status' => 3,
            'updateby'=> $adminbadge,
            'updatedate'=> now(),
        ]);

        
        DB::table('tbl_riwayatpengkinian')->insert([
            'id_pengkinian' => $id,
            'status_pengkinian' => 3,
            'badge_id' => $badgeid,
            'createby' => $adminbadge,
            'createdate' => now(),
            'alasan' => $alasan,
        ]);



        $selectdata = "SELECT * FROM (
            SELECT 'Nama' AS Kategori, 'Nama' AS Detail, a.fullname, b.nama AS newdata, b.dok_nama FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $id
            UNION
            SELECT 'No. KK' AS Kategori, 'No. KK' AS Detail, a.nokk, b.nokk AS newdata, b.dok_kk FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id = $id
            UNION
            SELECT 'Agama' AS Kategori, 'Agama' AS Detail, a.agama, b.agama AS newdata, b.dok_agama FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid AND b.id = $id
            UNION
            SELECT 'Status Pernikahan' AS Kategori, 'Status Pernikahan' AS Detail, a.statusnikah, b.statusnikah AS newdata, b.dok_nikah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id = $id
            UNION
            SELECT 'Pendidikan Terakhir' AS Kategori, 'Pendidikan Terakhir' AS Detail, a.pendidikan, b.pendidikan AS newdata, b.dok_ijazah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id = $id
            UNION
            SELECT 'Pendidikan Terakhir' AS Kategori, 'Jurusan' AS Detail, a.jurusan, b.jurusan AS newdata, b.dok_ijazah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid  AND b.id = $id
            UNION
            SELECT 'Pendidikan Terakhir' AS Kategori, 'Tahun Lulus' AS Detail, a.tahunlulus, b.tahunlulus AS newdata, b.dok_ijazah FROM tbl_detailkaryawan a, tbl_pengkiniandata b WHERE a.badgeid = b.badgeid AND b.id = $id
            UNION
            SELECT 'Kontak' AS Kategori, 'Email' AS Detail, a.email, b.email AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $id
            UNION
            SELECT 'Kontak' AS Kategori, 'No. Hp' AS Detail, a.no_hp, b.no_hp AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $id
            UNION
            SELECT 'Kontak' AS Kategori, 'No. HP 2' AS Detail, a.no_hp2, b.no_hp2 AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $id
            UNION
            SELECT 'Kontak' AS Kategori, 'No. Telepon' AS Detail, a.home_telp, b.home_telp AS newdata, '' FROM tbl_karyawan a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $id
            UNION
            SELECT 'Domisili' AS Kategori, 'Alamat' AS Detail, a.alamat, b.alamat AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid AND b.id = $id
            UNION
            SELECT 'Domisili' AS Kategori, 'Kecamatan' AS Detail, c.kecamatan, b.kecamatan AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b, tbl_kecamatan c WHERE a.kecamatan = c.id AND a.badge_id = b.badgeid  AND b.id = $id
            UNION
            SELECT 'Domisili' AS Kategori, 'Kelurahan' AS Detail, c.kelurahan, b.kelurahan AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b, tbl_kelurahan c WHERE a.kelurahan = c.id AND a.badge_id = b.badgeid  AND b.id = $id
            UNION
            SELECT 'Domisili' AS Kategori, 'RT' AS Detail, a.rt, b.rt AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid  AND b.id = $id
            UNION
            SELECT 'Domisili' AS Kategori, 'RW' AS Detail, a.rw, b.rw AS newdata, '' FROM tbl_alamat a, tbl_pengkiniandata b WHERE a.badge_id = b.badgeid  AND b.id = $id) AS A WHERE newdata IS NOT NULL
        ";
        
        $result = DB::select($selectdata);

        $sourceDir = public_path("employee_uploads/{$badgeid}");
        $destinationDir = public_path("documents");
        
        $files = scandir($sourceDir);
        
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && strpos($file, "{$id}_{$badgeid}") !== false) {
                // Buat path untuk file sumber dan tujuan
                $sourcePath = "{$sourceDir}/{$file}";
                $destinationPath = "{$destinationDir}/{$file}";
        
                File::copy($sourcePath, $destinationPath);
            }
        }
                       
        foreach ($result as $row) {
            $kategori = $row->Kategori;
            $detail = $row->Detail;
            $newdata = $row->newdata;
            $olddata = $row->fullname;
            $dokumen = $row->dok_nama;

            // Pemeriksaan berdasarkan kategori atau $detail
            switch ($detail) {
                case 'Nama':
                    // Update pada tabel tbl_karyawan kolom fullname
                    DB::table('tbl_karyawan')
                        ->where('badge_id', $badgeid)
                        ->update(['fullname' => $newdata]);

                    DB::table('tbl_dokumen')
                        ->where('badge_id', $badgeid)
                        ->where('kategori', 1)
                        ->delete();
                    

                    DB::table('tbl_dokumen')
                       ->insert([
                        'kategori'=> 1,
                        'badge_id' => $badgeid,
                        'updateby'=> $adminbadge,
                        'filename'=> $dokumen,
                        'updatedate'=> now(),
                       ]);

                
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                            'kategori'=> $kategori,
                            'dokumen'=> $dokumen,
                        ]);
                    break;
        
                case 'No. KK':
                    // Update pada tabel tbl_detailkaryawan kolom nokk
                    DB::table('tbl_detailkaryawan')
                        ->where('badgeid', $badgeid)
                        ->update(['nokk' => $newdata]);

                        DB::table('tbl_dokumen')
                        ->where('badge_id', $badgeid)
                        ->where('kategori', 2)
                        ->delete();

                    DB::table('tbl_dokumen')
                        ->insert([
                         'kategori'=> 2,
                         'badge_id' => $badgeid,
                         'updateby'=> $adminbadge,
                         'filename'=> $dokumen,
                         'updatedate'=> now(),
                    ]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                             'kategori'=> $kategori,
                            'dokumen'=> $dokumen,
                        ]);
                    break;
        
                case 'Agama':
                    // Update pada tabel tbl_detailkaryawan kolom agama
                    DB::table('tbl_detailkaryawan')
                        ->where('badgeid', $badgeid)
                        ->update(['agama' => $newdata]);

                        DB::table('tbl_dokumen')
                        ->where('badge_id', $badgeid)
                        ->where('kategori', 3)
                        ->delete();

                    DB::table('tbl_dokumen')
                        ->insert([
                         'kategori'=> 3,
                         'badge_id' => $badgeid,
                         'updateby'=> $adminbadge,
                         'filename'=> $dokumen,
                         'updatedate'=> now(),
                    ]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                             'kategori'=> $kategori,
                            'dokumen'=> $dokumen,
                        ]);
                    break;
        
                case 'Status Pernikahan':
                    // Update pada tabel tbl_detailkaryawan kolom statusnikah
                    DB::table('tbl_detailkaryawan')
                        ->where('badgeid', $badgeid)
                        ->update(['statusnikah' => $newdata]);

                    DB::table('tbl_dokumen')
                        ->where('badge_id', $badgeid)
                        ->where('kategori', 5)
                        ->delete();

                    DB::table('tbl_dokumen')
                        ->insert([
                         'kategori'=> 5,
                         'badge_id' => $badgeid,
                         'updateby'=> $adminbadge,
                         'filename'=> $dokumen,
                         'updatedate'=> now(),
                    ]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                             'kategori'=> $kategori,
                            'dokumen'=> $dokumen,
                        ]);
                    break;
        
                case 'Pendidikan Terakhir':
                    // Update pada tabel tbl_detailkaryawan kolom pendidikan
                    DB::table('tbl_detailkaryawan')
                        ->where('badgeid', $badgeid)
                        ->update(['pendidikan' => $newdata]);

                        DB::table('tbl_dokumen')
                        ->where('badge_id', $badgeid)
                        ->where('kategori', 4)
                        ->delete();

                    DB::table('tbl_dokumen')
                        ->insert([
                         'kategori'=> 4,
                         'badge_id' => $badgeid,
                         'updateby'=> $adminbadge,
                         'filename'=> $dokumen,
                         'updatedate'=> now(),
                    ]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                            'kategori'=> $kategori,
                            'dokumen'=> $dokumen,
                        ]);
                    break;
        
                case 'Jurusan':
                    // Update pada tabel tbl_detailkaryawan kolom jurusan
                    DB::table('tbl_detailkaryawan')
                        ->where('badgeid', $badgeid)
                        ->update(['jurusan' => $newdata]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                             'kategori'=> $kategori,
                            'dokumen'=> $dokumen,
                        ]);
                    break;
        
                case 'Tahun Lulus':
                    // Update pada tabel tbl_detailkaryawan kolom tahunlulus
                    DB::table('tbl_detailkaryawan')
                        ->where('badgeid', $badgeid)
                        ->update(['tahunlulus' => $newdata]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                            'kategori'=> $kategori,
                            'dokumen'=> $dokumen,
                        ]);
                    break;
        
                case 'Email':
                    // Update pada tabel tbl_karyawan kolom email
                    DB::table('tbl_karyawan')
                        ->where('badge_id', $badgeid)
                        ->update(['email' => $newdata]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                            'kategori'=> $kategori,
                        ]);
                    break;
        
                case 'No. Hp':
                    // Update pada tabel tbl_karyawan kolom no_hp
                    DB::table('tbl_karyawan')
                        ->where('badge_id', $badgeid)
                        ->update(['no_hp' => $newdata]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                             'kategori'=> $kategori,
                        ]);
                    break;
        
                case 'No. HP 2':
                    // Update pada tabel tbl_karyawan kolom no_hp2
                    DB::table('tbl_karyawan')
                        ->where('badge_id', $badgeid)
                        ->update(['no_hp2' => $newdata]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                             'kategori'=> $kategori,
                        ]);
                    break;
        
                case 'No. Telepon':
                    // Update pada tabel tbl_karyawan kolom home_telp
                    DB::table('tbl_karyawan')
                        ->where('badge_id', $badgeid)
                        ->update(['home_telp' => $newdata]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                             'kategori'=> $kategori,
                        ]);
                    break;
        
                case 'Alamat':
                    // Update pada tabel tbl_alamat kolom alamat
                    DB::table('tbl_alamat')
                        ->where('badge_id', $badgeid)
                        ->update(['alamat' => $newdata]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                            'kategori'=> $kategori,
                            'dokumen'=> $dokumen,
                        ]);
                    break;
        
                case 'Kecamatan':
                    $kecamatanId = DB::table('tbl_kecamatan')
                    ->where('kecamatan', $newdata)
                    ->value('id');

                    // Update pada tabel tbl_alamat kolom kecamatan
                    DB::table('tbl_alamat')
                        ->where('badge_id', $badgeid)
                        ->update(['kecamatan' => $kecamatanId]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                            'kategori'=> $kategori,
                            'dokumen'=> $dokumen,
                        ]);
                    break;
        
                case 'Kelurahan':
                    $kelurahanId = DB::table('tbl_kelurahan')
                    ->where('kelurahan', $newdata)
                    ->value('id');

                    // Update pada tabel tbl_alamat kolom kelurahan
                    DB::table('tbl_alamat')
                        ->where('badge_id', $badgeid)
                        ->update(['kelurahan' => $kelurahanId]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                            'kategori'=> $kategori,
                            'dokumen'=> $dokumen,
                        ]);
                    break;
        
                case 'RT':
                    // Update pada tabel tbl_alamat kolom rt
                    DB::table('tbl_alamat')
                        ->where('badge_id', $badgeid)
                        ->update(['rt' => $newdata]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                            'kategori'=> $kategori,
                            'dokumen'=> $dokumen,
                        ]);
                    break;
        
                case 'RW':
                    // Update pada tabel tbl_alamat kolom rw
                    DB::table('tbl_alamat')
                        ->where('badge_id', $badgeid)
                        ->update(['rw' => $newdata]);
        
                    // Insert ke tabel tbl_logupdatedatakaryawan
                    DB::table('tbl_logupdatedatakaryawan')
                        ->insert([
                            'id_pengkinian'=> $id,
                            'badge_id' => $badgeid,
                            'tipe' => $detail,
                            'newdata' => $newdata,
                            'olddata' => $olddata,
                            'createdate' => now(),
                            'createby'=> $adminbadge,
                             'kategori'=> $kategori,
                            'dokumen'=> $dokumen,
                        ]);
                    break;
        
                // Tambahkan case untuk setiap kolom yang sesuai
        
                default:
                    // Default case jika kategori atau $detail tidak cocok dengan kasus yang dihandle
                    break;
            }
           
        }

        return response()->json(['success'=> true,'message'=> 'Berhasil Menerima Pengkinian Data']);

    }
    
}