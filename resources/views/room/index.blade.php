@extends('layouts.app')
@section('title', 'List Room')

@section('content')


    <style>
        .custom-file-label::after {
            content: "Browse";
        }

        .custom-file-label.browse::after {
            content: "Browse";
        }
    </style>
    <div class="wrappers">
        <div class="wrapper_content">

            {{-- All Modals --}}

            <!-- modal Add Room Meeting-->
            <div class="modal fade" data-bs-backdrop="static" id="modalAddRoom" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Add Room</h1>
                            <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px;">
                            <form id="formAddRoom" autocomplete="off">
                                @csrf
                                <div class="row">
                                    {{-- Room Name --}}
                                    <div class="col-sm-12">
                                        <label for="addRoomName" class="form-label">Room</label>
                                        <input class="form-control" id="addRoomName" name="room_name"
                                            placeholder="Insert Room Name">
                                        {{-- Peringatan jika inputan kosong --}}
                                        <div id="err-RoomName" class="text-danger d-none">
                                            Please Insert Room Name !
                                        </div>
                                    </div>
                                    {{-- Select Floor --}}
                                    <div class="col-sm-12 mt-3">
                                        <label for="addSelectFloor" class="form-label">Floor</label>
                                        <input type="number" class="form-control" id="addSelectFloor" name="floor"
                                            placeholder="Insert Floor" value="selectfloor" min="1" max="20"
                                            step="1" oninput="checkInputLength(this)">



                                        {{-- Peringatan jika select masih kosong --}}
                                        <div id="err-SelectFloor" class="text-danger d-none">
                                            Please Select Floor !
                                        </div>
                                    </div>
                                    {{-- Input Capacity --}}
                                    <div class="col-sm-12 mt-3">
                                        <label for="addCapacityRoom" class="form-label">Capacity</label>
                                        <div class="row align-items-center">
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" id="addCapacityRoom"
                                                    name="capacity" placeholder="Insert Capacity" value="selectcapacity"
                                                    min="1" max="99" step="1"
                                                    oninput="checkInputLength(this)">

                                                {{-- Peringatan jika inputan kosong --}}
                                                <div id="err-Capacity" class="text-danger d-none">
                                                    Please Insert Capacity Room !
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <span>People</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mt-3">
                                                                            </div>
                                </div>
                                {{-- Input Image Room --}}
                                <div class="col-sm-12 mt-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" id="addImage1" name="roomimage_1" class="form-control mb-3">

                                    {{-- Peringatan jika inputan kosong --}}
                                    <div id="err-RoomImage1" class="text-danger d-none">
                                        Please Upload Image MAX 10 MB !
                                    </div>

                                </div>

                                <div class="col-sm-12 mt-3">
                                    <input type="file" id="addImage2" name="roomimage_2" class="form-control mb-3">

                                    {{-- Peringatan jika inputan kosong --}}
                                    <div id="err-RoomImage2" class="text-danger d-none">
                                        Please Upload Image MAX 10 MB !
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-3">
                                    <input type="file" id="addImage3" name="roomimage_3" class="form-control mb-3">

                                    {{-- Peringatan jika inputan kosong --}}
                                    <div id="err-RoomImage3" class="text-danger d-none">
                                        Please Upload Image MAX 10 MB !
                                    </div>
                                </div>


                                <div class="float-end">
                                    <button type="button" class="btn text-danger" data-bs-dismiss="modal">Cancel</button>
                                    <button id="btnTambah" type="submit" class="btn btn-primary">Add Room</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal Add Room Meeting-->

            <!-- modal detail room -->
            <div class="modal fade" data-bs-keyboard="false" id="modalDetailRoom" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered" style="max-width: 800px;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" style="margin-left: 20px;" id="modalDetailTitle">Detail
                                Room</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px; margin-left: 20px;">
                            <form id="formDetailRoom">
                                <table class="ms-2" style="font-size: 16px; line-height: 2.4;">
                                    <tr>
                                        <td style="width: 250px; color: gray;">Room</td>
                                        <td style="color: black;" id="detailRoomName" name="room_name"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 250px; color: gray;">Floor</td>
                                        <td style="color: black;" id="detailSelectFloor" name="floor"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 250px; color: gray;">Capacity</td>
                                        <td style="color: black;">
                                            <span id="detailCapacityRoom" name="capacity"></span> People
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        <td style="width: 250px; color: gray;">Dept Room</td>
                                        <td style="color: black;" id="detailDept" name="detailDept"></td>
                                    </tr> --}}
                                    <tr>
                                        <td style="width: 250px; color: gray;">Image</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <img id="detailImage1" name="roomimage_1" alt="Room Image"
                                                style="max-width: 100%; height: auto; max-height: 100px; border-radius: 10px; margin-right: 10px; cursor: pointer;">
                                            <img id="detailImage2" name="roomimage_2" alt="Room Image"
                                                style="max-width: 100%; height: auto; max-height: 100px; border-radius: 10px; margin-right: 10px; cursor: pointer;">
                                            <img id="detailImage3" name="roomimage_3" alt="Room Image"
                                                style="max-width: 100%; height: auto; max-height: 100px; border-radius: 10px; cursor: pointer;">
                                        </td>
                                    </tr>
                                </table>
                                <br>
                                <br>
                                <br>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="detailId" name="detailId">
                            <button id="btnEditDetail" type="button" class="btn btn-outline-danger">
                                Edit Room
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal detail room-->

            <!-- modal Edit Room Meeting-->
            <div class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" id="modalEditRoom"
                tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5">Edit Room</h1>
                            <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 16px;">
                            <form action="" id="formEditRoom" enctype="multipart/form-data" method="post">
                                <div class="row">
                                    {{-- Room Name --}}
                                    <div class="col-sm-12">
                                        <label for="editRoomName" class="form-label">Room</label>
                                        <input class="form-control" id="editRoomName" name="room_name"
                                            placeholder="Insert Room Name">
                                        {{-- Peringatan jika inputan kosong --}}
                                        <div id="err-RoomName2" class="text-danger d-none">
                                            Please Insert Room Name !
                                        </div>
                                    </div>
                                    {{-- Select Floor --}}
                                    <div class="col-sm-12 mt-3">
                                        <label for="editSelectFloor" class="form-label">Floor</label>
                                        <input type="number" class="form-control" placeholder="Select Floor"
                                            name="floor" id="editSelectFloor" min="1" max="20"
                                            step="1" oninput="checkInputLength(this)">

                                        {{-- Peringatan jika select masih kosong --}}
                                        <div id="err-SelectFloor2" class="text-danger d-none">
                                            Please Select Floor !
                                        </div>
                                    </div>
                                    {{-- Input Capacity --}}
                                    <div class="col-sm-12 mt-3">
                                        <label for="editCapacityRoom" class="form-label">Capacity</label>
                                        <div class="row align-items-center">
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" id="editCapacityRoom"
                                                    name="capacity" placeholder="Insert Capacity" value="selectcapacity"
                                                    min="1" max="99" step="1"
                                                    oninput="checkInputLength(this)">
                                                {{-- Peringatan jika inputan kosong --}}
                                                <div id="err-Capacity2" class="text-danger d-none">
                                                    Please Insert Capacity Room !
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <span>People</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">

                                  </select>
                                    {{-- Peringatan jika inputan kosong --}}
                                    <div id="err-RoomName2" class="text-danger d-none">
                                        Please Insert Room Name !
                                    </div>
                                </div>
                                {{-- Input Image Room --}}
                                <div class="col-sm-12 mt-3">
                                    <label class="form-label">Image</label>

                                    <div class="input-group mb-3">
                                        <button class="btn btn-outline-secondary image1trigger" type="button">Choose
                                            File</button>
                                        <input type="file" class="hidden-xs-up" name="roomimageedit_1"
                                            id="editImage1" hidden />
                                        <input type="text" class="form-control image1trigger"
                                            placeholder="No file chosen" readonly />
                                    </div>

                                    {{-- Peringatan jika inputan kosong --}}
                                    <div id="err-RoomEditImage1" class="text-danger d-none">
                                        Please Upload Image MAX 10 MB !
                                    </div>

                                </div>

                                <div class="col-sm-12 mt-3">

                                    <div class="input-group mb-3">
                                        <button class="btn btn-outline-secondary image2trigger" type="button">Choose
                                            File</button>
                                        <input type="file" class="hidden-xs-up" name="roomimageedit_2"
                                            id="editImage2" hidden />
                                        <input type="text" class="form-control image2trigger"
                                            placeholder="No file chosen" readonly />
                                    </div>

                                    {{-- Peringatan jika inputan kosong --}}
                                    <div id="err-RoomEditImage2" class="text-danger d-none">
                                        Please Upload Image MAX 10 MB !
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-3">

                                    <div class="input-group mb-3">
                                        <button class="btn btn-outline-secondary image3trigger" type="button">Choose
                                            File</button>
                                        <input type="file" class="hidden-xs-up" name="roomimageedit_3"
                                            id="editImage3" hidden />
                                        <input type="text" class="form-control image3trigger"
                                            placeholder="No file chosen" readonly />
                                    </div>

                                    {{-- Peringatan jika inputan kosong --}}
                                    <div id="err-RoomEditImage3" class="text-danger d-none">
                                        Please Upload Image MAX 10 MB !
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-3 gap-3">
                                    <input type="hidden" id="editId" name="editId">
                                    <button type="button" class="btn text-danger"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" id="btnEdit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal Edit Room Meeting-->


            <!-- {{-- Modal Delete --}}
                                                                                                            <div class="modal fade" id="modalDeleteRoom" tabindex="-1">
                                                                                                                <div class="modal-dialog modal-dialog-centered">
                                                                                                                    <div class="modal-content">
                                                                                                                        <div class="modal-header">
                                                                                                                            <h1 class="modal-title fs-5">Delete Room</h1>
                                                                                                                            <button type="button" class="btn-close" id="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                                                                        </div>
                                                                                                                        <div class="modal-body">
                                                                                                                            <img src="{{ asset('images/deleteModal.png') }}" alt="delete image" class="w-25 mx-auto d-block">
                                                                                                                            <h5 class="text-center mt-3">Are you sure want to delete room ?</h5>
                                                                                                                            <p class="mb-0 text-center">Data that has been deleted cannot be recovered.</p>
                                                                                                                            <div class="d-flex justify-content-center mt-5 gap-3">
                                                                                                                                <button type="button" class="btn text-danger" data-bs-dismiss="modal">No, keep it up</button>
                                                                                                                                <button type="button" id="deleteButton" class="btn btn-primary" >Yes, Delete</button>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            {{-- End Modal Delete --}} -->

            {{-- End All Modals --}}


            {{-- Main --}}
            <div class="row me-1">
                <div class="col-sm-6">
                    <p class="h3 mt-6">
                        List Room
                    </p>
                </div>

                <div class="col-sm-12 mt-2 d-flex justify-content-between">
                    {{-- Search --}}
                    <div class="d-flex gap-1">
                        <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"
                            class="form-control rounded-3" placeholder="Search here" autocomplete="off">
                    </div>

                    {{-- Button Add Room Meeting --}}
                    <div class="d-flex gap-1">
                        <button style="font-size: 16px;" type="button" class="btn btn-primary rounded-3"
                            id="btnAdd">
                            Add Room Meeting
                        </button>
                    </div>
                </div>

                {{-- Table List Room --}}
                <div id="containerRoom" class="col-sm-12 mt-3">
                    <table id="tableRoom" class="table table-responsive table-hover" style="font-size: 16px">
                        <!-- <thead>
                                                                                                                            <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                                                                                                                                <th class="p-3" scope="col">Room</th>
                                                                                                                                <th class="p-3" scope="col">Floor</th>
                                                                                                                                <th class="p-3" scope="col">Capacity</th>
                                                                                                                                <th class="p-3" scope="col">Action</th>
                                                                                                                            </tr>
                                                                                                                        </thead>
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td class="p-3">Room 1</td>
                                                                                                                                <td class="p-3">Floor 1</td>
                                                                                                                                <td class="p-3">10 People</td>
                                                                                                                                <td>
                                                                                                                                    <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailRoom"> <img src="{{ asset('icons/detail.svg') }}"></a>
                                                                                                                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditRoom"><img src="{{ asset('icons/edit.svg') }}"></a>
                                                                                                                                    <a class="btn btnDelete" data-bs-toggle="modal" data-bs-target="#modalDeleteRoom"><img src="{{ asset('icons/delete.svg') }}"></a>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td class="p-3">Room 2</td>
                                                                                                                                <td class="p-3">Floor 1</td>
                                                                                                                                <td class="p-3">10 People</td>
                                                                                                                                <td>
                                                                                                                                    <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailRoom"> <img src="{{ asset('icons/detail.svg') }}"></a>
                                                                                                                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditRoom"><img src="{{ asset('icons/edit.svg') }}"></a>
                                                                                                                                    <a class="btn btnDelete" data-bs-toggle="modal" data-bs-target="#modalDeleteRoom"><img src="{{ asset('icons/delete.svg') }}"></a>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td class="p-3">Room 3</td>
                                                                                                                                <td class="p-3">Floor 1</td>
                                                                                                                                <td class="p-3">10 People</td>
                                                                                                                                <td>
                                                                                                                                    <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailRoom"> <img src="{{ asset('icons/detail.svg') }}"></a>
                                                                                                                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditRoom"><img src="{{ asset('icons/edit.svg') }}"></a>
                                                                                                                                    <a class="btn btnDelete" data-bs-toggle="modal" data-bs-target="#modalDeleteRoom" ><img src="{{ asset('icons/delete.svg') }}"></a>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td class="p-3">Room 4</td>
                                                                                                                                <td class="p-3">Floor 1</td>
                                                                                                                                <td class="p-3">8 People</td>
                                                                                                                                <td>
                                                                                                                                <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailRoom"> <img src="{{ asset('icons/detail.svg') }}"></a>
                                                                                                                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditRoom"><img src="{{ asset('icons/edit.svg') }}"></a>
                                                                                                                                    <a class="btn btnDelete" data-bs-toggle="modal" data-bs-target="#modalDeleteRoom"><img src="{{ asset('icons/delete.svg') }}"></a>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td class="p-3">Room 5</td>
                                                                                                                                <td class="p-3">Floor 2</td>
                                                                                                                                <td class="p-3">8 People</td>
                                                                                                                                <td>
                                                                                                                                <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailRoom"> <img src="{{ asset('icons/detail.svg') }}"></a>
                                                                                                                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditRoom"><img src="{{ asset('icons/edit.svg') }}"></a>
                                                                                                                                    <a class="btn btnDelete" data-bs-toggle="modal" data-bs-target="#modalDeleteRoom"><img src="{{ asset('icons/delete.svg') }}"></a>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td class="p-3">Room 6</td>
                                                                                                                                <td class="p-3">Floor 2</td>
                                                                                                                                <td class="p-3">8 People</td>
                                                                                                                                <td>
                                                                                                                                <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailRoom"> <img src="{{ asset('icons/detail.svg') }}"></a>
                                                                                                                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditRoom"><img src="{{ asset('icons/edit.svg') }}"></a>
                                                                                                                                    <a class="btn btnDelete" data-bs-toggle="modal" data-bs-target="#modalDeleteRoom"><img src="{{ asset('icons/delete.svg') }}"></a>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td class="p-3">Room 7</td>
                                                                                                                                <td class="p-3">Floor 2</td>
                                                                                                                                <td class="p-3">8 People</td>
                                                                                                                                <td>
                                                                                                                                <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailRoom"> <img src="{{ asset('icons/detail.svg') }}"></a>
                                                                                                                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditRoom"><img src="{{ asset('icons/edit.svg') }}"></a>
                                                                                                                                    <a class="btn btnDelete" data-bs-toggle="modal" data-bs-target="#modalDeleteRoom"><img src="{{ asset('icons/delete.svg') }}"></a>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td class="p-3">Room 8</td>
                                                                                                                                <td class="p-3">Floor 2</td>
                                                                                                                                <td class="p-3">8 People</td>
                                                                                                                                <td>
                                                                                                                                <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailRoom"> <img src="{{ asset('icons/detail.svg') }}"></a>
                                                                                                                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditRoom"><img src="{{ asset('icons/edit.svg') }}"></a>
                                                                                                                                    <a class="btn btnDelete" data-bs-toggle="modal" data-bs-target="#modalDeleteRoom"><img src="{{ asset('icons/delete.svg') }}"></a>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                            <tr>
                                                                                                                                <td class="p-3">Room 9</td>
                                                                                                                                <td class="p-3">Floor 2</td>
                                                                                                                                <td class="p-3">8 People</td>
                                                                                                                                <td>
                                                                                                                                    <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailRoom"> <img src="{{ asset('icons/detail.svg') }}"></a>
                                                                                                                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditRoom"><img src="{{ asset('icons/edit.svg') }}"></a>
                                                                                                                                    <a class="btn btnDelete" data-bs-toggle="modal" data-bs-target="#modalDeleteRoom"><img src="{{ asset('icons/delete.svg') }}"></a>
                                                                                                                                </td>
                                                                                                                            </tr>
                                                                                                                        </tbody> -->
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    @include('room.ListAndSearch_JS')
    @include('room.addJS')
    @include('room.deleteJS')
    @include('room.editJS')
    @include('room.detailJS')

    <script>
        // start gambar
        $(document).on('click', '.image1trigger', function(e) {
            $('#editImage1').click()
        })

        $('#editImage1').change(function(e) {
            var fileName = $(this).val().split("\\").pop()
            $('.image1trigger').val(fileName);
        })

        $(document).on('click', '.image2trigger', function(e) {
            $('#editImage2').click()
        })

        $('#editImage2').change(function(e) {
            var fileName = $(this).val().split("\\").pop()
            $('.image2trigger').val(fileName);
        })

        $(document).on('click', '.image3trigger', function(e) {
            $('#editImage3').click()
        })

        $('#editImage3').change(function(e) {
            var fileName = $(this).val().split("\\").pop()
            $('.image3trigger').val(fileName);
        })
        // end

        // untuk input floor modal add
        function checkInputLength(input) {
            if (input.value.length > 2 || input.value > 20) {
                input.value = input.value.slice(0, 2);
            }
        }
    </script>

@endsection
