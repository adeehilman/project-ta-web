@extends('layouts.app')
@section('title', 'List Meeting')

@section('content')
    <div class="wrappers">
        <div class="wrapper_content">



            <!-- modal Filter-->

            <!-- end modal Filter-->

            <!-- modal Export-->
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
                                            <input class="form-check-input" type="checkbox" value="" id="allRoom"
                                                name="allRoom">
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
            <!-- end modal Export-->


            <!-- end modal detail reschedule-->




            <div class="row me-1">
                <div class="col-sm-6">
                    <p class="h3 mt-6">
                        Meeting
                    </p>
                </div>

                <div class="col-sm-12 mt-2 d-flex justify-content-between">
                    <div class="d-flex gap-1">
                        <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"
                            class="form-control rounded-3" placeholder="Search here">

                        <select class="form-select" id="tahunDropdown" name="tahunDropdown">
                            <?php
                            $tahunSekarang = date('Y');
                            for ($tahun = $tahunSekarang; $tahun >= $tahunSekarang - 2; $tahun--) {
                                echo "<option value='$tahun'>$tahun</option>";
                            }
                            ?>
                        </select>
                        {{-- <select class="form-select" id="monthFilter" name="monthFilter">
                            <option value="">All Month</option>
                        </select> --}}
                        <input id="monthFilter" class="form-control" placeholder="All Months" name="monthFilter"
                            value="">
                        <select class="form-select" id="selectDept" name="selectDept"
                            style="width: 250px; min-width: 250px;" placeholder="All Department">
                            <option value="">All Department</option>
                            @foreach ($list_dept as $item)
                                <option value="{{ $item->dept_code }}">
                                    {{ $item->dept_name }}</option>
                            @endforeach

                        </select>
                        <button id="btnReset" type="button" class="btn btn-outline-secondary">
                            <div class="d-flex align-items-center gap-1">
                                <i class='bx bx-refresh bx-rotate-90 fs-4'></i>
                                Reset
                            </div>
                        </button>
                    </div>

                    <div class="d-flex gap-1">
                        <button id="btnExportSummary" style="font-size: 16px;" type="button"
                            class="btn btn-outline-danger rounded-3">
                            Export Data
                        </button>
                    </div>

                </div>


                {{-- Table --}}
                <div id="containerSummaryMeeting" class="col-sm-12 mt-4">




                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    @include('meetingreport.meetingsummary.filter_JS')
    @include('meetingreport.meetingsummary.listAndSearch_JS')
    @include('meetingreport.meetingsummary.export_JS')

    <script>
        // //summernote init
        // $(document).ready(function() {
        //     $('#txDeskripsi').summernote({
        //         placeholder: 'Tulis tanggapan',
        //         tabsize: 2,
        //         height: 120,
        //         toolbar: [
        //             ['font', ['bold', 'italic', 'underline']],
        //             ['para', ['ul', 'ol']],
        //         ]
        //     });
        // });

        // insialisasi 
        // $('#tahunDropdown').select2({
        //     theme: "bootstrap-5",
        //     minimumResultsForSearch: -1
        // });
        $('#selectRoom1').select2({
            theme: "bootstrap-5",

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
