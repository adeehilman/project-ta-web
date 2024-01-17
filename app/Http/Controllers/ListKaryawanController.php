<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Excel;
use Illuminate\Support\Facades\Crypt;

class ListKaryawanController extends Controller
{
    public function __construct()
    {
        // Kode untuk constructor
        // $this->db_second = DB::connection('second_db');
    }


    public function index()
    {

          // $data = ['userInfo' => DB::table('tbl_user')->where('employee_no', session('loggedInUser'))->first()];
        $data = [
            'userInfo' => DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser'))->first(),
            'userRole' => (int)session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')->select('name_vlookup')->where('id_vlookup', session()->get('loggedInUser')['session_roles'])->first()->name_vlookup,
        ];

        return view('karyawan.list', $data);
    }


    public function employee_list(Request $req)
    {

        $txSearch = "%" . strtoupper($req->get('txSearch')) . "%";
        $rdPT = $req->get('rdPT');
        $selectDepartment = $req->get('selectDepartment');
        $selectLine = $req->get('selectLine');
        $rdALLRegis = $req->get('rdALLRegis');
        $selectMulaiKerja = $req->get('selectMulaiKerja');

        $output = "";

        $qFilter = '';
        if($rdPT != 'all'){
            $qFilter .= " AND pt='$rdPT'";
        }
        if($selectDepartment != ''){
            $qFilter .= " AND dept_code='$selectDepartment'";
        }
        if($selectLine != ''){
            $qFilter .= " AND line_code='$selectLine'";
        }
        if($rdALLRegis != "all"){
            if($rdALLRegis == "terdaftar"){
                $qFilter .= " AND password IS NOT NULL";
            }else{
                $qFilter .= " AND password IS NULL";
            }  
        }
        if($selectMulaiKerja != ""){
            if($selectMulaiKerja == '1'){
                $dateAwal = date('Y-m-d', strtotime('-1 day'));
                $dateAkhir = date('Y-m-d');
                $qFilter .= " AND (join_date BETWEEN '$dateAwal' AND '$dateAkhir')";
            }elseif($selectMulaiKerja == '7'){
                $dateAwal = date('Y-m-d', strtotime('-7 day'));
                $dateAkhir = date('Y-m-d');
                $qFilter .= " AND (join_date BETWEEN '$dateAwal' AND '$dateAkhir')";
            }elseif($selectMulaiKerja == '30'){
                $dateAwal = date('Y-m-d', strtotime('-1 month'));
                $dateAkhir = date('Y-m-d');
                $qFilter .= " AND (join_date BETWEEN '$dateAwal' AND '$dateAkhir')";
            }else{
                $qFilter .= '';
            }
        }

        // dd($rdALLRegis);


        
        // $employeeData = DB::connection('second_db')->table('tbl_karyawan')->get();
        // $q = "SELECT a.badge_id, a.password, a.email, a.fullname, (SELECT dept_name FROM tbl_deptcode WHERE dept_code=a.dept_code) as dept_code, a.line_code, a.rfid_no, a.position_code, a.id_grup, a.pt, a.tempat_lahir, a.tgl_lahir, a.join_date, a.regis_mysatnusa, a.gender, a.no_hp, a.no_hp2, a.home_telp, a.img_user, a.createby, a.createdate, a.updateby, a.updatedate, a.card_no 
        // FROM tbl_karyawan_temp a WHERE (upper(a.badge_id) LIKE '$txSearch' OR upper(a.fullname) LIKE '$txSearch') LIMIT 100";

        $q = "SELECT `statusdaftar`, `password`, `badge_id`, `email`, `fullname`, `dept_code`, `dept_name`, `line_code`, `rfid_no`, `position_code`, 
        `id_grup`, pt, `tempat_lahir`, `tgl_lahir`, `join_date`, `gender`,`jenis_kelamin` , `no_hp`, `no_hp2`, `home_telp`, 
        `createby`, `createdate`, `updateby`, `updatedate`, `card_no` FROM 
        (SELECT 
        a.password, 
        IF(a.password IS NULL, 'Tidak Terdaftar', 'Terdaftar') as statusdaftar,
        a.badge_id, 
        a.email, 
        a.fullname, 
        a.dept_code, 
        (SELECT dept_name FROM tbl_deptcode WHERE dept_code=a.dept_code) as dept_name, 
        a.line_code, 
        a.rfid_no, 
        a.position_code, 
        a.id_grup, 
        a.pt, 
        a.tempat_lahir, 
        a.tgl_lahir, 
        DATE_FORMAT(a.join_date, '%d %b %Y') as join_date,
        a.gender, 
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=a.gender) AS jenis_kelamin,
        a.no_hp, 
        a.no_hp2, 
        a.home_telp, 
        a.createby, 
        a.createdate, 
        a.updateby, 
        a.updatedate, 
        a.card_no 
        FROM tbl_karyawan a) as b WHERE (upper(badge_id) LIKE '$txSearch' OR upper(fullname) LIKE '$txSearch' OR upper(dept_code) LIKE '$txSearch' OR upper(dept_name) LIKE '$txSearch' OR upper(line_code) LIKE '$txSearch' OR upper(join_date) LIKE '$txSearch' OR upper(statusdaftar) LIKE '$txSearch') $qFilter LIMIT 100";

        // $q = "SELECT * FROM tbl_karyawan_temp LIMIT 100";
        $employeeData = DB::select($q);

        

        $output .= 
        '
        <table style="font-size: 18px;" id="tableEmployeeList" class="table table-responsive table-hover">
            <thead>
                <tr style="color: #CD202E; height: 10px;" class="table-danger">
                    <th class="p-3" scope="col">Nama Lengkap Karyawan</th>
                    <th class="p-3" scope="col">Badge No.</th>
                    <th class="p-3" scope="col">Jenis Kelamin</th>
                    <th class="p-3" scope="col">Posisi</th>
                    <th class="p-3" scope="col">Dept. Code</th>
                    <th class="p-3" scope="col">Departemen</th>
                    <th class="p-3" scope="col">Line Code</th>
                    <th class="p-3" scope="col">Mulai Kerja</th>
                    <th class="p-3" scope="col">Status Mysatnusa Mobile</th>
                    
                </tr>
            </thead>
            <tbody>
            ';

        if($employeeData){

            foreach($employeeData as $row){


                $avatar = '<a class="text-muted" style="text-decoration: none;" href="' . url('/list') . '/' . $row->badge_id . '">' . $row->fullname . '</a>';
                // $statusRegis = $row->regis_mysatnusa  == "Terdaftar" ? '<img src="' . asset('img/checklist.png') . '">' . $row->regis_mysatnusa . '' : '<img src="' . asset('img/vector.png') . '">' . $row->regis_mysatnusa . '';
                $statusRegis = $row->statusdaftar == 'Terdaftar' ? '<i class="bx bxs-check-circle text-success"></i> Terdaftar' : '<i class="bx bxs-check-circle text-danger"></i>Tidak Terdaftar';
                $joinDate = $row->join_date ? date('d-m-Y', strtotime($row->join_date)) : '-';

                // $photo = $row->img_user ? '<img class="rounded-circle me-3" style="width:40px; height:40px;" src="' . $row->img_user . '" />' : '';

                $output .= 
                '
                
                <tr style="font-size: 18px;" class="viewProfile">
                    <th class="p-3">' . $row->fullname . '</th>
                    <td class="p-3">' . $row->badge_id . '</td>
                    <td class="p-3">' . $row->jenis_kelamin . '</td>
                    <td class="p-3">' . $row->position_code . '</td>
                    <td class="p-3">' . $row->dept_code . '</td>
                    <td class="p-3">' . $row->dept_name . '</td>
                    <td class="p-3">' . $row->line_code . '</td>
                    <td class="p-3">' . $row->join_date . '</td>
                    <td class="p-3">
                        ' . $statusRegis . '
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


    public function employee_view($id)
    {

        // untuk ambil position name di header
        $qKaryawan1 = DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser'))->first();
        $positionName = NULL;
        if($qKaryawan1){
            $dataPosition = DB::table('tbl_position')->select('position_name')->where('position_code', $qKaryawan1->position_code)->first();
            $positionName = $dataPosition->position_name;
        }

        $qKaryawan = "SELECT *, 
        (SELECT dept_name FROM tbl_deptcode WHERE dept_code=tk.dept_code) as dept_name, 
        (SELECT fullname FROM tbl_karyawan WHERE badge_id=tk.createby) as pembuat, 
        (SELECT fullname FROM tbl_karyawan WHERE badge_id=tk.updateby) as pengedit, 
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=tk.pt) as pt_name, 
        (SELECT position_name FROM tbl_position WHERE position_code=tk.position_code) as position_name, 
        tk.img_user as photoprofile, 
        tk.mulai_kontrak as mulai_kontrak, 
        tk.selesai_kontrak as selesai_kontrak, 
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=tk.gender) as gender_name 
        FROM tbl_karyawan tk WHERE tk.badge_id='$id'";
        $dataKaryawan = DB::select($qKaryawan); 

        $qAlamat = "SELECT * FROM tbl_alamat WHERE badge_id='$id'";
        $dataAlamat = DB::select($qAlamat);

        $qPerangkat = "SELECT 
        tm.tipe_hp, 
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=tm.merek_hp) as brand, 
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup=tm.os) as os_name, 
        tm.versi_aplikasi 
        FROM tbl_mms tm WHERE tm.badge_id='$id'";
        $dataPerangkat = DB::select($qPerangkat);

        $qPrivasiKaryawan = "SELECT * FROM tbl_detailkaryawan WHERE badgeid='$id'";
        $dataPrivasiKaryawan = DB::select($qPrivasiKaryawan); 

        $qAgama = "SELECT * FROM tbl_masteragama";
        $dataAgama = DB::select($qAgama); 

        $qDokumen = "SELECT tbl_dokumen.*, tbl_kategoridokumen.name AS kategori_name
             FROM tbl_dokumen
             JOIN tbl_kategoridokumen ON tbl_dokumen.kategori = tbl_kategoridokumen.id
             WHERE tbl_dokumen.badge_id = '$id'
             ORDER BY tbl_kategoridokumen.name";

        $dataDokumen = DB::select($qDokumen);

        if($id){
            $data = array(
                'userInfo' => DB::table('tbl_karyawan')->where('badge_id', session('loggedInUser'))->first(), 
                // 'listview' => DB::table('tbl_karyawan')->where('badge_id', $id)->first()
                'listview' => $dataKaryawan, 
                'listprivasi' => $dataPrivasiKaryawan, 
                'listagama' => $dataAgama, 
                'listDokumen' => $dataDokumen, 
                'dataPerangkat' => $dataPerangkat, 
                'dataAlamat' => $dataAlamat, 
                'userRole' => (int)session()->get('loggedInUser')['session_roles'], 
                'positionName' => $positionName,
            );
        }

        

        return view('karyawan.profil', $data);
    }


    public function employee_line(Request $req)
    {

        $deptCode = $req->get('deptCode');

        // dd($deptCode);

        $q = "SELECT * FROM tbl_linecode WHERE dept_code='$deptCode'";
        $result = DB::select($q);

        return response()->json([
            'status' => 200, 
            'data' => $result
        ]);

        
    }


    public function employee_dept(Request $req)
    {

        $q = "SELECT * FROM tbl_deptcode ORDER BY dept_name";
        $result = DB::select($q);

        return response()->json([
            'status' => 200, 
            'data' => $result
        ]);
    }

    public function kategori_non_karyawan()
    {
        $q = "SELECT * FROM tbl_vlookup WHERE category='STK' AND id_vlookup <> 68";
        $data = DB::select($q);

        if($data){
            return response()->json([
                'status' => 200,
                'data' => $data
            ]);
        }
    }

    public function generate_badge(Request $req)
    {
        $category = $req->get('category');
        return $this->generateBadge($category);
    }

    // fungsi untuk generate badge
    private function generateBadge($params="")
    {
        $category = strtoupper(trim($params));
        if($category != ""){
            $q = "SELECT CAST(REGEXP_REPLACE(badge_id, '[^0-9]', '') AS SIGNED INTEGER) AS nomor FROM tbl_karyawan WHERE badge_id LIKE '%$category%' ORDER BY nomor DESC LIMIT 1";
            $data = DB::select($q);
            $no = 0;
            if($data){
                $no = $data[0]->nomor;  
            }

            return $category . $no+1;
        }
    }

    public function simpan_non_karyawan(Request $req)
    {
        $base64String = NULL;
        $profileImage = NULL;

        DB::beginTransaction();
        try {

            $file = $req->file('btnUpload');

            $durasi = $req->post('selectDurasi');
            

            
            if($file){
                $profileImage = time() . '_' . $file->getClientOriginalName();
                $file->move('img/', $profileImage);
                $fileContent = public_path('img/' . $profileImage);
                $fileContent1 = file_get_contents($fileContent);
                $base64String = 'data:image/png;base64,' . base64_encode($fileContent1);
            }

            $data = array(
                'tipe_karyawan' => $req->post('selectKategoriNonKaryawan'),
                'badge_id'          => $req->post('txBadge'),
                'fullname'     => $req->post('txFullname'),
                'gender'            => $req->post('rdJenisKelamin'),
                'no_hp'             => $req->post('txHP1'),
                'no_hp2'            => $req->post('txHP2'),
                'password' => bcrypt('Passw0rd'),
                'home_telp'         => $req->post('txTelp'),
                'email'             => $req->post('txEmail'),
                'img_user'          => $base64String, 
                'mulai_kontrak'     => $durasi == "jangka_pendek" ? date('Y-m-d', strtotime($req->post('txMulai'))) : NULL,
                'selesai_kontrak'     => $durasi == "jangka_pendek" ? date('Y-m-d', strtotime($req->post('txSelesai'))) : NULL, 
                'join_date'         => ($durasi == "jangka_pendek" ? date('Y-m-d', strtotime($req->post('txMulai'))) : ($durasi == "jangka_panjang" ? date('Y-m-d') : NULL)), 
                'createby'          => session('loggedInUser')['session_badge'], 
                'createdate'        => date('Y-m-d H:i:s'), 
                'is_active'         => '1',
            );

            // dd($data);

            $dataAlamat = array(
                'badge_id'  => $req->post('txBadge'),
                'alamat'    => $req->post('txAlamat'),
                'kecamatan' => $req->post('selectKec'),
                'kelurahan' => $req->post('selectKel'),
            );

            DB::table('tbl_karyawan')->insert($data);

            if($req->post('txAlamat') != "" && $req->post('txAlamat') != "" && $req->post('txAlamat') != ""){
                DB::table('tbl_alamat')->insert($dataAlamat);
            }

            DB::commit();

            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil tersimpan'
            ]);

        }catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status'    => 400, 
                'message'   => 'gagal menyimpan' . $ex->getMessage()
                // 'message'   => 'gagal menyimpan'
            ]);
        }
    }







    // import
    public function import_rfid(Request $req)
    {
        
        try {

            Excel::import(new ExcelReader(), $req->rfidImport);

            return response()->json([
                'status' => 200, 
                'message' => 'RFID Number berhasil di import'
            ]);
        } catch (\Exception $ex) {
            //throw $ex;
            return response()->json([
                'status' => 400, 
                'message' => $ex->getMessage()
            ]);
        }

    }
}
