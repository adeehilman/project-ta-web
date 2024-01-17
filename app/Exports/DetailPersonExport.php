<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class DetailPersonExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $badge_id;
    protected $name;
    protected $dept;
    protected $total_absent;
    protected $total_not_attend;
    protected $total_present;
    protected $monthFilter;
    protected $yearFilter;

    public function __construct($badge_id, $name, $dept, $total_absent, $total_not_attend, $total_present, $monthFilter, $yearFilter)
    {
        $this->badge_id = $badge_id;
        $this->name = $name;
        $this->dept = $dept;
        $this->total_absent = $total_absent;
        $this->total_not_attend = $total_not_attend;
        $this->total_present = $total_present;
        $this->monthFilter = $monthFilter;
        $this->yearFilter = $yearFilter;
    }

    public function view(): View
    {
        // $value = $this->valueDetail;
        $query = "SELECT * FROM tbl_absensiinternship
            WHERE badge_id = '$this->badge_id'
            AND MONTH(submit_date) =  '$this->monthFilter'
            AND YEAR(submit_date) =  '$this->yearFilter'
            ORDER BY submit_date ASC, scanin ASC";
        $data = DB::SELECT($query);
        // dd($data);
        //   dd($value);
        foreach ($data as $entry) {
            $entry->scanin = $entry->scanin? date('H:i:s', strtotime($entry->scanin)) : '';
            $entry->scanout = $entry->scanout ? date('H:i:s', strtotime($entry->scanout)) : '';
        }


        return view('export.employeeinternship', [
            'data' => $data,
            'badgeId' => $this->badge_id,
            'Fullname' => $this->name,
            'Department' => $this->dept,
            'Total_attend' => $this->total_present,
            'Total_not_attend' => $this->total_not_attend,
            'Absent' => $this->total_absent,
        ]);
    }
}
