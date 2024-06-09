@extends('layouts.app')
@section('title', 'List Karyawan')


@section('content')

    <div class="wrappers">
        <div class="wrapper_content">

            <!-- modal -->
            <div class="modal fade" data-bs-backdrop="static" id="modalFilterData" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-6" id="modalFilterTitle">Filter Pencarian Karyawan</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 14px;">
                            <form id="formInputRepair">
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <p>PT</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rdPT"
                                                id="rdALLPT" value="all" checked>
                                            <label class="form-check-label" for="rdALLPT">ALL</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rdPT"
                                                id="rdPTSN" value="1">
                                            <label class="form-check-label" for="rdPTSN">PTSN</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rdPT"
                                                id="rdSME" value="2">
                                            <label class="form-check-label" for="rdSME">SM Engineering</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <p>Department</p>
                                        <select class="form-select" id="selectDepartment" name="selectDepartment">
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <p>Line Code</p>
                                        <select class="form-select" id="selectLine" name="selectLine">

                                        </select>
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rdStatusRegis"
                                                id="rdALLRegis" value="all" checked>
                                            <label class="form-check-label" for="rdALLRegis">ALL</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rdStatusRegis"
                                                id="rdTerdaftar" value="terdaftar">
                                            <label class="form-check-label" for="rdTerdaftar">Terdaftar</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rdStatusRegis"
                                                id="rdTidakTerdaftar" value="tidakterdaftar">
                                            <label class="form-check-label" for="rdTidakTerdaftar">Tidak Terdaftar</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <p>Mulai Kerja</p>
                                        <select class="form-select" id="selectMulaiKerja" name="selectMulaiKerja">
                                            <option value="all">All</option>
                                            <option value="1">24 Jam Terakhir</option>
                                            <option value="7">1 Minggu Terakhir</option>
                                            <option value="30">1 Bulan Terakhir</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">

                                    </div>
                                </div>

                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal" style="text-decoration: none;">Batalkan</button>
                            <button type="button" id="btnFilterData" class="btn btn-primary">Tampilkan Hasil</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end modal -->
            <div class="row me-1">
                <div class="col-sm-6">
                    <p class="h4 mt-6">
                        List Karyawan
                    </p>
                </div>

                <div class="col-sm-12 mt-2 d-flex justify-content-between">
                    <div class="d-flex gap-1">
                        <input type="text" id="txSearch"
                            style="width: 50px; min-width: 300px;"
                            class="form-control rounded-3" placeholder="Cari Karyawan" autocomplete="off">
                        <button id="btnReset" style="font-size: 12px;" type="button"
                            class="btn text-danger rounded-3"><i class='bx bx-refresh'></i>
                            Reset Filter
                        </button>
                    </div>
                </div>

                <div class="text-end col-sm-9 d-flex mt-2 mb-2 rounded-3">
                </div>

                <div id="containerEmployeeTable" class="col-sm-12 mt-1">
                </div>
            </div>
        </div>
    </div>

    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <h1 class="modal-title fs-5">View Photo</h1> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                  <div id="containerViewGambar" class="col-sm-12 text-center">
                    <img id="imageView" class="img-fluid" src="" style="max-width: 400px">
                  </div>
                </div>

            </div>
        </div>
    </div>
  </div>
  {{-- end modal view Gambar --}}

@endsection

@section('script')

    <script>
        const btnModal = $('#btnFilter');
        const modalForm = $('#modalFilterData');
        const selectCustomer = $('#selectCustomer');
        const selectModelCustomer = $('#selectModelCustomer');
        const btnSubmitRepair = $('#btnSubmitRepair');
        const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
              <div class="spinner-border d-flex justify-content-center align-items-center text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
            </div> `;
        const pageBody = $('body');
        const loaderIcon = `<i class='bx bx-loader bx-spin align-middle me-2'></i>`;

        // get list employee
        const getEmployeeList = () => {

            const txSearch = $('#txSearch').val();
            const rdPT = $('input[name="rdPT"]:checked').val();
            const selectDepartment = $('#selectDepartment').val();
            const selectLine = $('#selectLine').val();
            const rdALLRegis = $('input[name="rdStatusRegis"]:checked').val();
            const selectMulaiKerja = $('#selectMulaiKerja').val();

            // console.log(selectMulaiKerja);
            // return;

            $.ajax({
                url: '{{ route('employeelist') }}',
                method: 'GET',
                data: {txSearch, rdPT, selectDepartment, selectLine, rdALLRegis, selectMulaiKerja},
                beforeSend: () => {
                    $('#containerEmployeeTable').html(loadSpin);
                }
            }).done(res => {

                $('#containerEmployeeTable').html(res);
                $('#tableEmployeeList').DataTable({
                    // dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'csv',
                        }
                    ],
                    searching: false,
                    lengthChange: false
                });
            })
        }

        getEmployeeList();

        // end get list employee


        // view employee
        pageBody.on('click', '.viewEmployee', ()=>{
            let id = $(this).data('id');
            console.log(id);
            console.log($('#txSearch').val());
        })


        $('#txSearch').keyup(function(){
            if($('#txSearch').val() !== ""){
                $('#btnReset').show()
            }else{
                // $('#btnReset').hide()
            }
            getEmployeeList();
        })


        $('#btnFilterData').click(e => {
            e.preventDefault()

            getEmployeeList();
            $('#modalFilterData').modal('hide');

            // console.log('clicked');
        })


    $('#btnReset').click(e=>{
        e.preventDefault()
        $('#txSearch').val('');
        $('#rdALLPT').prop('checked', true);
        $('#selectDepartment').val('');
        $('#selectLine').val('');
        $('#rdALLRegis').prop('checked', true);
        $('#selectMulaiKerja').val('');
        getEmployeeList();
        $('#btnReset').hide();
    })

    </script>

@endsection
