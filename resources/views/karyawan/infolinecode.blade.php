@extends('layouts.app')
@section('title', 'Anggota Line Code')
@section('content')

    <div class="wrappers">
        <div class="wrapper_content">
            <!-- modal -->
            <div class="modal fade" data-bs-backdrop="static" id="modalRepairData" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 50%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Pencarian Karyawan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formInputRepair" style="font-size: 14px;">
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <p>PT</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radioRejectCategory"
                                                id="radioFunction" value="29">
                                            <label class="form-check-label" for="radioFunction">PTSN</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radioRejectCategory"
                                                id="radioVisual" value="30">
                                            <label class="form-check-label" for="radioVisual">SM Engineering</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <p>Department</p>
                                        <select class="form-select" id="selectNGStation" name="selectNGStation"
                                            style="font-size: 12px;">
                                            <option value="">Masukkan atau Pilih Departement</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3" style="font-size: 12px;">
                                    <div class="col-sm-6">
                                        <p>Line Code</p>
                                        <select class="form-select" id="selectCustomer" name="selectCustomer"
                                            style="font-size: 12px;">
                                            <option value="">Masukkan atau Pilih Line Code</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <p>Regis MySatnusa</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radioRejectCategory"
                                                id="radioFunction" value="29">
                                            <label class="form-check-label" for="radioFunction">Terdaftar</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radioRejectCategory"
                                                id="radioVisual" value="30">
                                            <label class="form-check-label" for="radioVisual">Tidak Terdaftar</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3" style="font-size: 12px; display: flex; flex-direction: row;">
                                    <div class="col-sm-12">
                                        <p>Mulai Kerja</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radioRejectCategory"
                                                id="radioFunction" value="29">
                                            <label class="form-check-label" for="radioFunction" style="font-size: 12px;">24
                                                Jam Terakhir</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radioRejectCategory"
                                                id="radioVisual" value="30">
                                            <label class="form-check-label" for="radioVisual" style="font-size: 12px;">1
                                                Minggu Terakhir</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radioRejectCategory"
                                                id="radioVisual" value="30">
                                            <label class="form-check-label" for="radioVisual" style="font-size: 12px;">1
                                                Bulan Terakhir</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                                style="text-decoration: none; font-size: 12px; width: 200px; height: 30px;">Batal</button>
                            <button type="button" style="font-size: 12px; width: 240px; height: 30px;"
                                id="btnSubmitRepair" class="btn btn-primary">Tampilkan Hasil</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal -->
            <div class="row me-3">
                <div class="col-sm-6">
                    <p class="h4 mt-6">
                        Anggota Line Code  {{ $data[0]->line_code }}
                    </p>
                </div>
                <a href="{{ route('grup') }}" style="color: #101010; text-decoration: none;">
                    <i class='bx bx-chevron-left' style='color:#101010; font-size: 1.2rem; vertical-align: middle;'></i>
                    <span style="vertical-align: middle;">Kembali</span>
                </a>
                <!-- <div class="row mb-1 mt-3">
                    <div class="col-sm-12 d-flex gap-1">
                        <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"
                            class="form-control rounded-3" placeholder="Search here">
                        <button id="btnModalFilter" class="btn btn-outline-danger">
                            <i class='bx bx-slider p-1'></i> Filter
                        </button>
                    </div>
                </div> -->
                <div class="col-sm-12 mt-1">
                    <table id="tableInfoLineCode" class="table table-responsive table-hover">
                        <thead>
                            <tr style="color: #CD202E; height: -10px;" class="table-danger">
                                <th class="p-3" scope="col">Nama</th>
                                <th class="p-3" scope="col">Badge ID</th>
                                <th class="p-3" scope="col">PT</th>
                                <th class="p-3" scope="col">Departemen</th>
                                <th class="p-3" scope="col">Line Code</th>
                                <th class="p-3" scope="col">DOJ</th>
                                <th class="p-3" scope="col">Status MySatnusa</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                        @foreach($data as $row)
                        <tr style="color: gray;">
                                <th class="p-3">{{ $row->fullname }}</th>
                                <td class="p-3">{{ $row->badge_id }}</td>
                                <td class="p-3">{{ $row->pt }}</td>
                                <td class="p-3">{{ $row->dept_name }}</td>
                                <td class="p-3">{{ $row->line_code }}</td>
                                <td class="p-3">{{ $row->join_date }}</td>
                                <td class="p-3">
                                    @if($row->statusdaftar == 'Terdaftar')
                                        <img src="{{ asset('/img/checklist.png') }}" alt="Terdaftar"> Terdaftar
                                    @endif
                                    @if($row->statusdaftar != 'Terdaftar')
                                        <img src="{{ asset('/img/vector.png') }}" alt="Tidak Terdaftar"> Tidak Terdaftar
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @endsection

    @section('script')
        <script>
            const btnfilter = $('#btnModalFilter');
            const modalFormFilter = $('#modalFilter');

            btnfilter.click(e => {
                e.preventDefault();
                modalFormFilter.modal('show');

            });
        </script>

    @endsection
