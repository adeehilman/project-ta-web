<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

// class MeetingExport implements FromCollection
// {
//     protected $divisi;

//     public function __construct($divisi)
//     {
//         $this->divisi = $divisi;
//     }

//     public function collection()
//     {
$query = "
        SELECT
        tm.id as meetingId,
        tm.roommeeting_id,
        tm.title_meeting,
        tm.meeting_date,
        tm.meeting_start,
        tm.meeting_end,
        tm.statusmeeting_id,
        tm.description,
        tm.booking_by,
        tm.booking_date,
        tm.update_date,
        tm.reason,
        b.room_name,
        b.id,
        b.floor,
        k.fullname,
        k.badge_id,
        s.status_name_eng,
        (
            SELECT COUNT(*)
            FROM tbl_participant p
            WHERE p.meeting_id = tm.id
        ) as participant_count
        FROM
            tbl_meeting tm
        INNER JOIN
            tbl_roommeeting b ON b.id = tm.roommeeting_id
        INNER JOIN
            tbl_karyawan k ON tm.booking_by = k.badge_id
        INNER JOIN
            tbl_statusmeeting s ON s.id = tm.statusmeeting_id
          ";

//         $query = "
//         SELECT * FROM tbl_meeting
//         ";

//         return DB::select($query);
//     }
// }

class MeetingExport implements FromView
{
    protected $divisi;

    public function __construct($divisiId, $sFilter, $qFilter, $statusFilter)
    {
        $this->divisi = $divisiId;
        $this->sFilter = $sFilter;
        $this->qFilter = $qFilter;
        $this->statusFilter = $statusFilter;
    }

    public function view(): View
    {
        $query = "
        SELECT
        tm.id as meetingId,
        tm.roommeeting_id,
        tm.title_meeting,
        tm.meeting_date,
        tm.meeting_start,
        tm.meeting_end,
        tm.statusmeeting_id,
        tm.description,
        tm.booking_by,
        tm.booking_date,
        tm.update_date,
        tm.reason,
        b.room_name,
        b.id,
        b.floor,
        k.fullname,
        k.badge_id,
        s.status_name_eng,
        (
            SELECT COUNT(*)
            FROM tbl_participant p
            WHERE p.meeting_id = tm.id
        ) as participant_count
        FROM
            tbl_meeting tm
        INNER JOIN
            tbl_roommeeting b ON b.id = tm.roommeeting_id
        INNER JOIN
            tbl_karyawan k ON tm.booking_by = k.badge_id
        INNER JOIN
            tbl_statusmeeting s ON s.id = tm.statusmeeting_id
            $this->sFilter $this->qFilter $this->statusFilter
          ";
        $data = DB::select($query);

        return view('export.meeting', [
            'data' => $data,
        ]);
    }
}
