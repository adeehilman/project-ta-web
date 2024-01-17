<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class DailyInternExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $dFilter;
    protected $rFilter;

    public function __construct($dFilter, $rFilter)
    {

        $this->dFilter = $dFilter;
        $this->rFilter = $rFilter;
    }

    public function view(): View
    {
        $query ="SELECT k.badge_id, k.fullname ,
        (SELECT dept_name FROM tbl_deptcode dc
        WHERE dc.dept_code = k.dept_code)AS dept_name, a.submit_date, a.scanin, a.scanout, a.status, a.attachment
        FROM tbl_absensiinternship a JOIN tbl_karyawan k ON a.badge_id = k.badge_id
        $this->dFilter $this->rFilter";
        $data = DB::select($query);

        foreach ($data as $entry) {
            $entry->scanin = $entry->scanin ? date('H:i:s', strtotime($entry->scanin)): '';
            $entry->scanout = $entry->scanout ? date('H:i:s', strtotime($entry->scanout)): '' ;
        }
        // dd($data);
        return view('export.dailyinternship', [
            'data' => $data,
        ]);
    }
}
