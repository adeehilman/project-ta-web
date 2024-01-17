<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class RoomSummaryExport implements FromView
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

    public function __construct($txSearch, $divisiId, $yFilter, $monthNumber, $mFilter)
    {
        $this->divisiId = $divisiId;
        $this->yFilter = $yFilter;
        $this->monthNumber = $monthNumber;
        $this->mFilter = $mFilter;
        $this->txSearch = $txSearch ?? '%%';
        // dd($yFilter);
    }

    public function view(): View
    {
        $query = "
        SELECT rm.room_name, rm.id, COUNT(tm.id) as meeting_count,
                GROUP_CONCAT(DISTINCT tm.meeting_date ORDER BY tm.meeting_date ASC SEPARATOR ', ') AS meeting_dates
        FROM tbl_roommeeting rm
        LEFT JOIN tbl_meeting tm ON rm.id = tm.roommeeting_id
        WHERE (room_name LIKE '$this->txSearch') AND tm.statusmeeting_id = '5' $this->yFilter $this->mFilter $this->dFilter
        GROUP BY rm.room_name, rm.id
        ORDER BY
                CAST(SUBSTRING_INDEX(room_name, ' ', -1) AS UNSIGNED), room_name
          ";
        $data = DB::select($query);

        // dd($data);
        return view('export.roomsummary', [
            'data' => $data,
        ]);
    }
}
