<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class SummaryMeetingExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $txSearch;
    protected $divisiId;
    protected $yFilter;
    protected $monthNumber;
    protected $dFilter;
    protected $mFilter;

    public function __construct($txSearch, $divisiId, $yFilter, $monthNumber, $dFilter, $mFilter)
    {
        $this->divisiId = $divisiId;
        $this->yFilter = $yFilter;
        $this->monthNumber = $monthNumber;
        $this->dFilter = $dFilter;
        $this->mFilter = $mFilter;
        $this->txSearch = $txSearch ?? '%%';
    }

    public function view(): View
    {
        $query = "
        SELECT
            p.participant,
            k.fullname,
            k.dept_code,
            dept.dept_name,
            GROUP_CONCAT(DISTINCT tm.meeting_date ORDER BY tm.meeting_date ASC SEPARATOR ', ') AS meeting_dates,
            COUNT(*) AS tot_meeting,
            SUM(CASE WHEN p.kehadiran = '1' THEN 1 ELSE 0 END) AS kehadiran,
            SUM(CASE WHEN p.kehadiran = '0' THEN 1 ELSE 0 END) AS absent
        FROM
            tbl_participant p
        INNER JOIN
            tbl_karyawan k ON k.badge_id = p.participant
        INNER JOIN
            tbl_deptcode dept ON dept.dept_code = k.dept_code
        INNER JOIN
            tbl_meeting tm ON tm.id = p.meeting_id
            WHERE (fullname LIKE '$this->txSearch' OR participant LIKE '$this->txSearch' OR dept_name LIKE '$this->txSearch') $this->yFilter $this->mFilter $this->dFilter
            AND tm.statusmeeting_id = '5'
        GROUP BY
            p.participant,
            k.fullname,
            k.dept_code,
            dept.dept_name
        ORDER BY
            k.fullname ASC;
          ";
        $data = DB::select($query);

        // dd($data);
        return view('export.meetingSummary', [
            'data' => $data,
        ]);
    }
}
