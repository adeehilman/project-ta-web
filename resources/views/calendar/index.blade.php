@extends('layouts.app')
@section('title', 'Calendar')


@section('content')
    <div class="wrappers">

        <div class="wrapper_content">

            <!-- modal Add Event-->
            <div class="modal fade" data-bs-backdrop="static" id="modalAdd" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Add Event</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px; overflow:auto; max-height: 700px;">
                            <form id="formAdd" method="post" autocomplete="off">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="selectEventAdd" class="form-label">Event Name</label>
                                        <input class="form-control" id="titleAdd" name="selectEventAdd">
                                        <!-- <input class="form-control" id="meetingIdAdd" name="MeetingId" hidden> -->
                                        <div id="err-selectEventAdd" class="text-danger d-none">
                                            Event title field is required.
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <p class="mt-4">Event Category</p>
                                        <!-- <select id="ParticipantList"></select> -->
                                        <select class="form-select" id="selectEventCategory" name="event"
                                            data-placeholder="-- SELECT CATEGORY --">
                                            @foreach ($list_category as $item)
                                                <option value="{{ $item->id_vlookup }}">{{ $item->name_vlookup }} </option>
                                            @endforeach

                                        </select>

                                        <div id="err-selectEventCategory" class="text-danger d-none">
                                            Category field is required.
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="DateEvent" class="form-label mt-3">Date</label>
                                        <input id="DateEvent" type="date" class="form-control" placeholder="Select Date"
                                            name="DateEvent">
                                        <div id="err-DateEvent" class="text-danger d-none">
                                            Date field is required.
                                        </div>
                                    </div>


                                </div>


                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary d-none" type="button" id="SpinnerBtnAdd">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                            <button type="submit" id="btnSimpanAdd" class="btn btn-primary">Add Event</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end modal Add Event-->

            <!-- modal Add Event On Date Select-->
            <div class="modal fade" data-bs-backdrop="static" id="modalAddSelect" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Add Event</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px; overflow:auto; max-height: 700px;">
                            <form id="formAddSelect" method="post" autocomplete="off">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="selectEventAdd" class="form-label">Event Name</label>
                                        <input class="form-control" id="selectEventAddSelect" name="selectEventAddSelect">
                                        <!-- <input class="form-control" id="meetingIdAdd" name="MeetingId" hidden> -->
                                        <div id="err-selectEventAdd" class="text-danger d-none">
                                            Event title field is required.
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <p class="mt-4">Event Category</p>
                                        <!-- <select id="ParticipantList"></select> -->
                                        <select class="form-select" id="selectEventCategorySelect" name="event">

                                            @foreach ($list_category as $item)
                                                <option value="{{ $item->id_vlookup }}">{{ $item->name_vlookup }} </option>
                                            @endforeach

                                        </select>

                                        <div id="err-selectEventCategory" class="text-danger d-none">
                                            Category field is required.
                                        </div>
                                    </div>
                                    <input type="text" name="dateSelect" id="dateSelect" hidden>

                                </div>


                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary d-none" type="button" id="SpinnerBtnAdd">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                            <button type="submit" id="btnSimpanAdd" class="btn btn-primary">Add Event</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end modal Add Event-->

            <!-- modal Edi Event-->
            <div class="modal fade" data-bs-backdrop="static" id="modalEdit" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalEditEvent">Edit Event</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px; overflow:auto; max-height: 700px;">
                            <form id="formEditEvent" method="post" autocomplete="off">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="selectEventAdd" class="form-label">Event Name</label>
                                        <input class="form-control" id="titleEdit" name="title">
                                        <!-- <input class="form-control" id="meetingIdAdd" name="MeetingId" hidden> -->
                                        <div id="err-selectEventEdit" class="text-danger d-none">
                                            Event title field is required.
                                        </div>
                                    </div>

                                    <input type="text" id="idEditModal" name="id" hidden>
                                    <input type="text" id="tanggalEditStart" name="start" hidden>
                                    <input type="text" id="tanggalEditEnd" name="end" hidden>
                                    <div class="col-sm-12">
                                        <p class="mt-4">Event Category</p>
                                        <!-- <select id="ParticipantList"></select> -->
                                        <select class="form-select" id="selectEventCategoryEdit" name="category">

                                            @foreach ($list_category as $item)
                                                <option value="{{ $item->id_vlookup }}">{{ $item->name_vlookup }} </option>
                                            @endforeach

                                        </select>

                                        <div id="err-selectEventCategoryEdit" class="text-danger d-none">
                                            Category field is required.
                                        </div>
                                    </div>


                                </div>


                        </div>

                        <div class="modal-footer justify-content-between">
                            <button type="button" id="btnDeleteEvent"
                                class="btn btn-outline-danger rounded-3 mr-auto">Delete
                                Event</button>
                            <button class="btn btn-secondary d-none" type="button" id="SpinnerBtnEdit">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                            <button type="submit" id="btnSimpanEdit" class="btn btn-primary">Edit Event</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end modal Edit Event-->

            <div class="row me-1">
                <div class="col-sm-6">
                    <span class="text-muted">Calendar</span>
                    <p id="KalenderH1" class="h3 mt-6 fw-bold">

                    </p>
                </div>

                <hr class="mb-1">
                <div class="col-sm-12 mt-2 d-flex justify-content-between">
                    <div class="d-flex gap-1">
                        <div class="d-flex align-items-center gap-1">
                            <button id="btnToday" type="button" class="btn btn-outline-secondary">
                                Today
                            </button>
                        </div>


                        <div class="d-flex align-items-center gap-1 " style="margin-left: 15px;">
                            <button id="monthEvent" class="btn btn-light">

                                <span id="calendarTitle" class="fs-5"></span>
                            </button>
                        </div>

                        <div class="d-flex align-items-center gap-1 mt-1">
                            <a href="#" id="prevButton" style="text-decoration: none; color:black;">
                                <i class='bx bx-chevron-left fs-2'></i>
                            </a>
                            <a href="#" id="nextButton" style="text-decoration: none; color:black;">
                                <i class='bx bx-chevron-right fs-2'></i>
                            </a>
                        </div>


                    </div>
                    <div class="d-flex gap-1">
                        <div class="d-flex align-items-center gap-1 mt-1">
                            <a href="#" style="text-decoration: none; color:black;">
                                <div class="row">
                                    <div class="col-4">
                                        <p id="Month" class="fw-bold mt-2" hidden>

                                        </p>
                                    </div>
                                    <div class="col-4">
                                        <p id="Week" class="fw-bold mt-2 mx-2" hidden>

                                        </p>
                                    </div>
                                    <div class="col-4">
                                        <p id="Day" class="fw-bold mt-2 mx-2" hidden>

                                        </p>
                                    </div>
                                </div>

                            </a>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <button id="btnAddEvent" style="font-size: 16px;" type="button"
                                class="btn btn-danger rounded-3">
                                <i class='bx bx-plus fs-6'></i>
                                Create New Event
                            </button>
                        </div>

                    </div>

                </div>

            </div>
            <hr class="mt-2">
            <div class="row me-1">
                <div class="col-4">
                    <div class="row">
                        <div class="col-4">
                            <i class='bx bxs-circle' style="color: #d74d58;"></i>
                            <span style="font-size: 15px; font-weight: bold; color: #4e4e4e;">Libur Nasional</span>
                        </div>

                    </div>


                </div>
            </div>
            {{-- Table --}}
            <div id="calendar" class="col-sm-12"></div>

        </div>

    </div>

    <style>

    </style>
@endsection

@section('script')
    @include('calendar.add_JS')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const todayButton = document.getElementById('btnToday');
            const prevButton = document.getElementById('prevButton');
            const nextButton = document.getElementById('nextButton');
            const Month = document.getElementById('Month');
            const Week = document.getElementById('Week');
            const Day = document.getElementById('Day');
            const calendarTitleEl = document.getElementById('calendarTitle');
            const btnAdd = $('#btnAddEvent');
            const modalFormAdd = $('#modalAdd');
            const modalFormEdit = $('#modalEdit');
            const modalAddSelect = $('#modalAddSelect');

            const today = new Date();

            const months = [
                "Januari", "Februari", "Maret",
                "April", "Mei", "Juni", "Juli",
                "Agustus", "September", "October",
                "November", "Desember"
            ];

            $.ajax({
                    url: "{{ route('/calendar/getList') }}",
                    method: "GET",
                    beforeSend: function() {
                        // Tampilkan indikator loading jika diperlukan
                    }
                })
                .done(res => {
                    // console.log(res);
                    const data = res.dataEvent;
                    $.each(data, function(index, event) {

                        calendar.addEventSource({
                            events: [{
                                    id: event.id,
                                    title: event.acara,
                                    start: event.tanggal,
                                    end: event.tanggal_end,
                                    extendedProps: {
                                        category: event.kategori_kalender
                                    }
                                },

                            ],
                            color: '#FAE9EA', // an option!
                            textColor: '#E92C2C' // an option!
                        })


                    });


                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', textStatus, errorThrown);
                });


            // Menampilkan tanggal terkini di bagian atas, 06 October 2023
            const formattedDateH1 = today.getDate() + ' ' + months[today.getMonth()] + ' ' + today.getFullYear();
            $("#KalenderH1").text(formattedDateH1);
            console.log(formattedDateH1);
            // Format tanggal dalam format YYYY-MM-DD
            const formattedDate = today.getFullYear() + '-' + ('0' + (today.getMonth() + 1)).slice(-2) + '-' + (
                '0' +
                today.getDate()).slice(-2);

            var calendar = new FullCalendar.Calendar(calendarEl, {
                height: 10,
                windowResize: function(arg) {},
                headerToolbar: {
                    left: '',
                    center: '',
                    right: ''
                },

                initialDate: formattedDate,
                editable: true,
                navLinks: true, // can click day/week names to navigate views
                selectable: true,
                selectMirror: true,
                droppable: true,

                // Event ketika klik kalender ditanggal tertentu
                select: function(arg) {
                    var dateSelectInput = document.getElementById('dateSelect');
                    var selectedDate = new Date(arg.start);
                    var formattedDate = selectedDate.getFullYear() + '-' + ('0' + (selectedDate
                        .getMonth() + 1)).slice(-2) + '-' + ('0' + selectedDate.getDate()).slice(-2);
                    dateSelectInput.value = formattedDate;
                    // $("#selectEventCategorySelect").val('');
                    $("#selectEventAddSelect").val('');


                    modalAddSelect.modal('show');
                    calendar.unselect();

                    $("#formAddSelect").on('submit', function(e) {
                        e.preventDefault();

                        const titleAdd = $('#selectEventAddSelect').val();
                        const selectEventCategory = $('#selectEventCategorySelect').val();
                        const DateEvent = $('#dateSelect').val();




                        if (titleAdd == '' || titleAdd == null) {
                            $('#err-selectEventAdd').removeClass('d-none');
                        } else {
                            $('#err-selectEventAdd').addClass('d-none');
                        }

                        if (selectEventCategory == '' || selectEventCategory == null) {
                            $('#err-selectEventCategory').removeClass('d-none');
                        } else {
                            $('#err-selectEventCategory').addClass('d-none');
                        }
                        if (DateEvent == '' || DateEvent == null) {
                            $('#err-DateEvent').removeClass('d-none');
                        } else {
                            $('#err-DateEvent').addClass('d-none');
                        }

                        if (
                            titleAdd != "" &&
                            selectEventCategory != "" &&
                            DateEvent != ""
                        ) {
                            Swal.fire({
                                title: "Do you want to Add this Meeting?",
                                icon: 'warning',
                                showCancelButton: true,
                                cancelButtonColor: '#6e7881',
                                confirmButtonColor: '#dd3333',
                                cancelButtonText: 'Cancel',
                                confirmButtonText: 'Yes',
                                reverseButtons: true,
                                customClass: {
                                    confirmButton: "swal-confirm-right",
                                    cancelButton: "swal-cancel-left"
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {

                                    $.ajax({
                                            url: '{{ route('/calendar/insert') }}',
                                            method: 'POST',
                                            data: new FormData(this),
                                            cache: false,
                                            processData: false,
                                            contentType: false,
                                            beforeSend: () => {
                                                $('#SpinnerBtnAdd').removeClass(
                                                    'd-none')
                                                $('#SpinnerBtnAdd').prop(
                                                    'disabled', true);
                                                $('#btnSimpanAdd').hide();
                                            }
                                        })
                                        .done(res => {

                                            $('#spinnerAdd').addClass('d-none')
                                            $('#SpinnerBtnAdd').addClass('d-none')
                                            $('#btnSimpanAdd').show();


                                            showMessage('success',
                                                "Event was successfully added!")
                                            modalAddSelect.modal('hide');
                                            const rese = res.dataEvent;

                                            console.log(rese);
                                            calendar.addEventSource({
                                                events: [{
                                                        id: rese.id,
                                                        title: rese
                                                            .acara,
                                                        start: rese
                                                            .tanggal,
                                                        end: rese
                                                            .tanggal_end,
                                                        extendedProps: {
                                                            category: rese
                                                                .kategori_kalender
                                                        }
                                                    },

                                                ],
                                                color: '#FAE9EA', // an option!
                                                textColor: '#E92C2C' // an option!
                                            })
                                        })
                                        .fail(err => {

                                            showMessage('error',
                                                'Sorry! we failed to insert data'
                                            )
                                            $('#spinnerAdd').addClass('d-none')
                                            $('#SpinnerBtnAdd').addClass('d-none')
                                            $('#btnSimpanAdd').show();
                                        });

                                }
                            })





                        }
                    })

                },

                // Event Click untuk update modal 
                eventClick: function(arg) {
                    modalFormEdit.modal('show');
                    const id = arg.event.id;
                    const acara = arg.event.title;
                    const start = arg.event.start;
                    const end = arg.event.end;
                    const category = arg.event.extendedProps.category;
                    // console.log(id, acara, category);


                    $("#titleEdit").val(acara);
                    $("#selectEventCategoryEdit").val(category);
                    $("#idEditModal").val(id);
                    $("#tanggalEditStart").val(start);
                    $("#tanggalEditEnd").val(end);

                    $("#btnDeleteEvent").on('click', function(e) {
                        e.preventDefault();

                        Swal.fire({
                            title: "Are you sure want delete this Event?",
                            icon: 'warning',
                            showCancelButton: true,
                            cancelButtonColor: '#6e7881',
                            confirmButtonColor: '#dd3333',
                            cancelButtonText: 'Cancel',
                            confirmButtonText: 'Yes',
                            reverseButtons: true,
                            customClass: {
                                confirmButton: "swal-confirm-right",
                                cancelButton: "swal-cancel-left"
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const csrfToken = $('meta[name="csrf-token"]').attr(
                                    'content'); // Ambil token CSRF dari meta tag
                                $.ajax({
                                        url: "{{ route('/calendar/delete') }}",
                                        method: "POST",
                                        data: {
                                            _token: csrfToken,
                                            id,
                                        },
                                    })
                                    .done(res => {
                                        modalFormEdit.modal('hide');
                                        showMessage('success',
                                            "Event was successfully delete!")

                                        arg.event.remove();
                                    })


                            }
                        })
                    })
                },

                dayMaxEvents: true, // allow "more" link when too many events
                eventSources: [

                ],

                // event update when drag and drop
                eventDrop: function(info) {

                    const id = info.event.id;
                    const start = info.event.start;
                    const end = info.event.end;
                    const title = info.event.title;
                    const category = info.event.extendedProps.category;


                    const csrfToken = $('meta[name="csrf-token"]').attr(
                        'content'); // Ambil token CSRF dari meta tag

                    $.ajax({
                            url: "{{ route('/calendar/update') }}",
                            method: "POST",
                            data: {
                                _token: csrfToken,
                                id,
                                start,
                                end,
                                title,
                                category,
                            }
                        })
                        .done(res => {
                            showMessage('success', "Event was successfully update!")

                        })

                },
                // event saat event diperpanjang ketanggal lain
                eventResize: function(info) {
                    const id = info.event.id;
                    const start = info.event.start;
                    const end = info.event.end;
                    const title = info.event.title;
                    const category = info.event.extendedProps.category;

                    console.log(category);
                    const csrfToken = $('meta[name="csrf-token"]').attr(
                        'content'); // Ambil token CSRF dari meta tag

                    $.ajax({
                            url: "{{ route('/calendar/update') }}",
                            method: "POST",
                            data: {
                                _token: csrfToken,
                                id,
                                start,
                                end,
                                title,
                                category,
                            }
                        })
                        .done(res => {
                            showMessage('success', "Event was successfully update!")

                        })
                },

                datesSet: function(info) {
                    var formattedDate = info.view.title;
                    calendarTitleEl.innerText = formattedDate;
                }




            });



            function changeView(view) {
                calendar.changeView(view);
            }
            calendar.render();

            // Mulai permintaan AJAX untuk mendapatkan data


            todayButton.addEventListener('click', function() {
                calendar.gotoDate(new Date());
            });

            prevButton.addEventListener('click', function() {
                calendar.prev();
            });

            Month.addEventListener('click', function() {
                changeView('dayGridMonth');
            });

            Week.addEventListener('click', function() {
                changeView('timeGridWeek');
            });

            Day.addEventListener('click', function() {
                changeView('timeGridDay');
            });

            nextButton.addEventListener('click', function() {
                calendar.next();
            });

            // Temukan elemen input
            const monthFilterInput = document.getElementById('monthEvent');

            // Inisialisasi flatpickr
            const flatpickrInstance = flatpickr(monthFilterInput, {
                plugins: [
                    new monthSelectPlugin({
                        shorthand: true,
                        dateFormat: "F",
                        altFormat: "F",
                        theme: "light"
                    })
                ],
                onChange: function(selectedDates, dateStr, instance) {
                    // Ambil tanggal dari input bulan
                    const selectedDate = selectedDates[0];

                    // Perbarui tampilan kalender ke bulan yang dipilih
                    calendar.gotoDate(selectedDate);
                }
            });

        });
    </script>

    @include('calendar.listCalendar_JS')
    @include('calendar.update_JS')
@endsection
