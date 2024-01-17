<?php

namespace App\Http\Controllers;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use DB;
use Exception;

class ExcelReader implements ToCollection{


    public function collection(Collection $rows){


        // 
        // $totalRow = count($rows);
        // dd($totalRow);
        $uniqueValues = [];
        $duplicateRows = [];
        // $rowCheck = [];

        // Iterasi melalui data yang dikumpulkan
         // foreach ($rows as $index => $rowData) {
        //     // Mendapatkan nilai yang akan diperiksa duplikat
        //     $valueToCheck = $rowData[1]; // Menggunakan kolom kedua sebagai contoh
            
        //     // Pengecekan duplikat
        //     if (in_array($valueToCheck, $uniqueValues)) {
        //         // Data duplikat ditemukan
        //         $duplicateRows[] = $index + 1; // Menambahkan nomor baris ke dalam array data duplikat
        //         // $rowCheck = $rowData[0];
        //     } else {
        //         // Menyimpan nilai unik ke dalam array
        //         $uniqueValues[] = $valueToCheck;
        //     }
        // }
// dd($rowCheck);

// Menampilkan data duplikat
        if (!empty($duplicateRows)) {
            // dd($duplicateRows[0]);
            // echo "Data duplikat ditemukan pada baris: " . implode(', ', $duplicateRows);
            // $message = 'Data RFID duplikat ditemukan pada baris: ' . implode(', ', $duplicateRows) . ' dan :' . $rowCheck;
            $message = 'Data RFID duplikat ditemukan pada baris: ' . implode(', ', $duplicateRows);
            throw new Exception($message);
        } else {
        //     dd('tidak duplikat');
        //     echo "Tidak ada data duplikat.";
        // }
        for($i=1; $i < count($rows); $i++){

            $badge = $rows[$i][0];
            $rfid = $rows[$i][1];

            // cek rfid yang duplikat di database
            $dataDuplikat = DB::table('tbl_karyawan')->where('rfid_no', $rfid)->first();

            if($dataDuplikat){

                // dd($dataDuplikat);
                $message = "RFID Duplikat = '" . $rfid . "' Pada row " . $i+1;
                throw new Exception($message);
            }else{

                DB::table('tbl_karyawan')->where('badge_id', $badge)
                ->update([
                    'rfid_no' => $rfid,
                ]);
            }

        }

        // for($a=1; $a < count($rows); $a++){

        //     $badge = $rows[$a][0];
        //     $rfid = $rows[$a][1];

            

        //     if($rfid == $rows[$a+1][1]){
        //         // dd($rows[$a+1][1]);
        //         $message = 'Data pada excel duplikat';
        //         throw new Exception($message);
        //     }

        //     $b=2;
        //     $rfidCheck = $rows[$b][1];

        //     // dd($rfid);

        //     if($b < count($rows)){
        //         if($rfidCheck == $rfid){
        //             dd($rfid);
        //             $message = 'Data pada excel duplikat';
        //             throw new Exception($message);
        //         }else{
        //             $b+1;
        //         }
        //     }
       

        }


            

            // return false;

            // foreach($rows as $key => $row){

            //     dd($rows);

            //     DB::table('tbl_karyawan')->where('badge_id', $row[0])
            //     ->update([
            //         'rfid_no' => $row[1],
            //     ]);
            // }

            // DB::commit();
            // return response()->json([
            //     'status' => 200,
            //     'message' => 'Data berhasil tersimpan'
            // ]);

        // }catch (\Exception $ex) {
        //     // DB::rollback();
        //     return response()->json([
        //         'status'    => 400, 
        //         // 'message'   => 'gagal menyimpan' . $ex->getMessage()
        //         'message'   => 'gagal menyimpan'
        //     ]);
        // }
    }
}