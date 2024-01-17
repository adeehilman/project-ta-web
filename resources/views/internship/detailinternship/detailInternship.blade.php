@extends('layouts.app')
@section('title', 'Detail Internship')

@section('content')

    <div class="wrappers">
        <div class="wrapper_content">

            <!-- modal Export-->
            <div class="modal fade" data-bs-backdrop="static" id="modalExport" tabindex="-1">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Export</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formImport" method="GET">
                            @csrf
                            <div class="modal-body" style="font-size: 16px;">

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="dateImport" class="form-label">Select Document</label>
                                        <select class="form-control" id="opsiDocument" name="category">
                                            <option value="">-- Choose Document --</option>
                                            <option value="downtime">Daily Downtime Record</option>
                                            <option value="output_daily">Daily Production Record</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="dateImport" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="dateExports" name="date">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                                    style="text-decoration: none;">Cancel</button>
                                <button class="btn btn-primary d-none" type="button" id="SpinnerBtnExport">
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="submit" id="btnExport" class="btn btn-primary">Export</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end modal Export-->


            <!-- modal view attachment-->
            <div class="modal fade" data-bs-backdrop="static" id="modalView" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered  modal-dialog-scrollable modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">View File</h1>
                            <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px;">
                            <img src="" id="img-attach" alt="" width="100%" class="img-fluid">
                        </div>

                    </div>
                </div>
            </div>
            <!-- modal detail-->
            <div class="modal fade" data-bs-backdrop="static" id="modalDetail" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" style="height: 600px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalDetailTitle">Detail Meeting</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px;">
                            <form id="formDetailMeeting">
                                <div class="tabsMenu">
                                    <input type="radio" class="hidden" id="multitabs1" name="mtabs" checked>
                                    <input type="radio" class="hidden" id="multitabs2" name="mtabs">
                                    <input type="radio" class="hidden" id="multitabs3" name="mtabs">
                                    <input type="radio" class="hidden" id="multitabs4" name="mtabs">
                                    <div class="tabsHead fw-bold">
                                        <label for="multitabs1" class="active" id="tab1"
                                            style="cursor: pointer">Info
                                            Booking Room</label>
                                        <label for="multitabs2" class="tabs" id="tab2" style="cursor: pointer"
                                            id="participantLabel">
                                            <div id="participantLabel"></div>
                                        </label>
                                        <label for="multitabs3" class="tabs" id="tab3"
                                            style="cursor: pointer">History Status</label>
                                        <label for="multitabs4" class="tabs" id="tab4"
                                            style="cursor: pointer">Respons</label>
                                    </div>
                                    <div class="tabsContent">

                                        {{-- Tab konten Info Booking --}}
                                        <div class="tabsContent1" style="height:460px">
                                            <div class="row mb-1">
                                                <div class="col-sm-12">
                                                    <table id="infobooking" class="ms-2"
                                                        style="font-size: 16px; line-height: 2.4;">
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Meeting Title</td>
                                                            <td id="titleDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Description</td>
                                                            <td id="descDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Meeting Date</td>
                                                            <td id="dateDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Room</td>
                                                            <td id="roomDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Floor</td>
                                                            <td id="floorDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Participant</td>
                                                            <td id="participantDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Visitor</td>
                                                            <td id="visitorDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Facilities</td>
                                                            <td id="facilityDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Project Name</td>
                                                            <td id="ProjectNameDetailTextMeetingSummary"
                                                                style="color: black;">
                                                            </td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <td style="width: 250px; color: gray;">Start Meeting</td>
                                                            <td id="startMeetingDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Finished Meeting</td>
                                                            <td id="finishMeetingDetail" style="color: black;">
                                                            </td>
                                                        </tr> --}}
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Request</td>
                                                            <td id="bookingByDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Booking Time</td>
                                                            <td id="bookingTime" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Created by</td>
                                                            <td id="createdBy" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <td style="width: 250px; color: gray;">Badge</td>
                                                            <td id="bookingByBadgeDetail" style="color: black;">
                                                            </td>
                                                        </tr> --}}
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Status</td>
                                                            <td id="statusDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Reason</td>
                                                            <td id="reasonDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>

                                        </div>

                                        {{-- Tab konten Participant --}}
                                        <div class="tabsContent2" style="height:460px">
                                            <div class="row mb-3">
                                                <div class="col-10">
                                                    <p class="fw-bold" id="AttendanceCount">Attendance</p>
                                                </div>
                                            </div>



                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-10">

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div id="listOfParticipants" class="ms-2"
                                                        style="font-size: 16px; line-height: 2; display: flex; flex-wrap: wrap;">
                                                    </div>
                                                </div>





                                            </div>

                                        </div>


                                        {{-- Tab konten History Status --}}
                                        <div class="tabsContent3" style="height:460px;">
                                            <div class="row mx-2 my-2">
                                                <div class="col-sm-2 mt-2">
                                                    <div id="containerRiwayatClock">
                                                    </div>
                                                </div>

                                                <div class="col-sm-10">
                                                    <div id="containerRiwayatStatus">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Tab konten Response --}}
                                        <div class="tabsContent4" style="height:460px">
                                            <div class="row mb-1">
                                                <div class="row">
                                                    <div class="col-10">
                                                        <p class="fw-bold mt-3">History Reason</p>

                                                    </div>
                                                </div>
                                                <div class="container border rounded">

                                                    <div id="listOfTanggapan"></div>

                                                </div>
                                                <div id="noRespon"></div>





                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
            <!-- end modal detail -->

             <!-- modal Edit-->
             <div class="modal fade" data-bs-backdrop="static" id="modalEdit" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Edit</h1>
                            <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px;">
                            <form id="formEditAttend">
                                @csrf
                                <div class="row mb-3">
                                    <table id="infoDetail" class="ms-3" style="font-size: 16px; line-height: 2.4;">
                                        <tr>
                                            <td>Badge ID</td>
                                            <td id="badgeEdit" style="color: black; font-weight:bold;" name="badgeEdit">-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 250px; color: gray;">Name</td>
                                            <td id="fullnameEdit" style="color: black; font-weight:bold;"
                                                name="fullnameEdit">-
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width: 250px; color: gray;">Department</td>
                                            <td id="deptEdit" style="color: black; font-weight:bold;" name="deptEdit">-
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <hr>
                                <input class="form-control" id="dateSubmit" name="dateSubmit" readonly>
                                <div class="row" class="ms-3">
                                    <div class="col-sm-6">
                                        <label for="timeInEdit" class="form-label mt-3">Time In</label>
                                        <input id="timeInEdit" type="time" class="form-control"
                                            placeholder="Select Date" name="timeInEdit">
                                        <input class="form-control" id="idAttendance" name="idAttendance" hidden>
                                        <div id="err-timeInEdit" class="text-danger d-none">
                                            Time In field is required.
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="timeOutEdit" class="form-label mt-3">Time Out</label>
                                        <input id="timeOutEdit" type="time" class="form-control"
                                            placeholder="Select Date" name="timeOutEdit">
                                        <div id="err-timeOutEdit" class="text-danger d-none">
                                            Time Out meeting time field is required.
                                        </div>
                                    </div>
                                </div>

                                <div class="row" class="ms-3" style="margin-top: 15px;">
                                    <div class="col-sm-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input radioAttend" type="radio"
                                                name="attendOption" id="present" value="Present"
                                                onclick="hideInput()">
                                            <label class="form-check-label" for="rdlast7days">Present</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input radioAttend" type="radio"
                                                name="attendOption" id="permission" value="Permission"
                                                onclick="showInputOptional()">
                                            <label class="form-check-label" for="rdlast7days">Permission</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input radioAttend" type="radio"
                                                name="attendOption" id="sick" value="Sick" onclick="showInput()"
                                                onclick="hideInputOptional()">
                                            <label class="form-check-label" for="rdlast7days">Sick</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input radioAttend" type="radio"
                                                name="attendOption" id="absent" value="Absent" onclick="hideInputAbsent()">
                                            <label class="form-check-label" for="rdlast7days">Absent</label>
                                        </div>
                                    </div>
                                    <div id="err-attendOption" class="text-danger d-none">
                                        Status field is required.
                                    </div>
                                    <div class="col-sm-12 mt-3 d-none" id="colImage">
                                        <label class="form-label">Attach File</label>
                                        <input type="file" id="imageAttach" name="imageAttach"
                                            class="form-control mb-3">

                                        {{-- Peringatan jika inputan kosong --}}
                                        <div id="err-imageAttach" class="text-danger d-none">
                                            Please Upload Image MAX 10 MB !
                                        </div>

                                    </div>
                                    <div class="col-sm-12 mt-3 d-none" id="colImageOptional">
                                        <label class="form-label">Attach File(Optional)</label>
                                        <input type="file" id="imageAttach" name="imageAttachPermission"
                                            class="form-control mb-3">

                                        {{-- Peringatan jika inputan kosong --}}
                                        <div id="err-imageAttach" class="text-danger d-none">
                                            Please Upload Image MAX 10 MB !
                                        </div>

                                    </div>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary d-none" type="button" id="SpinnerBtnEdit">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                            <button type="submit" id="btnSimpanEdit" class="btn btn-primary">Save Changes</button>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- end modal Edit-->

            <div class="row me-1">
                <div class="col-sm-6">
                    <a href="{{ route('internship') }}" style="text-decoration: none">
                        <span class="text-muted fs-6">
                            <img src="{{ asset('icons/left.svg') }}"> Back to Internship Attendance</span>
                    </a>
                </div>

                <div class="col-sm-12 mt-2 d-flex justify-content-between">
                    <p class="h3 mt-6">
                        Detail Internship
                    </p>
                    <div class="d-flex gap-1">
                        <button id="btnExportsDetail" type="button" style="font-size: 16px; margin-right: 5px;"
                            class="btn btn-danger rounded-3">
                            Export Data
                        </button>
                    </div>
                </div>

                <div class="container" id="ContainerDetailIntern">
                    <div class="row mb-3">
                        <div class="col-sm-4">
                            {{-- <h5 class="text-center">No History</h5> --}}
                            <table class="ms-2" style="font-size: 16px; line-height: 2;">
                                <tr>
                                    <td style="width: 300px; color: gray;">Badge ID</td>
                                    <td id="EmployeeNo" style="color: black;">{{ $attend->badge_id }}</td>
                                </tr>
                                <tr>
                                    <td style="width:  300px; color: gray;">Name</td>
                                    <td id="Fullname" style="color: black;">{{ $attend->fullname }}</span></td>
                                </tr>
                                <tr>
                                    <td style="width:  300px; color: gray;">Department</td>
                                    <td id="ParticipantBadge" style="color: black;">{{ $attend->dept_name }}</span>
                                    </td>
                                </tr>


                            </table>
                        </div>
                        <div class="col-sm-4">
                            {{-- <h5 class="text-center">No History</h5> --}}
                            <table class="ms-2" style="font-size: 16px; line-height: 2;">

                                <tr>
                                    <td style="width:  300px; color: gray;">Total Attend</td>
                                    <td style="color: black;" id="totalAttend">{{ $attend->total_present }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 300px; color: gray;">Not Attend</td>
                                    <td style="color: black;" id="NotAttend">{{ $attend->total_not_attend }}</td>
                                </tr>
                                <tr>
                                    <td style="width: 300px; color: gray;">Absent</td>
                                    <td style="color: black;" id="Absent">{{ $attend->total_absent }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-sm-4 d-flex  align-items-end justify-content-end">

                            <div class="d-flex gap-1 ">
                                <select class="form-select" id="bulanDropdown" name="bulanDropdown" style="width: 200px;">
                                    <?php
                                    $bulanSekarang = date('n');
                                    $namaBulan = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                    
                                    for ($bulan = 1; $bulan <= 12; $bulan++) {
                                        $selected = $bulan == $bulanSekarang ? 'selected' : '';
                                        echo "<option value='$bulan' $selected>{$namaBulan[$bulan - 1]}</option>";
                                    }
                                    ?>
                                </select>
                                <select class="form-select" id="tahunDropdown" name="tahunDropdown" style="width: 100px;">
                                    <?php
                                    $tahunSekarang = date('Y');
                                    for ($tahun = $tahunSekarang; $tahun >= $tahunSekarang - 2; $tahun--) {
                                        echo "<option value='$tahun'>$tahun</option>";
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>

                    </div>
                </div>
                {{-- <div class="row mb-3">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6 d-flex justify-content-end">

                        <div class="d-flex gap-1 ">
                            <button id="btnExportsDetail" type="button" style="font-size: 16px; margin-right: 5px;"
                                class="btn btn-outline-primary rounded-3">
                                Export Data
                            </button>
                        </div>
                    </div>
                </div> --}}

                {{-- Table --}}
                <div id="containerDetailIntern" class="col-sm-12 mt-3">

                </div>

            </div>
        </div>
    </div>

    {{-- @include('meetingreport.meetingsummary.detailsummary.export_JS') --}}

@endsection
@section('script')
    @include('internship.detailinternship.listAndEdit_JS')
    @include('internship.detailinternship.Edit_JS')
    @include('internship.detailinternship.export_JS')
@endsection
