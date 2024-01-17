<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class DetailSummaryRoomExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($HeadDataRoom, $TimeDetail, $timeDB, $TotMeeting, $IdRoom)
    {
        $this->HeadDataRoom = $HeadDataRoom;
        $this->TimeDetail = $TimeDetail;
        $this->TotMeeting = $TotMeeting;
        $this->timeDB = $timeDB;
        $this->IdRoom = $IdRoom;
    }

    public function view(): View
    {
        // dd($data);
        $query = "
        SELECT
        tm.id AS meetingId,
        tm.title_meeting,
        tm.meeting_date,
        tm.booking_by,
        tm.booking_date,
        tm.jumlah_tamu,
        tm.project_name,
        tm.ext,
        tm.meeting_start,
        tm.meeting_end,
        tm.roommeeting_id,
        tm.project_name,
        p.kehadiran,
            (SELECT fullname FROM tbl_karyawan k WHERE k.badge_id = tm.booking_by)AS booking_by_name,
            SUM(CASE WHEN p.kehadiran = '1' THEN 1 ELSE 0 END) AS tot_kehadiran,
            GROUP_CONCAT(DISTINCT mf.fasilitas SEPARATOR ', ') AS fasilitas,
            (SELECT room_name FROM tbl_roommeeting r WHERE r.id = tm.roommeeting_id) AS room_name,
            (
                SELECT COUNT(*)
                FROM tbl_participant p
                WHERE p.meeting_id = tm.id
            ) as participant_count
        FROM tbl_meeting tm
        INNER JOIN tbl_participant p ON p.meeting_id = tm.id
        LEFT JOIN tbl_meetingfasilitasdetail f ON f.meeting_id = tm.id
        LEFT JOIN tbl_meetingfasilitas mf ON mf.id = f.meetingfasilitas_id
 WHERE tm.roommeeting_id = '$this->IdRoom'
 AND tm.meeting_date IN ($this->timeDB)
 AND statusmeeting_id = '5'
        GROUP BY tm.id, tm.title_meeting, tm.meeting_date, tm.booking_by, tm.booking_date, tm.jumlah_tamu, tm.project_name, tm.ext, p.kehadiran, room_name, tm.project_name, tm.roommeeting_id;
        ";
        $list_tabel = DB::select($query);

        $data = [
            'NameRoom' => $this->HeadDataRoom,
            'TimeDetail' => $this->TimeDetail,
            'TotMeeting' => $this->TotMeeting,
            'list_tabel' => $list_tabel,
        ];
        return view('export.roomDetailSummary', $data);
    }
}
