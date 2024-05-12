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

    // //section update employee data process
    // Route::get('/dataProcess', [UpdateEmployeeDataProcessController::class, 'index'])->name('dataProcess');
    // Route::get('/dataProcess/detail/{id}', [UpdateEmployeeDataProcessController::class, 'detail'])->name('dataProcessdetail');
    // Route::get('/dataProcess/listpengkinian', [UpdateEmployeeDataProcessController::class, 'getListPengkinian'])->name('getListPengkinian');
    // Route::get('/dataProcess/listclosed', [UpdateEmployeeDataProcessController::class, 'getListClosed'])->name('getListClosed');
    // Route::get('/dataProcess/detailmodal/{id}', [UpdateEmployeeDataProcessController::class, 'detailmodal'])->name('dataProcessdetailmodal');
    // Route::get('/dataProcess/getModalPengkinian', [UpdateEmployeeDataProcessController::class, 'getModalPengkinian'])->name('getModalPengkinian');
    // Route::post('/dataProcess/addApproved', [UpdateEmployeeDataProcessController::class, 'addApproved'])->name('addApproved');
    // Route::post('/dataProcess/addReject', [UpdateEmployeeDataProcessController::class, 'addReject'])->name('addReject');
    // Route::post('dataProcess/detail/tolakpengkinian', [UpdateEmployeeDataProcessController::class ,'tolakpengkinian'])->name('tolakpengkinian');
    // Route::post('dataProcess/detail/terimapengkinian', [UpdateEmployeeDataProcessController::class ,'terimapengkinian'])->name('terimapengkinian');
    // Route::post('/dataProcess/detail/tambahtanggapan', [UpdateEmployeeDataProcessController::class, 'tambahtanggapan'])->name('tambahtanggapan');



    //section update employee data report
    Route::get('/dataReport', [UpdateEmployeeDataReportController::class, 'index'])->name('dataReport');
    Route::get('/datareport/getlist', [UpdateEmployeeDataReportController::class, 'getlisreport'])->name('getlisreport');

     //section update employee data notice
     Route::get('/dataNotice', [UpdateEmployeeDataNoticeController::class, 'index'])->name('dataNotice');
     Route::get('/dataNotice/getlistnotice', [UpdateEmployeeDataNoticeController::class, 'getlistnotice'])->name('getlistnotice');
     Route::post('/dataNotice/tambahnotice', [UpdateEmployeeDataNoticeController::class, 'tambahnotice'])->name('tambahnotice');
     Route::post('/dataNotice/editnotice', [UpdateEmployeeDataNoticeController::class, 'updatenotice'])->name('updatenotice');
     Route::get('/dataNotice/deletenotice', [UpdateEmployeeDataNoticeController::class, 'hapusnotice'])->name('hapusnotice');



    // section mms
    // Route::get('/mms', [MMSController::class, 'index'])->name('mms');
    // Route::get('/set_inactive_mobile', [MMSController::class, 'set_inactive_mobile'])->name('setinactivemobile');
    // Route::get('/update_barcode_label', [MMSController::class, 'update_barcode_label'])->name('updatebarcodelabel');
    // Route::get('/update_uuid', [MMSController::class, 'update_uuid'])->name('updateuuid');
    // Route::get('/update_tipe_hp', [MMSController::class, 'update_tipe_hp'])->name('updatetipehp');
    // Route::get('/mms_list', [MMSController::class, 'mms_list'])->name('mmslist');
    // Route::get('/karyawan_by_id', [MMSController::class, 'karyawan_by_id'])->name('karyawanbyid');
    // Route::get('/merek_hp_list', [MMSController::class, 'merek_hp_list'])->name('merekhplist');
    // Route::get('/permohonan_list', [MMSController::class, 'permohonan_list'])->name('permohonanlist');
    // Route::get('/status_permohonan_list', [MMSController::class, 'status_permohonan_list'])->name('statuspermohonanlist');
    // Route::get('/os_list', [MMSController::class, 'os_list'])->name('oslist');
    // Route::post('/simpan_mms', [MMSController::class, 'simpan_mms'])->name('simpanmms');
    // Route::get('/get_mms_by_id', [MMSController::class, 'get_mms_by_id'])->name('getmmsbyid');
    // Route::post('/update_pengajuan_mms', [MMSController::class, 'update_pengajuan_mms'])->name('updatepengajuanmms');
    // Route::post('/simpan_tanggapan_mms', [MMSController::class, 'simpan_tanggapan_mms'])->name('simpantanggapanmms');
    // Route::get('/check_imei', [MMSController::class, 'check_imei'])->name('checkimei');
    // Route::get('/check_uuid', [MMSController::class, 'check_uuid'])->name('checkuuid');
    // Route::get('/check_barcode_label', [MMSController::class, 'check_barcode_label'])->name('checkbarcodelabel');
    // Route::get('/tanggapan_list', [MMSController::class, 'tanggapan_list'])->name('tanggapanlist');
    // Route::get('/decrypt_uuid', [MMSController::class, 'decrypt_uuid'])->name('decryptuuid');

    // // section lms
    // Route::get('/lms', [LMSController::class, 'index'])->name('lms');
    // Route::get('/lms_list', [LMSController::class, 'lms_list'])->name('lmslist');
    // Route::get('/merek_laptop_list', [LMSController::class, 'merek_laptop_list'])->name('mereklaptoplist');
    // Route::get('/durasi_pemakaian_list', [LMSController::class, 'durasi_pemakaian_list'])->name('durasipemakaianlist');
    // Route::get('/alasan_list', [LMSController::class, 'alasan_list'])->name('alasanlist');
    // Route::get('/get_lms_by_id', [LMSController::class, 'get_lms_by_id'])->name('getlmsbyid');
    // Route::post('/simpan_lms', [LMSController::class, 'simpan_lms'])->name('simpanlms');
    // Route::post('/simpan_tanggapan_lms', [LMSController::class, 'simpan_tanggapan_lms'])->name('simpantanggapanlms');
    // Route::get('/status_permohonan_list_laptop', [LMSController::class, 'status_permohonan_list_laptop'])->name('statuspermohonanlistlaptop');
    // Route::get('/check_barcode_label_lms', [LMSController::class, 'check_barcode_label_lms'])->name('checkbarcodelabellms');
    // Route::get('/check_asset_number', [LMSController::class, 'check_asset_number'])->name('checkassetnumber');
    // Route::post('/update_pengajuan_lms', [LMSController::class, 'update_pengajuan_lms'])->name('updatepengajuanlms');
    // Route::get('/tanggapan_list_lms', [LMSController::class, 'tanggapan_list_lms'])->name('tanggapanlistlms');
    // Route::post('/recall_lms', [LMSController::class, 'recall_lms'])->name('recalllms');
    // Route::get('/update_barcode_label_lms', [LMSController::class, 'update_barcode_label_lms'])->name('updatebarcodelabellms');

    // /* karna pake session authentication, maka api harus ditarok di route web, karna tidak dapat akses session */
    // Route::get('/pemberitahuan', [PemberitahuanController::class, 'index'])->name('pemberitahuan');
    // Route::post('/simpan_pemberitahuan', [PemberitahuanController::class, 'simpan_pemberitahuan'])->name('simpanpemberitahuan');
    // Route::post('/update_pemberitahuan', [PemberitahuanController::class, 'update_pemberitahuan'])->name('updatepemberitahuan');
    // Route::get('/group_list', [PemberitahuanController::class, 'group_list'])->name('grouplist');
    // Route::get('/pemberitahuan_list', [PemberitahuanController::class, 'pemberitahuan_list'])->name('pemberitahuanlist');
    // Route::get('/get_pemberitahuan_by_id', [PemberitahuanController::class, 'get_pemberitahuan_by_id'])->name('getpemberitahuanbyid');

    // Route::get('/pemberitahuan/list', [PemberitahuanController::class, 'list'])->name('list_pemberitahuan');
    // Route::get('/pemberitahuan/penerima/{pemberitahuanId}', [PemberitahuanController::class, 'getReceiver']);
    // Route::get('/pemberitahuan/show/{id}', [PemberitahuanController::class, 'show'])->name('show_pemberitahuan');
    // Route::get('/pemberitahuan/{id}', [PemberitahuanController::class, 'detail']);
    // Route::post('/pemberitahuan', [PemberitahuanController::class, 'store'])->name('simpan_pemberitahuan');
    // Route::put('/pemberitahuan/{id}', [PemberitahuanController::class, 'update'])->name('ubah_pemberitahuan');
    // // Route::delete('/pemberitahuan/{id}', [LokerController::class, 'destroy'])->name('hapus_loker');

    // Route::get('/loker', [LokerController::class, 'index'])->name('loker');
    // Route::get('/loker/list', [LokerController::class, 'list'])->name('list_loker');
    // Route::get('/loker/detail', [LokerController::class, 'getDetailLoker'])->name('detail_loker');
    // Route::post('/loker/insert', [LokerController::class, 'insert'])->name('insert_loker');
    // Route::post('/loker/update', [LokerController::class, 'update'])->name('update_loker');
    // Route::get('/loker/delete', [LokerController::class, 'hapus'])->name('hapus_loker');

    // Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan');

    // Route::get('/peran', [PeranController::class, 'index'])->name('peran');

    // Route::get('/kritik', [KritikController::class, 'index'])->name('kritik');
    // Route::get('/kritik_list', [KritikController::class, 'kritik_list'])->name('kritiklist');
    // Route::post('/simpan_tanggapan_kritik', [KritikController::class, 'simpan_tanggapan_kritik'])->name('simpantanggapankritik');
    // Route::get('/tanggapan_list_kritik', [KritikController::class, 'tanggapan_list_kritik'])->name('tanggapanlistkritik');
    // Route::get('/get_kritik_by_id', [KritikController::class, 'get_kritik_by_id'])->name('getkritikbyid');
    // Route::post('/selesai_kritik_saran', [KritikController::class, 'selesai_kritik_saran'])->name('selesaikritiksaran');
    // Route::post('/kritik_set_hide', [KritikController::class, 'setHideKritik'])->name('kritiksethide');

    // // section lpb
    // Route::get('/lpb', [LPBController::class, 'index'])->name('lpb');
    // Route::get('/list_pb', [LPBController::class, 'list_pb'])->name('listpb');
    // Route::get('/get_list_pb_by_badge', [LPBController::class, 'get_list_pb_by_badge'])->name('getlistpbbybadge');
    // Route::post('/update_pb', [LPBController::class, 'update_pb'])->name('updatepb');

    // // section calendar
    // Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    // Route::post('/calendar/insert', [CalendarController::class, 'insert'])->name('/calendar/insert');
    // Route::post('/calendar/update', [CalendarController::class, 'update'])->name('/calendar/update');
    // Route::post('/calendar/delete', [CalendarController::class, 'delete'])->name('/calendar/delete');
    // Route::get('/calendar/getList', [CalendarController::class, 'getList'])->name('/calendar/getList');

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
    // section list user
    // Route::get('/user', [UserController::class, 'index'])->name('user');
    // Route::get('/user/getlistuser', [UserController::class, 'getListUser'])->name('/user/getlistuser');
    // Route::get('/user/getfilteruser', [UserController::class, 'getFilterUser'])->name('/user/getfilteruser');
    // Route::post('/user/insert', [UserController::class, 'insert'])->name('/user/insert');
    // Route::get('/user/edit', [UserController::class, 'edit'])->name('/user/edit');
    // Route::post('/user/update', [UserController::class, 'update'])->name('/user/update');

    // // section list user role
    // Route::get('/userrole', [UserRoleController::class, 'index'])->name('userrole');

    // section internship attendance
    // Route::get('/internship', [InternshipController::class, 'index'])->name('internship');
    // Route::get('/internship/getList', [InternshipController::class, 'getList'])->name('/internship/getList');
    // Route::get('/internship/getValue', [InternshipController::class, 'getValue'])->name('/internship/getValue');
    // Route::get('/internship/getAttach', [InternshipController::class, 'getAttach'])->name('/internship/getAttach');
    // Route::post('/internship/update', [InternshipController::class, 'update'])->name('/internship/update');
    // Route::get('/internship/detailInternship', [DetailInternshipController::class, 'index'])->name('/internship/detailInternship');
    // Route::get('/internship/detailInternship/filter', [DetailInternshipController::class, 'filterDesc'])->name('/internship/detailInternship/filter');
    // Route::get('/internship/detailInternship/getList', [DetailInternshipController::class, 'getList'])->name('/internship/detailInternship/getList');
    // Route::post('/internship/getListF', [InternshipController::class, 'getList'])->name('/internship/getListF');
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
