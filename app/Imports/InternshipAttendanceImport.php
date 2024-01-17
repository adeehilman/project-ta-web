<?php

namespace App\Imports;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InternshipAttendanceImport implements ToCollection, WithHeadingRow
{
    protected $badgeId;

    // constructor
    public function __construct($badgeId)
    {
        $this->badgeId = $badgeId;
    }

    public function collection(Collection $rows)
    {
        // dd($rows);
        foreach ($rows as $key => $row) {
            if ($row['badge_id'] == '' || $row['name'] == '') {
                throw new Exception('Empty text in excel cell, please check!');
            }
            // validasi costumer dari database
            
            $badgeId = $row['badge_id'];
            $query_cekBadgeId = "SELECT badge_id FROM tbl_karyawan WHERE badge_id = '$badgeId'";
            $data_cekBadgeId = DB::select($query_cekBadgeId);
            if (COUNT($data_cekBadgeId) == 0) {
                throw new Exception('Employee ' . $badgeId . ' is not exist!');
            }

            //

            $name = $row['name'];
            $date = $row['date'];
            $time_in = $row['time_in'];
            $time_out = $row['time_out'];
            $status = $row['status'];

            $datetime_in = $date . ' ' . $time_in;
            $datetime_out = $date . ' ' . $time_out;

            // dd($badgeId);
            // dd($date, $datetime_in ,$datetime_out)
            //  lakukan update
            // $idTooling = $data_cekTooling[0]->id;
            try {
                DB::table('tbl_absensiinternship')
                    ->where('badge_id', $badgeId)
                    ->where('submit_date', $date)
                    ->update([
                        'badge_id' => $badgeId,
                        'submit_date' => $date,
                        'scanin' => $datetime_in,
                        'scanout' => $datetime_out,
                        'status' => $status,
                        'updateby' => $this->badgeId,
                        'updatedate' => date('Y-m-d H:i:s'),
                    ]);
            } catch (\Throwable $th) {
                throw new Exception('Something went wrong' . $th->getMessage());
            }

           
        }
    }
}
