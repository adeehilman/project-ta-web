@extends('layouts.app')
@section('title', 'Meeting')

@section('content')
    <div class="wrappers">
        <div class="wrapper_content">

            <!-- modal Add meeting-->
            <div class="modal fade" data-bs-backdrop="static" id="modalAdd" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Add Meeting</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px; overflow:auto; max-height: 700px;">
                            <form id="formAdd" method="post" autocomplete="off">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="MeetingTitle" class="form-label">Meeting Title</label>
                                        <input class="form-control" id="titleAdd" name="MeetingTitleAdd" maxlength="90">
                                        <!-- <input class="form-control" id="meetingIdAdd" name="MeetingId" hidden> -->
                                        <div id="err-MeetingTitleAdd" class="text-danger d-none">
                                            Meeting title field is required.
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <p class="mt-3">Meeting Room</p>
                                        <select class="form-select" id="RoomAdd" name="room_nameadd"
                                            data-placeholder="-- SELECT ROOM --">
                                            <option value="" disabled selected>-- SELECT ROOM --</option>
                                            @foreach ($list_room as $item)
                                                <option value="{{ $item->id }}">{{ $item->room_name }}</option>
                                            @endforeach
                                        </select>

                                        <div id="err-MeetingRoomAdd" class="text-danger d-none">
                                            Meeting Room field is required.
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <p class="mt-4">Host</p>
                                        <!-- <select id="ParticipantList"></select> -->
                                        <select class="form-select" id="selectHostAdd" name="hostAdd">
                                            @foreach ($list_participant as $item)
                                                <option value="{{ $item->badge_id }}">{{ $item->fullname }}

                                                </option>
                                            @endforeach

                                        </select>

                                        <div id="err-selectHost" class="text-danger d-none">
                                            Host field is required.
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <p class="mt-4">Participant</p>
                                        <!-- <select id="ParticipantList"></select> -->
                                        <select class="form-select" id="selectParticipanAdd" name="badge_id[]" multiple>
                                            @foreach ($list_participant as $item)
                                                <option value="{{ $item->badge_id }}">{{ $item->fullname }}

                                                </option>
                                            @endforeach

                                        </select>



                                        {{-- tes menggunakan lazy_loading --}}
                                        {{-- <select class="form-select" id="selectParticipanEdit" name="badge_id[]" multiple>
                                    </select> --}}


                                        <p class="small mt-2" id="selectedParticipantCountAdd">0 Participant Selected</p>
                                        <div id="err-selectParticipan" class="text-danger d-none">
                                            Participant field is required.
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="DateAdd" class="form-label mt-3">Date Meeting</label>
                                        <input id="DateAdd" type="date" class="form-control" placeholder="Select Date"
                                            name="DateMeetingAdd">
                                        <div id="err-DateMeetingAdd" class="text-danger d-none">
                                            Date field is required.
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label for="startMeetingAdd" class="form-label mt-3">Start
                                                Meeting</label>
                                            <input id="startMeetingAdd" type="date" class="form-control"
                                                placeholder="Select Date" name="StartMeetingAdd">
                                            <div id="err-StartMeetingAdd" class="text-danger d-none">
                                                Start meeting time field is required.
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="finishMeetingAdd" class="form-label mt-3">Finish
                                                Meeting</label>
                                            <input id="finishMeetingAdd" type="date" class="form-control"
                                                placeholder="Select Date" name="FinishMeetingAdd">
                                            <div id="err-FinishMeetingAdd" class="text-danger d-none">
                                                Finish meeting time field is required.
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-2">
                                    <label for="MeetingExtension" class="form-label">Extension No</label>
                                    <input class="form-control" id="ExtensionAdd" name="ExtensionAdd"
                                        placeholder="Input Extension No"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 13) this.value = this.value.slice(0, 13);">
                                    <!-- <input class="form-control" id="meetingIdAdd" name="MeetingId" hidden> -->
                                    <div id="err-MeetingExtensionAdd" class="text-danger d-none">
                                        Extension No field is required.
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-2">
                                    <div class="row">
                                        <label for="ProyekName" class="form-label">Is this related to the Project?</label>
                                    </div>

                                    <div class="form-check form-check-inline">

                                        <input class="form-check-input" style="width: 20px; height: 20px;" type="radio"
                                            name="timeFilter" id="rdlast7daysAdd" value="yes" onclick="showInput()">
                                        <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                            for="rdlast7days">Yes</label>

                                    </div>
                                    <div class="form-check form-check-inline">

                                        <input class="form-check-input" style="width: 20px; height: 20px;" type="radio"
                                            name="timeFilter" id="NoRadio" value="no" onclick="hideInput()"
                                            checked>
                                        <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                            for="rdlast7days">No</label>

                                    </div>
                                </div>


                                <div id="ProjectInput" class="col-sm-12 mt-2">
                                    <label for="ProjectName" class="form-label">Project Name</label>
                                    <input class="form-control" id="ProjectNameAdd" name="ProjectNameAdd"
                                        placeholder="Insert Project Name">
                                    <!-- <input class="form-control" id="meetingIdAdd" name="MeetingId" hidden> -->

                                </div>
                                <div class="col-sm-12 mt-2">
                                    <div class="row">
                                        <label for="ProyekName" class="form-label">Any Guest?</label>
                                    </div>
                                </div>
                                <div class="col-sm-12">


                                    <div class="form-check form-check-inline">

                                        <input class="form-check-input" style="width: 20px; height: 20px;" type="radio"
                                            name="guestRadio" id="guestRadioYes" value="yes" onclick="showInputGuest()">
                                        <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                            for="rdlast7days">Yes</label>

                                    </div>
                                    <div class="form-check form-check-inline">

                                        <input class="form-check-input" style="width: 20px; height: 20px;" type="radio"
                                            name="guestRadio" id="guestRadioNo" value="no" onclick="hideInputGuest()"
                                            >
                                        <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                            for="rdlast7days">No</label>

                                    </div>
                                </div>
                                <div id="customertName" class="col-sm-12 mt-2">
                                    <label for="customertNameAdd" class="form-label">Customer Name (Optional)</label>
                                    <input class="form-control" id="customertNameAdd" name="customertNameAdd"
                                        placeholder="Insert Customer Name">
                                    <!-- <input class="form-control" id="meetingIdAdd" name="MeetingId" hidden> -->

                                    <div class="col-sm-12 mt-2">
                                        <label for="Description" class="form-label">Description (Optional)</label>
                                        <textarea class="form-control" id="descAdd" name="DescAdd"></textarea>
                                    </div>
                                    <div class="mt-2">
                                        <span class="">Visitor</span>
                                        <div class="input-group mt-2">
                                            <input type="number" class="form-control"
                                                id="othersvisitorAdd" name="othersvisitorAdd"
                                                min="1" max="99" step="1"
                                                oninput="checkInputLength(this)">
                                        </div>
                                    </div>
                                    <div class="mt-4">
                                        <span class="">Facilities</span>
                                        {{-- dinamis fasilitas --}}
                                        @foreach ($list_facilities as $item)
                                            <div class="form-check mt-2">
                                                <input class="form-check-input menuCheck" type="checkbox"
                                                    data-facilities="{{ $item->id }}"
                                                    value="{{ $item->id }}"
                                                    id="facilities_{{ $item->id }}"
                                                    name="facilities_{{ $item->id }}" checked
                                                    data-operation="insert">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    {{ $item->fasilitas }}
                                                </label>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>




                            </form>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary d-none" type="button" id="SpinnerBtnAdd">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                            <button type="submit" id="btnSimpanAdd" class="btn btn-primary">Add Meeting</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end modal Add meeting-->


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

                                        <p>Reason</p>
                                        <style>
                                            .note-editor {
                                                border-radius: 10px;
                                            }
                                        </style>
                                        <input type="text" value="6" name="confirm" hidden>
                                        <input id="meetingId" value="" name="idmeeting" hidden>
                                        <textarea id="txDeskripsiCancel" name="txDeskripsi" style="border-radius: 10px;"></textarea>

                                        <div id="err-cancel" class="text-danger d-none">
                                            This field Reason is required!
                                        </div>

                                    </div>
                                </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-target="#modalDetail"
                                data-bs-toggle="modal" id="btn-close" data-bs-dismiss="modal"
                                style="text-decoration: none;">Back</button>
                            <button class="btn btn-primary d-none" type="button" id="SpinnerBtnCancel">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
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
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Filter</h1>
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
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="allRoomFilter" name="allRoomFilter">
                                            <label class="form-check-label" for="allRoom">
                                                All Rooms
                                            </label>
                                        </div>

                                    </div>
                                    <p class="small mt-2" id="selectedRoomCount">0 Room Selected</p>
                                    <div id="err-selectRoomFilter" class="text-danger d-none">
                                        Please select a valid Room.
                                    </div>
                                    <div class="col-sm-12">


                                        <label for="selectRoom" class="form-label">Filter by Status</label>
                                        <select class="form-select" id="selectStatus"
                                            data-placeholder="-- SELECT STATUS  --" style="width: 100%">
                                            <option value="" selected>ALL</option>
                                            @foreach ($list_status as $item)
                                                <option value="{{ $item->id }}"> {{ $item->status_name_eng }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>


                                </div>


                                <div class="row mb-3">
                                    <div class="col-sm-12" id="filtertime">


                                        <div class="col-sm-6">
                                            <p>Filter by Time</p>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" style="width: 20px; height: 20px;"
                                                    type="radio" name="timeFilter" id="rdlast7daysAdd" value="1"
                                                    checked>
                                                <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                                    for="rdlast7days">Last 7 Days</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" style="width: 20px; height: 20px;"
                                                    type="radio" id="rdlast30daysAdd" value="2"
                                                    name="timeFilter">
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
                            <button type="button" class="btn btn-link" id="btnResetF"
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
                            <form id="formExport">
                                <div class="row mb-3">
                                    <div class="col-sm-12">


                                        <label for="selectRoom2" class="form-label">Filter by Room</label>
                                        <select class="form-select" id="selectRoom2" data-placeholder="-- ALL ROOM  --"
                                            style="width: 100%" multiple>

                                            @foreach ($list_room as $item)
                                                <option value="{{ $item->id }}"> {{ $item->room_name }} </option>
                                            @endforeach

                                        </select>
                                        <div class="form-check mt-1">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="allRoomExport" name="allRoomFilter">
                                            <label class="form-check-label" for="allRoom">
                                                All Rooms
                                            </label>
                                        </div>

                                    </div>
                                    <p class="small mt-2" id="selectedRoomCountExport">0 Room Selected</p>
                                    <div id="err-selectRoomFilter" class="text-danger d-none">
                                        Please select a valid Room.
                                    </div>
                                    <div class="col-sm-12">


                                        <label for="selectRoom" class="form-label">Filter by Status</label>
                                        <select class="form-select" id="selectStatusExport"
                                            data-placeholder="-- SELECT STATUS  --" style="width: 100%">
                                            <option value="" selected>ALL</option>
                                            @foreach ($list_status as $item)
                                                <option value="{{ $item->id }}"> {{ $item->status_name_eng }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>


                                </div>


                                <div class="row mb-3">
                                    <div class="col-sm-12" id="filtertime">


                                        <div class="col-sm-6">
                                            <p>Filter by Time</p>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" style="width: 20px; height: 20px;"
                                                    type="radio" name="timeFilterExport" id="rdlast7daysExport"
                                                    value="1" checked>
                                                <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                                    for="rdlast7days">Last 7 Days</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" style="width: 20px; height: 20px;"
                                                    type="radio" id="rdlast30daysExport" value="2"
                                                    name="timeFilterExport">
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
                            <button type="button" class="btn btn-link" id="btnResetExport"
                                style="text-decoration: none;">Reset</button>
                            <button type="button" id="btnExportResult" class="btn btn-primary">Export</button>
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
                                        <label for="multitabs2" class="tabs" id="tab2" style="cursor: pointer"
                                            id="participantLabel">
                                            <div id="participantLabel"></div>
                                        </label>
                                        <label for="multitabs3" class="tabs" id="tab3"
                                            style="cursor: pointer">History Status</label>
                                        <label for="multitabs4" class="tabs" id="tab4"
                                            style="cursor: pointer">Response</label>
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
                                                            <td id="ProjectNameDetailText" style="color: black;">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 250px; color: gray;">Customer Name</td>
                                                            <td id="CustomerNameDetailText" style="color: black;">
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

                                                <div class="col-2">
                                                    <button type="button" id="btnAttendance" data-bs-dismiss="modal"
                                                        class="btn btn-outline-danger rounded-3 float-end">Edit
                                                        Attendance</button>
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
                                                <div class="col-sm-2">
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
                                                <div class="response col-12">
                                                    <p>Add Response</p>
                                                    <form id="formTanggapan" method="post" action="#">
                                                        @csrf
                                                        <textarea id="txDeskripsiResponse" name="txDeskripsiResponse"></textarea>
                                                        <input id="meetingIdResponse" name="meetingIdResponse" hidden>

                                                        <div id="err-response" class="text-danger d-none mt-2">
                                                            This field Reason is required!
                                                        </div>
                                                        <button class="btn btn-primary float-end d-none" type="button"
                                                            id="SpinnerBtnResponse">
                                                            <span class="spinner-border spinner-border-sm" role="status"
                                                                aria-hidden="true"></span>
                                                            Loading...
                                                        </button>
                                                        <button type="submit" id="btnResponse"
                                                            class="btn btn-primary float-end mt-2">Save
                                                            Changes</button>
                                                    </form>
                                                </div>






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
                        <div class="modal-footer">


                            <button type="button" id="btnCancel" class="btn btn-link" style="text-decoration: none;"
                                data-bs-dismiss="modal">Cancel Meeting</button>

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
                                        <p class="mt-4">Host</p>
                                        <!-- <select id="ParticipantList"></select> -->
                                        <input type="text" id="HiddenHostEdit" hidden>
                                        <select class="form-select" id="selectHostEdit" name="hostEdit" disabled>
                                            @foreach ($list_participant as $item)
                                                <option value="{{ $item->badge_id }}">
                                                    {{ $item->fullname }}
                                                    ({{ $item->position_name }})
                                                </option>
                                            @endforeach

                                        </select>

                                        <div id="err-selectHostEdit" class="text-danger d-none">
                                            Host field is required.
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <p class="mt-4">Participant</p>
                                        <!-- <select id="ParticipantList"></select> -->
                                        <select class="form-select" id="selectParticipanEdit" name="badge_id[]" multiple>
                                            @foreach ($list_participant as $item)
                                                <option value="{{ $item->badge_id }}">{{ $item->fullname }}
                                                    ({{ $item->position_name }})
                                                </option>
                                            @endforeach

                                        </select>



                                        {{-- tes menggunakan lazy_loading --}}
                                        {{-- <select class="form-select" id="selectParticipanEdit" name="badge_id[]" multiple>
                                        </select> --}}


                                        <p class="small mt-2" id="selectedParticipantCount">0 Participant Selected</p>
                                        <div id="err-selectParticipanEdit" class="text-danger d-none">
                                            Participant field is required.
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
                                            <input class="form-control" id="statusEdit" name="statusEdit" hidden>
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
                                <div class="col-sm-12 mt-2">
                                    <label for="MeetingExtension" class="form-label">Extension No</label>
                                    <input class="form-control" id="ExtensionEdit" name="ExtensionEdit"
                                        placeholder="Input Extension No"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, ''); if (this.value.length > 13) this.value = this.value.slice(0, 13);">
                                    <!-- <input class="form-control" id="meetingIdAdd" name="MeetingId" hidden> -->
                                    <div id="err-MeetingExtensionEdit" class="text-danger d-none">
                                        Extension No field is required.
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-2">
                                    <div class="row">
                                        <label for="ProyekName" class="form-label">Is this related to the Project?</label>
                                    </div>

                                    <div class="form-check form-check-inline">

                                        <input class="form-check-input" style="width: 20px; height: 20px;" type="radio"
                                            name="timeFilter" id="yesRadioEdit" value="yes"
                                            onclick="showInputEdit()">
                                        <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                            for="rdlast7days">Yes</label>

                                    </div>
                                    <div class="form-check form-check-inline">

                                        <input class="form-check-input" style="width: 20px; height: 20px;" type="radio"
                                            name="timeFilter" id="noRadioEdit" value="no" onclick="hideInputEdit()"
                                            checked>
                                        <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                            for="rdlast7days">No</label>

                                    </div>
                                </div>

                                <div id="ProjectInputEdit" class="col-sm-12 mt-2">
                                    <label for="ProjectName" class="form-label">Project Name</label>
                                    <input class="form-control" id="ProjectNameEdit" name="ProjectNameEdit"
                                        placeholder="Insert Project Name">
                                    <!-- <input class="form-control" id="meetingIdAdd" name="MeetingId" hidden> -->

                                </div>
                                <div class="col-sm-12 mt-2">
                                    <div class="row">
                                        <label for="ProyekName" class="form-label">Any Guest?</label>
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2">


                                    <div class="form-check form-check-inline">

                                        <input class="form-check-input" style="width: 20px; height: 20px;" type="radio"
                                            name="guestRadioEdit" id="YesGuestRadioEdit" value="yes" onclick="showInputGuestEdit()"
                                            checked>
                                        <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                            for="rdlast7days">Yes</label>

                                    </div>
                                    <div class="form-check form-check-inline">

                                        <input class="form-check-input" style="width: 20px; height: 20px;" type="radio"
                                            name="guestRadioEdit" id="NoGuestRadioEdit" value="no" onclick="hideInputGuestEdit()"
                                            >
                                        <label class="form-check-label" style="font-size: 15px; margin-left: 5px;"
                                            for="rdlast7days">No</label>

                                    </div>
                                </div>
                                <div id="customertNameEdit" class="col-sm-12 mt-2 mb-2">
                                    <label for="customertNameEdit" class="form-label">Customer Name (Optional)</label>
                                    <input class="form-control" id="customerNameEditField" name="customerNameEditField"
                                        placeholder="Insert Customer Name">

                                        <div class="col-sm-12">
                                            <label for="Description" class="form-label">Description (Optional)</label>
                                            <input class="form-control" id="descDetailEdit" name="Desc">
                                        </div>
                                        <div>
                                            <span class="">Visitor</span>
                                            <div class="input-group mt-2">
                                                <input type="number" class="form-control"
                                                    id="othersvisitorEdit" name="othersvisitorEdit"
                                                    min="1" max="99" step="1"
                                                    oninput="checkInputLength(this)">
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <span class="">Facilities</span>
                                            {{-- dinamis fasilitas --}}
                                            @foreach ($list_facilities as $item)
                                                <div class="form-check mt-2">
                                                    <input class="form-check-input menuCheckE" type="checkbox"
                                                        data-facilities="{{ $item->id }}" value=""
                                                        id="facilities_edit_{{ $item->id }}"
                                                        name="facilities_edit_{{ $item->id }}">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{ $item->fasilitas }}
                                                    </label>
                                                </div>
                                            @endforeach

                                        </div>
                                </div>





                                <div class="modal-footer">
                                    <button type="button" class="btn btn-link" data-bs-target="#modalDetail"
                                        data-bs-toggle="modal" id="btn-close" data-bs-dismiss="modal"
                                        style="text-decoration: none;">Back</button>
                                    <button class="btn btn-primary d-none" type="button" id="SpinnerBtnEdit">
                                        <span class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        Loading...
                                    </button>
                                    <button type="submit" id="btnSimpanReschedule" class="btn btn-primary">Save
                                        Changes</button>
                                </div>
                            </form>

                        </div>


                    </div>
                </div>
            </div>
            <!-- end modal Detail Reschedule-->

            <!-- modal Edit Attendance-->
            <div class="modal fade" id="modalAttendance" tabindex="-">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalFilterTitle">Edit Attendance</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px; overflow:auto; max-height: 700px;">
                            <form id="formAdd" method="post" autocomplete="off">
                                @csrf
                                <input class="form-control" type="text" id="meetingIdAttend" name="meetingIdAttend"
                                    hidden>

                                <div id="listOfParticipantAttend">
                                </div>


                            </form>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-primary d-none" type="button" id="SpinnerBtnAttend">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Loading...
                            </button>
                            <div class="col-2"> <button type="button" class="btn btn-link"
                                    data-bs-target="#modalDetail" data-bs-toggle="modal" id="btn-close"
                                    data-bs-dismiss="modal" style="text-decoration: none;">Back</button></div>
                            <button type="submit" id="btnSimpanAttend" class="btn btn-primary">Save Changes</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end modal Edit Attendance-->

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
                        <button id="btnExport" style="font-size: 16px;" type="button"
                            class="btn btn-outline-danger rounded-3">
                            Export Data
                        </button>
                        <button id="btnAdd" style="font-size: 16px;" type="button" class="btn btn-danger rounded-3">
                            Add Meeting
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
    @include('meeting.add_JS')
    @include('meeting.filter_JS')
    @include('meeting.export_JS')
    @include('meeting.cancel_JS')
    @include('meeting.response_JS')
    @include('meeting.attendance_JS')

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







        // insialisasi
        $('#RoomDetailEdit').select2({
            theme: "bootstrap-5",

        });





        $('#selectRoom').select2({
            theme: "bootstrap-5",

        });
        $('#selectRoomExport').select2({
            theme: "bootstrap-5",

        });
        $('#selectRoom2').select2({
            theme: "bootstrap-5",

        });
        $('#selectRoom3').select2({
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

        //     // validasi select room
        //     const selectRoom = $('#selectRoom1').val();
        //     if (selectRoom === '') {
        //         $('#err-selectRoomFilter').removeClass('d-none');
        //         return;
        //     } else {
        //         $('#err-selectRoomFilter').addClass('d-none');

        //     }
        //     // validasi filter time
        //     const filtertime = $('#filtertime').val();
        //     if (filtertime === '') {
        //         $('#err-filtertime').removeClass('d-none');
        //         return;
        //     } else {

        //         $('#err-filtertime').addClass('d-none');

        //     }

        //     // Cek apakah semua validasi telah terpenuhi
        //     if ($('#err-selectRoomFilter').hasClass('d-none') && $('#err-filtertime').hasClass('d-none')) {
        //         modalFormFilter.modal('hide');
        //     }

        //     // fungsi ketika modal add close
        //     $('#modalFilter').on('hidden.bs.modal', function(event) {
        //         console.log($('#selectRoom1').val());
        //         console.log($('#filtertime').val());
        //         $('#selectRoom1').val(null).trigger('change');
        //         $('#filtertime').val(null).trigger('change');
        //         $('#formFilterListMeeting')[0].reset();


        //         $('#err-selectRoomFilter').addClass('d-none');
        //         $('#err-filtertime').addClass('d-none');

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
            // console.log($('#MeetingTitle').val());
            // console.log($('#selectRoom5').val());
            // console.log($('#DateMeetingDetail').val());
            // console.log($('#StartMeetingDetail').val());
            // console.log($('#FinishMeetingDetail').val());
            // console.log($('#description').val());
            // console.log($('#selectParticipan').val());
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

        // fungsi max inputan 2 digit
        function checkInputLength(input) {
            if (input.value.length > 2 || input.value > 20) {
                input.value = input.value.slice(0, 2);
            }
        }
    </script>

@endsection
