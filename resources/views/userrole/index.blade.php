@extends('layouts.app')
@section('title', 'User Role')

@section('content')
<div class="wrappers">

    {{-- Modals --}}

    {{-- Modal Detail User Role --}}
    <div class="modal fade" id="modalDetailUserRole" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDetailUserRoleLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalDetailUserRoleLabel">Detail User Role</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    {{-- Row Nomor Employee --}}
                    <div class="row">
                        <div class="col-lg-5 text-secondary"><p class="mb-0">Employee No</p></div>
                        <div class="col-lg-7"><p class="mb-0">123456</div>
                    </div>
                    {{-- Row Nama Employee --}}
                    <div class="row mt-3">
                        <div class="col-lg-5 text-secondary"><p class="mb-0">Name</p></div>
                        <div class="col-lg-7"><p class="mb-0">Pengguna</p></div>
                    </div>
                    {{-- Row Posisi Employee --}}
                    <div class="row mt-3">
                        <div class="col-lg-5 text-secondary"><p class="mb-0">Position</p></div>
                        <div class="col-lg-7"><p class="mb-0">Administrative Assistant</p></div>
                    </div>
                    {{-- Row Access yang dimilki --}}
                    <div class="row mt-3">
                        <div class="col-lg-5 text-secondary"><p class="mb-0">Access QTY</p></div>
                        <div class="col-lg-7"><p class="mb-0">4</p></div>
                    </div>
                    {{-- Row List Access yang dimiliki --}}
                    <div class="row mt-3">
                        <h5>List Access :</h5>
                        {{-- List jika terdapat Access yang dimiliki --}}
                        <div class="d-flex align-items-center gap-2 mt-3">
                            <i class='bx bxs-check-circle text-success fs-4'></i>
                            <p class="mb-0">Menu List Meeting</p>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-3">
                            <i class='bx bxs-check-circle text-success fs-4'></i>
                            <p class="mb-0">Menu List Room</p>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-3">
                            <i class='bx bxs-check-circle text-success fs-4'></i>
                            <p class="mb-0">Menu User</p>
                        </div>
                        <div class="d-flex align-items-center gap-2 mt-3">
                            <i class='bx bxs-check-circle text-success fs-4'></i>
                            <p class="mb-0">Menu User Role</p>
                        </div>
                        {{-- List jika tidak terdapat access yang dimiliki --}}
                        <p class="mb-0 text-center mt-3 fw-semibold d-none">No Access</p>
                    </div>
                    <div class="mt-3 d-flex justify-content-end">
                        <button class="btn btn-outline-primary" id="openModalEdit">Edit Role</button>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    {{-- Modal Edit User Role --}}
    <div class="modal fade" id="modalEditUserRole" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditUserRoleLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalEditUserRoleLabel">Edit User Role</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <form action="" id="formEditUserRole">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="checkMeeting">
                            <label class="form-check-label" for="checkMeeting">
                              Menu List Meeting
                            </label>
                        </div>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="" id="checkRoom">
                            <label class="form-check-label" for="checkRoom">
                              Menu List Room
                            </label>
                        </div>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="" id="checkUser">
                            <label class="form-check-label" for="checkUser">
                              Menu User
                            </label>
                        </div>
                        <div class="form-check mt-3">
                            <input class="form-check-input" type="checkbox" value="" id="checkUserRole">
                            <label class="form-check-label" for="checkUserRole">
                              Menu User Role
                            </label>
                        </div>
                        <div class="d-flex justify-content-end mt-3 gap-3">
                            <button type="button" class="btn text-danger" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
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
                        User Role
                    </p>
                </div>

                {{--  --}}
                <div class="col-sm-12 mt-3 d-flex justify-content-between">
                    <div class="d-flex gap-3">
                        {{-- Search --}}
                        <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"
                        class="form-control rounded-3" placeholder="Search">
                        {{-- Select Position --}}
                        <select class="form-select" id="selectPosition">
                            <option value="allPosition" selected>All Position</option>
                            <option value="administrativeAssistant">Administrative Assistant</option>
                            <option value="administrationCoordinator">Administration Coordinator</option>
                            <option value="administrativeExecutive">Administrative Executive</option>
                            <option value="executiveSecretary">Executive Secretary</option>
                            <option value="manager">Manager</option>
                            <option value="financialAdministration">Financial Administration</option>
                        </select>
                        {{-- Button Reset --}}
                        <button type="button" class="btn btn-outline-secondary" id="resetButton">
                            <div class="d-flex align-items-center gap-1">
                                <i class='bx bx-refresh bx-rotate-90 fs-4'></i>
                                Reset
                            </div>
                        </button>
                    </div>
                </div>

                {{-- Table --}}
                <div id="containerWater" class="col-sm-12 mt-3">
                    <table id="tableUserRole" class="table table-responsive table-hover" style="font-size: 16px">
                        <thead>
                            <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                                <th class="p-3" scope="col">No</th>
                                <th class="p-3" scope="col">Employee No</th>
                                <th class="p-3" scope="col">Name</th>
                                <th class="p-3" scope="col">Position</th>
                                <th class="p-3" scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="p-3">1</td>
                                <td class="p-3">031844</td>
                                <td class="p-3">Sarah</td>
                                <td class="p-3">Administrative Assistant</td>
                                <td>
                                    <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailUserRole"> <img src="{{ asset('icons/Eye.svg') }}"></a>
                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUserRole"><img src="{{ asset('icons/Edit.svg') }}"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3">2</td>
                                <td class="p-3">000547</td>
                                <td class="p-3">Lisa</td>
                                <td class="p-3">Administrative Coordinator</td>
                                <td>
                                    <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailUserRole"> <img src="{{ asset('icons/Eye.svg') }}"></a>
                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUserRole"><img src="{{ asset('icons/Edit.svg') }}"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3">3</td>
                                <td class="p-3">033788</td>
                                <td class="p-3">Maria</td>
                                <td class="p-3">Administrative Executive</td>
                                <td>
                                    <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailUserRole"> <img src="{{ asset('icons/Eye.svg') }}"></a>
                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUserRole"><img src="{{ asset('icons/Edit.svg') }}"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3">4</td>
                                <td class="p-3">000376</td>
                                <td class="p-3">Jessica</td>
                                <td class="p-3">Executive Secretary</td>
                                <td>
                                    <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailUserRole"> <img src="{{ asset('icons/Eye.svg') }}"></a>
                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUserRole"><img src="{{ asset('icons/Edit.svg') }}"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3">5</td>
                                <td class="p-3">007035</td>
                                <td class="p-3">Kunarti</td>
                                <td class="p-3">Manager</td>
                                <td>
                                    <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailUserRole"> <img src="{{ asset('icons/Eye.svg') }}"></a>
                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUserRole"><img src="{{ asset('icons/Edit.svg') }}"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3">6</td>
                                <td class="p-3">031844</td>
                                <td class="p-3">Sarah</td>
                                <td class="p-3">Administrative Assistant</td>
                                <td>
                                    <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailUserRole"> <img src="{{ asset('icons/Eye.svg') }}"></a>
                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUserRole"><img src="{{ asset('icons/Edit.svg') }}"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3">7</td>
                                <td class="p-3">000547</td>
                                <td class="p-3">Lisa</td>
                                <td class="p-3">Administrative Coordinator</td>
                                <td>
                                    <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailUserRole"> <img src="{{ asset('icons/Eye.svg') }}"></a>
                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUserRole"><img src="{{ asset('icons/Edit.svg') }}"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3">8</td>
                                <td class="p-3">033788</td>
                                <td class="p-3">Maria</td>
                                <td class="p-3">Administrative Executive</td>
                                <td>
                                    <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailUserRole"> <img src="{{ asset('icons/Eye.svg') }}"></a>
                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUserRole"><img src="{{ asset('icons/Edit.svg') }}"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3">9</td>
                                <td class="p-3">000376</td>
                                <td class="p-3">Jessica</td>
                                <td class="p-3">Executive Secretary</td>
                                <td>
                                    <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailUserRole"> <img src="{{ asset('icons/Eye.svg') }}"></a>
                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUserRole"><img src="{{ asset('icons/Edit.svg') }}"></a>
                                </td>
                            </tr>
                            <tr>
                                <td class="p-3">10</td>
                                <td class="p-3">007035</td>
                                <td class="p-3">Kunarti</td>
                                <td class="p-3">Manager</td>
                                <td>
                                    <a class="btn btnDetail" data-bs-toggle="modal" data-bs-target="#modalDetailUserRole"> <img src="{{ asset('icons/Eye.svg') }}"></a>
                                    <a class="btn btnEdit" data-bs-toggle="modal" data-bs-target="#modalEditUserRole"><img src="{{ asset('icons/Edit.svg') }}"></a>
                                </td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        // Table List User
        $(document).ready( function () {
            $('#tableUserRole').DataTable({
                searching: false,
                lengthChange: false,
                "bSort": true,
                pageLength: 13,
                responsive: true,
            });
        } );

        // Jquery untuk Modal Edit User Role
        $(document).ready(function() {
            // Membuka Modal Edit User Role didalam Modal Detail
            $('#openModalEdit').click(function() {
            $('#modalEditUserRole').modal('show');
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

        // Jquery Sweetalert jika berhasil submit bagian Edit User Role
        $(document).ready(function() {
            $('#formEditUserRole').submit(function(event) {
                event.preventDefault();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'User Role has been updated',
                    confirmButtonColor: '#CD202e',
                }).then(function(result) {
                    if (result.isConfirmed) {
                        $('#modalEditUserRole').modal('hide');
                        $('#modalDetailUserRole').modal('show');
                    }
                });
            });
        });
    </script>

@endsection
