@extends('layouts.app')
@section('title', 'Meeting')

@section('content')
    <div class="wrappers">
        <div class="wrapper_content">

            <!-- modal Cancel-->
            <div class="modal fade" data-bs-backdrop="static" id="modalCancel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalCancelTitle">Cancel Meeting</h1>
                            <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px;">
                            <form id="formCancelMeeting" method="post">
                                @csrf
                                <div class="row mb-1">
                                    <div class="col">

                                        <p>Reason (Optional)</p>
                                        <style>
                                            .note-editor {
                                                border-radius: 10px;
                                            }
                                        </style>
                                        <input type="text" value="6" name="confirm" hidden>
                                        <input id="meetingId" value="" name="idmeeting" hidden>
                                        <textarea id="txDeskripsiCancel" name="txDeskripsi" style="border-radius: 10px;"></textarea>
                                    </div>
                                </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-target="#modalDetail" data-bs-toggle="modal"
                                id="btn-close" data-bs-dismiss="modal" style="text-decoration: none;">Back</button>
                            <button type="submit" id="btnCancelModal" class="btn btn-primary">Confirm</button>
                        </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- end modal cancel-->
            <!-- modal Filter-->
            <div class="modal fade" data-bs-backdrop="static" id="modalFilter" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Export</h1>
                            <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px;">
                            <form id="formFilterTime">
                                <div class="row mb-3">
                                    <div class="col-sm-12">


                                        <label for="selectRoom" class="form-label">Filter by Room</label>
                                        <select class="form-select" id="selectRoom" data-placeholder="-- SELECT ROOM  --"
                                            style="width: 100%" multiple>
                                            @foreach ($list_room as $item)
                                                <option value="{{ $item->id }}"> {{ $item->room_name }} </option>
                                            @endforeach

                                        </select>

                                    </div>
                                    <p class="small mt-2" id="selectedRoomCount">0 Room Selected</p>
                                    <div id="err-selectRoomFilter" class="text-danger d-none">
                                        Please select a valid Room.
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12" id="filtertime">


                                        <div class="col-sm-6">
                                            <p>Filter by Time</p>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" style="width: 20px; height: 20px;"
                                                    type="radio" name="timeFilter" id="rdlast7daysAdd" value="1">
                                                <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                                    for="rdlast7days">Last 7 Days</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" style="width: 20px; height: 20px;"
                                                    type="radio" id="rdlast30daysAdd" value="2" name="timeFilter">
                                                <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                                    for="rdlast30daysAdd">Last 30 Days</label>
                                            </div>

                                        </div>
                                        <div id="err-filtertime" class="text-danger d-none">
                                            Please select a valid Time.
                                        </div>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" id="btn-close" data-bs-dismiss="modal"
                                style="text-decoration: none;">Reset</button>
                            <button type="button" id="btnFilterData" class="btn btn-primary">Show Result</button>
                        </div>

                    </div>
                </div>
            </div>
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
            <!-- end modal Export-->

            <!-- modal detail-->
            <div class="modal fade" data-bs-backdrop="static" id="modalDetail" tabindex="-1">
                <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" style="height: 600px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalDetailTitle">Detail Meeting</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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
                                            style="cursor: pointer">Info Booking Room</label>
                                        <label for="multitabs2" class="tabs" id="tab2"
                                            style="cursor: pointer">Participant</label>
                                        <label for="multitabs3" class="tabs" id="tab3"
                                            style="cursor: pointer">History Status</label>
                                        {{-- <label for="multitabs4" class="tabs" id="tab4"
                                            style="cursor: pointer">Respons</label> --}}
                                    </div>
                                    <div class="tabsContent">

                                        {{-- Tab konten Info Booking --}}
                                        <div class="tabsContent1" style="height:460px">
                                            <div class="row mb-1">
                                                <div class="col-sm-12">
                                                    <table class="ms-2" style="font-size: 16px; line-height: 2.4;">
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
                                                            <td style="width: 250px; color: gray;">Date</td>
                                                            <td id="dateDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Start Meeting</td>
                                                            <td id="startMeetingDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Finished Meeting</td>
                                                            <td id="finishMeetingDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Request</td>
                                                            <td id="bookingByDetail" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Badge</td>
                                                            <td id="bookingByBadgeDetail" style="color: black;">
                                                            </td>
                                                        </tr>
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
                                            <div class="container">
                                                <div class="row">
                                                    <div id="listOfParticipants" class="ms-2"
                                                        style="font-size: 16px; line-height: 2; display: flex; flex-wrap: wrap;">
                                                    </div>
                                                </div>





                                            </div>

                                        </div>


                                        {{-- Tab konten History Status --}}
                                        <div class="tabsContent3" style="height:460px">
                                            <div class="row mx-2 my-2">

                                                <div id="containerRiwayatClock" class="col-sm-2 mt-1">
                                                </div>


                                                <div id="containerRiwayatStatus" class="col-sm-10">
                                                </div>

                                            </div>
                                        </div>

                                        {{-- Tab konten Participant --}}
                                        {{-- <div class="tabsContent4" style="height:460px">
                                            <div class="row mb-1">
                                                <p>Tambahkan Komentar</p>
                                                <textarea id="txDeskripsi" name="txDeskripsi"></textarea>
                                                <p class="fw-bold mt-3">History Tanggapan</p>
                                                <div class="mt-5"style="text-align: center;" color="#D3D3D3;">
                                                    Ini adalah teks di tengah dengan warna abu-abu muda.
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnCancel" class="btn btn-link" style="text-decoration: none;"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="button" id="btnReschedule" data-bs-dismiss="modal"
                                class="btn btn-outline-danger rounded-3">Edit Meeting</button>
                        </div>
                    </div>

                </div>

            </div>
            <!-- end modal detail -->

            <!-- modal detail reschedule-->
            <div class="modal fade" data-bs-backdrop="static" id="modalReschedule" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Edit Meeting</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px;">
                            <form id="formReschedule" method="post">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="MeetingTitle" class="form-label">Meeting Title</label>
                                        <input class="form-control" id="titleDetailEdit" name="MeetingTitle">
                                        <input class="form-control" id="meetingIdEdit" name="MeetingId" hidden>
                                        <div id="err-MeetingTitle" class="text-danger d-none">
                                            Meeting title field is required.
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <p class="mt-3">Meeting Room</p>
                                        <select class="form-select" id="RoomDetailEdit" name="room_name"
                                            data-placeholder="-- SELECT ROOM --">
                                            <option value="" disabled selected>-- SELECT ROOM --</option>
                                            @foreach ($list_room as $item)
                                                <option value="{{ $item->id }}">{{ $item->room_name }}</option>
                                            @endforeach
                                        </select>

                                        <div id="err-MeetingRoom5" class="text-danger d-none">
                                            Meeting Room field is required.
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="DateDetailEdit" class="form-label mt-3">Date</label>
                                        <input id="DateDetailEdit" type="text" class="form-control"
                                            placeholder="Select Date" name="DateMeeting">
                                        <div id="err-DateMeetingDetail" class="text-danger d-none">
                                            Date field is required.
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="startMeetingDetailEdit" class="form-label mt-3">Start
                                                Meeting</label>
                                            <input id="startMeetingDetailEdit" type="time" class="form-control"
                                                placeholder="Select Date" name="StartMeeting">
                                            <div id="err-StartMeetingDetail" class="text-danger d-none">
                                                Start meeting time field is required.
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="finishMeetingDetailEdit" class="form-label mt-3">Finish
                                                Meeting</label>
                                            <input id="finishMeetingDetailEdit" type="time" class="form-control"
                                                placeholder="Select Date" name="FinishMeeting">
                                            <div id="err-FinishMeetingDetail" class="text-danger d-none">
                                                Finish meeting time field is required.
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <label for="Description" class="form-label">Description (Optional)</label>
                                    <input class="form-control" id="descDetailEdit" name="Desc">
                                </div>
                                <div class="col-sm-12">
                                    <p class="mt-4">Participant</p>
                                    <!-- <select id="ParticipantList"></select> -->
                                    <select class="form-select" id="selectParticipanEdit" name="badge_id[]" multiple>
                                        @foreach ($list_participant as $item)
                                            <option value="{{ $item->badge_id }}">{{ $item->fullname }}</option>
                                        @endforeach

                                    </select>



                                    {{-- tes menggunakan lazy_loading --}}
                                    {{-- <select class="form-select" id="selectParticipanEdit" name="badge_id[]" multiple>
                                    </select> --}}


                                    <p class="small mt-2" id="selectedParticipantCount">0 Participant Selected</p>
                                    <div id="err-selectParticipan" class="text-danger d-none">
                                        Finish meeting time field is required.
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-bs-target="#modalDetail"
                                        data-bs-toggle="modal" id="btn-close" data-bs-dismiss="modal"
                                        style="text-decoration: none;">Back</button>

                                    <button type="submit" id="btnSimpanReschedule" class="btn btn-primary">Save
                                        Changes</button>
                                </div>
                            </form>

                        </div>


                    </div>
                </div>
            </div>
            <!-- end modal Detail Reschedule-->


            <div class="row me-1">
                <div class="col-sm-6">
                    <p class="h3 mt-6">
                        Meeting
                    </p>
                </div>

                <div class="col-sm-12 mt-2 d-flex justify-content-between">
                    <div class="d-flex gap-1">
                        <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"
                            class="form-control rounded-3" placeholder="Search">
                        {{-- <button id="btnFilter" style="font-size: 16px;" type="button"
                            class="btn btn-outline-secondary rounded-3">
                            <i class='bx bx-slider p-1'></i>
                            Filter
                        </button> --}}
                        <button id="btnReset" type="button" class="btn btn-outline-secondary">
                            <div class="d-flex align-items-center gap-1">
                                <i class='bx bx-refresh bx-rotate-90 fs-4'></i>
                                Reset
                            </div>
                        </button>

                    </div>
                    <div class="d-flex gap-1">
                        <button id="btnExport" style="font-size: 16px;" type="button"
                            class="btn btn-outline-danger rounded-3">
                            Export Data
                        </button>
                    </div>

                </div>


                {{-- Table --}}
                <div id="containerMeeting" class="col-sm-12 mt-4">



                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    @include('meeting.ListAndSearch_JS')
    @include('meeting.detail_JS')
    @include('meeting.edit_JS')

    <script>
        //     $(document).ready(function () {
        //     // Inisialisasi dropdown Select2 dengan kemampuan pencarian

        //     // Tangani perubahan pada input pencarian Select2
        //     $('#selectParticipanEdit').on('select2:open', function (e) {
        //         // Perubahan dalam input pencarian
        //         $(this).parent().find('.select2-search__field').on('keyup', function (event) {
        //             var searchText = $(this).val();
        //             console.log(searchText);


        //             $.ajax({
        //             url: "{{ route('/meeting/listParticipant') }}",
        //             method: "GET",
        //             data: {
        //                 searchText: searchText
        //             },
        //             beforeSend: () => {

        //             }
        //         })
        //         .done(res => {

        //             const listParticipant = res.list_participant_w


        //             console.log(listParticipant);

        //             // $.each(listParticipant, function (index, item) {
        //             //     participantSelect.append($('<option>', {
        //             //         value: item.badge_id, // Nilai yang ingin Anda set
        //             //         text: item.fullname // Teks yang ingin Anda tampilkan
        //             //     }));
        //             // });



        //             $.each(listParticipant, function(index, item) {
        //                 const participantHtml1 = `


    //                                 <option value="${item.badge_id}">${item.fullname}</option>


    //                 `;

        //                 // Menambahkan participantHtml ke listOfParticipants
        //                 ParticipantList.append(participantHtml1);


        //             });


        //         })


        // });
        //         });
        //     });

        document.addEventListener('DOMContentLoaded', function() {
            flatpickr('#DateDetailEdit', {
                dateFormat: 'd/m/y', // Format tanggal yang diinginkan
                enableTime: false, // Tidak termasuk waktu
                minDate: 'today' // Tanggal minimum adalah hari ini
            });
        });



        //summernote init
        $(document).ready(function() {
            $('#txDeskripsi').summernote({
                placeholder: 'Insert reason (Optional)',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['font', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol']],
                ]
            });
        });

        // insialisasi
        $('#RoomDetailEdit').select2({
            theme: "bootstrap-5",

        });



        $('#selectRoom1').select2({
            theme: "bootstrap-5",

        });
        $('#selectRoom2').select2({
            theme: "bootstrap-5",

        });
        $('#selectRoom3').select2({
            theme: "bootstrap-5",

        });




        // open modal Filter

        const btnFilter = $('#btnFilter');
        const modalFormFilter = $('#modalFilter');
        const btnFilterData = $('#btnFilterData');

        btnFilter.click(e => {
            e.preventDefault();
            modalFormFilter.modal('show');
        });

        $('#btnFilterData').click(e => {
            e.preventDefault();

            // validasi select room
            const selectRoom = $('#selectRoom1').val();
            if (selectRoom === '') {
                $('#err-selectRoomFilter').removeClass('d-none');
                return;
            } else {
                $('#err-selectRoomFilter').addClass('d-none');

            }
            // validasi filter time
            const filtertime = $('#filtertime').val();
            if (filtertime === '') {
                $('#err-filtertime').removeClass('d-none');
                return;
            } else {

                $('#err-filtertime').addClass('d-none');

            }

            // Cek apakah semua validasi telah terpenuhi
            if ($('#err-selectRoomFilter').hasClass('d-none') && $('#err-filtertime').hasClass('d-none')) {
                modalFormFilter.modal('hide');
            }

            // fungsi ketika modal add close
            $('#modalFilter').on('hidden.bs.modal', function(event) {
                console.log($('#selectRoom1').val());
                console.log($('#filtertime').val());
                $('#selectRoom1').val(null).trigger('change');
                $('#filtertime').val(null).trigger('change');
                $('#formFilterListMeeting')[0].reset();


                $('#err-selectRoomFilter').addClass('d-none');
                $('#err-filtertime').addClass('d-none');

            })
        });



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


        // {{-- Modal export --}}

        // open modal Export
        const btnExport = $('#btnExport');
        const modalFormExport = $('#modalExport');

        btnExport.click(e => {
            e.preventDefault();
            // modalFormExport.modal('show');
            showMessage('info', 'Under Development');
        });



        // modal simpan data export
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



        // show confirm edit export

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

        // fungsi ketika modal add close
        $('#modalReschedule').on('hidden.bs.modal', function(event) {
            console.log($('#MeetingTitle').val());
            console.log($('#selectRoom5').val());
            console.log($('#DateMeetingDetail').val());
            console.log($('#StartMeetingDetail').val());
            console.log($('#FinishMeetingDetail').val());
            console.log($('#description').val());
            console.log($('#selectParticipan').val());
            $('#MeetingTitle').val(null).trigger('change');
            $('#selectRoom5').val(null).trigger('change');
            $('#DateMeetingDetail').val(null).trigger('change');
            $('#StartMeetingDetail').val(null).trigger('change');
            $('#FinishMeetingDetail').val(null).trigger('change');
            $('#description').val(null).trigger('change');
            $('#selectParticipan').val(null).trigger('change');
            $('#formExportData')[0].reset();


            $('#err-MeetingTitle').addClass('d-none');
            $('#err-MeetingRoom5').addClass('d-none');
            $('#err-DateMeetingDetail').addClass('d-none');
            $('#err-StartMeetingDetail').addClass('d-none');
            $('#err-FinishMeetingDetail').addClass('d-none');
            $('#err-selectParticipan').addClass('d-none');

        })
    </script>

@endsection
