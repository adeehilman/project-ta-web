<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $qSummaryKaryawan = "SELECT DISTINCT
                    (SELECT COUNT(*) FROM tbl_karyawan WHERE gender=3 AND is_active = '1') AS M,
                    (SELECT COUNT(*) FROM tbl_karyawan WHERE gender=4 AND is_active = '1') AS F,
                    (SELECT COUNT(*) FROM tbl_karyawan WHERE is_active = '1') AS TOTAL
                FROM tbl_karyawan
            ";

        $dataSummaryKaryawan = DB::select($qSummaryKaryawan);
        $qTotalSummaryDalamSebulan = "select COUNT(*) AS TOTAL from `tbl_karyawan` where join_date BETWEEN (SELECT DATE_FORMAT(NOW(), '%Y-%m-01')) AND (DATE_FORMAT(LAST_DAY(NOW()), '%Y-%m-%d'))";
        $dataTotalSummaryDalamSebulan = DB::select($qTotalSummaryDalamSebulan);

        // OS ANDROID
        // $qOS = "SELECT tm.`os`, COUNT(*) AS TOTAL FROM tbl_mms tm WHERE tm.`status_pendaftaran_mms`=12 GROUP BY tm.`os`";
        $qOSAndroid = "SELECT COUNT(*) AS TOTAL FROM tbl_mms tm WHERE tm.`status_pendaftaran_mms`=12 AND tm.os = '32' AND is_active = '1' ";
        $dataOSAndroid = DB::select($qOSAndroid);
        // OS IOS
        $qOSIOS = "SELECT COUNT(*) AS TOTAL FROM tbl_mms tm WHERE tm.`status_pendaftaran_mms`=12 AND tm.os = '31' AND is_active = '1'";
        $dataOSIOS = DB::select($qOSIOS);
        // OS NULL
        $qOSUnknown = "SELECT COUNT(*) AS TOTAL FROM tbl_mms tm WHERE tm.`status_pendaftaran_mms`=12 AND tm.os IS NULL AND is_active = '1'";
        $dataOSUnknown = DB::select($qOSUnknown);

        $qOSSebulan = "SELECT COUNT(*) AS TOTAL from `tbl_mms` where waktu_pengajuan BETWEEN (SELECT DATE_FORMAT(NOW(), '%Y-%m-01')) AND (DATE_FORMAT(LAST_DAY(NOW()), '%Y-%m-%d')) AND is_active = '1'";
        $dataOSSebulan = DB::select($qOSSebulan);

        $totalTerdaftarMMS = DB::table('tbl_mms')
            ->where('status_pendaftaran_mms', 12)
            ->where('is_active', 1)
            ->count();
        $totalPenggunaAplikasiMMS = DB::table('tbl_karyawan')
            ->whereNull('password')
            ->count();
        $totalTidakTerdaftarMMS = DB::table('tbl_mms')
            ->where('status_pendaftaran_mms', '!=', 12)
            ->count();
        $qTotalMMSSebulan = "select COUNT(*) AS TOTAL from `tbl_mms` where status_pendaftaran_mms=12 AND waktu_pengajuan BETWEEN (SELECT DATE_FORMAT(NOW(), '%Y-%m-01')) AND (DATE_FORMAT(LAST_DAY(NOW()), '%Y-%m-%d')) AND is_active = 1";
        $dataTotalMMSSebulan = DB::select($qTotalMMSSebulan);

        $qTotalLMSSebulan = "select COUNT(*) AS TOTAL from `tbl_lms` where status_pendaftaran_lms=15 AND tanggal_pengajuan BETWEEN (SELECT DATE_FORMAT(NOW(), '%Y-%m-01')) AND (DATE_FORMAT(LAST_DAY(NOW()), '%Y-%m-%d'))";
        $dataTotalLMSSebulan = DB::select($qTotalLMSSebulan);

        /**
         * Laptop Chart
         */
        $WorkerWorkingLMS = DB::table('tbl_lms')
            ->where('durasi', 58)
            ->count();
        $jangkaPendekLMS = DB::table('tbl_lms')
            ->where('durasi', 56)
            ->count();
        $jangkaPanjangLMS = DB::table('tbl_lms')
            ->where('durasi', 57)
            ->count();

        /**
         * chart di row 1, kolom 1, yg bagian karyawan baru
         */
        // $qJlhKaryawanBulanIni  = "SELECT COUNT(*) as TOTAL FROM tbl_karyawan WHERE join_date BETWEEN '1990-06-01' AND LAST_DAY('%Y-%m-01')";
        $qJlhKaryawanBulanIni = "SELECT COUNT(*) AS TOTAL FROM `tbl_karyawan` WHERE join_date BETWEEN (SELECT DATE_FORMAT(NOW(), '%Y-%m-01')) AND (DATE_FORMAT(LAST_DAY(NOW()), '%Y-%m-%d'))";
        $totalKaryawanBulanIni = DB::select($qJlhKaryawanBulanIni);

        $bulan_lalu = date('m') - 1;
        $tahun_skrg = date('Y');

        $qJlhKaryawanBulanLalu = "SELECT COUNT(*) as TOTAL FROM tbl_karyawan WHERE join_date BETWEEN '1990-06-01' AND LAST_DAY('$tahun_skrg-$bulan_lalu-01')";
        $totalKaryawanBulanLalu = DB::select($qJlhKaryawanBulanLalu);
        $persentase_kenaikan_karyawan = 0;

        if ($totalKaryawanBulanLalu[0]->TOTAL != 0) {
            $persentase_kenaikan_karyawan = number_format(
                ((int) $totalKaryawanBulanIni[0]->TOTAL / (int) $totalKaryawanBulanLalu[0]->TOTAL) * 100,
                2
            );
        } else {

        }
        
        /**
         * Chart di row 1, kolom 2, yg bagian pengguna baru
         */
        $qPenggunaBaruBulanIni = "SELECT COUNT(*) as TOTAL FROM tbl_mms WHERE DATE_FORMAT(waktu_pengajuan, '%m-%Y') = DATE_FORMAT(NOW(), '%m-%Y')";
        $totalPenggunaBaruBulanIni = DB::select($qPenggunaBaruBulanIni);

        $qPenggunaBaruBulanLalu = "SELECT COUNT(*) as TOTAL FROM tbl_mms WHERE waktu_pengajuan BETWEEN '1990-06-01' AND LAST_DAY('$tahun_skrg-$bulan_lalu-01')";
        $totalPenggunaBaruBulanLalu = DB::select($qPenggunaBaruBulanLalu);
        $totalPenggunaBaruBulanLalu = $totalPenggunaBaruBulanLalu[0]->TOTAL;
        $persentase_kenaikan_pengguna = 0;
        if ($totalPenggunaBaruBulanLalu != 0) {
            $persentase_kenaikan_pengguna = number_format(((int) $totalPenggunaBaruBulanIni[0]->TOTAL / $totalPenggunaBaruBulanLalu) * 100, 2);
        }

        /**
         * Chart di row 1, kolom 2, yg bagian peminjam laptop
         */
        $qPeminjamLaptop = "SELECT COUNT(*) as TOTAL FROM tbl_lms WHERE DATE_FORMAT(tanggal_pengajuan, '%m-%Y') = DATE_FORMAT(NOW(), '%m-%Y')";
        $totalPeminjamLaptopBulaIni = DB::select($qPeminjamLaptop);

        $qPeminjamLaptopBulanLalu = "SELECT COUNT(*) as TOTAL FROM tbl_lms WHERE tanggal_pengajuan BETWEEN '1990-06-01' AND LAST_DAY('$tahun_skrg-$bulan_lalu-01') ";
        $totalPeminjamLaptopBulanLalu = DB::select($qPeminjamLaptopBulanLalu);

        $persentase_kenaikan_peminjam = 0;
        if ($totalPeminjamLaptopBulanLalu[0]->TOTAL != 0) {
            $persentase_kenaikan_peminjam = ((int) $totalPeminjamLaptopBulaIni[0]->TOTAL / (int) $totalPeminjamLaptopBulanLalu[0]->TOTAL) * 100;
        }

        /**
         * rentang usia
         */
        $qRentangUsia = "  SELECT umur_18_sampai_20, umur_21_sampai_30,umur_31_sampai_40,umur_41_sampai_50,umur_51_sampai_60, umur_61_sampai_70
            FROM (
                SELECT
                (SELECT COUNT(*) FROM (SELECT badge_id, YEAR(CURRENT_DATE()) - YEAR(tgl_lahir) - (DATE_FORMAT(CURRENT_DATE(), '%m%d') < DATE_FORMAT(tgl_lahir, '%m%d')) AS umur FROM tbl_karyawan WHERE is_active = '1') AS subquery WHERE umur >= 18 AND umur <= 20) AS umur_18_sampai_20,
                (SELECT COUNT(*) FROM (SELECT badge_id, YEAR(CURRENT_DATE()) - YEAR(tgl_lahir) - (DATE_FORMAT(CURRENT_DATE(), '%m%d') < DATE_FORMAT(tgl_lahir, '%m%d')) AS umur FROM tbl_karyawan WHERE is_active = '1') AS subquery WHERE umur >= 21 AND umur <= 30) AS umur_21_sampai_30,
                (SELECT COUNT(*) FROM (SELECT badge_id, YEAR(CURRENT_DATE()) - YEAR(tgl_lahir) - (DATE_FORMAT(CURRENT_DATE(), '%m%d') < DATE_FORMAT(tgl_lahir, '%m%d')) AS umur FROM tbl_karyawan WHERE is_active = '1') AS subquery WHERE umur >= 31 AND umur <= 40) AS umur_31_sampai_40,
                (SELECT COUNT(*) FROM (SELECT badge_id, YEAR(CURRENT_DATE()) - YEAR(tgl_lahir) - (DATE_FORMAT(CURRENT_DATE(), '%m%d') < DATE_FORMAT(tgl_lahir, '%m%d')) AS umur FROM tbl_karyawan WHERE is_active = '1') AS subquery WHERE umur >= 41 AND umur <= 50) AS umur_41_sampai_50,
                (SELECT COUNT(*) FROM (SELECT badge_id, YEAR(CURRENT_DATE()) - YEAR(tgl_lahir) - (DATE_FORMAT(CURRENT_DATE(), '%m%d') < DATE_FORMAT(tgl_lahir, '%m%d')) AS umur FROM tbl_karyawan WHERE is_active = '1') AS subquery WHERE umur >= 51 AND umur <= 60) AS umur_51_sampai_60,
                (SELECT COUNT(*) FROM (SELECT badge_id, YEAR(CURRENT_DATE()) - YEAR(tgl_lahir) - (DATE_FORMAT(CURRENT_DATE(), '%m%d') < DATE_FORMAT(tgl_lahir, '%m%d')) AS umur FROM tbl_karyawan WHERE is_active = '1') AS subquery WHERE umur >= 61 AND umur <= 70) AS umur_61_sampai_70
            ) AS hasil";
        $dataRentangUsia = DB::select($qRentangUsia);

        $data = [
            'userInfo' => DB::table('tbl_karyawan')
                ->where('badge_id', session('loggedInUser'))
                ->first(),
            'userRole' => (int) session()->get('loggedInUser')['session_roles'],
            'positionName' => DB::table('tbl_vlookup')
                ->select('name_vlookup')
                ->where('id_vlookup', session()->get('loggedInUser')['session_roles'])
                ->first()->name_vlookup,
            //
            'summaryJumlahKaryawan' => $dataSummaryKaryawan ? $dataSummaryKaryawan : null,
            'dataTotalSummaryDalamSebulan' => $dataTotalSummaryDalamSebulan ? $dataTotalSummaryDalamSebulan : null,
            // Chart Perangkat Pengguna
            'dataOSAndroid' => $dataOSAndroid ? $dataOSAndroid[0]->TOTAL : 0,
            'dataOSIOS' => $dataOSIOS ? $dataOSIOS[0]->TOTAL : 0,
            'dataOSUnknown' => $dataOSUnknown ? $dataOSUnknown[0]->TOTAL : 0,

            'dataOSSebulan' => $dataOSSebulan ? $dataOSSebulan : null,

            // Chart Pengguna Aplikasi
            'totalTerdaftarMMS' => $totalTerdaftarMMS ? (int) $totalTerdaftarMMS : 0,
            'totalPenggunaAplikasiMMS' => $totalPenggunaAplikasiMMS ? (int) $totalPenggunaAplikasiMMS : 0,
            'totalTidakTerdaftarMMS' => $totalTidakTerdaftarMMS ? (int) $totalTidakTerdaftarMMS : 0,
            'dataTotalMMSSebulan' => $dataTotalMMSSebulan ? $dataTotalMMSSebulan : null,

            // Chart Peminjam Laptop
            'totalWorkerWorkingLMS' => $WorkerWorkingLMS ? (int) $WorkerWorkingLMS : 0,
            'totalJangkaPendekLMS' => $jangkaPendekLMS ? (int) $jangkaPendekLMS : 0,
            'totalJangkaPanjangLMS' => $jangkaPanjangLMS ? (int) $jangkaPanjangLMS : 0,
            'dataTotalLMSSebulan' => $dataTotalLMSSebulan ? $dataTotalLMSSebulan : 0,

            // Chart line karyawan baru
            'dataTotalKaryawanBulanIni' => (int) $totalKaryawanBulanIni[0]->TOTAL ? (int) $totalKaryawanBulanIni[0]->TOTAL : 0,
            'dataTotalKaryawanBulanLalu' => (int) $totalKaryawanBulanLalu[0]->TOTAL ? (int) $totalKaryawanBulanLalu[0]->TOTAL : 0,
            'persentaseKenaikanKaryawan' => $persentase_kenaikan_karyawan,

            // Chart line Pengguna baru
            'dataTotalPenggunaBaruBulanIni' => $totalPenggunaBaruBulanIni ? (int) $totalPenggunaBaruBulanIni[0]->TOTAL : 0,
            'persentaseKenaikanPengguna' => $persentase_kenaikan_pengguna,

            // Peminjam Laptop
            'dataPeminjamLaptopBulanIni' => $totalPeminjamLaptopBulaIni ? $totalPeminjamLaptopBulaIni[0]->TOTAL : 0,
            'dataPeminjamLaptopBulanLalu' => $totalPeminjamLaptopBulanLalu ? $totalPeminjamLaptopBulanLalu[0]->TOTAL : 0,
            'persentaseKenaikanPeminjam' => $persentase_kenaikan_peminjam,

            // rentang usia
            'dataRentangUsia' => $dataRentangUsia ? $dataRentangUsia : 0,
        ];

        // dd(count($dataOS));

        return view('dashboard.index', $data);
    }

    public function customer_list()
    {
        $dataCustomer = DB::table('tbl_customer')->get();
        return response()->json([
            'status' => 200,
            'data' => $dataCustomer,
        ]);
    }

    public function model_list(Request $request)
    {
        $customerId = $request->post('values');

        if ($customerId) {
            $dataModel = DB::table('tbl_model')
                ->where('customer_id', $customerId)
                ->get();

            if ($dataModel) {
                return response()->json([
                    'status' => 200,
                    'data' => $dataModel,
                ]);
            }
        }
    }

    public function ng_station(Request $request)
    {
        $customerModel = $request->post('values');

        $dataNGStation = DB::table('tbl_stationRoute')
            ->join('tbl_vlookup', 'tbl_vlookup.id', '=', 'tbl_stationRoute.station_id')
            ->where('tbl_stationRoute.model_id', $customerModel)
            ->get();

        return response()->json([
            'status' => 200,
            'data' => $dataNGStation,
        ]);
    }

    public function simpan_repair(Request $request)
    {
        $repairCat = $request->post('repairCat');
        $serialNum = $request->post('serialNum');
        $selectCustomer = $request->post('selectCustomer');
        $selectModelCustomer = $request->post('selectModelCustomer');
        $rejectCategory = $request->post('rejectCategory');
        $selectNGStation = $request->post('selectNGStation');
        $ngSymptom = $request->post('ngSymptom');

        DB::table('tbl_datarepairanalyst')->get();

        return response()->json([
            'status' => 200,
            'data' => $repairCat,
        ]);
    }
}
