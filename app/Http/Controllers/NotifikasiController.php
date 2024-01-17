<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotifikasiController extends Controller
{
    /**
     * roles untuk get data mms
     */
    public function getCountNotif(Request $request)
    {
        $roles = $request->roles;
        // roles 63 dan 64 untuk HRD
        if ($roles == 63 || $roles == 64) {

            $filterMMS = "";
            if($roles == 63){
                $filterMMS = " WHERE hidden != 1";
            }

            $query_mms = "SELECT 
                SUM(CASE WHEN status_pendaftaran_mms = 2 THEN 1 ELSE 0 END) AS mms_idstat_2,
                SUM(CASE WHEN status_pendaftaran_mms = 4 THEN 1 ELSE 0 END) AS mms_idstat_4
            FROM tbl_mms;";

            $data_mms = DB::select($query_mms)[0];

            $query_lms = "SELECT 
                SUM(CASE WHEN status_pendaftaran_lms = 2 THEN 1 ELSE 0 END) AS lms_idstat_2,
                SUM(CASE WHEN status_pendaftaran_lms = 4 THEN 1 ELSE 0 END) AS lms_idstat_4
            FROM tbl_lms;
            ";

            $data_lms = DB::select($query_lms)[0];

            $query_kritiksaran = "SELECT 
                SUM(CASE WHEN status_kritiksaran = 2 THEN 1 ELSE 0 END) AS ks_idstat_2,
                SUM(CASE WHEN status_kritiksaran <> 4 THEN 1 ELSE 0 END) AS ks_idstat_not_4
            FROM tbl_kritiksaran $filterMMS;";

            $data_kritiksaran = DB::select($query_kritiksaran)[0];

            if($roles == 63){
                $count = $data_mms->mms_idstat_2 + $data_lms->lms_idstat_2 + $data_kritiksaran->ks_idstat_not_4;
            }
            else {
                $count =  $data_mms->mms_idstat_4 + $data_lms->lms_idstat_4 + $data_kritiksaran->ks_idstat_not_4;
            }

            return response()->json([
                "message" => "OK.",
                "jumlah_count" => $count,
                "data" => [
                    "status_mms_2" =>  $data_mms->mms_idstat_2,
                    "status_mms_4" =>  $data_mms->mms_idstat_4,
                    "status_lms_2" =>  $data_lms->lms_idstat_2,
                    "status_lms_4" =>  $data_lms->lms_idstat_4,
                    "status_kritiksaran_2" => $data_kritiksaran->ks_idstat_2,
                    "status_kritiksaran_not_4" => $data_kritiksaran->ks_idstat_not_4,
                ]
            ], 200);
        }

        // roles 65 dan 66 untuk QHSE Staff dan Manager
        if ($roles == 65 || $roles == 66) {
            $query_mms = "SELECT 
                SUM(CASE WHEN status_pendaftaran_mms = 7 THEN 1 ELSE 0 END) AS mms_idstat_2,
                SUM(CASE WHEN status_pendaftaran_mms = 9 THEN 1 ELSE 0 END) AS mms_idstat_4
            FROM tbl_mms;";

            $data_mms = DB::select($query_mms)[0];

            $query_lms = "SELECT 
                SUM(CASE WHEN status_pendaftaran_lms = 7 THEN 1 ELSE 0 END) AS lms_idstat_2,
                SUM(CASE WHEN status_pendaftaran_lms = 9 THEN 1 ELSE 0 END) AS lms_idstat_4
            FROM tbl_lms;
            ";

            $data_lms = DB::select($query_lms)[0];

            if($roles == 65){
                $count = $data_mms->mms_idstat_2 + $data_mms->mms_idstat_4 + $data_lms->lms_idstat_2 + $data_lms->lms_idstat_4;
            }
            else {
                $count =  $data_mms->mms_idstat_4 +  $data_lms->lms_idstat_4;
            }

            return response()->json([
                "message" => "OK.",
                "jumlah_count" => $count ? $count : 0,
                "data" => [
                    "status_mms_2" =>  $data_mms->mms_idstat_2,
                    "status_mms_4" =>  $data_mms->mms_idstat_4,
                    "status_lms_2" =>  $data_lms->lms_idstat_2,
                    "status_lms_4" =>  $data_lms->lms_idstat_4,
                    "status_kritiksaran_2" => 0,
                    "status_kritiksaran_not_4" => 0
                ]
            ], 200);
        }

        // roles 67 untuk MIS
        if ($roles == 67 ) {

            $query_lms = "SELECT 
                SUM(CASE WHEN status_pendaftaran_lms = 12 THEN 1 ELSE 0 END) AS lms_idstat_2
            FROM tbl_lms;
            ";

            $data_lms = DB::select($query_lms)[0];

            return response()->json([
                "message" => "OK.",
                "jumlah_count" => $data_lms->lms_idstat_2,
                "data" => [
                    "status_mms_2" =>  0,
                    "status_mms_4" =>  0,
                    "status_lms_2" =>  $data_lms->lms_idstat_2,
                    "status_kritiksaran_2" => 0,
                    "status_kritiksaran_not_4" => 0
                ]
            ], 200);
        }


        // roles 84 untuk Recepcionist
        if ($roles == 84 ) {

            $query_wait_meeting = " SELECT 
                SUM(CASE WHEN statusmeeting_id = 2 OR statusmeeting_id = 3 THEN 1 ELSE 0 END) AS wait_meeting_idstat_2
            FROM tbl_meeting LEFT JOIN tbl_roommeeting rm ON roommeeting_id = rm.id WHERE rm.dept = 'SATNUSA';
            ";

            $data_wait_meeting = DB::select($query_wait_meeting)[0];

            $query_now_meeting = "SELECT 
                SUM(CASE WHEN statusmeeting_id = 4 THEN 1 ELSE 0 END) AS now_meeting_idstat_2
            FROM tbl_meeting LEFT JOIN tbl_roommeeting rm ON roommeeting_id = rm.id WHERE rm.dept = 'SATNUSA';
            ";

            $data_now_meeting = DB::select($query_now_meeting)[0];

            if($roles == 84){
                $count = $data_wait_meeting->wait_meeting_idstat_2 + $data_now_meeting->now_meeting_idstat_2 ;
            }

            return response()->json([
                "message" => "OK.",
                "jumlah_count" => $count ? $count : 0,
                "data" => [
                    "status_mms_2" =>  0,
                    "status_mms_4" =>  0,
                    "status_lms_2" =>  0,
                    "status_lms_4" =>  0,
                    "status_wait_meeting_2" =>  $data_wait_meeting->wait_meeting_idstat_2,
                    "status_meeting_now_2" =>  $data_now_meeting->now_meeting_idstat_2,
                    "status_kritiksaran_2" => 0,
                    "status_kritiksaran_not_4" => 0
                ]
            ], 200);
        }
    }
}
