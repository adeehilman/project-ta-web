@extends('layouts.app')
@section('title', 'Detail Meeting Summary')

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
                                        <label for="multitabs1" class="active" id="tab1" style="cursor: pointer">Info
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
            <div class="row me-1">
                <div class="col-sm-6">
                    <a href="{{ route('meetingSummary') }}" style="text-decoration: none">
                        <span class="text-muted fs-6">
                            <img src="{{ asset('icons/left.svg') }}"> Back to Meeting Summary</span>
                    </a>
                </div>

                <div class="col-sm-12 mt-2 d-flex justify-content-between">
                    <p class="h3 mt-6">
                        Detail Meeting Summary
                    </p>
                    <div class="d-flex gap-1">
                        <button id="btnExportsDetail" type="button" style="font-size: 16px; margin-right: 5px;"
                            class="btn btn-outline-primary rounded-3">
                            Export Data
                        </button>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-6">
                        {{-- <h5 class="text-center">No History</h5> --}}
                        <table class="ms-2" style="font-size: 16px; line-height: 2;">
                            <tr>
                                <td style="width: 300px; color: gray;">Name</td>
                                <td id="Fullname" style="color: black;">{{ $total->fullname }}</td>
                            </tr>
                            <tr>
                                <td style="width:  300px; color: gray;">Employee No</td>
                                <td id="EmployeeNo" style="color: black;">{{ $total->participant }}</span></td>
                            </tr>
                            <tr>
                                <td style="width:  300px; color: gray;" hidden>HIdden</td>
                                <td id="ParticipantBadge" style="color: black;" hidden>{{ $total->meeting_dates }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 300px; color: gray;">Department</td>
                                <td id="DeptName" style="color: black;">{{ $total->dept_name }}</td>
                            </tr>
                            <tr>
                                <td style="width: 300px; color: gray;">Time</td>
                                <td id="TimeDetail" style="color: black;">{{ $time }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-6">
                        {{-- <h5 class="text-center">No History</h5> --}}
                        <table class="ms-2" style="font-size: 16px; line-height: 2;">
                            <tr>
                                <td style="width: 300px; color: gray;">

                                    Total Meetings
                                </td>
                                <td style="color: black;">{{ $total->tot_meeting }}</td>
                            </tr>
                            <tr>
                                <td style="width:  300px; color: gray;">Total Attendance</td>
                                <td style="color: black;">{{ $total->kehadiran }}</td>
                            </tr>
                            <tr>
                                <td style="width: 300px; color: gray;">Total Absent</td>
                                <td style="color: black;">{{ $total->absent }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Table --}}
                <div id="containerDetailSummary" class="col-sm-12 mt-3">
                    <table id="tableDetailSummary" class="table table-responsive table-hover" style="font-size: 16px">
                        <thead>
                            <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                                <th class="p-3" scope="col">Meeting Title</th>
                                <th class="p-3" scope="col">Room</th>
                                <th class="p-3" scope="col">Meeting Date</th>
                                <th class="p-3" scope="col">Start Meeting</th>
                                <th class="p-3" scope="col">Finished Meeting</th>
                                <th class="p-3" scope="col">Attendance Status</th>
                                <th class="p-3" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list_data as $item)
                                <tr>
                                    <td class="p-3">{{ $item->title_meeting }}</td>
                                    <td class="p-3">{{ $item->room_name }}</td>
                                    <td class="p-3">{{ date('d F Y', strtotime($item->meeting_date)) }}</td>
                                    <td class="p-3">{{ date('H:i', strtotime($item->meeting_start)) }}</td>
                                    <td class="p-3">{{ date('H:i', strtotime($item->meeting_end)) }}</td>
                                    @if ($item->kehadiran == 1)
                                        <td class="p-3">Attendance</td>
                                    @else
                                        <td class="p-3">Absent</td>
                                    @endif
                                    <td class="p-3">
                                        <a id="btnDetail" class="btn btnDetail" data-id={{ $item->meetingId }}><img
                                                src="{{ asset('icons/eye.svg') }}">
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    @include('meetingreport.meetingsummary.detailsummary.infoDetail_JS')
    @include('meetingreport.meetingsummary.detailsummary.export_JS')

@endsection
