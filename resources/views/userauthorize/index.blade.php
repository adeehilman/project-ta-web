@extends('layouts.app')
@section('title', 'User Role')

@section('content')
<div class="wrappers">

    {{-- Modals --}}

    {{-- Modal Add User Role --}}
    <div class="modal fade" id="modalAddUserRole" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDetailUserRoleLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
            <h1 class="modal-title fs-5" id="modalDetailUserRoleLabel">Add User Authorize</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAdd" method="post" autocomplete="off">
                    @csrf

                <div>
                     {{-- Select Employee --}}
                     <div class="row mb-2">
                        <div class="col-sm-12">
                            <label for="selectEmployeeAdd" class="form-label">Employee</label>
                            <select class="form-select" id="selectEmployeeAdd" name="selectEmployeeAdd" >
                                @foreach ($list_participant as $item)
                                <option value="{{ $item->badge_id }}">{{ $item->fullname }}

                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="err-selectEmployeeAdd" class="text-danger d-none">
                            Please select a valid Employee.
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <label for="selectRoleAdd" class="form-label">Role</label>
                            <select class="form-select" id="selectRoleAdd" name="selectRoleAdd" >
                                @foreach ($list_role as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}

                                </option>
                            @endforeach
                            </select>
                        </div>

                        <div id="err-selectRoleAdd" class="text-danger d-none">
                            Please select a valid Role.
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-primary d-none" type="button" id="SpinnerBtnAdd">
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                </button>
                <button type="submit" id="btnSimpanAdd" class="btn btn-primary">Add User</button>
            </div>
        </form>
        </div>
        </div>
    </div>

    {{-- Modal Edit User Role --}}
    <div class="modal fade" id="modalEditUserRole" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEditUserRoleLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalDetailUserRoleLabel">Edit User Authorize</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEdit" method="post" autocomplete="off">
                        @csrf

                    <div>
                         {{-- Select Employee --}}
                         <div class="row mb-2">
                            <div class="col-sm-12">
                                <label for="selectEmployeeEdit" class="form-label">Employee</label>
                                <input type="text" id="hiddenBadge" name="selectEmployeeEdit" hidden>
                                <select class="form-select" id="selectEmployeeEdit" name="selectEmployeeEdit" disabled>
                                    @foreach ($list_participant as $item)
                                    <option value="{{ $item->badge_id }}">{{ $item->fullname }}

                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="err-selectEmployeeEdit" class="text-danger d-none">
                                Please select a valid Employee.
                            </div>
                        </div>

                        {{-- Row Nomor Employee --}}

                        <div class="row mt-2">
                            <div class="col-sm-12">
                                <label for="selectRoleEdit" class="form-label">Role</label>
                                <select class="form-select" id="selectRoleEdit" name="selectRoleEdit" >
                                    @foreach ($list_role as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}

                                    </option>
                                @endforeach
                                </select>
                            </div>

                            <div id="err-selectRoleEdit" class="text-danger d-none">
                                Please select a valid Role.
                            </div>
                        </div>
                        <div class="form-check mt-1">
                            <input class="form-check-input" type="checkbox" value=""
                                id="isactive" name="isactive">
                            <label class="text-danger form-check-label " for="isactive">
                                Non Aktifkan Akun
                            </label>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary d-none" type="button" id="SpinnerBtnEdit">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <button type="submit" id="btnSimpanedit" class="btn btn-primary">Save Change</button>
                </div>
            </form>
            </div>
            </div>
    </div>

    {{-- End All Modals --}}

        {{-- Main --}}
        <div class="wrapper_content">
            <div class="row me-1">
                <div class="col-sm-6">
                    <p class="h3 mt-6">
                        User Authorization
                    </p>
                </div>

                {{--  --}}
                <div class="col-sm-12 mt-3 d-flex justify-content-between">
                    <div class="d-flex gap-3">
                        {{-- Search --}}
                        <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"
                            class="form-control rounded-3" placeholder="Search">
                        {{-- Select Position --}}
                        {{-- <select class="form-select" id="selectPosition">
                            <option value="allPosition" selected>All Position</option>
                            <option value="administrativeAssistant">Administrative Assistant</option>
                            <option value="administrationCoordinator">Administration Coordinator</option>
                            <option value="administrativeExecutive">Administrative Executive</option>
                            <option value="executiveSecretary">Executive Secretary</option>
                            <option value="manager">Manager</option>
                            <option value="financialAdministration">Financial Administration</option>
                        </select> --}}
                        {{-- Button Reset --}}
                        <button type="button" class="btn btn-outline-secondary" id="resetButton">
                            <div class="d-flex align-items-center gap-1">
                                <i class='bx bx-refresh bx-rotate-90 fs-4'></i>
                                Reset
                            </div>
                        </button>
                    </div>
                    {{-- Button Add Room Meeting --}}
                    <div class="d-flex gap-1">
                        <button style="font-size: 16px;" type="button" class="btn btn-primary rounded-3"
                            id="btnAdd">
                            Add User Authorization
                        </button>
                    </div>
                </div>

                {{-- Table --}}
                <div id="containerUserAuthorize" class="col-sm-12 mt-3">

                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
@include('userauthorize.getList_JS')
@include('userauthorize.edit_JS')
@include('userauthorize.add_JS')


@endsection
