<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResetPasswdController;
use App\Http\Controllers\ProfilUSerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ListKaryawanController;
use App\Http\Controllers\ProfilKaryawanController;
use App\Http\Controllers\GrupKaryawanController;
use App\Http\Controllers\PKBKaryawanController;
use App\Http\Controllers\AddPKBKaryawanController;
use App\Http\Controllers\UpdateEmployeeDataProcessController;
use App\Http\Controllers\UpdateEmployeeDataReportController;
use App\Http\Controllers\UpdateEmployeeDataNoticeController;
use App\Http\Controllers\MMSController;
use App\Http\Controllers\LMSController;
use App\Http\Controllers\InfoDepartemenController;
use App\Http\Controllers\InfoLineCodeController;
use App\Http\Controllers\LPBController;
use App\Http\Controllers\PemberitahuanController;
use App\Http\Controllers\LokerController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\PeranController;
use App\Http\Controllers\KritikController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\MeetingSummaryController;
use App\Http\Controllers\DetailMeetingSummaryContoller;
use App\Http\Controllers\DetailInternshipController;
use App\Http\Controllers\DetailRoomSummaryController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomSummaryController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use App\Http\Controllers\UserAuthorizeController;
use App\Http\Controllers\InternshipController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/resetpasswd', [ResetPasswdController::class, 'index'])->name('resetpasswd');
Route::get('/profile', [ProfilUserController::class, 'index'])->name('profile');

Route::group(['middleware' => ['LoginCheck']], function () {
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::get('/auth/change-password', [AuthController::class, 'indexChangePass']);
    Route::post('/update-pass', [AuthController::class, 'prosesChangePass'])->name('changPass');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/customer_list', [DashboardController::class, 'customer_list'])->name('customerlist');
    Route::post('/dashboard/model_list', [DashboardController::class, 'model_list'])->name('modellist');
    Route::post('/dashboard/ng_station', [DashboardController::class, 'ng_station'])->name('ngstation');
    Route::post('/dashboard/simpan_repair', [DashboardController::class, 'simpan_repair'])->name('simpanrepair');

    // ====================
    // Karyawan Menu
    // ====================
    Route::get('/list', [ListKaryawanController::class, 'index'])->name('list');
    // ambil data karyawan
    Route::get('/employee_list', [ListKaryawanController::class, 'employee_list'])->name('employeelist');
    Route::get('/employee_dept', [ListKaryawanController::class, 'employee_dept'])->name('employeedept');
    Route::get('/employee_line', [ListKaryawanController::class, 'employee_line'])->name('employeeline');
    Route::get('/list/{id}', [ListKaryawanController::class, 'employee_view']);
    Route::get('/kategori_non_karyawan', [ListKaryawanController::class, 'kategori_non_karyawan'])->name('kategorinonkaryawan');
    Route::get('/generate_badge', [ListKaryawanController::class, 'generate_badge'])->name('generatebadge');
    Route::post('/simpan_non_karyawan', [ListKaryawanController::class, 'simpan_non_karyawan'])->name('simpannonkaryawan');
    Route::post('/import_rfid', [ListKaryawanController::class, 'import_rfid'])->name('importrfid');

    Route::get('/profil', [ProfilKaryawanController::class, 'index'])->name('profil');
    Route::post('/updaterfid', [ProfilKaryawanController::class, 'update_rfid'])->name('updaterfid');
    Route::post('/updateprivasi', [ProfilKaryawanController::class, 'update_privasi'])->name('updateprivasi');
    Route::get('/kelurahan_list', [ProfilKaryawanController::class, 'kelurahan_list'])->name('kelurahanlist');
    Route::get('/kecamatan_list', [ProfilKaryawanController::class, 'kecamatan_list'])->name('kecamatanlist');
    Route::get('/alamat_by_badge', [ProfilKaryawanController::class, 'alamat_by_badge'])->name('alamatbybadge');
    Route::get('/mms_list_by_badge', [ProfilKaryawanController::class, 'mms_list_by_badge'])->name('mmslistbybadge');
    Route::get('/reset_password_profile', [ProfilKaryawanController::class, 'reset_password_profile'])->name('resetpasswordprofile');
    Route::get('/update_masa_kontrak', [ProfilKaryawanController::class, 'updateMasaKontrak'])->name('updatemasakontrak');
    Route::get('/cekpassword', [ProfilKaryawanController::class, 'cek_password'])->name('cekpassword');

    Route::get('/grup', [GrupKaryawanController::class, 'index'])->name('grup');
    Route::get('/dept_list', [GrupKaryawanController::class, 'dept_list'])->name('deptlist');
    Route::get('/line_list', [GrupKaryawanController::class, 'line_list'])->name('linelist');
    Route::get('/infodepart/{id}', [InfoDepartemenController::class, 'index']);
    Route::get('/infolinecode/{id}', [InfoLineCodeController::class, 'index']);

    Route::get('/pkb', [PKBKaryawanController::class, 'index'])->name('pkb');
    Route::get('/addpkb', [AddPKBKaryawanController::class, 'index'])->name('addpkb');


    //section update employee data report
    Route::get('/dataReport', [UpdateEmployeeDataReportController::class, 'index'])->name('dataReport');
    Route::get('/datareport/getlist', [UpdateEmployeeDataReportController::class, 'getlisreport'])->name('getlisreport');

     //section update employee data notice
     Route::get('/dataNotice', [UpdateEmployeeDataNoticeController::class, 'index'])->name('dataNotice');
     Route::get('/dataNotice/getlistnotice', [UpdateEmployeeDataNoticeController::class, 'getlistnotice'])->name('getlistnotice');
     Route::post('/dataNotice/tambahnotice', [UpdateEmployeeDataNoticeController::class, 'tambahnotice'])->name('tambahnotice');
     Route::post('/dataNotice/editnotice', [UpdateEmployeeDataNoticeController::class, 'updatenotice'])->name('updatenotice');
     Route::get('/dataNotice/deletenotice', [UpdateEmployeeDataNoticeController::class, 'hapusnotice'])->name('hapusnotice');

    // section list meeting
    Route::get('/meeting', [MeetingController::class, 'index'])->name('meeting');
    Route::get('/meeting/getList', [MeetingController::class, 'getList'])->name('/meeting/getList');
    Route::get('/meeting/getDetail', [MeetingController::class, 'getDetail'])->name('/meeting/getDetail');
    Route::get('/meeting/getParticipant', [MeetingController::class, 'getParticipant'])->name('/meeting/getParticipant');
    Route::get('/meeting/getTanggapan', [MeetingController::class, 'getTanggapan'])->name('/meeting/getTanggapan');
    Route::get('/meeting/listParticipant', [MeetingController::class, 'listParticipant'])->name('/meeting/listParticipant');
    Route::post('/meeting/insert', [MeetingController::class, 'insert'])->name('/meeting/insert');
    Route::post('/meeting/response', [MeetingController::class, 'response'])->name('/meeting/response');
    Route::post('/meeting/attendance', [MeetingController::class, 'attendance'])->name('/meeting/attendance');

    Route::post('/meeting/update', [MeetingController::class, 'update'])->name('/meeting/update');
    Route::post('/meeting/cancelMeeting', [MeetingController::class, 'cancelMeeting'])->name('/meeting/cancelMeeting');
    Route::get('/meeting/getRiwayatById', [MeetingController::class, 'getRiwayatById'])->name('requestriwayatbyid');
    Route::get('/meeting/filter', [MeetingController::class, 'filter'])->name('/meeting/filter');

    // section Summary Meeting
    Route::get('/meetingsummary', [MeetingSummaryController::class, 'index'])->name('meetingSummary');
    Route::get('/meetingsummary/getList', [MeetingSummaryController::class, 'getList'])->name('/meetingsummary/getList');
    // detail Summary Meeting
    Route::get('/meetingsummary/detailSummary', [DetailMeetingSummaryContoller::class, 'index'])->name('/meetingsummary/detailSummary');
    Route::get('/roomsummary/detailSummary', [DetailRoomSummaryController::class, 'index'])->name('/roomsummary/detailSummary');

    // section Room SUMMARY
    Route::get('/roomsummary', [RoomSummaryController::class, 'index'])->name('roomsummary');
    Route::get('/roomsummary/getList', [RoomSummaryController::class, 'getList'])->name('/roomsummary/getList');

    // section list room
    Route::get('/room', [RoomController::class, 'index'])->name('room');
    Route::get('/Room/getList', [RoomController::class, 'getListRoom'])->name('listRoom');
    Route::post('/Room/insert', [RoomController::class, 'insert'])->name('/Room/insert');
    Route::get('/Room/delete', [RoomController::class, 'delete'])->name('/Room/delete');
    Route::get('/Room/edit', [RoomController::class, 'edit'])->name('/Room/edit');
    Route::post('/Room/update', [RoomController::class, 'update'])->name('/Room/update');
    Route::get('/Room/detail', [RoomController::class, 'detail'])->name('/Room/detail');

    Route::get('/user/listEmployee', [UserController::class, 'listEmployee'])->name('/user/listEmployee');

    // section user authorize
    Route::get('/userauthorize', [UserAuthorizeController::class, 'index'])->name('userauthorize');
    Route::get('/userauthorize/getList', [UserAuthorizeController::class, 'getList'])->name('/userauthorize/getList');
    Route::get('/userauthorize/getDept', [UserAuthorizeController::class, 'getDept'])->name('/userauthorize/getDept');
    Route::get('/userauthorize/getVal', [UserAuthorizeController::class, 'getVal'])->name('/userauthorize/getVal');
    Route::post('/userauthorize/insert', [UserAuthorizeController::class, 'insert'])->name('/userauthorize/insert');
    Route::post('/userauthorize/update', [UserAuthorizeController::class, 'update'])->name('/userauthorize/update');
});

// para export
Route::get('/internship/dailyExport', [InternshipController::class, 'dailyExport'])->name('/internship/dailyExport');
Route::post('/internship/import', [InternshipController::class, 'import'])->name('/internship/import');
Route::get('/internship/monthExport', [InternshipController::class, 'monthlyExport'])->name('/internship/monthExport');
Route::get('/internship/detailInternship/personExport', [DetailInternshipController::class, 'personExport'])->name('/internship/detailInternship/personExport');
Route::get('/meeting/export', [MeetingController::class, 'export'])->name('/meeting/export');
Route::get('/meetingsummary/export', [MeetingSummaryController::class, 'export'])->name('/meetingsummary/export');
Route::get('/roomsummary/export', [RoomSummaryController::class, 'export'])->name('/roomsummary/export');
Route::get('/meetingsummary/exportDetail', [DetailMeetingSummaryContoller::class, 'exportDetail'])->name('/meetingsummary/exportDetail');
Route::get('/roomsummary/exportDetail', [DetailRoomSummaryController::class, 'exportDetail'])->name('/roomsummary/exportDetail');
