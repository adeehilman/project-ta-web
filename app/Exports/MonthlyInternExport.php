<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class MonthlyInternExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $dFilter;
    protected $mFilter;

    public function __construct($dFilter, $mFilter , $monthNumber, $deptMonthly)
    {
        $this->dFilter = $dFilter;
        $this->mFilter = $mFilter;
        $this->monthNumber = $monthNumber;
        $this->deptMonthly = $deptMonthly ;
    }

    public function view(): View
    {
        
        $queryNameDept = "SELECT dept_name from tbl_deptcode where dept_code = '$this->deptMonthly'";
        $GetDept = DB::select($queryNameDept);
        // dd($GetDept);
        $GetDept = $GetDept ? $GetDept[0]->dept_name : 'ALL';
        

        // dd($this->monthNumber);
        $month = date('F Y', mktime(0, 0, 0, $this->monthNumber, 1));


        $query = "SELECT
        k.badge_id,
        k.fullname,
        DATE_FORMAT(k.selesai_kontrak, '%d-%b-%y') AS formatted_selesai_kontrak,
        (SELECT dept_name FROM tbl_deptcode dc WHERE dc.dept_code = k.dept_code) AS dept_name,
        COUNT(CASE WHEN a.status = 'Present' THEN 1 ELSE NULL END) AS total_present
        FROM
            tbl_absensiinternship a
        JOIN
            tbl_karyawan k ON a.badge_id = k.badge_id $this->dFilter $this->mFilter
        GROUP BY
        k.badge_id, k.fullname, dept_name
       ";
        $data = DB::select($query);


        // foreach ($data as $entry) {
        //     $entry->scanin = $entry->scanin ? date('H:i:s', strtotime($entry->scanin)) : '';
        //     $entry->scanout = $entry->scanout ? date('H:i:s', strtotime($entry->scanout)) : '';
        // }
        // dd($data);
        return view('export.monthlyinternship', [
            'data' => $data,
            'month' => $month,
            'dept' => $GetDept,
        ]);
    }   


}
