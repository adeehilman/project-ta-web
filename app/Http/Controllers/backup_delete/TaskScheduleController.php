<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

class TaskScheduleController extends Controller
{

    // public function __construct(){
    //     set_time_limit(8000000);
    // }
    // get and save data karyawan
    public function getDataKaryawan()
    {

        $client = new Client();
        // $response = $client->post('http://snws07:8001/api/MES/Ext/GetEmployeeList?plant=%');
        $response = $client->post('http://snws07:8000/api/MES/Ext/GetEmployeeList?plant=%');
        $statusCode = $response->getStatusCode();
        

        if($statusCode == 200){
            $data = json_decode($response->getBody(), true);
            $json = json_decode($data["DATA"]);

            DB::beginTransaction();
            try {

                DB::table('tbl_karyawan_from_api')->delete();
                // DB::connection('second')->table('tbl_karyawan_from_api')->delete();

                $testArr = array();

                for($i=0; $i < count($json); $i++){

                    $dataGender = 0;
                    if($json[$i]->Gender == "M"){
                        $dataGender = 3;
                    }else{
                        $dataGender = 4;
                    }

		    $exCode = explode(",", $json[$i]->Level3Code);
                    $deptCode = $exCode[0];

                    $data = array(
                        'badge_id'      => $json[$i]->EmployeeNo,
                        'fullname'      => $json[$i]->FullName,
                        'join_date'     => date('Y-m-d', strtotime($json[$i]->JoinDate)),
                        'dept_code'     => $deptCode,
                        'line_code'     => $json[$i]->Level4Code,
                        'position_code' => $json[$i]->PositionCode,
                        'card_no'       => $json[$i]->CardNo,
                        'gender'        => $dataGender,
                        'createdate'    => date('Y-m-d H:i:s'),
                        'tgl_lahir'     => date('Y-m-d', strtotime($json[$i]->BirthDate))
                    );

                    DB::table('tbl_karyawan_from_api')->insert($data);
                    // DB::connection('second')->table('tbl_karyawan_from_api')->insert($data);
                }

                DB::commit();

                return response()->json([
                    'status' => 200,
                    'message' => 'Fetching data karyawan sukses', 
                ]);


            } catch (\Exception $ex) {
                DB::rollback();
                return response()->json([
                    'status'    => 401, 
                    'message'   => 'gagal menyimpan' . $ex->getMessage(), 
                ]);
    
            }
        }      
    }


    // public function checkDataKaryawan(){
    //     $client = new Client();
    //     $response = $client->post('http://snws07:8001/api/MES/Ext/GetEmployeeList?plant=%');
    //     $statusCode = $response->getStatusCode();

    //     if($statusCode == 200){
    //         $data = json_decode($response->getBody(), true);
    //         $json = json_decode($data["DATA"]);

    //         return response()->json([
    //             'status' => 200, 
    //             'total' => count($json)
    //         ]);
    //     }
    // }

    // public function getBlobtoBase64()
    // {   

    //     $qBadge = "SELECT td.badge_no, td.imei1 FROM `tbl_dump_4` td WHERE device_type='Mobile' LIMIT 100";
    //     $dataBadge = DB::connection('second')->select($qBadge);

    //     DB::beginTransaction();
    //     try {

    //         for($i=0; $i < count($dataBadge); $i++){

    //             $arrBadge = $dataBadge[$i]->badge_no;
    //             $arrImei1 = $dataBadge[$i]->imei1;

    //             $q = "SELECT 
    //             badge_no, 
    //             mobile_info, 
    //             imei1, 
    //             imei2,
    //             TO_BASE64(front_image) AS front_image, 
    //             TO_BASE64(back_image) AS back_image, 
    //             barcode_label, 
    //             device_uuid, 
    //             device_type 
    //             FROM tbl_dump_4 WHERE badge_no='$arrBadge' AND imei1='$arrImei1' LIMIT 1";
    //             $dataImage = DB::connection('second')->select($q);


    //             if($dataImage){

    //                 foreach($dataImage as $row) {

    //                     $data = array(
    //                         'badge_id' => $arrBadge,
    //                         'tipe_hp' => $row->mobile_info,
    //                         'imei1' => $row->imei1,
    //                         'imei2' => $row->imei2,
    //                         'img_dpn' => 'data:image/jpg;base64,' . $row->front_image,
    //                         'img_blk' => 'data:image/jpg;base64,' . $row->back_image, 
    //                         'barcode_label' => $row->barcode_label, 
    //                         'uuid' => $row->device_uuid, 
    //                         'status_pendaftaran_mms' => '12'
    //                     );

    //                     DB::table('tbl_mms_dummy')->insert($data);
            
    //                 }

    //             }

    //         }

    //         DB::commit();
    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'Data berhasil tersimpan', 
    //         ]);

    //     } catch (\Exception $ex) {
    //         DB::rollback();
    //         return response()->json([
    //             'status'    => 401, 
    //             'message'   => 'gagal menyimpan' . $ex->getMessage(), 
    //         ]);

    //     }    
        
    // }


    public function checkImei()
    {
        ini_set('memory_limit', '80G');
        set_time_limit(200000);

        $dateAkhir = date('Y-m-d H:i:s');
        $dateAwal = date('Y-m-d', strtotime('-1 day')) . ' 08:00:00';

        $qRegisteredImei = "SELECT imei1 as imei FROM tbl_mms WHERE (waktu_pengajuan BETWEEN '$dateAwal' AND '$dateAkhir') AND status_pendaftaran_mms < 12";
        $dataRegisteredImei = DB::select($qRegisteredImei);

        if($dataRegisteredImei){

            DB::beginTransaction();
            try {

                foreach($dataRegisteredImei as $row){
                    $client = new Client();
                    $response = $client->post('http://snws07:8000/api/MES/Ext/IMEIVerification?plant=MI11&IMEI=' . $row->imei);
                    $statusCode = $response->getStatusCode();
                    if($statusCode == 200){
                        $data = json_decode($response->getBody(), true);

                        if($data['MESSAGETYPE'] == 'S'){

			    $isShipData = json_decode($data['DATA']);
                            if($isShipData->is_shipped == null || $isShipData->is_shipped == "" || $isShipData->is_shipped == false){
                                DB::table('tbl_mms')->where('imei1', $row->imei)->update(['status_pendaftaran_mms' => 13, 'status_imei' => 2]);   
                            }

                            $dataLog = array(
                                'imei' => $row->imei, 
                                'message_type' => $data['MESSAGETYPE'],
                                'message' => $data['MESSAGE'],
                                'data' => $data['DATA'],
                                'created_at' => date('Y-m-d H:i:s')
                            );
                            DB::table('tbl_logcheckimei')->insert($dataLog);
                        }else{
                            DB::table('tbl_mms')->where('imei1', $row->imei)->update(['status_imei' => 1]);
                            $dataLog = array(
                                'imei' => $row->imei, 
                                'message_type' => $data['MESSAGETYPE'],
                                'message' => $data['MESSAGE'],
                                'data' => $data['DATA'], 
                                'created_at' => date('Y-m-d H:i:s')
                            );
                            DB::table('tbl_logcheckimei')->insert($dataLog);
                        }
                            
                    }else{
                        return response()->json([
                            'status' => 400,
                            'message' => 'Gagal request ke api - ' . date('d M Y H:i'), 
                        ]); 
                    }

                }

                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => 'Data imei telah diupdate - ' . date('d M Y H:i'), 
                ]);

            }catch (\Exception $ex) {
                DB::rollback();
                return response()->json([
                    'status'    => 401, 
                    'message'   => 'Gagal untuk mengupdate data ' . $ex->getMessage(), 
                ]);
            }
        }else{
            return response()->json([
                'status' => 200,
                'message' => 'Tidak ada data imei untuk dicheck - ' . date('d M Y H:i'), 
            ]); 
        }


    }




    // public function deleteAlreadyGet()
    // {
    //     $qBadge = "SELECT td.badge_id, td.imei1 FROM `tbl_mms_dummy` td ORDER BY td.id DESC LIMIT 100";
    //     $dataBadge = DB::select($qBadge);

    //     DB::beginTransaction();
    //     try {

    //         for($i=0; $i < count($dataBadge); $i++){

    //             $arrBadge = $dataBadge[$i]->badge_id;
    //             $arrImei1 = $dataBadge[$i]->imei1;

    //             // DB::connection('second')->table('tbl_dump_1')->where(['badge_no' => $arrBadge, 'imei1' => $arrImei1])->delete();

    //             $q = "DELETE FROM tbl_dump_4 WHERE badge_no='$arrBadge' AND imei1='$arrImei1' LIMIT 100";
    //             $dataImage = DB::connection('second')->select($q);

                

    //         }

    //         DB::commit();
    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'Data berhasil terhapus', 
    //         ]);
    //     } catch (\Exception $ex) {
    //         DB::rollback();
    //         return response()->json([
    //             'status'    => 401, 
    //             'message'   => 'gagal menyimpan' . $ex->getMessage(), 
    //         ]);

    //     }

    // }



    // public function checkCountTableDump()
    // {
    //     $count = DB::connection('second')->table('tbl_dump_4')->count();

    //     return response()->json([
    //         'status' => 200, 
    //         'countData' => $count
    //     ]);
    // }


    public function convertBlobKeJpg()
    {
        ini_set('memory_limit', '20G');
        // $q = "SELECT id, profile_image FROM tbl_dump  WHERE id >= 1 AND id <= 9000";
        // $data = DB::select($q);

        // if($data){
            
        //     foreach($data as $row){
        //         $namaFile = $row->id . '.jpg';
        //         $fileGambar = $row->profile_image;

        //         file_put_contents('profile_image1/' . $namaFile, $fileGambar);
        //     }


            
        // }

        $q = "SELECT DISTINCT badge_no, back_image FROM tbl_dump  WHERE id >= 1 AND id <= 32";
        $data = DB::connection('second')->select($q);

        if($data){
            
            foreach($data as $row){
                $namaFile = $row->badge_no . '.jpg';
                $fileGambar = $row->back_image;

                file_put_contents('back_image/' . $namaFile, $fileGambar);
            }


            
        }




    }










    // // local to database
    // public function localBlobtoBase64()
    // {   
    //     ini_set('memory_limit', '80G');
    //     set_time_limit(200000);
    //     $folderPath = 'C:\Users\ali.sadikin\Desktop\foto\laptop_belakang';
    
    //     $files = scandir($folderPath);

    //     // dd($files);
    
    //     $data = array();
    
    //     foreach ($files as $file) {
    //             // Hanya proses file dengan ekstensi gambar tertentu
    //         $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    //         $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    
    //         if (in_array($extension, $allowedExtensions)) {
    //             $dataImg = array(
    //                 'id' => pathinfo($file, PATHINFO_FILENAME),
    //             );
    //             array_push($data, $dataImg);
    //         }       
    
    //     }
    
    //     DB::beginTransaction();
    
    //         try {
    
    //             for($i=0; $i < count($data); $i++){
    
    //                 $imageUrl  = 'C:/Users/ali.sadikin/Desktop/foto/laptop_belakang/' . $data[$i]['id'] . '.jpg';
    
    //                 $imageData = file_get_contents($imageUrl);
    //                 $base64Image = 'data:image/jpg;base64,' . base64_encode($imageData);
    
    //                 DB::table('tbl_dump')->where('id', $data[$i]['id'])->update(['img_blk' => $base64Image]);              
        
    //             }
    
    //         DB::commit();
    //         return response()->json([
    //             'status' => 200,
    //             'message' => 'Data berhasil tersimpan', 
    //         ]);
    
    //     } catch (\Exception $ex) {
    //         DB::rollback();
    //         return response()->json([
    //             'status'    => 401, 
    //             'message'   => 'gagal menyimpan' . $ex->getMessage(), 
    //         ]);
    
    //     }
    
    // }

    public function karyawanImagetoBase64()
    {
        ini_set('memory_limit', '80G');
        set_time_limit(200000);

        // $folderPath = 'C:\Users\ali.sadikin\Desktop\foto\profile_image1';
        $folderPath = 'D:\workspace\25052023\fix-mysatnusa-admin\public\profile_image';

        $files = scandir($folderPath);

        $data = array();

        foreach ($files as $file) {
            // Hanya proses file dengan ekstensi gambar tertentu
            $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array($extension, $allowedExtensions)) {
                $dataImg = array(
                    'badge_id' => pathinfo($file, PATHINFO_FILENAME),
                );
                array_push($data, $dataImg);
            }       

        }


        DB::beginTransaction();

        try {

            for($i=0; $i < count($data); $i++){

                $imageUrl  = 'D:\workspace\25052023\fix-mysatnusa-admin\public\profile_image/' . $data[$i]['badge_id'] . '.jpg';

                $imageData = file_get_contents($imageUrl);
                $base64Image = 'data:image/jpg;base64,' . base64_encode($imageData);

                DB::table('tbl_karyawan')->where('badge_id', $data[$i]['badge_id'])->update(['img_user' => $base64Image]);              
                // DB::connection('second')->table('tbl_dump')->where('badge_no', $data[$i]['badge_id'])->update(['back_image_base64' => $base64Image]);              
    
            }

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

    }



    // public function dataLocaltoServer()
    // {

    //     $qLocal = "SELECT * FROM tbl_dump WHERE id >= 1 AND id <= 1000";
    //     $dataLocal = DB::select($q);

    //     dd($dataLocal);
    // }

    // update gambar karyawan
    public function fetchGambarKaryawan()
    {

        DB::beginTransaction();
            
        try {

            $q = "SELECT badge_id FROM tbl_karyawan WHERE img_user IS NULL AND tipe_karyawan='68'";
            $dataKaryawan = DB::select($q);

            for($i=0; $i<count($dataKaryawan); $i++){

                $badge = $dataKaryawan[$i]->badge_id;

                $client = new Client();
                $response = $client->get('http://snws07:8000/api/SAP/Ext/GetEmployeePicture/' . $badge);
                $statusCode = $response->getStatusCode();

                if($statusCode == 200){

                    $imageData = $response->getBody()->getContents();

                    if (str_contains($imageData, 'img') == TRUE) { 
                        
                        $clean1 = str_replace('<img src="', "", $imageData);
                        $clean2 = str_replace('"></img>', "", $clean1);
                        $base64image = $clean2;

                        DB::table('tbl_karyawan')->where('badge_id', $badge)->update([
                            'img_user' => $base64image
                        ]);
                    }
                                 
                }

            }

            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Data gambar telah di update - ' . date('d M Y H:i'), 
            ]);

        }catch (\Exception $ex) {
            DB::rollback();
            return response()->json([
                'status'    => 401, 
                'message'   => 'Gagal untuk mengupdate data ' . $ex->getMessage(), 
            ]);
        }

        
    }
    //end update data gambar karyawan
    
}
