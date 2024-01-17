<?php

namespace App\Http\Controllers;

use App\Exports\MeetingExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use GuzzleHttp\Client;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $query_category = "SELECT * FROM tbl_vlookup WHERE category = 'KK'";
        $list_category = DB::SELECT($query_category);

        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')
                ->select('name_vlookup')
                ->where('id_vlookup', session()->get('loggedInUser')['session_roles'])
                ->first()->name_vlookup,
            'list_category' => $list_category,
        ];

        return view('calendar.index', $data);
    }

    public function getList(Request $request)
    {
        $query = "SELECT * ,
        (SELECT name_vlookup FROM tbl_vlookup WHERE id_vlookup = kl.kategori_kalender)
        AS vlookup FROM tbl_kalender kl";
        $dataQuery = DB::select($query);

        // dd($dataMeeting);
        return response()->json([
            'dataEvent' => $dataQuery,
        ]);
    }

    public function insert(Request $request)
    {
        DB::beginTransaction();
        try {
            $selectEventAdd = $request->selectEventAdd;
            $CategoryEvent = $request->event;
            $DateEvent = $request->DateEvent;
            $dateSelect = $request->dateSelect;

            if (strpos($DateEvent, ' to ') !== false) {
                // Pisahkan tanggal menggunakan "to"
                [$start_date, $end_date] = explode(' to ', $DateEvent);

                // Format ulang tanggal dalam format YYYY-MM-DD
                $start_date_formatted = date('Y-m-d', strtotime(str_replace('/', '-', $start_date)));
                $end_date_formatted = date('Y-m-d', strtotime(str_replace('/', '-', $end_date)));
                $end_date_formatted = date('Y-m-d', strtotime($end_date_formatted . ' +1 day'));

                // dd($start_date_formatted, $end_date_formatted);
            } else {
                $start_date_formatted = date('Y-m-d', strtotime(str_replace('/', '-', $DateEvent)));
                $end_date_formatted = date('Y-m-d', strtotime(str_replace('/', '-', $DateEvent)));

                // dd($start_date_formatted, $end_date_formatted);
            }

            // dd($start_date_formatted, $end_date_formatted);

            // $newDateMeeting = date('Y-m-d', strtotime(str_replace('/', '-', $DateEvent))); // UNTUK INSERT DATABASE

            // dd($selectEventAdd, $event, $newDateMeeting);

            if ($dateSelect) {
                // insert data ke riwayat meeting
                DB::table('tbl_kalender')->insert([
                    'acara' => $request->selectEventAddSelect,
                    'tanggal' => $dateSelect,
                    'kategori_kalender' => $CategoryEvent,
                ]);
            } else {
                // insert data ke riwayat meeting
                DB::table('tbl_kalender')->insert([
                    'acara' => $selectEventAdd,
                    'tanggal' => $start_date_formatted,
                    'tanggal_end' => $end_date_formatted,
                    'kategori_kalender' => $CategoryEvent,
                ]);
            }

            $dataEvent = [
                'acara' => $request->selectEventAddSelect,
                'tanggal' => $dateSelect,
                'tanggal_end' => $end_date_formatted,
                'kategori_kalender' => $CategoryEvent,
            ];

            DB::commit();
            return response()->json([
                'dataEvent' => $dataEvent,
            ]);
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return response()->json(
                [
                    'MSGTYPE' => 'E',
                    'MSG' => 'Failed to insert data.',
                ],
                400,
            );
        }
    }
    public function update(Request $request)
    {
        $id = $request->id;
        $start = $request->start;
        $end = $request->end;
        $title = $request->title;
        $category = $request->category;

        /**
         * Fungsi Konversi tanggal kalender ke YYYY-MM-DD
         */
        $parts = explode(' ', $start);
        $day = $parts[2];
        $month = date('m', strtotime($parts[1]));
        $year = $parts[3];
        $tanggal_awal_formatted = "$year-$month-$day";
        /**
         * Fungsi Konversi tanggal kalender ke YYYY-MM-DD
         */

        if ($end) {
            $parts = explode(' ', $end);
            $day = $parts[2];
            $month = date('m', strtotime($parts[1]));
            $year = $parts[3];
            $end = "$year-$month-$day";
        }

        DB::beginTransaction();
        // dd($id, $tanggal_awal_formatted, $end);
        try {
            if ($end) {
                // update event lebih dari 1 hari
                DB::table('tbl_kalender')
                    ->where('id', $id)
                    ->update([
                        'acara' => $title,
                        'tanggal' => $tanggal_awal_formatted,
                        'tanggal_end' => $end,
                        'kategori_kalender' => $category,
                    ]);
            } else {
                // update event 1 hari saja
                DB::table('tbl_kalender')
                    ->where('id', $id)
                    ->update([
                        'acara' => $title,
                        'tanggal' => $tanggal_awal_formatted,
                        'tanggal_end' => $tanggal_awal_formatted,
                        'kategori_kalender' => $category,
                    ]);
            }

            DB::commit();
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

    public function delete(Request $request)
    {
        $id = $request->id;
        // dd($id);
        DB::beginTransaction();
        try {
            DB::table('tbl_kalender')
                ->where('id', $id)
                ->delete();

            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return response()->json(
                [
                    'MSGTYPE' => 'E',
                    'MSG' => 'Failed to delete data.',
                ],
                400,
            );
        }
    }
}
