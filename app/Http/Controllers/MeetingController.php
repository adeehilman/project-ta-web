<?php

namespace App\Http\Controllers;
use App\Exports\MeetingExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Client;

class MeetingController extends Controller
{
    public function index(Request $req)
    {
        $filter = $req->get('filter');

        $now = $req->get('now');

        // query filter
        $query_list_room = "SELECT * FROM tbl_roommeeting ORDER BY
        CAST(SUBSTRING_INDEX(room_name, ' ', -1) AS UNSIGNED), room_name";
        $list_room = DB::select($query_list_room);

        $query_list_participant = 'SELECT fullname, badge_id, p.position_name FROM tbl_karyawan k LEFT JOIN tbl_position p ON p.position_code = k.position_code';
        $list_participant = DB::select($query_list_participant);

        $query_list_status = 'SELECT * FROM tbl_statusmeeting';
        $list_status = DB::select($query_list_status);

        $query_list_facilities = 'SELECT * FROM tbl_meetingfasilitas ORDER BY id ASC';
        $list_facilities = DB::select($query_list_facilities);

        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_rolemeeting')
                ->select('name')
                ->where('id', session()->get('loggedInUser')['session_roles'])
                ->first()->name,

            'list_room' => $list_room,
            'list_participant' => $list_participant,
            'list_status' => $list_status,
            'list_facilities' => $list_facilities,
            'filterData' => $filter ? $filter : null,
            'filterDataNow' => $now ? $now : null,
        ];

        return view('meeting.index', $data);
    }

    // menampilkan data view meeting
    public function getList(Request $request)
    {
        $sessionLogin = session('loggedInUser');

        $badgeId = $sessionLogin['session_badge'];

        $txSearch = '%' . trim($request->txSearch) . '%';

        $qFilter = '';

        $selectRoom = $request->selectRoom;
        $filterTime = $request->filtertime;

        $fStatus = intval($request->get('fStatus'));

        $fNow = intval($request->get('fNow'));

        if ($filterTime == '2') {
            $date = date('Y-m-d', strtotime('+1 day'));
            $days30 = date('Y-m-d', strtotime('-30 days'));
            $qFilter .= "AND (booking_date BETWEEN '$days30' AND '$date')";
        } elseif ($filterTime == '1') {
            $date = date('Y-m-d', strtotime('+1 day'));
            $days7 = date('Y-m-d', strtotime('-7 days', strtotime($date)));
            $qFilter .= "AND (booking_date BETWEEN '$days7' AND '$date')";
        } else {
            $qFilter .= '';
        }

        // dd($selectRoom);
        $sFilter = '';
        if (is_array($selectRoom) && !empty($selectRoom)) {
            $selectRoomStr = "'" . implode("','", $selectRoom) . "'";
            $sFilter .= " AND tm.roommeeting_id IN ($selectRoomStr)";
        } else {
            // Handle jika $selectRoom adalah string kosong atau bukan array
            $sFilter .= ''; // Atau sesuai dengan apa yang Anda butuhkan dalam kasus ini
        }

        // filter redirect
        if ($fStatus > 0) {
            $qFilter .= ' AND (statusmeeting_id = 2 OR statusmeeting_id = 3)';
        } else {
            $qFilter .= '';
        }

        // filter redirect
        if ($fNow > 0) {
            $qFilter .= ' AND (statusmeeting_id = 4)';
        } else {
            $qFilter .= '';
        }

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
        booking_date,
        update_date,
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
        ) as participant_count,
        ABS(TIMESTAMPDIFF(HOUR, NOW(), CONCAT(tm.meeting_date, ' ', tm.meeting_start))) as hour_difference
        FROM
        tbl_meeting tm
        INNER JOIN
        tbl_roommeeting b ON b.id = tm.roommeeting_id
        INNER JOIN
        tbl_karyawan k ON tm.booking_by = k.badge_id
        INNER JOIN
        tbl_statusmeeting s ON s.id = tm.statusmeeting_id
        WHERE (title_meeting LIKE '$txSearch' OR room_name LIKE '$txSearch' OR floor LIKE '$txSearch' OR meeting_date LIKE '$txSearch' OR meeting_start LIKE '$txSearch' OR meeting_start LIKE '$txSearch'
        OR status_name_eng LIKE '$txSearch' OR fullname LIKE '$txSearch')  $sFilter $qFilter
        ORDER BY  CASE
                WHEN tm.statusmeeting_id IN (1, 2, 3, 4) THEN 0 -- Prioritaskan status 1, 2, 3, 4
                ELSE 1
            END,
        ABS(DATEDIFF(NOW(), tm.meeting_date)), hour_difference, tm.meeting_start ,tm.statusmeeting_id ASC
        ";

        $data = DB::select($query);
        // dd($data);
        $output = '';
        $output .= '
            <table id="tableMeeting" class="table table-responsive table-hover" style="font-size: 16px">
                <thead>
                    <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                            <th class="p-3" scope="col">Meeting Title</th>
                            <th class="p-3" scope="col">Room</th>
                            <th class="p-3" scope="col">Date Meeting</th>
                            <th class="p-3" scope="col">Start Meeting</th>
                            <th class="p-3" scope="col">Finished Meeting</>
                            <th class="p-3" scope="col">Participant</th>
                            <th class="p-3" scope="col">Request</th>
                            <th class="p-3" scope="col">Booking Date</th>
                            <th class="p-3" scope="col">Status</th>
                            <th class="p-3" scope="col">Action</th>
                        </tr>
                </thead>
                <tbody>
        ';
        $no = 1;
        foreach ($data as $key => $item) {
            $statusBadge = $item->status_name_eng == 'Canceled' ? '<p class="badge bg-danger">' . $item->status_name_eng . '</p>' : $item->status_name_eng;

            $output .=
                '
                <tr>
                    <td class="p-3">' .
                $item->title_meeting .
                '</td>
                    <td class="p-3">' .
                $item->room_name .
                '</td>
                    <td class="p-3">' .
                date('d F Y', strtotime($item->meeting_date)) .
                '</td>
                    <td class="p-3">' .
                date('H:i', strtotime($item->meeting_start)) .
                '</td>
                    <td class="p-3">' .
                date('H:i', strtotime($item->meeting_end)) .
                '</td>
                    <td class="p-3">' .
                $item->participant_count .
                '  People' .
                '</td>
                    <td class="p-3">' .
                $item->fullname .
                '</td>
                    <td class="p-3">' .
                date('d F Y H:i', strtotime($item->booking_date)) .
                '</td>
                <td class="p-3">' .
                $statusBadge .
                '</td>
                <td>
                <a id="btnDetail" class="btn btnDetail" data-id=' .
                $item->meetingId .
                '><img src="' .
                asset('icons/eye.svg') .
                '"></a>
            </td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
        return $output;
    }

    // untuk menampilkan data di modal detail
    public function getDetail(Request $request)
    {
        $idMeeting = $request->meetingId;

        // dd($idMeeting);
        $query = "SELECT
        tm.id as meetingId,
        tm.roommeeting_id,
        tm.title_meeting,
        tm.meeting_date,
        tm.meeting_start,
        tm.meeting_end,
        tm.customer_name,
        tm.statusmeeting_id,
        tm.description,
        tm.booking_by,
        tm.category_meeting,
        tm.booking_date,
        tm.update_date,
        tm.customer_name,
        tm.reason,
        tm.jumlah_tamu,
        tm.ext,
        tm.createby,
        tm.customer_name,
        b.room_name,
        b.id,
        b.floor,
        k.fullname,
        k.badge_id,
        s.status_name_eng,
        s.id as statusId,
        tm.project_name AS project,
        (
            SELECT COUNT(*)
            FROM tbl_participant p
            WHERE p.meeting_id = tm.id
        ) as participant_count,
        (
            SELECT fullname FROM tbl_karyawan WHERE badge_id = tm.createby
        ) AS recepcionist ,
        (
        SELECT COUNT(*)
        FROM tbl_participant
        WHERE meeting_id = tm.id
        AND kehadiran = 1
        ) as kehadiran_count
            FROM
                tbl_meeting tm
            INNER JOIN
                tbl_roommeeting b ON b.id = tm.roommeeting_id
            INNER JOIN
                tbl_karyawan k ON tm.booking_by = k.badge_id
            INNER JOIN
                tbl_statusmeeting s ON s.id = tm.statusmeeting_id
                WHERE tm.id = '$idMeeting' ";
        $dataMeeting = DB::select($query)[0];

        $fasilitasName = " SELECT * , (SELECT fasilitas FROM tbl_meetingfasilitas mfs WHERE mfs.id = meetingfasilitas_id)AS nama_fasilitas FROM tbl_meetingfasilitasdetail mfd WHERE meeting_id = '$idMeeting'";
        $listFasilitas = DB::select($fasilitasName);

        $dataMeeting->meeting_date = date('d F Y', strtotime($dataMeeting->meeting_date));
        $dataMeeting->booking_date = date('d F Y,   H:i', strtotime($dataMeeting->booking_date));
        // Mengubah format jam dari "HH:mm:ss" menjadi "h:m"
        // $dataMeeting->booking_date = date('H:i', strtotime($dataMeeting->booking_date));
        $dataMeeting->meeting_start = date('H:i', strtotime($dataMeeting->meeting_start));
        $dataMeeting->meeting_end = date('H:i', strtotime($dataMeeting->meeting_end));
        $dataMeeting->description = $dataMeeting->description !== null ? $dataMeeting->description : '-';

        // dd($dataMeeting);
        return response()->json([
            'DetailMeeting' => $dataMeeting,
            'FasilitasList' => $listFasilitas,
        ]);
    }

    // untuk menampilkan data participant di modal detail
    public function getParticipant(Request $request)
    {
        $idMeeting = $request->meetingId;

        $query_participant_list = "SELECT
        p.meeting_id,
        p.participant,
        p.kehadiran,
        p.statusrsvp_id,
        p.reasonrsvp,
        k.fullname,
        k.img_user,
        k.position_code,
        m.statusmeeting_id,
        a.position_name FROM tbl_participant p
        INNER JOIN tbl_karyawan k ON p.participant = k.badge_id
        INNER JOIN tbl_meeting m ON m.id = p.meeting_id
        INNER JOIN tbl_position a ON k.position_code = a.position_code
        WHERE p.meeting_id = '$idMeeting'";

        $dataParticipant = DB::select($query_participant_list);

        $listParticipant = "SELECT participant FROM tbl_participant where meeting_id = '$idMeeting'";
        $query_list_p = DB::SELECT($listParticipant);

        $listParticipantID = [];
        foreach ($query_list_p as $key => $item) {
            array_push($listParticipantID, $item->participant);
        }

        // dd($dataMeeting);
        return response()->json([
            'ParticipantTabs' => $dataParticipant,
            'editParticipant' => $listParticipantID,
        ]);
    }

    // untuk cancel meeting
    public function cancelMeeting(Request $request)
    {
        $sessionLogin = session('loggedInUser');
        $divisiId = $sessionLogin['session_badge'];

        $reason = strip_tags($request->txDeskripsi);
        $idMeeting = $request->idmeeting;
        $confirm = $request->confirm;

        DB::beginTransaction();

        try {
            $cancelq = "SELECT statusmeeting_id FROM tbl_meeting WHERE id = '$idMeeting' and statusmeeting_id = '$confirm'";
            $data_cancel = DB::select($cancelq);

            if (COUNT($data_cancel) > 0) {
                return response()->json([
                    'MSGTYPE' => 'W',
                    'MSG' => 'The Meeting already Canceled',
                ]);
            }

            DB::table('tbl_meeting')
                ->where('id', $idMeeting)
                ->update([
                    'statusmeeting_id' => $confirm,
                    'update_date' => now(),
                    'reason' => $reason,
                ]);

            DB::table('tbl_riwayatmeeting')->insert([
                'meeting_id' => $idMeeting,
                'statusmeeting_id' => $confirm,
                'remark' => $reason,
                'createby' => $divisiId,
                'createdate' => now(),
            ]);

            DB::commit();

            //kirim notif cancel
            if ($idMeeting) {
                $query = "SELECT participant, tm.title_meeting FROM tbl_participant JOIN tbl_meeting tm ON meeting_id = tm.id WHERE meeting_id = '$idMeeting'";
                $results = DB::select($query);

                foreach ($results as $result) {
                    $badge_ids[] = $result->participant;
                    $Title = $result->title_meeting;
                }

                // RESEPSIONIS NOTIFICATION Cancel
                $badgeIds = $this->getBadgeRecepcionist();
                foreach ($badgeIds as $badge_id) {
                    $pesan = "Meeting $Title telah dibatalkan";
                    $subpesan = 'Ketuk untuk lihat lebih detail';
                    $category = 'MEETING';
                    $tag = 'Info Meeting';
                    $this->sendNotification($badge_id, $pesan, $subpesan, $category, $tag, $idMeeting);
                }
                // buat participant
                foreach ($badge_ids as $badge_id) {
                    $pesan = "Meeting $Title telah dibatalkan";
                    $subpesan = 'Ketuk untuk lihat lebih detail';
                    $category = 'MEETING';
                    $tag = 'MEETING';
                    $this->sendNotification($badge_id, $pesan, $subpesan, $category, $tag, $idMeeting);
                }
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            return response()->json('FAILED.', 400);
        }
    }

    // untuk menampilkan data di modal edit meeting
    public function update(Request $request)
    {
        $sessionLogin = session('loggedInUser');
        $divisiId = $sessionLogin['session_badge'];
        $idMeeting = $request->MeetingId;

        try {
            DB::beginTransaction();

            $Title = $request->MeetingTitle;
            $RoomName = $request->room_name;
            $DateMeeting = $request->DateMeeting;
            $StartMeeting = $request->StartMeeting;
            $FinishMeeting = $request->FinishMeeting;
            $MeetingTitle = $request->MeetingTitle;
            $Desc = $request->Desc;
            $statusCek = $request->statusEdit;
            $ProjectNameEdit = $request->ProjectNameEdit;
            $customerNameEditField = $request->customerNameEditField;
            $NoGuestRadioEdit = $request->NoGuestRadioEdit;

            // dd($NoGuestRadioEdit)
            $ExtensionNoEdit = intval($request->get('ExtensionEdit'));
            $SumVisitor = $request->othersvisitorEdit;
            if ($SumVisitor > 0) {
                $categoryM = '1';
            } else {
                $categoryM = '0';
            }

            $HostEdit = $request->hostEdit;

            $newDateMeeting = date('Y-m-d', strtotime(str_replace('/', '-', $DateMeeting)));

            $newTimeMeeting = $StartMeeting . ':00';
            $newFinishMeeting = $FinishMeeting . ':00';

            // Mendapatkan data meeting yang sudah ada dengan ID tertentu
            $existingMeeting = DB::table('tbl_meeting')
                ->where('id', $idMeeting)
                ->first();

            // Inisialisasi array $facilities yang akan mengandung semua data
            $facilities = [];

            // Mengambil semua kunci yang sesuai dengan format 'facilities_X'
            $keys = array_keys($request->all());

            foreach ($keys as $key) {
                if (preg_match('/^facilities_(\d+)$/', $key, $matches)) {
                    $facilitiesNumber = $matches[1]; // Mendapatkan nomor fasilitas dari kunci
                    $isChecked = $request->input($key) === 'true'; // Mengambil nilai checkbox
                    $facilities[$facilitiesNumber] = $isChecked;
                }
            }

            //cek data participant
            $query_pn = "SELECT * FROM tbl_participant WHERE meeting_id = '$idMeeting' ";
            $data_pn = DB::select($query_pn);
            // delete yang udah ada
            DB::table('tbl_participant')
                ->where('meeting_id', $data_pn[0]->meeting_id)
                ->delete();

            // edit ke tbl_participant
            if (request()->has('badge_id')) {
                // insert ke tbl participant

                foreach ($request->badge_id as $key => $badge_id) {
                    DB::table('tbl_participant')->insert([
                        'meeting_id' => $idMeeting,
                        'participant' => $badge_id,
                    ]);
                }
            } else {
                DB::table('tbl_participant')->insert([
                    'meeting_id' => $idMeeting,
                    'participant' => $request->hostEdit,
                ]);
            }

            if ($newTimeMeeting == $newFinishMeeting) {
                return response()->json([
                    'MSGTYPE' => 'W',
                    'MSG' => 'Start Meeting and Finish Meeting is duplicated!',
                ]);
            } elseif ($newFinishMeeting < $newTimeMeeting) {
                return response()->json([
                    'MSGTYPE' => 'E',
                    'MSG' => 'Start Meeting and Finish Meeting is not valid!',
                ]);
            }

            //  Kondisi kalau ROOM, TIME, DATE tidak berubah
            if ($existingMeeting->roommeeting_id == (int) $RoomName and $existingMeeting->meeting_start == $newTimeMeeting and $existingMeeting->meeting_date == $newDateMeeting and $existingMeeting->meeting_end == $newFinishMeeting) {
                // Ada perubahan pada ruangan, jam, atau tanggal
                $status = $existingMeeting->statusmeeting_id;

                //kirim notif perubahan title, participant, dll
                if ($idMeeting) {
                    $query = "SELECT participant FROM tbl_participant WHERE meeting_id = '$idMeeting'";
                    $results = DB::select($query);

                    foreach ($results as $result) {
                        $badge_ids[] = $result->participant;
                    }
                    // RESEPSIONIS NOTIFICATION Reschedule
                    $badgeIds = $this->getBadgeRecepcionist();
                    foreach ($badgeIds as $badge_id) {
                        $pesan = "Ada perubahan pada meeting $Title ";
                        $subpesan = 'Ketuk untuk lihat lebih detail';
                        $category = 'MEETING';
                        $tag = 'Info Meeting';
                        $this->sendNotification($badge_id, $pesan, $subpesan, $category, $tag, $idMeeting);
                    }

                    foreach ($badge_ids as $badge_id) {
                        $pesan = "Ada perubahan pada meeting $Title ";
                        $subpesan = 'Ketuk untuk lihat lebih detail';
                        $category = 'MEETING';
                        $tag = 'MEETING';
                        $this->sendNotification($badge_id, $pesan, $subpesan, $category, $tag, $idMeeting);

                    }
                }
            }
            //KONDISI SAAT MEETING SEDANG ON GOING
            elseif ($statusCek == '4') {
                $now = Carbon::now();

                $newTimeMeeting = Carbon::parse($newTimeMeeting);

                // kondisi kalau di undur jam mulainnya
                if ($newTimeMeeting > $now) {
                    $status = '3';
                    $conflict = "SELECT *
                FROM tbl_meeting
                WHERE roommeeting_id = '$RoomName'
                AND meeting_date = '$newDateMeeting'
                AND (
                    (meeting_start < '$newFinishMeeting' AND meeting_end > '$newTimeMeeting') -- Memeriksa tumpang tindih waktu
                )AND NOT (
                id = '$idMeeting'
                )
                AND statusmeeting_id IN ('1','2','3','4')
                ;";
                    $tes = DB::select($conflict);
                    if (COUNT($tes) > 0) {
                        return response()->json([
                            'MSGTYPE' => 'W',
                            'MSG' => 'Meeting Already Booked',
                        ]);
                    }
                } elseif ($existingMeeting->roommeeting_id == (int) $RoomName and $existingMeeting->meeting_date == $newDateMeeting) {
                    $status = '4';
                }
                //kondisi kalau di percepat jam selesainya
                else {
                    $status = '3';
                }

                //kirim notif perubahan title, participant, dll
                if ($idMeeting) {
                    $query = "SELECT participant FROM tbl_participant WHERE meeting_id = '$idMeeting'";
                    $results = DB::select($query);

                    foreach ($results as $result) {
                        $badge_ids[] = $result->participant;
                    }

                    // RESEPSIONIS NOTIFICATION Reschedule
                    $badgeIds = $this->getBadgeRecepcionist();
                    foreach ($badgeIds as $badge_id) {
                        $pesan = "Ada perubahan pada meeting $Title ";
                        $subpesan = 'Ketuk untuk lihat lebih detail';
                        $category = 'MEETING';
                        $tag = 'Info Meeting';
                        $this->sendNotification($badge_id, $pesan, $subpesan, $category, $tag, $idMeeting);
                    }

                    // PARTICIPANT NOTIFICATION
                    foreach ($badge_ids as $badge_id) {
                        $pesan = "Ada perubahan pada meeting $Title ";
                        $subpesan = 'Ketuk untuk lihat lebih detail';
                        $category = 'MEETING';
                        $tag = 'MEETING';
                        $this->sendNotification($badge_id, $pesan, $subpesan, $category, $tag, $idMeeting);
                    }
                }
            } else {
                $status = '3';

                $namelist = "SELECT fullname FROM tbl_karyawan WHERE badge_id = '$divisiId'";
                $remark = DB::SELECT($namelist)[0]->fullname;

                // pesan untuk riwayat histori
                $note = "$remark has just rescheduled the Meeting Schedule";

                // mengecek duplikasi meeting
                $conflict = "SELECT *
                FROM tbl_meeting
                WHERE roommeeting_id = '$RoomName'
                AND meeting_date = '$newDateMeeting'
                AND (
                    (meeting_start < '$newFinishMeeting' AND meeting_end > '$newTimeMeeting') -- Memeriksa tumpang tindih waktu
                )AND NOT (
                id = '$idMeeting'
                )
                AND statusmeeting_id IN ('1','2','3','4')
                ;";
                $tes = DB::select($conflict);
                if (COUNT($tes) > 0) {
                    return response()->json([
                        'MSGTYPE' => 'W',
                        'MSG' => 'Meeting Already Booked',
                    ]);
                } else {
                    // tambahkan ke tbl riwayat
                    DB::table('tbl_riwayatmeeting')->insert([
                        'meeting_id' => $idMeeting,
                        'statusmeeting_id' => $status,
                        'remark' => $note,
                        'createby' => $divisiId,
                        'createdate' => now(),
                    ]);

                    //kirim notif rschedule
                    if ($idMeeting) {
                        $query = "SELECT participant FROM tbl_participant WHERE meeting_id = '$idMeeting'";
                        $results = DB::select($query);


                        foreach ($results as $result) {
                            $badge_ids[] = $result->participant;
                        }

                        // RESEPSIONIS NOTIFICATION Reschedule v2
                        $badgeIds = $this->getBadgeRecepcionist();
                        foreach ($badgeIds as $badge_id) {
                            $pesan = "Ada perubahan pada meeting $Title ";
                            $subpesan = 'Ketuk untuk lihat lebih detail';
                            $category = 'MEETING';
                            $tag = 'Info Meeting';
                            $this->sendNotification($badge_id, $pesan, $subpesan, $category, $tag, $idMeeting);
                        }

                        // PARTICIPANT NOTIFICAITON
                        foreach ($badge_ids as $badge_id) {
                            $pesan = "Ada perubahan pada meeting $Title ";
                            $subpesan = 'Ketuk untuk lihat lebih detail';
                            $category = 'MEETING';
                            $tag = 'MEETING';
                            $this->sendNotification($badge_id, $pesan, $subpesan, $category, $tag, $idMeeting);
                        }
                    }
                }
            }

            // dd($facilities);
            if (array_sum($facilities) >= 1) {
                $query_pn = "SELECT * FROM tbl_meetingfasilitasdetail WHERE meeting_id = '$idMeeting' ";
                $data_pn = DB::select($query_pn);

                if (COUNT($data_pn) > 0) {
                    // delete yang udah ada
                    DB::table('tbl_meetingfasilitasdetail')
                        ->where('meeting_id', $data_pn[0]->meeting_id)
                        ->delete();
                }

                // Lakukan pengolahan data berdasarkan $facilities
                foreach ($facilities as $facilitiesNumber => $isChecked) {
                    if ($isChecked) {
                        $facilitiesId = $facilitiesNumber;

                        $newData = [
                            'meeting_id' => $idMeeting,
                            'meetingfasilitas_id' => $facilitiesId,
                        ];

                        DB::table('tbl_meetingfasilitasdetail')->insert($newData);
                    }
                }
            }else if($NoGuestRadioEdit){
                $query_pn = "SELECT * FROM tbl_meetingfasilitasdetail WHERE meeting_id = '$idMeeting' ";
                $data_pn = DB::select($query_pn);

                if (COUNT($data_pn) > 0) {
                    // delete yang udah ada
                    DB::table('tbl_meetingfasilitasdetail')
                        ->where('meeting_id', $data_pn[0]->meeting_id)
                        ->delete();
                }
            }

            $conflict = "SELECT *
                FROM tbl_meeting
                WHERE roommeeting_id = '$RoomName'
                AND meeting_date = '$newDateMeeting'
                AND (
                    (meeting_start < '$newFinishMeeting' AND meeting_end > '$newTimeMeeting') -- Memeriksa tumpang tindih waktu
                )AND NOT (
                id = '$idMeeting'
                )
                AND statusmeeting_id IN ('1','2','3','4')
                ;";
            $tes = DB::select($conflict);
            if (COUNT($tes) > 0) {
                return response()->json([
                    'MSGTYPE' => 'W',
                    'MSG' => 'Meeting Already Booked',
                ]);
            } else {
                // update meeting
                DB::table('tbl_meeting')
                    ->where('id', $idMeeting)
                    ->update([
                        'title_meeting' => $Title,
                        'roommeeting_id' => $RoomName,
                        'meeting_date' => $newDateMeeting,
                        'meeting_start' => $newTimeMeeting,
                        'meeting_end' => $newFinishMeeting,
                        'description' => $Desc,
                        'update_date' => date('Y-m-d H:i:s'),
                        'statusmeeting_id' => $status,
                        'updateby' => $divisiId,
                        'category_meeting' => $categoryM,
                        'jumlah_tamu' => $SumVisitor,
                        'ext' => $ExtensionNoEdit,
                        'project_name' => $ProjectNameEdit,
                        'customer_name' => $customerNameEditField,
                    ]);
            }



            // update meeting
            DB::table('tbl_meeting')
                ->where('id', $idMeeting)
                ->update([
                    'title_meeting' => $Title,
                    'roommeeting_id' => $RoomName,
                    'meeting_date' => $newDateMeeting,
                    'meeting_start' => $newTimeMeeting,
                    'meeting_end' => $newFinishMeeting,
                    'description' => $Desc,
                    'update_date' => date('Y-m-d H:i:s'),
                    'statusmeeting_id' => $status,
                    'updateby' => $divisiId,
                ]);

            DB::commit();

            return response()->json([
                'MSGTYPE' => 'S',
                'MSG' => 'OK.',
            ]);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return response()->json(
                [
                    'MSGTYPE' => 'E',
                    'MSG' => 'Failed to update data.',
                ],
                400,
            );
        }
    }

    // untuk pagination dropdown employee di modal edit
    public function listParticipant(Request $request)
    {
        $txSearch = '%' . trim($request->input('q')) . '%';

        $query = "SELECT fullname, badge_id, p.position_name FROM tbl_karyawan k LEFT JOIN tbl_position p ON p.position_code = k.position_code WHERE (fullname LIKE '$txSearch' OR badge_id LIKE '$txSearch') LIMIT 100";
        $list_w_participant = DB::select($query);

        $listParticipantPosition = [];
        foreach ($list_w_participant as $key => $item) {
            array_push($listParticipantPosition, $item->position_name);
        }

        $listParticipantEd = [];
        foreach ($list_w_participant as $key => $item) {
            array_push($listParticipantEd, $item->badge_id);
        }

        $listFullname = [];
        foreach ($list_w_participant as $key => $item) {
            array_push($listFullname, $item->fullname);
        }

        // dd($list_w_participant);
        return response()->json([
            'list_participant_p' => $listParticipantPosition,
            'list_participant_w' => $listParticipantEd,
            'list_participant_f' => $listFullname,
        ]);
    }
    // get history by meeting id
    public function getRiwayatById(Request $req)
    {
        $idMeeting = $req->input('meetingId');

        $q = "SELECT
        tr.id as meetingId,
        tr.meeting_id,
        tr.statusmeeting_id,
        tr.createby,
        tr.createdate,
        tr.remark,
        s.status_name_eng
        FROM tbl_riwayatmeeting tr
        INNER JOIN
        tbl_meeting b ON b.id = tr.meeting_id
        INNER JOIN
        tbl_statusmeeting s ON s.id = tr.statusmeeting_id
        WHERE tr.meeting_id = '$idMeeting'";

        $data = DB::select($q);
        // dd($data);

        if ($data) {
            return response()->json([
                'status' => 200,
                'response' => [
                    'data' => $data,
                ],
            ]);
        }
    }

    public function filter(Request $request)
    {
        $sessionLogin = session('loggedInUser');

        $badgeId = $sessionLogin['session_badge'];

        $txSearch = '%' . trim($request->txSearch) . '%';

        $selectRoom = $request->selectRoom;
        $filterTime = $request->filtertime;

        $qFilter = '';

        if ($filterTime == '2') {
            $date = date('Y-m-d', strtotime('+1 day'));
            $days30 = date('Y-m-d', strtotime('-30 days'));
            $qFilter .= "AND (booking_date BETWEEN '$days30' AND '$date')";
        } elseif ($filterTime == '1') {
            $date = date('Y-m-d', strtotime('+1 day'));
            $days7 = date('Y-m-d', strtotime('-7 days', strtotime($date)));
            $qFilter .= "AND (booking_date BETWEEN '$days7' AND '$date')";
        } else {
            $qFilter .= '';
        }

        $statusSelect = intval($request->get('selectStatus'));
        $statusFilter = '';
        if ($statusSelect) {
            $statusFilter .= "AND s.id = $statusSelect";
        }

        $sFilter = '';
        if (is_array($selectRoom) && !empty($selectRoom)) {
            $selectRoomStr = "'" . implode("','", $selectRoom) . "'";
            $sFilter .= " AND tm.roommeeting_id IN ($selectRoomStr)";
        } else {
            // Handle jika $selectRoom adalah string kosong atau bukan array
            $sFilter .= ''; // Atau sesuai dengan apa yang Anda butuhkan dalam kasus ini
        }

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
        COALESCE(tm.update_date, tm.booking_date) as latestDate,
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
        ) as participant_count,
            ABS(TIMESTAMPDIFF(HOUR, NOW(), CONCAT(tm.meeting_date, ' ', tm.meeting_start))) as hour_difference
        FROM
            tbl_meeting tm
        INNER JOIN
            tbl_roommeeting b ON b.id = tm.roommeeting_id
        INNER JOIN
            tbl_karyawan k ON tm.booking_by = k.badge_id
        INNER JOIN
            tbl_statusmeeting s ON s.id = tm.statusmeeting_id
        WHERE (title_meeting LIKE '$txSearch' OR room_name LIKE '$txSearch' OR floor LIKE '$txSearch' OR meeting_date LIKE '$txSearch' OR meeting_start LIKE '$txSearch' OR meeting_start LIKE '$txSearch'
            OR status_name_eng LIKE '$txSearch' OR fullname LIKE '$txSearch')$sFilter $statusFilter $qFilter ORDER BY tm.statusmeeting_id,
        ABS(DATEDIFF(NOW(), tm.meeting_date)), hour_difference, tm.meeting_start, latestDate ASC
            ";
        // dd($query);
        $data = DB::select($query);

        // dd($data);
        $output = '';
        $output .= '
                <table id="tableMeeting" class="table table-responsive table-hover" style="font-size: 16px">
                    <thead>
                        <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                            <th class="p-3" scope="col">Meeting Title</th>
                            <th class="p-3" scope="col">Room</th>
                            <th class="p-3" scope="col">Date Meeting</th>
                            <th class="p-3" scope="col">Start Meeting</th>
                            <th class="p-3" scope="col">Finished Meeting</>
                            <th class="p-3" scope="col">Participant</th>
                            <th class="p-3" scope="col">Request</th>
                            <th class="p-3" scope="col">Booking Date</th>
                            <th class="p-3" scope="col">Status</th>
                            <th class="p-3" scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
            ';
        $no = 1;
        $no = 1;
        foreach ($data as $key => $item) {
            $statusBadge = $item->status_name_eng == 'Canceled' ? '<p class="badge bg-danger">' . $item->status_name_eng . '</p>' : $item->status_name_eng;
            $output .=
                '
                <tr>
                    <td class="p-3">' .
                $item->title_meeting .
                '</td>
                    <td class="p-3">' .
                $item->room_name .
                '</td>
                    <td class="p-3">' .
                date('d F Y', strtotime($item->meeting_date)) .
                '</td>
                    <td class="p-3">' .
                date('H:i', strtotime($item->meeting_start)) .
                '</td>
                    <td class="p-3">' .
                date('H:i', strtotime($item->meeting_end)) .
                '</td>
                    <td class="p-3">' .
                $item->participant_count .
                '  People' .
                '</td>
                    <td class="p-3">' .
                $item->fullname .
                '</td>
                    <td class="p-3">' .
                date('d F Y H:i', strtotime($item->booking_date)) .
                '</td>
                <td class="p-3">' .
                $statusBadge .
                '</td>
                <td>
                <a id="btnDetail" class="btn btnDetail" data-id=' .
                $item->meetingId .
                '><img src="' .
                asset('icons/eye.svg') .
                '"></a>
            </td>
                </tr>
            ';
        }

        $output .= '</tbody></table>';
        return $output;
    }

    public function export(Request $request)
    {
        $sessionLogin = session('loggedInUser');
        $divisiId = $sessionLogin['session_badge'];

        $selectRoom = $request->selectExport;
        $filterTime = $request->filtertimeExport;

        $qFilter = '';

        if ($filterTime == '2') {
            $date = date('Y-m-d', strtotime('+1 day'));
            $days30 = date('Y-m-d', strtotime('-30 days'));
            $qFilter .= "AND (booking_date BETWEEN '$days30' AND '$date')";
        } elseif ($filterTime == '1') {
            $date = date('Y-m-d', strtotime('+1 day'));
            $days7 = date('Y-m-d', strtotime('-7 days', strtotime($date)));
            $qFilter .= "AND (booking_date BETWEEN '$days7' AND '$date')";
        } else {
            $qFilter .= '';
        }

        $statusSelect = intval($request->get('selectStatusExport'));

        // dd($statusSelect);
        $statusFilter = '';
        if ($statusSelect) {
            $statusFilter .= "AND s.id = $statusSelect";
        }

        $sFilter = '';
        if (is_array($selectRoom) && !empty($selectRoom)) {
            $selectRoomStr = "'" . implode("','", $selectRoom) . "'";
            $sFilter .= " AND tm.roommeeting_id IN ($selectRoomStr)";
        } else {
            // Handle jika $selectRoom adalah string kosong atau bukan array
            $sFilter .= ''; // Atau sesuai dengan apa yang Anda butuhkan dalam kasus ini
        }

        // dd($divisiId, $sFilter, $qFilter, $statusFilter);

        return Excel::download(new MeetingExport($divisiId, $sFilter, $qFilter, $statusFilter), 'Meeting_Report.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }

    // fungsi untuk insert
    public function insert(Request $request)
    {
        $sessionLogin = session('loggedInUser');
        $divisiId = $sessionLogin['session_badge'];

        try {
            DB::beginTransaction();

            $Title = $request->titleAdd;
            $RoomName = $request->roomAdd;
            $DateMeeting = $request->dateAdd;
            $StartMeeting = $request->startMeetingAdd;
            $FinishMeeting = $request->finishMeetingAdd;
            $status = 2;
            $Desc = $request->DescAdd;
            $Host = $request->hostAdd;
            $projectNameDetail = $request->projectNameDetail;
            $customertNameAdd = $request->customertNameAdd;
            // enhance
            $ExtensionNo = intval($request->get('ExtensionAdd'));
            $SumVisitor = $request->othersvisitorAdd;

            if ($SumVisitor > 0) {
                $categoryM = '1';
            } else {
                $categoryM = '0';
            }

            // format tanggal untuk one signal dan database
            $newDateMeeting = date('Y-m-d', strtotime(str_replace('/', '-', $DateMeeting))); // UNTUK INSERT DATABASE
            $formattedDate = date('d F Y', strtotime(str_replace('/', '-', $DateMeeting))); // UNTUK ONE SIGNAL ext: 12 Februari 2032

            $newTimeMeeting = $StartMeeting . ':00';
            $newFinishMeeting = $FinishMeeting . ':00';

            // Inisialisasi array $facilities yang akan mengandung semua data
            $facilities = [];

            // Mengambil semua kunci yang sesuai dengan format 'facilities_X'
            $keys = array_keys($request->all());

            foreach ($keys as $key) {
                if (preg_match('/^facilities_(\d+)$/', $key, $matches)) {
                    $facilitiesNumber = $matches[1]; // Mendapatkan nomor fasilitas dari kunci
                    $isChecked = $request->input($key) === 'true'; // Mengambil nilai checkbox
                    $facilities[$facilitiesNumber] = $isChecked;
                }
            }

            if ($newTimeMeeting == $newFinishMeeting) {
                return response()->json([
                    'MSGTYPE' => 'W',
                    'MSG' => 'Start Meeting and Finish Meeting is duplicated!',
                ]);
            } elseif ($newFinishMeeting < $newTimeMeeting) {
                return response()->json([
                    'MSGTYPE' => 'E',
                    'MSG' => 'Start Meeting and Finish Meeting is not valid!',
                ]);
            }
            // query mencari kesamaan data meeting
            $conflict = "SELECT *
            FROM tbl_meeting
            WHERE roommeeting_id = '$RoomName'
              AND meeting_date = '$newDateMeeting'
              AND (
                (meeting_start < '$newFinishMeeting' AND meeting_end > '$newTimeMeeting') -- Memeriksa tumpang tindih waktu
              )
              AND statusmeeting_id IN ('1','2','3','4')
              ;";
            $tes = DB::select($conflict);

            // dd($tes);
            if (COUNT($tes) > 0) {
                return response()->json([
                    'MSGTYPE' => 'W',
                    'MSG' => 'Meeting Already Booked',
                ]);
            } else {
                $dataM = [
                    'title_meeting' => $Title,
                    'roommeeting_id' => $RoomName,
                    'meeting_date' => $newDateMeeting,
                    'meeting_start' => $newTimeMeeting,
                    'meeting_end' => $newFinishMeeting,
                    'description' => $Desc,
                    'booking_by' => $Host,
                    'booking_date' => date('Y-m-d H:i:s'),
                    'statusmeeting_id' => $status,
                    'createby' => $divisiId, //resepsionis badge
                    'category_meeting' => $categoryM,
                    'jumlah_tamu' => $SumVisitor,
                    'ext' => $ExtensionNo,
                    'project_name' => $projectNameDetail,
                    'customer_name' => $customertNameAdd,
                ];

                $newId = DB::table('tbl_meeting')->insertGetId($dataM);
            }

            // cek duplikasi particiapnt dan host
            if ($newId) {
                $rq = $request->badge_id;

                // edit ke tbl_participant
                if (request()->has('badge_id')) {
                    // insert ke tbl participant
                    foreach ($rq as $key => $badge_id) {
                        if ($Host == $badge_id) {
                            return response()->json([
                                'MSGTYPE' => 'W',
                                'MSG' => 'Participant and Host are duplicated!',
                            ]);
                        }
                    }

                    foreach ($request->badge_id as $key => $badge_id) {
                        DB::table('tbl_participant')->insert([
                            'meeting_id' => $newId,
                            'participant' => $badge_id,
                        ]);
                    }

                    DB::table('tbl_participant')->insert([
                        'meeting_id' => $newId,
                        'participant' => $request->hostAdd,
                    ]);
                } else {
                    DB::table('tbl_participant')->insert([
                        'meeting_id' => $newId,
                        'participant' => $request->hostAdd,
                    ]);
                }

                // Lakukan pengolahan data berdasarkan $facilities
                foreach ($facilities as $facilitiesNumber => $isChecked) {
                    if ($isChecked) {
                        $facilitiesId = $facilitiesNumber;

                        $newData = [
                            'meeting_id' => $newId,
                            'meetingfasilitas_id' => $facilitiesId,
                        ];

                        DB::table('tbl_meetingfasilitasdetail')->insert($newData);
                    }
                }
            } else {
                return response()->json(['message' => 'Gagal process'], 500);
            }

            // query mengambil nama
            $namelist = "SELECT fullname FROM tbl_karyawan WHERE badge_id = '$Host'";
            $remark = DB::SELECT($namelist)[0]->fullname;

            // tambahan remark
            $statusArray = [1, 2];
            foreach ($statusArray as $status) {
                if ($status === 1) {
                    $noteText = "Meeting room has been booked by $remark";
                } else {
                    $noteText = '';
                }

                // insert data ke riwayat meeting
                DB::table('tbl_riwayatmeeting')->insert([
                    'meeting_id' => $newId,
                    'statusmeeting_id' => $status,
                    'remark' => $noteText,
                    'createby' => $Host,
                    'createdate' => now(),
                ]);
            }

            // Konversi tanggal ke format "d F Y"

            DB::commit();

            //kirim notif rapat baru
            if ($newId) {
                $query = "SELECT participant FROM tbl_participant WHERE meeting_id = '$newId'";
                $results = DB::select($query);

                foreach ($results as $result) {
                    $badge_ids[] = $result->participant;
                }

                // RESEPSIONIS NOTIFICATION Rapat BARU
                $badgeIds = $this->getBadgeRecepcionist();
                foreach ($badgeIds as $badge_id) {
                    $pesan = "Rapat baru $Title ";
                    $subpesan = " $formattedDate pukul $StartMeeting WIB";
                    $category = 'MEETING';
                    $tag = 'Info Meeting';
                    $this->sendNotification($badge_id, $pesan, $subpesan, $category, $tag, $newId);
                }

                foreach ($badge_ids as $badge_id) {
                    $pesan = "Rapat baru $Title ";
                    $subpesan = " $formattedDate pukul $StartMeeting WIB";
                    $category = 'MEETING';
                    $tag = 'MEETING';
                    $this->sendNotification($badge_id, $pesan, $subpesan, $category, $tag, $newId);
                }
            }

            return response()->json([
                'MSGTYPE' => 'S',
                'MSG' => 'OK.',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th);
            return response()->json(
                [
                    'MSGTYPE' => 'E',
                    'MSG' => 'Failed to update data.',
                ],
                400,
            );
        }
    }

    public function response(Request $request)
    {
        $idMeeting = $request->meetingIdResponse;
        $sessionLogin = session('loggedInUser');

        // dd($idMeeting);
        $badgeId = $sessionLogin['session_badge'];

        try {
            DB::beginTransaction();

            $tanggapanRec = $request->txDeskripsiResponse;

            DB::table('tbl_tanggapanmeeting')->insert([
                'meeting_id' => $idMeeting,
                'tanggapan' => $tanggapanRec,
                'createby' => $badgeId,
                'createdate' => now(),
            ]);

            //kirim notif perubahan title, participant, dll
            if ($idMeeting) {
                $query = "SELECT participant FROM tbl_participant WHERE meeting_id = '$idMeeting'";
                $results = DB::select($query);

                $title = "SELECT title_meeting, (SELECT fullname FROM tbl_karyawan WHERE badge_id = '$badgeId') AS fullname FROM tbl_meeting where id = '$idMeeting'";
                $result_title = DB::select($title);
                if (!empty($result_title)) {
                    $Title = $result_title[0]->title_meeting;
                    $fullname = $result_title[0]->fullname;
                } else {
                    // Tindakan jika tidak ada hasil yang ditemukan
                    $Title = null;
                    $fullname = null;
                }

                // RESEPSIONIS NOTIFICATION Tanggapan
                $badgeIds = $this->getBadgeRecepcionist();
                foreach ($badgeIds as $badge_id) {
                    $pesan = "Ada tanggapan baru pada meeting $Title dari $fullname";
                    $subpesan = 'Tanggapan dapat dilihat di website Satnusa.';
                    $this->onlyNotif($badge_id, $pesan, $subpesan);
                }

                // $badge_ids = [];
                foreach ($results as $result) {
                    $badge_ids[] = $result->participant;
                }

                // participant notification
                foreach ($badge_ids as $badge_id) {
                    $pesan = "Ada tanggapan baru pada meeting $Title dari $fullname ";
                    $subpesan = 'Ketuk untuk lihat tanggapan';
                    $category = 'MEETING';
                    $tag      = 'MEETING';
                    $this->sendNotification($badge_id, $pesan, $subpesan, $category, $tag, $idMeeting);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            // dd($th);
            DB::rollBack();
            return response()->json(
                [
                    'MSGTYPE' => 'E',
                    'MSG' => 'Failed to update data.',
                ],
                400,
            );
        }
    }

    // send notifikasi dengan mms
    private function sendNotification($badge_id, $pesan, $subpesan, $category, $tag, $dynamicId)
    {
        $apiUrl = config('urls.base_url') . '/api/notifikasi/send';

        // Membuat instance Client Guzzle
        $client = new Client();

        // Mengirim permintaan GET ke API dengan parameter badge_id, message, dan sub_message
        $response = $client->post($apiUrl, [
            'query' => [
                'badge_id' => $badge_id,
                'message' => $pesan,
                'sub_message' => $subpesan,
                'category' => $category,
                'tag' => $tag,
                'dynamic_id' => $dynamicId,
            ],
        ]);
        // Insert ke tbl_notification
        DB::table('tbl_notification')->insert([
                'title' => $pesan,
                'description' => $subpesan,
                'category' => 'Meeting',
                'createdate' => now(),
                'badge_id' => $badge_id,
                'isread' => 0,
            ]);
    }

    private function onlyNotif($badge_id, $pesan, $subpesan){
        // URL API tujuan Prod
        $apiUrl = config('urls.base_url') . '/api/meeting/send-notif';
        // dev

        // Membuat instance Client Guzzle
        $client = new Client();

        // Mengirim permintaan GET ke API dengan parameter badge_id, message, dan sub_message
        $response = $client->get($apiUrl, [
            'query' => [
                'badge_id' => $badge_id,
                'message' => $pesan,
                'sub_message' => $subpesan
            ],
        ]);
    }

    public function getTanggapan(Request $request)
    {
        $idMeeting = $request->meetingId;

        // tanggapan tabs
        $tanggapan = "SELECT tm.* , k.fullname, k.img_user, k.position_code
        , (select position_name from tbl_position p WHERE p.position_code = k.position_code)AS position_name
        FROM tbl_tanggapanmeeting tm
        INNER JOIN tbl_karyawan k ON tm.createby = k.badge_id
        WHERE meeting_id = '$idMeeting' ORDER BY createdate desc";
        $listTanggapan = DB::select($tanggapan);

        return response()->json([
            'TanggapanList' => $listTanggapan,
        ]);
    }

    public function attendance(Request $request)
    {
        $idMeeting = $request->meetingId;

        DB::beginTransaction();

        try {
            $attendance = [];

            // Mengambil semua kunci yang sesuai dengan format 'facilities_X'
            $keys = array_keys($request->all());

            foreach ($keys as $key) {
                if (preg_match('/^attendance_(\w+)$/', $key, $matches)) {
                    $attendanceKey = $matches[1]; // Mendapatkan kunci attendance yang berisi huruf dan nomor
                    $isChecked = $request->input($key) === 'true'; // Mengambil nilai checkbox
                    $attendance[$attendanceKey] = $isChecked;
                }
            }

            // dd($attendance);
            $keys = array_keys($attendance);

            foreach ($keys as $key) {
                // Cek apakah kunci adalah string atau integer
                if (is_string($key)) {
                    // Jika kunci adalah string, masukkan ke dalam perulangan $badge_id
                    $badge_id = $key;
                } else {
                    // Jika kunci adalah integer, ubah menjadi string dan masukkan ke dalam perulangan $badge_id
                    $badge_id = strval($key);
                }

                $kehadiran = $attendance[$key] ? 1 : 0;
                DB::table('tbl_participant')
                    ->where('meeting_id', $idMeeting)
                    ->where('participant', $badge_id)
                    ->update(['kehadiran' => $kehadiran]);

                // Lakukan pengolahan data berdasarkan $facilities

                DB::commit();
                // Selanjutnya, Anda dapat menggunakan $badge_id dalam perulangan atau operasi lainnya.
            }
            // dd($keys);

            // dd($attendance);
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            DB::rollBack();
            return response()->json('FAILED.', 400);
        }
    }

    public function getBadgeRecepcionist()
    {
        $badgeIds = DB::table('tbl_deptauthorize')
            ->where('get_notif', '1')
            ->where('dept_code', 'SATNUSA')
            ->pluck('badge_id')
            ->toArray();

        return $badgeIds;
    }
}
