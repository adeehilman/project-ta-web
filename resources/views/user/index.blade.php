@extends('layouts.app')
@section('title', 'User')

@section('content')
    <div class="wrappers">
        <!-- All Modals -->


        {{-- Modal Add User --}}
        <div class="modal fade" id="modalAddUser" tabindex="-1" aria-labelledby="modalAddUserLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddUserLabel">Add User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="formAddUser">
                            @csrf
                            {{-- Nama dan No Employee --}}
                            <div class="col-sm-12">
                            <label for="selectEmployeeAdd" class="form-label">Employee</label>
                                    <select class="form-select" id="selectEmployeeAdd" name="badge_id" placeholder=" Select Employee " style="width: 100%">
                                    <option value="" selected disabled>Select Employee</option>
                                        @foreach ($list_employee as $item)
                                            <option value="{{ $item->badge_id }}">{{ $item->badge_id }} - {{ $item->fullname }}</option>
                                        @endforeach
                                    </select>

                                    <div id="err-employeeAdd" class="text-danger d-none">
                                    Please Select Employee !
                                </div>
                            </div>

                            {{-- Select Position --}}
                            <div class="mt-4">
                                <label for="selectPositionAdd" class="form-label">Position</label>
                                <select class="form-select" id="selectPositionAdd" name="user_level"
                                    placeholder="Choose Position" style="width: 465px; min-width: 465px;">
                                    <option value="" selected disabled>Select Position</option>
                                    @foreach ($list_position as $item)
                                        <option value="{{ $item->id_vlookup }}">{{ $item->name_vlookup }}</option>
                                    @endforeach
                                </select>

                                {{-- Peringatan jika select masih default tanpa diisi --}}
                                <div id="err-positionAdd" class="text-danger d-none">
                                    Please Select Position !
                                </div>
                            </div>
                            {{-- Button --}}
                            <div class="d-flex justify-content-end mt-3 gap-3">
                                <button type="button" class="btn text-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Add User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Edit User --}}
        <div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalEditUserLabel">Edit User</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="formEditUser">
                            {{-- Nama Employee --}}
                            <div class="col-sm-12">
                            <label for="selectEmployeeEdit" class="form-label">Employee</label>
                                <input type="text" name="badge_id" hidden>
                                    <select class="form-select" id="selectEmployeeEdit" name="badge_id" placeholder=" Select Employee " style="width: 100%" disabled>
                                    <option value="" selected disabled>Select Employee</option>
                                        @foreach ($list_employee as $item)
                                            <option value="{{ $item->badge_id }}">{{ $item->badge_id }} - {{ $item->fullname }}</option>
                                        @endforeach
                                    </select>

                                    <div id="err-employeeEdit" class="text-danger d-none">
                                    Please Select Employee !
                                    </div>
                            </div>
                            {{-- Select Position --}}
                            <div class="mt-4">
                                <label for="editPosition" class="form-label">Position</label>
                                <select class="form-select" id="editPosition" name="user_level"
                                    placeholder="Choose Position" style="width: 465px; min-width: 465px;">
                                    <option value="" selected disabled>Select Position</option>
                                    @foreach ($list_position as $item)
                                        <option value="{{ $item->id_vlookup }}">{{ $item->name_vlookup }}</option>
                                    @endforeach
                                </select>
                                <div id="err-positionEdit" class="text-danger d-none">
                                    Please Select Position !
                                </div>
                            </div>
                            {{-- Select Status --}}
                            <div class="mt-4">
                            <label for="editStatus" class="form-label">Status Account</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editStatus" name="is_active">
                                    <label class="form-check-label" for="editStatus">Active</label>
                                </div>
                                <div id="err-statusEdit" class="text-danger d-none">
                                    Please Select Position !
                                </div>
                            </div>
                            {{-- Button --}}
                            <div class="d-flex justify-content-end mt-3 gap-3">
                                <button type="button" class="btn text-danger" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- End All Modals --}}



        {{-- Main --}}
        <div class="wrapper_content">
            <div class="row me-1">
                <div class="col-sm-6">
                    <p class="h3 mt-6">
                        User
                    </p>
                </div>

                {{--  --}}
                <div class="col-sm-12 mt-3 d-flex justify-content-between">
                    <div class="d-flex gap-3">
                        {{-- Search --}}
                        <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"
                            class="form-control rounded-3" placeholder="Search">
                        {{-- Select Position --}}
                        <select class="form-select" id="selectPosition" name="position" placeholder="Choose Position"
                            style="width: 250px; min-width: 250px;">
                            <option value="" selected disabled>All Position</option>
                            @foreach ($list_position as $item)
                                <option value="{{ $item->id_vlookup }}">{{ $item->name_vlookup }}</option>
                            @endforeach
                        </select>


                        {{-- Button Reset --}}
                        <button type="button" class="btn btn-outline-secondary" id="btnReset">
                            <div class="d-flex align-items-center gap-1">
                                <i class='bx bx-refresh bx-rotate-90 fs-4'></i>
                                Reset
                            </div>
                        </button>
                    </div>
                    {{-- Button Add User --}}
                    <div class="d-flex gap-1">
                        <button id="btnAdd" style="font-size: 16px;" type="button" class="btn btn-primary rounded-3"
                            data-bs-toggle="modal">
                            Add User
                        </button>
                    </div>

                </div>

                {{-- Table --}}
                <div id="containerUser" class="col-sm-12 mt-3">
                    <!-- <table id="tableUser" class="table table-responsive table-hover" style="font-size: 16px">
                                <thead>
                                    <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                                        <th class="p-3" scope="col">No</th>
                                        <th class="p-3" scope="col">Employee No</th>
                                        <th class="p-3" scope="col">Name</th>
                                        <th class="p-3" scope="col">Position</th>
                                        <th class="p-3" scope="col">Status</th>
                                        <th class="p-3" scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="p-3">1</td>
                                        <td class="p-3">031844</td>
                                        <td class="p-3">Sarah</td>
                                        <td class="p-3">Administrative Assistant</td>
                                        <td class="p-3 text-success fw-bold">Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">2</td>
                                        <td class="p-3">000547</td>
                                        <td class="p-3">Lisa</td>
                                        <td class="p-3">Administrative Coordinator</td>
                                        <td class="p-3 text-success fw-bold">Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">3</td>
                                        <td class="p-3">033788</td>
                                        <td class="p-3">Maria</td>
                                        <td class="p-3">Administrative Executive</td>
                                        <td class="p-3 text-success fw-bold">Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">4</td>
                                        <td class="p-3">000376</td>
                                        <td class="p-3">Jessica</td>
                                        <td class="p-3">Executive Secretary</td>
                                        <td class="p-3 text-success fw-bold">Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">5</td>
                                        <td class="p-3">007035</td>
                                        <td class="p-3">Kunarti</td>
                                        <td class="p-3">Manager</td>
                                        <td class="p-3 text-success fw-bold">Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">6</td>
                                        <td class="p-3">031844</td>
                                        <td class="p-3">Sarah</td>
                                        <td class="p-3">Administrative Assistant</td>
                                        <td class="p-3 text-success fw-bold">Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">7</td>
                                        <td class="p-3">000547</td>
                                        <td class="p-3">Lisa</td>
                                        <td class="p-3">Administrative Coordinator</td>
                                        <td class="p-3 text-success fw-bold">Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">8</td>
                                        <td class="p-3">033788</td>
                                        <td class="p-3">Maria</td>
                                        <td class="p-3">Administrative Executive</td>
                                        <td class="p-3 text-success fw-bold">Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">9</td>
                                        <td class="p-3">000376</td>
                                        <td class="p-3">Jessica</td>
                                        <td class="p-3">Executive Secretary</td>
                                        <td class="p-3 text-success fw-bold">Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">10</td>
                                        <td class="p-3">007035</td>
                                        <td class="p-3">Kunarti</td>
                                        <td class="p-3">Manager</td>
                                        <td class="p-3 text-success fw-bold">Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">11</td>
                                        <td class="p-3">031844</td>
                                        <td class="p-3">Sarah</td>
                                        <td class="p-3">Administrative Assistant</td>
                                        <td class="p-3 text-success fw-bold">Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">12</td>
                                        <td class="p-3">000547</td>
                                        <td class="p-3">Lisa</td>
                                        <td class="p-3">Administrative Coordinator</td>
                                        <td class="p-3 text-danger fw-bold">Non Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">13</td>
                                        <td class="p-3">033788</td>
                                        <td class="p-3">Maria</td>
                                        <td class="p-3">Administrative Executive</td>
                                        <td class="p-3 text-danger fw-bold">Non Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">14</td>
                                        <td class="p-3">000376</td>
                                        <td class="p-3">Jessica</td>
                                        <td class="p-3">Executive Secretary</td>
                                        <td class="p-3 text-danger fw-bold">Non Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="p-3">15</td>
                                        <td class="p-3">007035</td>
                                        <td class="p-3">Kunarti</td>
                                        <td class="p-3">Manager</td>
                                        <td class="p-3 text-danger fw-bold">Non Active</td>
                                        <td>
                                            <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUser"><img src="{{ asset('icons/edit.svg') }}"></a>
                                        </td>
                                    </tr> -->
                    <!-- </tbody> -->
                    <!-- </table> -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    @include('user.ListAndSearch_JS')
    @include('user.FilterJS')
    @include('user.Add_JS')
    @include('user.EditJS')


    <script>
        // Script untuk validasi form dan reset data pada modal Edit User
        $(document).ready(function() {
            $('#modalEditUser').on('show.bs.modal', function() {
                $('#formEditUser')[0].reset();
                $('#editName, #editEmployeeNo').removeClass('is-invalid');
            });

            $('#formEditUser').submit(function(event) {
                let name = $('#editName').val();
                let email = $('#editEmployeeNo').val();
                let isValid = true;

                if (!name) {
                    $('#editName').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#editName').removeClass('is-invalid');
                }

                if (!email) {
                    $('#editEmployeeNo').addClass('is-invalid');
                    isValid = false;
                } else {
                    $('#editEmployeeNo').removeClass('is-invalid');
                }

                if (!isValid) {
                    event.preventDefault();
                }
                if (isValid) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Confirmation',
                        icon: 'warning',
                        text: 'Do you want to edit the Data User ?',
                        showCancelButton: true,
                        cancelButtonText: 'No',
                        confirmButtonText: 'Yes',
                        confirmButtonColor: '#CD202e',
                        reverseButtons: true,
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Data User has been updated',
                                confirmButtonColor: '#CD202e',
                            });
                            $('#modalEditUser').modal('hide');
                        }
                    });
                }
            });
        });

        // Jquery untuk Button reset
        $(document).ready(function() {
            $('#resetButton').hide();
            $('#selectPosition').change(function() {
                if ($(this).val() === 'allPosition') {
                    $('#resetButton').hide();
                } else {
                    $('#resetButton').show();
                }
            });

            // ketika button reset ditekan maka akan kembali ke opsi all position
            $('#resetButton').click(function() {
                $('#selectPosition').val('allPosition');
                $(this).hide();
            });
        });

        // untuk max length input employee no
        function checkInputLength(input) {
            if (input.value.length > 6 || input.value > 999999) {
                input.value = input.value.slice(0, 6);
            }
        }
    </script>

@endsection
