@extends('layouts.app')
@section('title', 'Grup Karyawan')
@section('content')

    <div class="wrappers">
        <div class="wrapper_content">
            {{-- container --}}
            {{-- title --}}
            <div class="row mb-3">
                <div class="col-sm-12">
                    <p class="h4 mt-2">
                        Grup Karyawan
                    </p>
                </div>
            </div>
            {{-- end title --}}

            {{-- tab --}}
            <div class="row mb-3">
                <div class="col-sm-12">
                    <div class="button-box d-flex">
                        <div id="btn"></div>
                        <button onclick="leftClick()" type="button" class="toggle-btn">Departemen</button>
                        <button onclick="rightClick()" type="button" class="toggle-btn">Line Code</button>
                    </div>
                </div>
            </div>
            {{-- end tab --}}

            <!-- {{-- section filter --}}
            <div class="row mb-1">
                <div class="col-sm-12 d-flex gap-1">
                    <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"
                        class="form-control rounded-3" placeholder="Search here">
                    {{-- <button id="btnModalFilterDepart" class="btn btn-outline-danger">
                        <i class='bx bx-slider p-1'></i> Filter
                    </button>
                    <button id="btnModalFilterLineCode" class="btn btn-outline-danger">
                        <i class='bx bx-slider p-1'></i> Filter
                    </button> 
                    <button class="btn btn-outline-danger">Test</button> --}}
                </div>
            </div>
            {{-- end section filter --}} -->

            <div class="row mb-3">
                <div id="containerDeptCode" class="col-sm-8">
                </div>
                <div id="containerLineCode" class="col-sm-8">
                </div>
                <div id="containerInformasiDepart" class="col-sm-4 border border-1 rounded">
                    <div class="text-center" style="margin-top: 250px">
                        <img src="{{ asset('img/hand-click.png') }}" class="my-auto" alt="Click Icon" style="width: 100px;">
                        <p class="text-center fw-bold">Klik salah satu grup untuk melihat informasi grupnya</p>
                    </div>
                </div>
                <div id="containerInformasiLine" class="col-sm-4 border border-1 rounded">
                    <div class="text-center" style="margin-top: 250px">
                        <img src="{{ asset('img/hand-click.png') }}" class="my-auto" alt="Click Icon" style="width: 100px;">
                        <p class="text-center fw-bold">Klik salah satu grup untuk melihat informasi grupnya</p>
                    </div>
                </div>
            </div>
            {{-- end container --}}

            <!-- modified modal Filter Depart -->
            <div class="modal fade" data-bs-backdrop="static" id="modalFilterDepart" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 30%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Pencarian Departemen</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formInputRepair">
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
                                            <label class="form-check-label" for="radioVisual">SM
                                                Engineering</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-5">
                                        <p>Jumlah Anggota</p>
                                        <input type="text" class="form-control" placeholder="Min" name="ng_symptom"
                                            id="ng_symptom">
                                    </div>
                                    <div class="col-sm-5">
                                        <p>&nbsp;</p>
                                        <input type="text" class="form-control" placeholder="Max" name="ng_symptom"
                                            id="ng_symptom">
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                                style="text-decoration: none; width: 170px; height: 30px;">Batal</button>
                            <button type="button" style="width: 190px; height: 40px;" id="btnSubmitRepair"
                                class="btn btn-primary">Tampilkan Hasil</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal Filter Depart -->

            <!-- modified modal Filter Line Code -->
            <div class="modal fade" data-bs-backdrop="static" id="modalFilterLC" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 35%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Pencarian Line Code</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formInputRepair">
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
                                            <label class="form-check-label" for="radioVisual">SM
                                                Engineering</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <p>Department</p>
                                        <select class="form-select" id="selectNGStation" name="selectNGStation">
                                            <option value="">Masukkan atau Pilih Departement</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <p>Jumlah Anggota</p>
                                        <input type="text" class="form-control" placeholder="Min" name="ng_symptom"
                                            id="ng_symptom">
                                    </div>
                                    <div class="col-sm-6">
                                        <p>&nbsp;</p>
                                        <input type="text" class="form-control" placeholder="Max" name="ng_symptom"
                                            id="ng_symptom">
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                                style="text-decoration: none; width: 210px; height: 30px;">Batal</button>
                            <button type="button" style="width: 220px; height: 40px;" id="btnSubmitRepair"
                                class="btn btn-primary">Tampilkan Hasil</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal Filter Line Code -->

        @endsection

        @section('script')

            <script>
                const btnfilterDepart = $('#btnModalFilterDepart');
                const modalFormFilterDepart = $('#modalFilterDepart');
                const btnfilterLC = $('#btnModalFilterLineCode');
                const modalFormFilterLC = $('#modalFilterLC');
                const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
              <div class="spinner-border d-flex justify-content-center align-items-center text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
            </div> `;

                // const btn = document.getElementById('btn');
                const btn = $('#btn')

                // hiden table line code
                $('#containerLineCode').hide();

                // hiden container line code
                $('#containerInformasiLine').hide();

                // hiden container line code
                // $('#btnModalFilterLineCode').hide();

                btnfilterDepart.click(e => {
                    e.preventDefault();
                    modalFormFilterDepart.modal('show');

                });

                btnfilterLC.click(e => {
                    e.preventDefault();
                    modalFormFilterLC.modal('show');

                });

                // departemen list
                const getAllDept = () => {

                    $.ajax({
                        url: '{{ route('deptlist') }}',
                        method: 'GET',
                        beforeSend: () => {
                            $('#containerDeptCode').html(loadSpin);
                        }
                    }).done(res => {

                        $('#containerDeptCode').html(res);
                        $('#tableDeptCode').DataTable({
                            searching: false,
                            lengthChange: false
                        });
                    })
                }
                getAllDept();

                // line list
                const getAllLine = () => {

                    $.ajax({
                        url: '{{ route('linelist') }}',
                        method: 'GET',
                        beforeSend: () => {
                            $('#containerLineCode').html(loadSpin);
                        }
                    }).done(res => {

                        // console.log(res);

                        $('#containerLineCode').html(res);
                        $('#tableLineCode').DataTable({
                            searching: false,
                            lengthChange: false
                        });
                    })
                }
                getAllLine();

                function leftClick() {
                    btn.animate({
                        left: '0'
                    }, 5)
                    $('#containerDeptCode').show()
                    $('#containerInformasiDepart').show()
                    $('#containerLineCode').hide()
                    $('#containerInformasiLine').hide()
                    // $('#btnModalFilterDepart').show()
                    // $('#btnModalFilterLineCode').hide()
                }

                function rightClick() {
                    btn.animate({
                        left: '170px'
                    }, 5)
                    $('#containerDeptCode').hide()
                    $('#containerLineCode').show()
                    $('#containerInformasiDepart').hide()
                    $('#containerInformasiLine').show()
                    // $('#btnModalFilterDepart').hide()
                    // $('#btnModalFilterLineCode').show()
                }

                $('#btnTest').click(function(e) {
                    e.preventDefault();
                    console.log($('#containerLineCode').is(':hidden'));
                })

                // show container departemen
                function showGrupInfo(dept_code, dept_name, pt, total_dept) {
                    // Mengisi kontainer dengan informasi grup yang diklik
                    var container = document.getElementById("containerInformasiDepart");
                    container.innerHTML =

                        '<table class="mt-3 ms-3" style="font-size: 16px; line-height: 3;">' +
                        '<tr>' +
                        '<td class="fw-bold fs-4">Informasi Departemen</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td class="fw-bold fs-4"></td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="width: 300px; color: gray;">Dept. Code</td>' +
                        '<td style="color: black;">' + dept_code + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="width: 300px; color: gray;">Nama</td>' +
                        '<td style="color: black;">' + dept_name + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="width: 300px; color: gray;">PT</td>' +
                        '<td style="color: black;">' + pt + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="width: 300px; color: gray;">Jumlah Anggota</td>' +
                        '<td style="color: black;">' + total_dept + '</td>' +
                        '</tr>' +
                        '</table>' +
                        '<a href="{{ url('infodepart') }}/'+dept_code+'" class="btn btn-outline-secondary fw-bold mt-4 ms-3">' +
                        '<i class="bx bx-user p-1"></i>List Karyawan' +
                        '</a>'
                }


                // show container line code
                function showLineInfo(line_code, total, dept_name) {
                    // Mengisi kontainer dengan informasi grup yang diklik
                    var container = document.getElementById("containerInformasiLine");
                    container.innerHTML =

                        '<table class="mt-3 ms-3" style="font-size: 16px; line-height: 3;">' +
                        '<tr>' +
                        '<td class="fw-bold fs-4">Informasi Line Code</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="width: 300px; color: gray;">Line Code</td>' +
                        '<td style="color: black;">' + line_code + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="width: 300px; color: gray;">Departemen</td>' +
                        '<td style="color: black;">' + dept_name + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td style="width: 300px; color: gray;">Jumlah Anggota</td>' +
                        '<td style="color: black;">' + total + '</td>' +
                        '</tr>' +
                        '</table>' +
                        '<a href="{{ url('infolinecode') }}/'+line_code+'" class="btn btn-outline-secondary fw-bold mt-4 ms-3">' +
                        '<i class="bx bx-user p-1"></i>List Karyawan' +
                        '</a>'                        
                }
            </script>
        @endsection