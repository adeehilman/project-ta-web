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
                                        <p>Regis MySatnusa</p>
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
                        <button id="btnFilter" style="font-size: 12px;" type="button"
                            class="btn btn-outline-danger rounded-3">
                            <i class='bx bx-slider p-1'></i>
                            Filter
                        </button>
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



<!-- modal input-->
<div class="modal fade" data-bs-backdrop="static" id="modalDaftar" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalDaftarTitle">Register Non Karyawan</h1>
                <button type="button" class="btn-close" id="btnCloseModalDaftar"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body" style="font-size: 14px">
                <form id="formDaftar" method="POST">
                    @csrf
                    <div id="section__one">

                        <div class="row mb-3 text-center">
                            <div class="col-sm-12">
                                <img id="containerGambarNonKaryawan" class="rounded-circle img-thumbnail" src="{{ url('/img/user.png') }}" style="min-height: 140px;min-width: 140px;max-height: 140px;max-width: 140px" width="140" height="140" alt="">
                            </div>
                        </div>

                        <div class="row mb-3 text-center">
                            <div class="col-sm-12">
                                <input type="file" class="d-none" id="btnUpload" name="btnUpload">
                                <label for="btnUpload" class="btn btn-outline-primary btn-sm font-size-12"><i class="bx bx-image-alt"></i> Unggah</label>
                                {{-- <button class="btn btn-outline-primary btn-sm font-size-12"><i class="bx bx-upload"></i> Unggah</button> --}}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="">Kategori Non Karyawan</label>
                                <select name="selectKategoriNonKaryawan" id="selectKategoriNonKaryawan" class="form-select"></select>
                                <span id="errKategoriNonKaryawan" class="text-danger"></span>
                            </div>
                            <div class="col-sm-6">
                                <label for="txBadge">Badge</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="txBadge" name="txBadge" readonly>
                                    <button class="btn btn-outline-primary" type="button" id="btnGenerate">Generate</button>
                                </div>
                                <span id="errBadge" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="">Nama Lengkap</label>
                                <input type="text" id="txFullname" name="txFullname" class="form-control" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z. ]/g, '').replace(/(\..*?)\..*/g, '$0');" autocomplete="off">
                                <span id="errFullname" class="text-danger"></span>
                            </div>
                            <div class="col-sm-6">
                                <label for="rdJenisKelamin" class="mb-2">Jenis Kelamin</label>
                                    <div class="d-flex gap-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rdJenisKelamin" id="rdLaki" value="3" checked>
                                        <label class="form-check-label" for="rdLaki">
                                            Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rdJenisKelamin" id="rdPerempuan" value="4">
                                        <label class="form-check-label" for="rdPerempuan">
                                            Perempuan
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="selectDurasi">Durasi Kontrak</label>
                                <select class="form-select" id="selectDurasi" name="selectDurasi">
                                    <option value="jangka_panjang">Jangka Panjang</option>
                                    <option value="jangka_pendek">Jangka Pendek</option>
                                </select>
                                <span id="errDurasi" class="text-danger"></span>
                            </div>
                            <div class="col-sm-3" id="containerMulai">
                                <label for="txMulai">Mulai</label>
                                <input type="text" id="txMulai" name="txMulai" class="form-control txMulai">
                            </div>
                            <div class="col-sm-3" id="containerSelesai">
                                <label for="txSelesai">Selesai</label>
                                <input type="text" id="txSelesai" name="txSelesai" class="form-control txSelesai">
                            </div>
                        </div>

                    </div>

                    <div id="section__two">

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="txHP1">Nomor HP 1 <span class="text-muted">(Opsional)</span></label>
                                <input type="text" id="txHP1" name="txHP1" class="form-control">
                                <span id="errHP1" class="text-danger"></span>
                            </div>
                            <div class="col-sm-6">
                                <label for="txHP1">Nomor HP 2 <span class="text-muted">(Opsional)</span></label>
                                <input type="text" id="txHP2" name="txHP2" class="form-control">
                                <span id="errHP2" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="txTelp">Telp Rumah <span class="text-muted">(Opsional)</span></label>
                                <input type="text" id="txTelp" name="txTelp" class="form-control">
                                <span id="errTelp" class="text-danger"></span>
                            </div>
                            <div class="col-sm-6">
                                <label for="txEmail">Email <span class="text-muted">(Opsional)</span></label>
                                <input type="text" id="txEmail" name="txEmail" class="form-control">
                                <span id="errEmail" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <label for="selectKec">Kecamatan <span class="text-muted">(Opsional)</span></label>
                                <select name="selectKec" id="selectKec" class="form-select">
                                </select>
                                <span id="errKec" class="text-danger"></span>
                            </div>
                            <div class="col-sm-6">
                                <label for="selectKel">Kelurahan <span class="text-muted">(Opsional)</span></label>
                                <select name="selectKel" id="selectKel" class="form-select">
                                </select>
                                <span id="errKel" class="text-danger"></span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <label for="txAlamat">Alamat Lengkap <span class="text-muted">(Opsional)</span></label>
                                <textarea name="txAlamat" id="txAlamat" rows="5" class="form-control"></textarea>
                                <span id="errAlamat" class="text-danger"></span>      
                            </div>
                        </div>
                    </div>

                    <div id="section__three">

                        <div class="row-mb-3">
                            <div class="col-sm-12 text-center mb-3">
                                <img id="containerGambarNonKaryawan1" class="rounded-circle img-thumbnail imgView" src="{{ url('/img/user.png') }}" style="min-height: 140px;min-width: 140px;max-height: 140px;max-width: 140px" width="140" height="140" alt="">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <p class="mb-0">Kategori Karyawan</p>
                                <p id="daftarKategori" class="mb-2 fw-bold"></p>
                                <p class="mb-0">Nama Lengkap</p>
                                <p id="daftarNamaLengkap" class="mb-2 fw-bold"></p>
                                <p class="mb-0">No. Handphone 1</p>
                                <p id="daftarHP1" class="mb-2 fw-bold"></p>
                                <p class="mb-0">Telp. Rumah</p>
                                <p id="daftarTelpRumah" class="mb-2 fw-bold"></p>
                                <p class="mb-0">Kecamatan</p>
                                <p id="daftarKec" class="mb-2 fw-bold"></p>
                            </div>
                            <div class="col-sm-6">
                                <p class="mb-0">Nomor Badge</p>
                                <p id="daftarBadge" class="mb-2 fw-bold"></p>
                                <p class="mb-0">Jenis Kelamin</p>
                                <p id="daftarJK" class="mb-2 fw-bold"></p>
                                <p class="mb-0">No. Handphone 2</p>
                                <p id="daftarHP2" class="mb-2 fw-bold"></p>
                                <p class="mb-0">Email</p>
                                <p id="daftarEmail" class="mb-2 fw-bold"></p>
                                <p class="mb-0">Kelurahan</p>
                                <p id="daftarKel" class="mb-2 fw-bold"></p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <p class="mb-0">Alamat</p>
                                <p id="daftarAlamat" class="mb-2 fw-bold">
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer section-btn-modal d-flex justify-content-between">
                        <div class="section-btn-modal__left">
                            <p class="mt-2"><span id="currentNumber" class="fw-bold">1</span> / 3 <span id="currentText">Informasi Non Karyawan</span></p>
                        </div>
                        <div class="section-btn-modal__left">
                            <button onclick="btnBack()" type="button" class="btn btn-link" style="text-decoration: none;">Batalkan</button>
                            <button onclick="btnNext()" type="button" id="btnSubmitDaftar" class="btn btn-secondary">Selanjutnya</button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<!-- End modal input -->


{{-- modal import rfid --}}
<div class="modal fade" data-bs-backdrop="static" id="modalImportRfid" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Import RFID</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formImportRfid" method="POST">
            @csrf
                <div class="modal-body">
                    <div class="row mb-3">
                        <input type="file" name="rfidImport" id="rfidImport">
                        <span id="errImport" class="text-danger"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{url('file/Sample.xlsx')}}" download><button type="button" class="btn btn-link" style="text-decoration: none;">Download Sample</button></a>
                    <button id="btnProsesImportRfid" type="submit" class="btn btn-outline-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
  </div>
{{-- end modal import --}}


{{-- modal view Gambar --}}
<div class="modal fade" data-bs-backdrop="static" id="modalViewGambar" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">View Photo</h1>
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

        btnModal.click(e => {
            e.preventDefault();
            modalForm.modal('show');

        });

        // tanggal
        let dateMulai = flatpickr(".txMulai", {
            dateFormat: "d-m-Y",
            defaultDate: "today",
        });

        let dateAkhir = flatpickr(".txSelesai", {
            dateFormat: "d-m-Y",
            defaultDate: "today",
        });

        $('#containerMulai').hide()
        $('#containerSelesai').hide()

        $('#selectDurasi').change(function(){
            if($(this).val() === "jangka_panjang"){
                $('#containerMulai').hide()
                $('#containerSelesai').hide()
            }else{
                $('#containerMulai').show()
                $('#containerSelesai').show()
            }
        })

        $('#btnReset').hide();

        // $('#section__one').hide()
        $('#section__two').hide()
        $('#section__three').hide()

        // button next
        const btnNext = async () => {

            const sectionOne = $('#section__one');
            const sectionTwo = $('#section__two');
            const sectionThree = $('#section__three');

            if(sectionOne.is(':visible')){

                // validasi tab 1
                if(!$('#txBadge').val()){
                    $('#errBadge').text('Badge tidak boleh kosong');
                    return;
                }else{
                    $('#errBadge').text('');
                }
                if(!$('#txFullname').val()){
                    $('#errFullname').text('Nama tidak boleh kosong');
                    return;
                }else{
                    $('#errFullname').text('');
                }


                sectionOne.hide()
                sectionTwo.show()
                $('#currentNumber').text('2');
                $('#currentText').text('Informasi Personal');
                $('#btnSubmitDaftar').text('Selanjutnya')

                $('#daftarKategori').text($('#selectKategoriNonKaryawan').val() ? $('#selectKategoriNonKaryawan option:selected').text() : '-');
                $('#daftarBadge').text($('#txBadge').val() ? $('#txBadge').val() : '-');
                $('#daftarNamaLengkap').text($('#txFullname').val() ? $('#txFullname').val() : '-');
                var jkText = $("input[name='rdJenisKelamin']:checked").siblings("label").text();
                $('#daftarJK').text(jkText ? jkText : '-');


            }else if(sectionTwo.is(':visible')){

                sectionTwo.hide()
                sectionThree.show()
                $('#currentNumber').text('3');
                $('#currentText').text('');
                $('#btnSubmitDaftar').text('Konfirmasi Pendaftaran')
                $('#btnSubmitDaftar').removeClass('btn-secondary')
                $('#btnSubmitDaftar').addClass('btn-primary')
                $('#modalDaftarTitle').text('Konfirmasi Pendaftaran')

                
                $('#daftarHP1').text($('#txHP1').val() ? $('#txHP1').val() : '-');
                $('#daftarHP2').text($('#txHP2').val() ? $('#txHP2').val() : '-');
                $('#daftarTelpRumah').text($('#txTelp').val() ? $('#txTelp').val() : '-');
                $('#daftarEmail').text($('#txEmail').val() ? $('#txEmail').val() : '-');
                $('#daftarKec').text($('#selectKec').val() ? $('#selectKec option:selected').text() : '-');
                $('#daftarKel').text($('#selectKel').val() ? $('#selectKel option:selected').text() : '-');
                $('#daftarAlamat').text($('#txAlamat').val() ? $('#txAlamat').val() : '-');

            }else if(sectionThree.is(':visible')){
                // saveNonKaryawan();
                $('#btnSubmitDaftar').prop('type', 'submit')

            }

        }

        function btnBack(){

            const sectionOne = $('#section__one');
            const sectionTwo = $('#section__two');
            const sectionThree = $('#section__three');

            if(sectionOne.is(':visible')){
                $('#formDaftar')[0].reset();
                modaldaftar.modal('hide');
            }else if(sectionTwo.is(':visible')){

                let txBadge = $('#txBadge').val();
                let txFullname = $('#txFullname').val();

                if(txBadge !== "" && txFullname !== ""){
                    $('#btnSubmitDaftar').removeClass('btn-secondary');
                    $('#btnSubmitDaftar').addClass('btn-primary');
                }else{
                    $('#btnSubmitDaftar').removeClass('btn-primary');
                    $('#btnSubmitDaftar').addClass('btn-secondary');
                }

                $('#currentNumber').text('1');
                $('#currentText').text('Informasi Non Karyawan');
                $('#btnSubmitDaftar').text('Selanjutnya')
                sectionTwo.hide()
                sectionOne.show()
            }else{
                $('#currentNumber').text('2');
                $('#currentText').text('Informasi Personal');
                $('#btnSubmitDaftar').text('Selanjutnya')
                $('#modalDaftarTitle').text('Register Non Karyawan')
                $('#btnSubmitDaftar').prop('type', 'button')
                sectionThree.hide();
                sectionTwo.show()
            }

        }
        // end button


        selectCustomer.change(e => {
            e.preventDefault();

            const value = $('#selectCustomer').val()
            let html = '';
            if (value) {

                $.ajax({
                    url: '{{ route('modellist') }}',
                    method: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        values: value
                    },
                    dataType: 'json',
                    success: (res) => {

                        if (res.status === 200) {

                            html += `<option value="">Pilih model</option>`;

                            $.each(res.data, (i, v) => {
                                html +=
                                    `
              <option value="${v.id}">${v.model}</option>
              `;
                            });
                        }

                        $('#selectModelCustomer').children().remove();
                        $('#selectModelCustomer').append(html)
                    }
                })

            }


        });


        // select model
        selectModelCustomer.change(e => {
            e.preventDefault();

            const value = $('#selectModelCustomer').val()
            let html = ''
            if (value) {
                $.ajax({
                    url: '{{ route('ngstation') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        values: value
                    },
                    dataType: 'json',
                    success: res => {

                        html += `<option value="">Pilih Lokasi NG</option>`;

                        if (res.status === 200) {

                            console.log(res);


                            $.each(res.data, (i, v) => {
                                html +=
                                    `
              <option value="${v.id}">${v.name_vlookup}</option>
              `;
                            });

                        }

                        $('#selectNGStation').children().remove();
                        $('#selectNGStation').append(html)


                    }

                })
            }
        });

        btnSubmitRepair.click(function(e) {
            e.preventDefault();

            // const repairCat = $('input[name="radioRepairCategory"]:checked').val();

            const repairCat = $('input[name="radioRepairCategory"]:checked').val();
            const serialNum = $('input[name="txSerial_number"]').val();
            const selectCustomer = $('#selectCustomer').val();
            const selectModelCustomer = $('#selectModelCustomer').val();
            const rejectCategory = $('input[name="radioRejectCategory"]:checked').val();
            const selectNGStation = $('#selectNGStation').val();
            const ngSymptom = $('#ng_symptom').val();


            const datas = {
                _token: '{{ csrf_token() }}',
                repairCat,
                serialNum,
                selectCustomer,
                selectModelCustomer,
                rejectCategory,
                selectNGStation,
                ngSymptom
            }

            $.ajax({
                url: '{{ route('simpanrepair') }}',
                data: datas,
                method: 'POST',
                dataType: 'json',
                beforeSend: () => {

                },
                success: res => {
                    console.log(res);
                }
            })


        });



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


        // button Import RFID
        $('#btnImportRFID').click(e => {
            e.preventDefault();

            const roles = '{{ session()->get('loggedInUser')['session_roles'] }}'

                if(parseInt(roles) === 64 || parseInt(roles) === 63){
                    $('#modalImportRfid').modal('show');
                }else{
                    showMessage('error', 'Kamu tidak punya akses')
                }

            

            // getEmployeeList();
       
        })

        $('#txSearch').keyup(function(){
            if($('#txSearch').val() !== ""){
                $('#btnReset').show()
            }else{
                $('#btnReset').hide()
            }
            getEmployeeList();
        })


        $('#btnFilterData').click(e => {
            e.preventDefault()

            getEmployeeList();
            $('#modalFilterData').modal('hide');

            // console.log('clicked');
        })


        

        // handle line code list
        const getDeptList = () => {

            let html = ''

            $.ajax({
                url: '{{ route('employeedept') }}', 
                method: 'GET', 
                dataType: 'json',
            }).done(res => {
                console.log(res);
                html += '<option value="">All</option>';

                if(res.status === 200){

                    $.each(res.data, (i, v) => {
                        html += `<option value="${v.dept_code}">${v.dept_code} - ${v.dept_name}</option>`;
                    });
                    
                }

                if($('#selectDepartment').children().lenght > 0){
                    $('#selectDepartment').children().remove();
                }

                $('#selectDepartment').html(html);
                    
            })
        }

        getDeptList();


        $('#selectDepartment').change(function(){
            getLineList()
        })


        // handle line code list
        const getLineList = () => {

            let deptCode = $('#selectDepartment').val();

            let html = ''

            $.ajax({
                url: '{{ route('employeeline') }}', 
                method: 'GET', 
                data: {deptCode},
                dataType: 'json',
            }).done(res => {
                console.log(res);

                html += `<option value="">All</option>`;

                if(res.status === 200){
                    $.each(res.data, (i, v) => {
                        html += `<option value="${v.line_code}">${v.line_code}</option>`;
                    })
                }

                $('#selectLine').html(html);
                    
            })
        }

        getLineList();



        // btnImportKaryawan
        $("#btnImportKaryawan").on("click", function() {
            $('#tableEmployeeList').DataTable().button( '.buttons-csv' ).trigger();
        });

        // //////////////////
        // Tambah karyawan
        // /////////////////
        $('#btnTambahKaryawan').click(e=>{
            e.preventDefault()

            $('#modalDaftar').modal('show');
        })

        // list kategori non karyawan
        const getListNonKaryawan = () => {
            let html = ''
            $.ajax({
                url: '{{ route('kategorinonkaryawan') }}',
                method: 'get',
            }).done(res=>{
                // console.log(res);
                if(res.status === 200){

                    $.each(res.data, (i, v) => {
                        html += `<option value="${v.id_vlookup}">${v.name_vlookup}</option>`
                    })
                }
                $('#selectKategoriNonKaryawan').children().remove()
                $('#selectKategoriNonKaryawan').html(html)
            })
        }
        getListNonKaryawan();

        // btn close modal daftar
        $('#btnCloseModalDaftar').click(function(e){
            e.preventDefault();

            $('#modalDaftar').modal('hide');
        })

        // button generate badge
        $('#btnGenerate').click(e=>{
            e.preventDefault()

            let category = $('#selectKategoriNonKaryawan option:selected').text();

            // console.log(category);

            $.ajax({
                url: '{{ route('generatebadge') }}',
                method: 'get', 
                data: {category},
                beforeSend: function(){
                    $('#btnGenerate').prepend(loaderIcon);
                    $('#btnGenerate').text(' Please wait');
                }
            }).done(res => {
                $('#btnGenerate').children().remove();
                $('#btnGenerate').text('Generate');
                $('#txBadge').val(res);

                if($('#txFullname').val() !== ""){
                    $('#btnSubmitDaftar').removeClass('btn-secondary');
                    $('#btnSubmitDaftar').addClass('btn-primary');
                }else{
                    $('#btnSubmitDaftar').removeClass('btn-primary');
                    $('#btnSubmitDaftar').addClass('btn-secondary');
                }
            })
        })

        // 
        $('#txFullname').keyup(function(e){
            let value = e.target.value;
            let txBadge = $('#txBadge').val();
            if(value !== "" && txBadge !== ""){
                $('#btnSubmitDaftar').removeClass('btn-secondary');
                $('#btnSubmitDaftar').addClass('btn-primary');
            }else{
                $('#btnSubmitDaftar').removeClass('btn-primary');
                $('#btnSubmitDaftar').addClass('btn-secondary');
            }
        });

        $('#btnUpload').change(function(e){
            convertToBase64()
        })


    function convertToBase64() {
        var fileInput = document.getElementById('btnUpload');
        var file = fileInput.files[0];
        var reader = new FileReader();

        reader.onloadend = function() {
        var base64Data = reader.result;
            $('#containerGambarNonKaryawan').attr('src', reader.result);
            $('#containerGambarNonKaryawan1').attr('src', reader.result);
        }

        reader.readAsDataURL(file);

    }

    // Handle modal view saat di close
    $('#modalDaftar').on('hidden.bs.modal', function (event) {
        $('#txBadge').val('');
        $('#txFullname').val('');
        $('#txHP1').val('');
        $('#txHP2').val('');
        $('#txTelp').val('');
        $('#txEmail').val('');
        $('#txAlamat').val('');
        $('#currentNumber').text('1');

        $('#containerMulai').hide();
        $('#containerSelesai').hide();
        $('#selectDurasi').val('jangka_panjang')

        // setion 3
        $('#daftarKategori').text('')
        $('#daftarNamaLengkap').text('')
        $('#daftarHP1').text('')
        $('#daftarTelpRumah').text('')
        $('#daftarKec').text('')
        $('#daftarBadge').text('')
        $('#daftarJK').text('')
        $('#daftarHP2').text('')
        $('#daftarEmail').text('')
        $('#daftarKel').text('')

        $('#currentText').text('Informasi Non Karyawan');
        $('#btnSubmitDaftar').text('Selanjutnya')
        $('#section__two').hide()
        $('#section__three').hide()
        $('#section__one').show()
        $('#btnSubmitDaftar').removeClass('btn-primary').addClass('btn-secondary')
        $('#btnSubmitDaftar').prop('type', 'button')

        $('#containerGambarNonKaryawan').attr('src', '{{ url('/img/user.png') }}');
        $('#containerGambarNonKaryawan1').attr('src', '{{ url('/img/user.png') }}');
    });

    // kelurahan list
    const getAllKelurahan = (id = "1") => {
        let html = '';
        $.ajax({
            url: '{{ route('kelurahanlist') }}',
            method: 'GET',
            dataType: 'json',
            data: {
                id
            },
        }).done(res => {
            html += `<option value="">--Pilih Kecamatan--</option>`
            if (res.status === 200) {
                $.each(res.data, (i, v) => {
                    html += `<option value="${v.id}">${v.kelurahan}</option>`;
                })
                if ($('#selectKel').children().length > 0) {
                    $('#selectKel').children().remove();
                }
                $('#selectKel').html(html);
            }
        })
    }

    getAllKelurahan();

    // kecamatan list
    const getAllKecamatan = () => {
        let html = '';
        $.ajax({
            url: '{{ route('kecamatanlist') }}',
            method: 'GET',
            dataType: 'json',
        }).done(res => {
            html += `<option value="">--Pilih Kecamatan--</option>`
            if (res.status === 200) {
                $.each(res.data, (i, v) => {
                    html += `<option value="${v.id}">${v.kecamatan}</option>`;
                })
                if ($('#selectKec').children().length > 0) {
                    $('#selectKec').children().remove();
                }
                $('#selectKec').html(html);
                if(!$('#selectKec') === ""){
                    getAllKelurahan(res.data[0].id);
                }
            }
        })
    }

    getAllKecamatan();

    // trigger change kecamatan
    $('#selectKec').change(function() {
        const id = $(this).val();
        getAllKelurahan(id);
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

    // $('input[name="rdPT"]').change(function(){
    //     if($('input[name="rdPT"]:checked').val() === "all"){

    //     }
    // })

    pageBody.on('click', '.viewProfile', function(e){
        const id = $(this).data('id');

        if(id){
            window.location = `{{ url('list/${id}') }}`;
        }
        // console.log('aaaa');
    })

    $('#formImportRfid').on('submit', function(e){
        e.preventDefault();

        if(!$('#rfidImport').val()){
            showMessage('error', 'Upload file excel terlebih dahulu');
            return;
        }

        $.ajax({
            url: '{{ route('importrfid') }}', 
            method: 'POST', 
            data: new FormData(this), 
            cache: false,
            processData: false,
            contentType: false, 
            dataType: 'json',
        }).done(res => {
            // console.log(res);

            if(res.status === 400){
                $('#errImport').text(res.message);
                return;
            }else{
                $('#errImport').text('');
                $('#formImportRfid')[0].reset();
                $('#modalImportRfid').modal('hide');
                showMessage('success', res.message);
                getEmployeeList();
            }
        });

    });

    $('#modalImportRfid').on('hidden.bs.modal', function (event) {

        $('#errImport').text('');
        $('#formImportRfid')[0].reset();
        getEmployeeList();

    });

    $('.imgView').click(function(e){
        e.preventDefault()

        if($(this).attr('src')){
            $('#imageView').attr('src', $(this).attr('src'))
            $('#modalViewGambar').modal('show')
        }

    })

    $('#modalViewGambar').on('hidden.bs.modal', function (event) {
        $('#imageView').removeAttr('src');
    });

    </script>

@endsection
