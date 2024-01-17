@extends('layouts.app')
@section('title', 'Internship Attendance')

@section('content')
    <div class="wrappers">
        <div class="wrapper_content">



            <!-- modal Filter-->
            <div class="modal fade" data-bs-backdrop="static" id="modalFilter" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Filter</h1>
                            <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px;">
                            <form id="formFilterTime">
                                <div class="row mb-3">
                                    <div class="col-sm-12">


                                        <label for="selectRoom" class="form-label">Filter Department</label>
                                        <select class="form-select" id="selectDeptFilter"
                                            data-placeholder="-- ALL DEPARTMENT  --" style="width: 100%">
                                            <option value="" selected>ALL</option>
                                            @foreach ($list_dept as $item)
                                                <option value="{{ $item->dept_code }}"> {{ $item->dept_name }} -
                                                    {{ $item->dept_code }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="col-sm-12">
                                        <label for="dateRange" class="form-label mt-3">Date</label>
                                        <input id="dateRange" type="date" class="form-control" placeholder="Select Date"
                                            name="dateRange">
                                        <div id="err-dateRange" class="text-danger d-none">
                                            Date field is required.
                                        </div>
                                    </div>


                                </div>


                                <div class="row mb-3">
                                    <div class="col-sm-6" id="filtertime">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input menuCheck" type="checkbox" data-attendance="1"
                                                value="1" id="attendance_1" name="attendance_1"
                                                data-operation="filter">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Present
                                            </label>
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input menuCheck" type="checkbox" data-attendance="2"
                                                value="2" id="attendance_2" name="attendance_2"
                                                data-operation="filter">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Permission
                                            </label>
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input menuCheck" type="checkbox" data-attendance="5"
                                                value="5" id="attendance_5" name="attendance_5"
                                                data-operation="filter">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Sick
                                            </label>
                                        </div>

                                        <div id="err-filtertime" class="text-danger d-none">
                                            Please select a valid Time.
                                        </div>
                                    </div>
                                    <div class="col-sm-6" id="filtertime">
                                        <div class="form-check mt-2">
                                            <input class="form-check-input menuCheck" type="checkbox" data-attendance="3"
                                                value="3" id="attendance_3" name="attendance_3"
                                                data-operation="filter">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Absent
                                            </label>
                                        </div>
                                        <div class="form-check mt-2">
                                            <input class="form-check-input menuCheck" type="checkbox" data-attendance="4"
                                                value="4" id="attendance_4" name="attendance_4"
                                                data-operation="filter">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Not Scan In / Out
                                            </label>
                                        </div>

                                        <div id="err-filtertime" class="text-danger d-none">
                                            Please select a valid Time.
                                        </div>
                                    </div>
                                </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" id="btnResetF"
                                style="text-decoration: none;">Reset</button>
                            <button type="submit" id="btnFilterShowResult" class="btn btn-primary">Show Result</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end modal Filter-->

            <!-- modal Export Monthly-->
            <div class="modal fade" data-bs-backdrop="static" id="modalExport" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Export</h1>
                            <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px;">
                            <form id="formExportData">
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <p>Filter by Room</p>
                                        <select class="form-select" id="selectRoom2" name="selectRoom" multiple>
                                            <option value="Room1">Room 1</option>
                                            <option value="Room2">Room 2</option>
                                            <option value="Room3">Room 3</option>
                                            <option value="Room4">Room 4</option>
                                            <option value="Room5">Room 5</option>
                                            <option value="Room6">Room 6</option>
                                        </select>

                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="allRoom" name="allRoom">
                                            <label class="form-check-label" for="allRoom">
                                                All Rooms
                                            </label>
                                        </div>
                                        <p class="small mt-2" id="selectedRoomCount">0 Room Selected</p>
                                        <div id="err-selectroomexport" class="text-danger d-none">
                                            Please select a valid Room.
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12" id="timeexport">
                                        <p>Time</p>
                                        <div class="form-check">
                                            <input class="form-check-input" style="width: 20px; height: 20px;"
                                                type="radio" name="timeFilter" id="alltimeAdd" value="1">
                                            <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                                for="rdalltime">All Time</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" style="width: 20px; height: 20px;"
                                                type="radio" name="timeFilter" id="rdlast7daysAdd" value="2">
                                            <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                                for="rdlast7days">Last 7 Days</label>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" style="width: 20px; height: 20px;"
                                                type="radio" id="rdlast30daysAdd" value="3" name="timeFilter">
                                            <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                                for="rdlast30daysAdd">Last 30 Days</label>
                                        </div>
                                        <p class="mt-2">Export in Excel format.</p>

                                        <div id="err-selecttimeexport" class="text-danger d-none">
                                            Please select a valid Time.
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" id="btn-close" data-bs-dismiss="modal"
                                style="text-decoration: none;">Reset</button>
                            <button type="button" id="btnsimpanExport" class="btn btn-primary">Export File</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end modal Export Monthly-->

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

             <!-- modal Export Daily-->
             <div class="modal fade" data-bs-backdrop="static" id="modalExportDaily" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Export Daily</h1>
                            <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px;">
                            <form id="formExportDaily">
                                <div class="row mb-3">
                                    <div class="col-sm-12">


                                        <label for="selectRoom" class="form-label"> Department</label>
                                        <select class="form-select" id="selectDeptExportD"
                                            data-placeholder="-- ALL DEPARTMENT  --" style="width: 100%">
                                            <option value="" selected>ALL</option>
                                            @foreach ($list_dept as $item)
                                                <option value="{{ $item->dept_code }}"> {{ $item->dept_name }} -
                                                    {{ $item->dept_code }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="col-sm-12">
                                        <label for="dateRange" class="form-label mt-3">Date</label>
                                        <input id="dateRangeD" type="date" class="form-control" placeholder="Select Date"
                                            name="dateRangeD">
                                        <div id="err-dateRange" class="text-danger d-none">
                                            Date field is required.
                                        </div>
                                    </div>


                                </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary d-none" type="button" id="SpinnerBtnExportDaily">
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                Loading...
                            </button>
                            <button type="submit" id="btnExportDaily" class="btn btn-primary">Show Result</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end modal Export Daily-->

             <!-- modal Export Monthly-->
             <div class="modal fade" data-bs-backdrop="static" id="modalExportMonthly" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Export Monthly</h1>
                            <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px;">
                            <form id="formExportMonthly">
                                <div class="row mb-3">
                                    <div class="col-sm-12">


                                        <label for="selectRoom" class="form-label"> Department</label>
                                        <select class="form-select" id="selectDeptMonthly"
                                            data-placeholder="-- ALL DEPARTMENT  --" style="width: 100%">
                                            <option value="" selected>ALL</option>
                                            @foreach ($list_dept as $item)
                                                <option value="{{ $item->dept_code }}"> {{ $item->dept_name }} -
                                                    {{ $item->dept_code }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="col-sm-12">
                                        <label for="monthExport" class="form-label mt-3">Month</label>
                                        <input id="monthExport" type="date" class="form-control" placeholder="Select Month"
                                            name="monthExport">
                                        <div id="err-monthExport" class="text-danger d-none">
                                            Date field is required.
                                        </div>
                                    </div>


                                </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary d-none" type="button" id="SpinnerBtnExportMonthly">
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                Loading...
                            </button>
                            <button type="submit" id="btnExportMonthly" class="btn btn-primary">Show Result</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end modal Export Monthly-->

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
            <!-- end modal view attachment-->
            <!-- end modal detail reschedule-->

             <!-- modal Import-->
             <div class="modal fade" data-bs-backdrop="static" id="modalImport" tabindex="-1">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Import Part Master</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form id="formImport" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body" style="font-size: 16px;">
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="uploadFile" class="form-label">Upload File</label>
                                        <input type="file" class="form-control" id="uploadFile" name="file"
                                            accept=".xlsx">
                                        <div id="err-fileImport" class="text-danger d-none">
                                            File Import is Required
                                        </div>
                                        <p class="mt-3">Before importing data, Please download this file for import your
                                            Internship Attendance
                                            <a href="{{ asset('/sample-excel/Template_Internship.xlsx') }}">
                                                Template_Internship.xlsx
                                            </a>
                                        </p>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                                    style="text-decoration: none;">Cancel</button>
                                <button class="btn btn-primary d-none" type="button" id="SpinnerBtnImport">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="submit" id="btnImportAttendance" class="btn btn-primary">Import
                                    Internship Attendance</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end modal Import-->





            <div class="row me-1">
                <div class="col-sm-6">
                    <p class="h3 mt-6">
                        Internship Attendance
                    </p>
                </div>

                <div class="col-sm-12 mt-2 d-flex justify-content-between">
                    <div class="d-flex gap-1">
                        <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"
                            class="form-control rounded-3" placeholder="Search here">

                        <button id="btnFilter" style="font-size: 16px;" type="button"
                            class="btn btn-outline-secondary rounded-3">
                            <i class='bx bx-slider p-1'></i>
                            Filter
                        </button>
                        <button id="btnReset" type="button" class="btn btn-outline-secondary">
                            <div class="d-flex align-items-center gap-1">
                                <i class='bx bx-refresh bx-rotate-90 fs-4'></i>
                                Reset
                            </div>
                        </button>
                    </div>

                    <div class="d-flex gap-1">
                        <!-- Example single danger button -->
                        <button id="btnImport" style="font-size: 16px;" type="button"
                        class="btn btn-outline-danger rounded-3">
                        Import
                    </button>
                        <div class="btn-group">
                           
                            <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Export
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" id="btnDailyExport" href="#">Daily</a></li>
                                <li><a class="dropdown-item" id="btnMonthlyExport" href="#">Monthly</a></li>
                            </ul>
                        </div>
                    </div>

                </div>


                {{-- Table --}}
                <div id="containerInternship" class="col-sm-12 mt-4">



                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    @include('internship.listAndSearch_JS')
    @include('internship.filter_JS')
    @include('internship.Edit_JS')
    @include('internship.export_JS')
    @include('internship.import_JS')

    <script>
        // Show dan hide project input
        function showInput() {
            $('#timeInEdit').prop('disabled', false);
            $('#timeOutEdit').prop('disabled', false);
            const colImage = $('#colImage');
            const colImageOptional = $('#colImageOptional');

            // Sembunyikan elemen colImageOptional
            colImageOptional.addClass('d-none');

            const sickRadio = $('#sick');

            if (sickRadio.is(':checked')) {
                // Tampilkan elemen colImage
                colImage.removeClass('d-none');

            } else {
                // Sembunyikan elemen colImage
                colImage.addClass('d-none');
            }
        }

        function showInputOptional() {

            $('#timeInEdit').prop('disabled', false);
            $('#timeOutEdit').prop('disabled', false);
            const colImage = $('#colImage');
            const colImageOptional = $('#colImageOptional');

            // Sembunyikan elemen colImage
            colImage.addClass('d-none');

            // Tampilkan elemen colImageOptional
            colImageOptional.removeClass('d-none');
        }

        function hideInput() {

            $('#timeInEdit').prop('disabled', false);
            $('#timeOutEdit').prop('disabled', false);

            const colImage = $('#colImage');
            colImage.addClass('d-none');

            const colImageOptional = $('#colImageOptional');
            colImageOptional.addClass('d-none');
        }
        function hideInputAbsent() {

            $('#timeInEdit').prop('disabled', true);
            $('#timeOutEdit').prop('disabled', true);

            const colImage = $('#colImage');
            colImage.addClass('d-none');

            const colImageOptional = $('#colImageOptional');
            colImageOptional.addClass('d-none');
        }

        $('#selectDeptFilter').select2({
            theme: "bootstrap-5",
            minimumResultsForSearch: -1

        });
        $('#selectRoom2').select2({
            theme: "bootstrap-5",

        });
        $('#selectRoom3').select2({
            theme: "bootstrap-5",

        });
        $('#selectParticipan').select2({
            theme: "bootstrap-5",

        });

        // open modal Filter

        // const btnFilter = $('#btnFilter');
        // const modalFormFilter = $('#modalFilter');
        // const btnFilterData = $('#btnFilterData');

        // btnFilter.click(e => {
        //     e.preventDefault();
        //     modalFormFilter.modal('show');
        // });

        // $('#btnFilterData').click(e => {
        //     e.preventDefault();

        //      // validasi select room
        //      const selectRoom = $('#selectRoom1').val();
        //     if (selectRoom === '') {
        //         $('#err-selectRoomFilter').removeClass('d-none');
        //         return;
        //     } else {
        //         $('#err-selectRoomFilter').addClass('d-none');

        //     }
        //      // validasi filter time
        //      const filtertime = $('#filtertime').val();
        //     if (filtertime === '') {
        //         $('#err-filtertime').removeClass('d-none');
        //         return;
        //     } else {

        //         $('#err-filtertime').addClass('d-none');

        //     }

        //     // Cek apakah semua validasi telah terpenuhi
        //     if ($('#err-selectRoomFilter').hasClass('d-none') && $('#err-filtertime').hasClass('d-none')) {
        //     modalFormFilter.modal('hide');
        //     }

        //     // fungsi ketika modal add close
        //     $('#modalFilter').on('hidden.bs.modal', function(event) {
        //      console.log($('#selectRoom1').val());
        //      console.log($('#filtertime').val());
        //     $('#selectRoom1').val(null).trigger('change');
        //     $('#filtertime').val(null).trigger('change');
        //     $('#formFilterListMeeting')[0].reset();


        //    $('#err-selectRoomFilter').addClass('d-none');
        //    $('#err-filtertime').addClass('d-none');

        //     })
        // });



        // {{-- Modal Filter --}}

        // // open modal Filter
        // const btnFilter = $('#btnFilter');
        // const modalFormFilter = $('#modalFilter');

        // btnFilter.click(e => {
        //     e.preventDefault();
        //     modalFormFilter.modal('show');
        // });


        // // modal simpan data filter
        // $('#btnFilterData').click(e => {
        //     e.preventDefault();

        //     const modalFilter = $('#modalFilter');

        //     // Validasi select room
        //     const roomSelected = $('#selectRoom1').val();
        //     if (roomSelected == '') {
        //         $('#err-selectRoomFilter').removeClass('d-none');
        //     } else {
        //         $('#err-selectRoomFilter').addClass('d-none');
        //     }
        //     // Validasi time filter
        //     const isChecked = $('input[name="timeFilter"]:checked').length > 0;
        //     if (!isChecked) {
        //         $('#err-filtertime').removeClass('d-none');
        //     } else {
        //         $('#err-filtertime').addClass('d-none');
        //     }

        //     // Cek apakah semua validasi telah terpenuhi
        //     if ($('#err-selectRoomFilter').hasClass('d-none') && $('#err-filtertime').hasClass('d-none')) {
        //         // Swal.fire({
        //         //     position: 'center',
        //         //     icon: 'success',
        //         //     title: "Meeting List data has been exported.",
        //         //     showConfirmButton: false,
        //         //     timer: 3000
        //         // });

        //         modalFilter.modal('hide');
        //     }

        //     // fungsi ketika modal add close
        //     $('#modalFilter').on('hidden.bs.modal', function(event) {
        //         console.log($('#selectRoom1').val());
        //         console.log($('#filtertime').val());
        //         $('#selectRoom1').val(null).trigger('change');
        //         $('#filtertime').val(null).trigger('change');
        //         $('#formFilterTime')[0].reset();


        //         $('#err-selectRoomFilter').addClass('d-none');
        //         $('#err-filtertime').addClass('d-none');

        //     })
        // });


        // // {{-- Modal export --}}

        // // open modal Export
        // const btnExport = $('#btnExport');
        // const modalFormExport = $('#modalExport');

        // btnExport.click(e => {
        //     e.preventDefault();
        //     modalFormExport.modal('show');
        // });


        // // modal simpan data export
        // $('#btnsimpanExport').click(e => {
        //     e.preventDefault();

        //     const modalExport = $('#modalExport');

        //     // Validasi select room
        //     const roomSelected = $('#selectRoom2').val();
        //     if (roomSelected == '') {
        //         $('#err-selectroomexport').removeClass('d-none');
        //     } else {
        //         $('#err-selectroomexport').addClass('d-none');
        //     }
        //     // Validasi time export
        //     const isChecked = $('input[name="timeFilter"]:checked').length > 0;
        //     if (!isChecked) {
        //         $('#err-selecttimeexport').removeClass('d-none');
        //     } else {
        //         $('#err-selecttimeexport').addClass('d-none');
        //     }

        //     // Cek apakah semua validasi telah terpenuhi
        //     if ($('#err-selectroomexport').hasClass('d-none') && $('#err-selecttimeexport').hasClass('d-none')) {
        //         Swal.fire({
        //             position: 'center',
        //             icon: 'success',
        //             title: "Meeting List data has been exported.",
        //             showConfirmButton: false,
        //             timer: 3000
        //         });

        //         modalExport.modal('hide');
        //     }

        //     // fungsi ketika modal add close
        //     $('#modalExport').on('hidden.bs.modal', function(event) {
        //         console.log($('#selectRoom2').val());
        //         console.log($('#timeexport').val());
        //         $('#selectRoom2').val(null).trigger('change');
        //         $('#timeexport').val(null).trigger('change');
        //         $('#formExportData')[0].reset();


        //         $('#err-selectroomexport').addClass('d-none');
        //         $('#err-selecttimeexport').addClass('d-none');

        //     })
        // });



        // // Checkbox All Room
        // const allRoomCheckbox = document.getElementById('allRoom');
        // const roomSelect = document.getElementById('selectRoom2');

        // allRoomCheckbox.addEventListener('change', function() {
        //     if (this.checked) {
        //         roomSelect.disabled = true;
        //         deselectAllOptions();
        //     } else {
        //         roomSelect.disabled = false;
        //     }
        // });

        // // open modal Add Data        
        // const btnAddData = $('#btnAddData');
        // const modalFormAddData = $('#modalAddData');

        // btnAddData.click(e => {
        //     e.preventDefault();
        //     modalFormAddData.modal('show');
        // });


        // // open modal Detail
        // const btnDetail = $('#btnDetail');
        // const modalFormDetail = $('#modalDetail');

        // btnDetail.click(e => {
        //     e.preventDefault();
        //     modalFormDetail.modal('show');
        // });

        // // open reschedule modal detail
        // const btnReschedule = $('#btnReschedule');
        // const modalReschedule = $('#modalReschedule');

        // btnReschedule.click(e => {
        //     e.preventDefault();
        //     modalReschedule.modal('show');
        // });


        // // show confirm edit export

        // $('#btnsimpaneditexport').click(e => {
        //     e.preventDefault()

        //     const modalReschedule = $('#modalReschedule')

        //     // Validasi meeting title
        //     const MeetingTitle = $('#MeetingTitle').val();
        //     if (MeetingTitle == '') {
        //         $('#err-MeetingTitle').removeClass('d-none');
        //     } else {
        //         $('#err-MeetingTitle').addClass('d-none');
        //     }

        //     // Validasi select room
        //     const selectRoom5 = $('#selectRoom5').val();
        //     if (selectRoom5 == '') {
        //         $('#err-MeetingRoom5').removeClass('d-none');
        //     } else {
        //         $('#err-MeetingRoom5').addClass('d-none');
        //     }

        //     // Validasi date meeting detail
        //     const MeetingDetail = $('#DateMeetingDetail').val();
        //     if (MeetingDetail == '') {
        //         $('#err-DateMeetingDetail').removeClass('d-none');
        //     } else {
        //         $('#err-DateMeetingDetail').addClass('d-none');
        //     }

        //     // Validasi start meeting detail
        //     const StartMeetingDetail = $('#StartMeetingDetail').val();
        //     if (StartMeetingDetail == '') {
        //         $('#err-StartMeetingDetail').removeClass('d-none');
        //     } else {
        //         $('#err-StartMeetingDetail').addClass('d-none');
        //     }

        //     // Validasi finish meeting detail
        //     const FinishMeetingDetail = $('#FinishMeetingDetail').val();
        //     if (FinishMeetingDetail == '') {
        //         $('#err-FinishMeetingDetail').removeClass('d-none');
        //     } else {
        //         $('#err-FinishMeetingDetail').addClass('d-none');
        //     }
        //     // Validasi select participan
        //     const selectParticipan = $('#selectParticipan').val();
        //     if (selectParticipan == '') {
        //         $('#err-selectParticipan').removeClass('d-none');
        //     } else {
        //         $('#err-selectParticipan').addClass('d-none');
        //     }

        //     // Cek apakah semua validasi telah terpenuhi
        //     if ($('#err-MeetingTitle').hasClass('d-none') && $('#err-MeetingRoom5').hasClass('d-none') && $(
        //             '#err-DateMeetingDetail').hasClass('d-none') && $('#err-StartMeetingDetail').hasClass(
        //             'd-none') &&
        //         $('#err-FinishMeetingDetail').hasClass('d-none') && $('#err-selectParticipan').hasClass('d-none')) {

        //         Swal.fire({
        //             title: "Do you want to Edit Meeting?",
        //             icon: 'warning',
        //             showCancelButton: true,
        //             confirmButtonColor: '#3085d6',
        //             cancelButtonColor: '#d33',
        //             confirmButtonText: 'Yes'
        //         }).then((result) => {
        //             if (result.isConfirmed) {
        //                 Swal.fire({
        //                     position: 'center',
        //                     icon: 'success',
        //                     title: "Meeting has been update",
        //                     showConfirmButton: false,
        //                     timer: 3000
        //                 })
        //             }
        //             modalReschedule.modal('hide');
        //         })
        //     }
        // })

        // // fungsi ketika modal add close
        // $('#modalReschedule').on('hidden.bs.modal', function(event) {
        //     console.log($('#MeetingTitle').val());
        //     console.log($('#selectRoom5').val());
        //     console.log($('#DateMeetingDetail').val());
        //     console.log($('#StartMeetingDetail').val());
        //     console.log($('#FinishMeetingDetail').val());
        //     console.log($('#description').val());
        //     console.log($('#selectParticipan').val());
        //     $('#MeetingTitle').val(null).trigger('change');
        //     $('#selectRoom5').val(null).trigger('change');
        //     $('#DateMeetingDetail').val(null).trigger('change');
        //     $('#StartMeetingDetail').val(null).trigger('change');
        //     $('#FinishMeetingDetail').val(null).trigger('change');
        //     $('#description').val(null).trigger('change');
        //     $('#selectParticipan').val(null).trigger('change');
        //     $('#formExportData')[0].reset();


        //     $('#err-MeetingTitle').addClass('d-none');
        //     $('#err-MeetingRoom5').addClass('d-none');
        //     $('#err-DateMeetingDetail').addClass('d-none');
        //     $('#err-StartMeetingDetail').addClass('d-none');
        //     $('#err-FinishMeetingDetail').addClass('d-none');
        //     $('#err-selectParticipan').addClass('d-none');

        // })

        // // show paginantion table meeting
        // $('#tablemeeting').DataTable({
        //     searching: false,
        //     lengthChange: false,
        //     Sort: true
        // });
    </script>

@endsection
