<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class DetailSummaryMeetingExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($ParticipantBadge, $Fullname, $TimeDetail, $DeptName, $timeDB, $TotMeeting, $Kehadiran, $Absent)
    {
        $this->ParticipantBadge = $ParticipantBadge;
        $this->Fullname = $Fullname;
        $this->TimeDetail = $TimeDetail;
        $this->TimeDB = $timeDB;
        $this->DeptName = $DeptName;
        $this->TotMeeting = $TotMeeting;
        $this->Kehadiran = $Kehadiran;
        $this->Absent = $Absent;
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
        WHERE p.participant = '$this->ParticipantBadge'
        AND tm.meeting_date IN ($this->TimeDB)
        AND statusmeeting_id = '5'
        GROUP BY tm.id, tm.title_meeting, tm.meeting_date, tm.booking_by, tm.project_name,tm.booking_date, tm.jumlah_tamu, tm.project_name, tm.ext, p.kehadiran, room_name;
        ";
        $list_tabel = DB::select($query);

        $data = [
            'ParticipantBadge' => $this->ParticipantBadge,
            'Fullname' => $this->Fullname,
            'TimeDetail' => $this->TimeDetail,
            'DeptName' => $this->DeptName,
            'TotMeeting' => $this->TotMeeting,
            'Kehadiran' => $this->Kehadiran,
            'Absent' => $this->Absent,
            'list_tabel' => $list_tabel,
        ];
        return view('export.meetingDetailSummary', $data);
    }
}
