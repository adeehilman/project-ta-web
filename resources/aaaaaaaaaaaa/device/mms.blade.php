@extends('layouts.app')
@section('title', 'MMS')

@section('content')

    <div class="wrappers">
        <div class="wrapper_content">

            <!-- modal filter -->
            <div class="modal fade" data-bs-backdrop="static" id="modalFilterData" tabindex="-1">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-6" id="modalFilterTitle">Filter Pencarian MMS</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 14px;">
                           

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <label for="selectMerekHPFilter">Merk HP</label>
                                    <select name="selectMerekHPFilter" id="selectMerekHPFilter" class="form-select">
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <label for="selectPermohonan">Jenis Permohonan</label>
                                    <select name="selectPermohonan" id="selectPermohonan" class="form-select">
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <label for="selectStatusPermohonan">Status Permohonan</label>
                                    <select name="selectStatusPermohonan" id="selectStatusPermohonan" class="form-select">
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="">Pilih Waktu Pengajuan</label>
                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rdWaktuPengajuan" id="rd24JamTerakhir" value="1">
                                        <label class="form-check-label" for="rd24JamTerakhir">
                                            24 Jam Terakhir
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rdWaktuPengajuan" id="rdSeminggu" value="7">
                                        <label class="form-check-label" for="rdSeminggu">
                                            1 Minggu Terakhir
                                        </label>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="rdWaktuPengajuan" id="rdSebulan" value="30">
                                        <label class="form-check-label" for="rdSebulan">
                                            1 Bulan Terakhir
                                        </label>
                                    </div>
                                </div>
                                                  
                            </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal" style="text-decoration: none;">Batalkan</button>
                            <button type="button" id="btnFilterData" class="btn btn-primary">Tampilkan Hasil</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end modal -->

   
          

            <!-- modal input-->
            <div class="modal fade" data-bs-backdrop="static" id="modalDaftar" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalDaftarTitle">Daftar Mobile Management System</h1>
                            <button type="button" class="btn-close" id="btnCloseModalDaftar"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 14px">
                            <form id="formDaftar" method="POST">
                                @csrf
                                <div id="section__one">

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label for="">Nomor Badge </label>
                                            {{-- <input oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1');" type="text" id="txBadge" name="txBadge" maxlength="6" class="form-control" placeholder="Masukkan nomor badge"> --}}
                                            <input oninput="this.value = this.value.toUpperCase()" type="text" id="txBadge" name="txBadge" maxlength="25" class="form-control" placeholder="Masukkan nomor badge">
                                            <span id="errBadge" class="text-danger"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Nama Karyawan</label>
                                            <input type="text" id="txNama" name="txNama" class="form-control" readonly>
                                            <span id="errNama"></span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label for="">Departmen</label>
                                            <input type="text" id="txDepartmen" name="txDepartmen" class="form-control" readonly>
                                            <span id="errDepartmen"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Posisi</label>
                                            <input type="text" id="txPosisi" name="txPosisi" class="form-control" readonly>
                                            <span id="errPosisi"></span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label for="">Mulai Masuk</label>
                                            <input type="text" id="txMulaiMasuk" name="txMulaiMasuk" class="form-control" readonly>
                                            <span id="errMulaiMasuk"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Pilih Jenis Permohonan</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="rdPermohonan" id="rdKaryawanBaru" value="1" checked>
                                                <label class="form-check-label" for="rdKaryawanBaru">
                                                    Karyawan Baru
                                                </label>
                                            </div>
                                            {{-- <div class="form-check">
                                                <input class="form-check-input" type="radio" name="rdPermohonan" id="rdError" value="2">
                                                <label class="form-check-label" for="rdError">
                                                    Error, Kerusakan Barcode atau lainnya
                                                </label>
                                            </div> --}}
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="rdPermohonan" id="rdPenambahan" value="3">
                                                <label class="form-check-label" for="rdPenambahan">
                                                    Penambahan Hp Baru
                                                </label>
                                            </div>
                                            {{-- <div class="form-check">
                                                <input class="form-check-input" type="radio" name="rdPermohonan" id="rdPerubahan" value="4">
                                                <label class="form-check-label" for="rdPerubahan">
                                                    Perubahan Data HP
                                                </label>
                                            </div> --}}
                                            <span id="errPermohonan"></span>
                                        </div>
                                    </div>

                                    
                                    
                                </div>

                                <div id="section__two">

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label for="">UUID</label>
                                            <input type="text" id="txUUID" name="txUUID" class="form-control" placeholder="Masukkan atau Scan UUID pada HP">
                                            <span id="errUUID" class="text-danger"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Merek HP</label>
                                            <select class="form-select" id="selectMerekHP" name="selectMerekHP">
                                            </select>
                                            <span id="errMerekHP" class="text-danger"></span>
                                        </div>
                                    </div>

                                    <div id="containerMerekHpLain" class="row mb-3">
                                        <div class="col-sm-6"></div>
                                        <div class="col-sm-6">
                                            <label for="txMerekHpLainnya">Merek Lain : </label>
                                            <input type="text" class="form-control" id="txMerekHpLain" name="txMerekHpLain">
                                            <span id="errMerekHpLain" class="text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label for="">Tipe HP</label>
                                            <input type="text" id="txTipeHP" name="txTipeHP" class="form-control" placeholder="Masukkan Tipe HP">
                                            <span id="errTipeHP" class="text-danger"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">Nomor Serial</label>
                                            <input type="text" id="txNoSerial" name="txNoSerial" class="form-control" placeholder="Masukkan Nomor Serial HP">
                                            <span id="errNoSerial" class="text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label for="">Barcode Label</label>
                                            <input type="text" id="txBarcodeLabel" name="txBarcodeLabel" class="form-control" placeholder="Masukkan atau Barcode Label">
                                            <span id="errBarcodeLabel" class="text-danger"></span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">OS</label>
                                            <select name="selectOs" id="selectOs" class="form-select">
                                            </select>
                                            <span id="errOs" class="text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <label for="">IMEI 1</label>
                                            <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" type="text" id="txImei1" name="txImei1" class="mb-1 form-control" placeholder="Masukkan Nomor IMEI 1 yg ada di hp kamu">
                                            <span id="errImei1" class="text-danger"></span>      
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="">IMEI 2 (Opsional)</label>
                                            <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" type="text" id="txImei2" name="txImei2" class="mb-1 form-control" placeholder="Masukkan Nomor IMEI 2 yg ada di hp kamu">
                                            <span id="errImei2" class="text-danger"></span>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="checkUploadFoto" name="checkUploadFoto">
                                                <label class="form-check-label" for="checkUploadFoto">
                                                  Upload Foto
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div id="fotoDepanSuccess" class="col-sm-6 text-center">
                                            <span class="text-success fs-2"><i class="bx bxs-check-circle"></i></span>
                                        </div>
                                        <div id="fotoBelakangSuccess" class="col-sm-6 text-center">
                                            <span class="text-success fs-2"><i class="bx bxs-check-circle"></i></span>
                                        </div>
                                    </div>

                                    <div id="containerUploadFoto" class="row mb-3">
                                        <div class="col-sm-6">
                                            <p class="mb-1">Foto HP bagian depan (JPG/PNG)</p>
                                            <input style="font-size: 12px; width: 100%; padding:8px;" type="file" id="gambarDpn" name="gambarDpn" class="fw-bold btn btn-outline-danger rounded-3">
                                                Ambil Foto Hp bagian depang
                                            <p class="mb-5">Foto HP bagian belakang (JPG/PNG)</p>
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="mb-1">Foto HP bagian belakang (JPG/PNG)</p>
                                            <input style="font-size: 12px; width: 100%; padding:8px;" type="file" id="gambarBlkng" name="gambarBlkng" class="fw-bold btn btn-outline-danger rounded-3">
                                                Ambil Foto Hp bagian belakang
                                            <p class="mb-5">Foto HP bagian belakang (JPG/PNG)</p>
                                        </div>
                                    </div>

                                    <div id="containerTakeFoto" class="row mb-3">
                                        <div class="col-sm-6 text-center">
                                            <input type="hidden" id="gambarDpnCamera" name="gambarDpnCamera" value="">
                                            <button id="btnCameraDepan" type="button" class="btn btn-primary"><i class="bx bxs-camera"></i> Ambil Foto Depan</button>
                                        </div>
                                        <div class="col-sm-6 text-center">
                                            <input type="hidden" id="gambarBlkngCamera" name="gambarBlkngCamera" value="">
                                            <button id="btnCameraBelakang" type="button" class="btn btn-primary"><i class="bx bxs-camera"></i> Ambil Foto Belakang</button>
                                        </div>
                                    </div>

                                    {{-- <div class="row mb-3">
                                        <label for="">Capture</label>
                                        <div id="results" class="col-sm-6">

                                            <input type="hidden" name="imagecam" class="img-tag">
                                        </div>
                                        <div class="col-sm-6"></div>
                                    </div> --}}
                                    <div class="row mb-3">
                                        <div class="col-sm-6 text-center">
                                            <span id="errImage1" class="text-danger"></span>
                                        </div>
                                        <div class="col-sm-6 text-center">
                                            <span id="errImage2" class="text-danger"></span>
                                        </div>
                                    </div>

                                    

                                </div>

                                <div id="section__three">

                                    <div class="row mb-3">
                                        <div class="col-sm-6">
                                            <p class="mb-0">Nama Karyawan</p>
                                            <p id="daftarNama" class="mb-2 fw-bold"></p>
                                            <p class="mb-0">Departemen</p>
                                            <p id="daftarDept" class="mb-2 fw-bold"></p>
                                            <p class="mb-0">Mulai Masuk</p>
                                            <p id="daftarJoinDate" class="mb-2 fw-bold"></p>
                                            <p class="mb-0">UUID</p>
                                            <p id="daftarUUID" class="mb-2 fw-bold"></p>
                                            <p class="mb-0">Type HP</p>
                                            <p id="daftarTipe" class="mb-2 fw-bold"></p>
                                            <p class="mb-0">IMEI 1</p>
                                            <p id="daftarImei1" class="mb-2 fw-bold"></p>
                                            <p class="mb-0">Barcode Label</p>
                                            <p id="daftarBarcode" class="mb-2 fw-bold"></p>
                                            <p class="mb-0">Upload Foto HP bagian depan</p>
                                            <img id="containerGambarDpn" class="img-thumbnail border-0 rounded-3 mb-2 fw-bold imgView" width="80" src="{{ asset('img/no-image.png') }}" alt="image depan">
                                        </div>
                                        <div class="col-sm-6">
                                            <p class="mb-0">Nomor Badge</p>
                                            <p id="daftarBadge" class="mb-2 fw-bold">123456</p>
                                            <p class="mb-0">Posisi</p>
                                            <p id="daftarPosisi" class="mb-2 fw-bold">UI/UX Designer</p>
                                            <p class="mb-0">Jenis Permohonan</p>
                                            <p id="daftarJenisPermohonan" class="mb-2 fw-bold">Karyawaan Baru</p>
                                            <p class="mb-0">Merek HP</p>
                                            <p id="daftarMerkHP" class="mb-2 fw-bold">Xiaomi</p>
                                            <p class="mb-0">Nomor Serial</p>
                                            <p id="daftarNoSerial" class="mb-2 fw-bold">012344556575624341</p>
                                            <p class="mb-0">IMEI 2</p>
                                            <p id="daftarImei2" class="mb-2 fw-bold">-</p>
                                            <p style="color: white;" class="mb-0">-</p>
                                            <p style="color: white;" id="daftarBarcode1" class="mb-2 fw-bold">-</p>
                                            <p class="mb-0">Upload Foto HP bagian belakang</p>
                                            <img id="containerGambarBlkng" class="img-thumbnail border-0 rounded-3 mb-2 fw-bold imgView" width="80" src="{{ asset('img/no-image.png') }}" alt="image belakang">
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer section-btn-modal d-flex justify-content-between">
                                    <div class="section-btn-modal__left">
                                        <p class="mt-2"><span id="currentNumber" class="fw-bold">1</span> / 3 <span id="currentText">Informasi Karyawan dan Jenis Permohonan</span></p>
                                    </div>
                                    <div class="section-btn-modal__left">
                                        <button onclick="btnBack()" type="button" class="btn btn-link" style="text-decoration: none;">Batalkan</button>
                                        <button onclick="btnNext()" type="button" id="btnSubmitMMS" class="btn btn-secondary">Selanjutnya</button>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <!-- End modal input -->

            {{-- modal camera 1 --}}
            <div class="modal fade" data-bs-backdrop="static" id="modalCamera" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalCameraTitle">Capture photo</h1>
                            <button type="button" class="btn-close" id="btnCloseModalCamera"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 14px">

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <div id="myCamera" class="mx-auto">

                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer text-center mx-auto">
                            <button type="button" class="btn btn-outline-primary" id="takephoto">Take Picture</button>
                            <button type="button" class="btn btn-outline-primary" id="confirmphoto">Confirm</button>
                            <button type="button" class="btn btn-outline-primary" id="retakephoto">Retake Picture</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end modal camera --}}

            {{-- modal camera 2 --}}
            <div class="modal fade" data-bs-backdrop="static" id="modalCamera2" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="modalCameraTitle2">Capture photo</h1>
                            <button type="button" class="btn-close" id="btnCloseModalCamera2"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="font-size: 14px">

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <div id="myCamera2" class="mx-auto">

                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer text-center mx-auto">
                            <button type="button" class="btn btn-outline-primary" id="takephoto2">Take Picture</button>
                            <button type="button" class="btn btn-outline-primary" id="confirmphoto2">Confirm</button>
                            <button type="button" class="btn btn-outline-primary" id="retakephoto2">Retake Picture</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end modal camera 2 --}}

            <div class="row me-3">
                <div class="col-sm-6">
                    <p class="h4 mt-6">
                        Mobile Management System 
                    </p>
                </div>

                <div class="col-sm-12 mt-2 d-flex justify-content-between">
                    <div class="d-flex gap-1">
                        <input id="txSearch" type="text"
                            style="width: 300px; min-width: 300px; font-size: 12px; padding-left: 30px; background-image: url('{{ asset('img/search.png') }}'); background-repeat: no-repeat; background-position: left center;"
                            class="form-control rounded-3" placeholder="Cari Badge / Nama">
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
                    <div class="d-flex gap-1">

                        {!! $userRole == 63 || $userRole == 64 ? 
                        '<button id="btnDaftar" style="font-size: 12px;" type="button"
                        class="btn btn-outline-danger rounded-3">
                        Daftar MMS
                        </button>' : '' !!} 
                        
                    </div>
                </div>

                <div class="text-end col-sm-9 d-flex mt-2 mb-2 rounded-3">
                    {{-- <span style="font-size: 12px;">Menampilkan 7 dari 8.138 Perangkat</span> --}}
                </div>

                <div id="containerMMS" class="col-sm-12 mt-1">
                </div>
            </div>
        </div>


        {{-- modal view --}}
        <div class="modal fade" data-bs-backdrop="static" id="modalView" tabindex="-1">
            <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" style="height: 600px;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalViewTitle">Informasi Mobile</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="font-size: 14px">

                        <div class="button-box-mms d-flex">
                            <div id="btn-mms"></div>
                            <button id="btnViewInformasiPerangkat" type="button" class="toggle-btn-mms">Informasi Perangkat</button>
                            <button id="btnViewInformasiPengguna" type="button" class="toggle-btn-mms">Informasi Pengguna</button>
                            <button id="btnViewRiwayat" type="button" class="toggle-btn-mms">Riwayat Status</button>
                            <button id="btnViewInformasiTanggapan" type="button" class="toggle-btn-mms">Tanggapan</button>
                        </div>

                        <div id="section__view__infomasiperangkat" style="height: 500px">
                            <div class="row mx-2 my-2">
                                <p class="fw-bold mt-2">Informasi Perangkat</p>
                                <div class="col-sm-4">
                                    <p class="mb-2">Merek HP</p>
                                    <p class="mb-2">Type HP</p>
                                    <p class="mb-2">UUID</p>
                                    <p class="mb-2">Barcode Label</p>
                                    <p class="mb-2">Nomor IMEI 1</p>
                                    <p class="mb-2">Nomor IMEI 2</p>
                                    <p class="mb-2">Jenis Permohonan</p>
                                    <p class="mb-2">Waktu Pengajuan</p>
                                    <p class="mb-2">Status Pengajuan</p>
                                </div>
                                <div class="col-sm-8">
                                    <p class="mb-2" id="txViewMerekHP"></p>
                                    {{-- <p class="mb-2" id="txViewTipeHP"></p> --}}
                                    <div class="d-flex">
                                        <p class="mb-2" id="txViewTipeHP"></p><button id="btnEditTipeHp" class="ms-2 btn btn-outline-secondary btn-sm"><i class="bx bx-edit"></i></button>
                                    </div>
                                    <div class="d-flex">
                                        <p class="mb-2" id="txViewUUID"></p><button id="btnEditUUID" class="ms-2 btn btn-outline-secondary btn-sm"><i class="bx bx-edit"></i></button>
                                    </div>
                                    <div class="d-flex">
                                        <p class="mb-2" id="txViewBarcodeLabel"></p><button id="btnEditBarcodeLabel" class="ms-2 btn btn-outline-secondary btn-sm"><i class="bx bx-edit"></i></button>
                                    </div>
                                    <p class="mb-2" id="txViewImei1"></p>
                                    <p class="mb-2" id="txViewImei2"></p>
                                    <p class="mb-2" id="txViewJenisPermohonan"></p>
                                    <p class="mb-2" id="txViewWaktuPengajuan"></p>
                                    <p class="mb-2" id="txViewStatusPengajuan" style="color: blue"></p>
                                </div>
                            </div>

                            <div class="row mx-2 my-2">
                                <p class="fw-bold mt-2">Foto Perangkat</p>
                                <div class="col-sm-4">
                                    <p class="mb-2">Foto dari depan</p>
                                </div>
                                <div class="col-sm-8">
                                    <img id="containerImgDpn" class="img-thumbnail border-0 rounded-3 mb-2 fw-bold imgView" width="80" src="{{ asset('img/foto-depan.png') }}">
                                </div>
                            </div>

                            <div class="row mx-2 my-2">
                                <div class="col-sm-4">
                                    <p class="mb-2">Foto dari depan</p>
                                </div>
                                <div class="col-sm-8">
                                    <img id="containerImgBlk" class="img-thumbnail border-0 rounded-3 mb-2 fw-bold imgView" width="80" src="{{ asset('img/foto-blkng.png') }}">
                                </div>
                            </div>
                        </div>

                        <div id="section__view__infomasipengguna" style="height: 500px">
                            <div class="row mx-2 my-2">
                                <p class="fw-bold mt-2">Informasi Pengguna</p>
                                <div class="col-sm-4">
                                    <p class="mb-2">Nama</p>
                                    <p class="mb-2">Badge</p>
                                    <p class="mb-2">Departemen</p>
                                    <p class="mb-2">Posisi</p>
                                    <p class="mb-2">Mulai Masuk</p>
                                </div>
                                <div class="col-sm-8">
                                    <p id="txViewName" class="mb-2"></p>
                                    <p id="txViewBadge" class="mb-2"></p>
                                    <p id="txViewDept" class="mb-2"></p>
                                    <p id="txViewPosition" class="mb-2"></p>
                                    <p id="txViewJoinDate" class="mb-2"></p>
                                </div>
                            </div>
                        </div>

                        <div id="section__view__riwayatstatus" style="height: 500px">
                            <div class="row mx-2 my-2">
                                {{-- <p class="fw-bold mt-2">Riwayat Status</p> --}}
                                {{-- <div class="col-sm-2">
                                    <p class="fw-bold mb-0">Hari ini</p>
                                    <span class="text-muted">10.00</span>
                                </div> --}}
                                {{-- <div class="col-sm-10">
                                    <ol id="containerTimeline" class="ol-timeline">
                                        <li class="li-timeline"><p class="fw-bold mb-0">Mendaftar MMS</p>
                                            <span class="text-muted" style="font-size: 11px">Kamu baru selesai melakukan daftar MMS untuk jenis permohonan karyawan baru</span>
                                        </li>
                                        <li class="li-timeline"><p class="fw-bold mb-0">Sedang ditinjau oleh HRD Staff</p>
                                            <span class="text-muted" style="font-size: 11px">Saat ini sedang dalam proses peninjauan oleh HRD Staff</span>
                                        </li>
                                        <li class="li-timeline"><p class="fw-bold mb-0">Menunggu diapprove oleh Manager HRD</p>
                                            <span class="text-muted" style="font-size: 11px">Saat ini sedang menunggu diapprove oleh HRD Manager</span>
                                        </li>
                                        <li class="li-timeline"><p class="fw-bold mb-0">Telah diapprove oleh Manager HRD</p>
                                            <span class="text-muted" style="font-size: 11px">Permohonan kamu telah disetujui oleh Manager HRD</span>
                                        </li>
                                        <li class="li-timeline"><p class="fw-bold mb-0">Sedang ditinjau oleh Staff QSHE</p>
                                            <span class="text-muted" style="font-size: 11px">Saat ini sedang dalam proses peninjauan oleh QHSE Staff</span>
                                        </li>
                                        <li class="li-timeline"><p class="fw-bold mb-0">Menunggu diapprove oleh Manager QSHE</p>
                                            <span class="text-muted" style="font-size: 11px">Saat ini sedang menunggu diapprove oleh QHSE Staff</span>
                                        </li>
                                        <li class="li-timeline"><p class="fw-bold mb-0">Telah diapprove oleh Manager QSHE</p>
                                            <span class="text-muted" style="font-size: 11px">Permohonan kamu sudah diapprove oleh Manager QSHE</span>
                                        </li>
                                        <li class="li-timeline"><p class="fw-bold mb-0">Selesai</p>
                                            <span class="text-muted" style="font-size: 11px">Status pengajuan selesai, sekarang perangkat kami sudah bisa melakukan Scan UUID</span>
                                        </li>
                                    </ol>
                                </div> --}}

                            </div>


                            <div class="row mx-2 my-2">
                                {{-- percobaan --}}
                                <p class="h5 fw-bold mt-2 mb-4">Riwayat Status</p>

                                <div id="containerRiwayatClock" style="padding: 10px;" class="col-sm-2">
                                    {{-- <div class="mb-4">
                                        <p class="fw-bold mb-0">Hari ini</p>
                                        <span class="text-muted">10.00</span>
                                    </div> 
                                    <div class="mb-4">
                                        <p class="fw-bold mb-0">Hari ini</p>
                                        <span class="text-muted">10.00</span>
                                    </div> 
                                    <div class="mb-4">
                                        <p class="fw-bold mb-0">Hari ini</p>
                                        <span class="text-muted">10.00</span>
                                    </div>       --}}
                                </div>

                                <div id="containerRiwayatStatus" class="col-sm-10">
                                    {{-- <ul>
                                        <li class="step step--done">
                                            <div class="step__title">Mendaftar MMS</div>
                                            <p class="step__detail">Kamu baru selesai melakukan daftar MMS untuk jenis permohonan karyawan baru.</p>
                                            <div class="step__circle">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 12l5 5l10 -10"></path>
                                                 </svg>
                                            </div>
                                        </li>
    
                                        <li class="step step--done">
                                            <div class="step__title">Telah diapprove oleh Manager HRD</div>
                                            <p class="step__detail">Permohonan kamu telah disetujui oleh Manager HRD.</p>
                                            <p class="step__detail">Your order checked by Paul Mavers.</p>
                                            <div class="step__circle">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 12l5 5l10 -10"></path>
                                                 </svg>
                                            </div>
                                        </li>
    
                                        <li class="step step--done">
                                            <div class="step__title">Sedang menunggu ditinjau oleh Staff QHSE</div>
                                            <p class="step__detail">Saat ini sedang dalam proses peninjauan oleh QHSE Staff.</p>
                                            <div class="step__circle">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M9 6l6 6l-6 6"></path>
                                                 </svg>
                                            </div>
                                        </li>
    
                                        <li class="step step--upcoming">
                                            <div class="step__title">Sedang menunggu ditinjau oleh Staff QHSE</div>
                                            <p class="step__detail">Saat ini sedang dalam proses peninjauan oleh QHSE Staff.</p>
                                            <div class="step__circle"></div>
                                        </li>

                                        <li class="step step--upcoming">
                                            <div class="step__title">Sedang menunggu diapprove oleh Manager QHSE</div>
                                            <p class="step__detail">Saat ini sedang menunggu diapprove oleh Manager QHSE.</p>
                                            <div class="step__circle"></div>
                                        </li>
    
                                        <li class="step step--upcoming">
                                            <div class="step__title">On a way</div>
                                            <p class="step__detail">Delivery by FedEx.</p>
                                            <p class="step__detail">Estimated delivery date: 10/31/2022.</p>
                                            <div class="step__circle"></div>
                                        </li>
    
                                        <li class="step step--upcoming">
                                            <div class="step__title">Package received</div>
                                            <p class="step__detail">Your package's journey finished!.</p>
                                            <div class="step__circle"></div>
                                        </li>
    
                                    </ul> --}}

                                </div>
                            </div>


                        </div>

                        <div id="section__view__informasitanggapan" style="height: 500px">
                            <div class="row mx-2 my-2">
                                <div class="col-sm-12">
                                    <p class="text-muted">Komentar</p>
                                    {{-- <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea> --}}
                                    <textarea id="txDeskripsi" name="txDeskripsi"></textarea>
                                </div>
                                <div class="col-sm-12 d-flex justify-content-between">
                                    <p class="fw-bold mt-2">History Tanggapan</p>
                                    <button id="btnSimpanTanggapan" type="button" class="btn btn-primary btn-sm mt-2">Tanggapi</button>
                                </div>
                                <div class="col-sm-12 my-auto mt-3">
                                    {{-- <div class="text-center">Belum ada Tanggapan Sama Sekali</div> --}}

                                    {{-- <div class="row-mb-3 d-flex justify-content-center">
                                        
                                        <div id="containerTanggapan" class="col-md-11">

                                        </div>

                                    </div> --}}

                                    <div class="row mb-3" id="newContainerTanggapan">
                                        {{-- <div class="card border border-1">
                                            <div class="card-body">
                                                <div class="row mb-3">
                                                    <div class="col-sm-6">
                                                        <img class="rounded-circle" src="{{ asset('img/foto-blkng.png') }}" width="50" height="50">
                                                        <span class="ms-3 fw-bold">Teguh</span>
                                                    </div>
                                                    <div class="col-sm-6 text-end">
                                                        <span style="font-size: 12px">Jam: 10:00</span>                 
                                                        <p class="m-0" style="font-size: 12px">12 Juni 2023</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus facere ducimus repellendus, excepturi dolores neque exercitationem explicabo tempore? Pariatur, vel hic! Omnis dolorum corrupti qui ipsam fugiat deserunt sit quibusdam veniam itaque minus vel ex possimus laboriosam labore, sequi eaque unde. Accusantium repellendus amet, officiis libero porro itaque aliquid non?
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <input type="hidden" id="valMMSId" name="valMMSId">
                        <input type="hidden" id="valStatusId" name="valStatusId"> 
                        <div id="containerSetActive">     
                            <label class="form-check-label text-danger" for="stts">
                                <input class="form-check-input" type="checkbox" id="stts" name="stts"> Non Aktifkan Mobile
                            </label>
                        </div>
                        <button type="button" id="btnTotalPengajuan" class="btn btn-link" style="text-decoration: none">Tolak Pengajuan</button>
                        <button type="button" id="btnTerimaPengajuan" class="btn btn-primary">Terima Pengajuan</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- end modal view --}}


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

  {{-- modal update barcode label --}}
<div class="modal fade" data-bs-backdrop="static" id="modalUpdateBarcodeLabel" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Update Barcode Label</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
  
                <div class="row mb-3">
                  <div class="col-sm-12">
                    <label for="txUpdateBarcodeLabel">Barcode Label</label>
                    <input type="text" class="form-control" name="txUpdateBarcodeLabel" id="txUpdateBarcodeLabel">
                    <span id="errUpdateBarcodeLabel" class="text-danger"></span>
                  </div>
                </div>

            </div>

            <div class="modal-footer">
                <button id="btnUpdateBarcodeLabel" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
  </div>
  {{-- end modal update barcode label --}}


{{-- modal update barcode label --}}
<div class="modal fade" data-bs-backdrop="static" id="modalUpdateUUID" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Update UUID</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
  
                <div class="row mb-3">
                  <div class="col-sm-12">
                    <label for="txUpdateUUID">UUID</label>
                    <input type="text" class="form-control" name="txUpdateUUID" id="txUpdateUUID">
                    <span id="errUpdateUUID" class="text-danger"></span>
                  </div>
                </div>

            </div>

            <div class="modal-footer">
                <button id="btnUpdateUUID" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
{{-- end modal update barcode label --}}

{{-- modal update tipe hp --}}
<div class="modal fade" data-bs-backdrop="static" id="modalUpdateTipeHp" tabindex="-1">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Update Tipe HP</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
  
                <div class="row mb-3">
                  <div class="col-sm-12">
                    <label for="txUpdateTipeHp">Tipe HP</label>
                    <input type="text" class="form-control" name="txUpdateTipeHp" id="txUpdateTipeHp">
                    <span id="errUpdateTipeHp" class="text-danger"></span>
                  </div>
                </div>

            </div>

            <div class="modal-footer">
                <button id="btnUpdateTipeHp" class="btn btn-primary">Update</button>
            </div>
        </div>
    </div>
</div>
{{-- end modal update tipe hp --}}



    @endsection

    @section('script')

        <script>
            let button = document.getElementById('button');
            const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
              <div class="spinner-border d-flex justify-content-center align-items-center text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
            </div>`;
            const loaderIcon = `<i class='bx bx-loader bx-spin align-middle me-2'></i>`
            let imgDepan = null;
            let imgBelakang = null;

            $('#btnSubmitMMS').prop('disabled', true)

            $('#containerUploadFoto').hide();

            $('#checkUploadFoto').click(()=>{
                $('#containerUploadFoto').toggle();
                $('#containerTakeFoto').toggle();
            })

            $('#fotoDepanSuccess').hide();
            $('#fotoBelakangSuccess').hide();

            // summernote init
            $(document).ready(function(){
                $('#txDeskripsi').summernote({
                    placeholder: 'Tulis tanggapan',
                    tabsize: 2,
                    height: 120,
                    toolbar: [
                        ['font', ['bold', 'italic', 'underline']],
                        ['para', ['ul', 'ol']],
                    ]
                });
            });

            function leftClick() {
                button.style.left = "0"
            }

            function rightClick() {
                button.style.left = "185px"
            }

            $('#gambarDpn').change(function(e){
                imgDepan = e.target.files[0];
                // console.log(ima);
            })
            $('#gambarBlkng').change(function(e){
                imgBelakang = e.target.files[0];
            })

            // const tglMasuk = flatpickr(".flatpickr", {
            //                     dateFormat: "d-m-Y",
            //                     defaultDate: "today",
            //                 });

            const btnModal = $('#btnModalRepair');
            const modalForm = $('#modalRepairData');
            const btndaftar = $('#btnDaftar');
            const modaldaftar = $('#modalDaftar');
            const btnSubmitRepair = $('#btnSubmitRepair');
            const pageBody = $('body');

            $('#section__view__infomasipengguna').hide();
            $('#section__view__riwayatstatus').hide()
            $('#section__view__informasitanggapan').hide();

            btndaftar.click(e => {
                e.preventDefault();

                const roles = '{{ session()->get('loggedInUser')['session_roles'] }}'

                if(parseInt(roles) === 64 || parseInt(roles) === 63){
                    modaldaftar.modal('show');
                }else{
                    showMessage('error', 'Kamu tidak punya akses')
                }

            });

            btnModal.click(e => {
                e.preventDefault();
                modalForm.modalfil('show');

            });



            // get data mms list
            const getAllMmsList = () => {

                const txSearch = $('#txSearch').val()
                const merkHP = $('#selectMerekHPFilter').val() ? $('#selectMerekHPFilter').val() : 0;
                const permohonan = $('#selectPermohonan').val() ? $('#selectPermohonan').val() : 0;
                const statusPermohonan = $('#selectStatusPermohonan').val() ? $('#selectStatusPermohonan').val() : 0;
                const waktuPengajuan = $('input[name="rdWaktuPengajuan"]:checked').val() === undefined ? 0 : $('input[name="rdWaktuPengajuan"]:checked').val();

                $.ajax({
                    url: '{{ route('mmslist') }}', 
                    method: 'GET', 
                    data: {txSearch,merkHP,permohonan,statusPermohonan,waktuPengajuan},
                    beforeSend: () => {
                        $('#containerMMS').html(loadSpin);
                    },
                }).done(res => {
                    // console.log(res);
                    $('#containerMMS').html(res);
                    $('#tableMMS').DataTable({
                        searching: false,
                        lengthChange: false,
                        "bSort": false,
                    });
                });
            }

            getAllMmsList();


            // section modal
            $('#section__two').hide()
            $('#section__three').hide()

            $('#btnSection1').click(e => {
                e.preventDefault();

                $('#section__one').hide();
                $('#section__three').hide();
                $('#section__two').show();
            })

            $('#btnSection2').click(e => {
                e.preventDefault();

                $('#section__three').show();
                $('#section__one').hide();
                $('#section__two').hide();
            })


            


            function btnBack(){

                const sectionOne = $('#section__one');
                const sectionTwo = $('#section__two');
                const sectionThree = $('#section__three');

                if(sectionOne.is(':visible')){
                    $('#formDaftar')[0].reset();
                    modaldaftar.modal('hide');
                }else if(sectionTwo.is(':visible')){
                    $('#currentNumber').text('1');
                    $('#currentText').text('Informasi Karyawan dan Jenis Permohonan');
                    $('#btnSubmitMMS').text('Selanjutnya')
                    sectionTwo.hide()
                    sectionOne.show()
                }else{
                    $('#currentNumber').text('2');
                    $('#currentText').text('Informasi Perangkat');
                    $('#btnSubmitMMS').text('Daftar MMS')
                    $('#modalDaftarTitle').text('Daftar Mobile Management System')
                    $('#btnSubmitMMS').prop('type', 'button')
                    sectionThree.hide();
                    sectionTwo.show()
                }

            }

            function checkImei(imei) {
                return $.ajax({
                    url: '{{ route('checkimei') }}',
                    method: 'GET',
                    data: { imei }
                }).then(function(res) {
                    if (res.status === 400) {
                    return true;
                    } else {
                    return false;
                    }
                });
            }

            function checkUUID(uuid) {
                return $.ajax({
                    url: '{{ route('checkuuid') }}',
                    method: 'GET',
                    data: { uuid }
                }).then(function(res) {
                    if (res.status === 400) {
                    return true;
                    } else {
                    return false;
                    }
                });
            }

            function checkBarcodeLabel(barcodeLabel) {
                return $.ajax({
                    url: '{{ route('checkbarcodelabel') }}',
                    method: 'GET',
                    data: { barcodeLabel }
                }).then(function(res) {
                    console.log(res);
                    if (res.status === 400) {
                    return true;
                    } else {
                    return false;
                    }
                });
            }

            // function checkUserExists(username, callback) {
            //     $.ajax({
            //         url: '{{ route('checkimei') }}',
            //         method: 'GET',
            //         data: { txImei: txImei2 }
            //         success: function(response) {
            //         if (response === 'exists') {
            //             callback(true);
            //         } else {
            //             callback(false);
            //         }
            //         },
            //         error: function() {
            //         callback(false);
            //         }
            //     });
            // }

            
            const btnNext = async () => {

                

                const sectionOne = $('#section__one');
                const sectionTwo = $('#section__two');
                const sectionThree = $('#section__three');

                if(sectionOne.is(':visible')){

                    sectionOne.hide()
                    sectionTwo.show()
                    $('#currentNumber').text('2');
                    $('#currentText').text('Informasi Perangkat');
                    $('#btnSubmitMMS').text('Daftar MMS')

                    // generate ke konfirmasi
                    $('#daftarNama').text($('#txNama').val() ? $('#txNama').val() : '-');
                    $('#daftarDept').text($('#txDepartmen').val() ? $('#txDepartmen').val() : '-');
                    $('#daftarJoinDate').text($('#txMulaiMasuk').val() ? $('#txMulaiMasuk').val() : '-');
                    
                    
                    $('#daftarBadge').text($('#txBadge').val() ? $('#txBadge').val() : '-');
                    $('#daftarPosisi').text($('#txPosisi').val() ? $('#txPosisi').val() : '-');

                    

                    var permohonanText = $("input[name='rdPermohonan']:checked").siblings("label").text();
                    

                    $('#daftarJenisPermohonan').text(permohonanText ? permohonanText : '-');
                    
                    
                    // $('#daftarJoinDate').text(permohonanText ? permohonanText : '-');


                }else if(sectionTwo.is(':visible')){

                    var selectedText = $('#selectMerekHP option:selected').text();

                    
                    $('#daftarUUID').text($('#txUUID').val() ? $('#txUUID').val() : '-');
                    $('#daftarTipe').text($('#txTipeHP').val() ? $('#txTipeHP').val() : '-');
                    $('#daftarImei1').text($('#txImei1').val() ? $('#txImei1').val() : '-');
                    $('#daftarMerkHP').text(selectedText ? selectedText : '-');
                    $('#daftarNoSerial').text($('#txNoSerial').val() ? $('#txNoSerial').val() : '-');
                    $('#daftarImei2').text($('#txImei2').val() ? $('#txImei2').val() : '-');
                    $('#daftarBarcode').text($('#txBarcodeLabel').val() ? $('#txBarcodeLabel').val() : '-');  

                    // validasi
                    const txImei = $('#txImei1').val();
                    const txImei2 = $('#txImei2').val();
                    const txTipeHP = $('#txTipeHP').val();
                    const txUUID = $('#txUUID').val();
                    const txBarcodeLabel = $('#txBarcodeLabel').val();


                    if($('#selectMerekHP').val() === "79"){
                        if($('#txMerekHpLain').val() === ""){
                            $('#errMerekHpLain').text('Merek HP lainnya tidak boleh kosong')
                            return
                        }else{
                            $('#errMerekHpLain').text('')
                        }
                    }


                    if(txImei === ""){
                        $('#errImei1').text('Imei 1 tidak boleh kosong')
                        return;
                    }else{
                        $('#errImei1').text('')
                    }

                    if(txUUID === "" && txBarcodeLabel === ""){
                        $('#errBarcodeLabel').text('UUID atau Barcode Label tidak boleh kosong')
                        $('#errUUID').text('UUID atau Barcode Label tidak boleh kosong')
                        return;
                    }else{
                        $('#errBarcodeLabel').text('')
                        $('#errUUID').text('')
                    }

                    if(txTipeHP === ""){
                        $('#errTipeHP').text('Tipe HP tidak boleh kosong')
                        return;
                    }else{
                        $('#errTipeHP').text('')
                    }

                    if(txImei.length !== 15){
                        $('#errImei1').text('Imei tidak boleh lebih kecil atau lebih besar dari 15 digit')
                        return;
                    }else{
                        $('#errImei1').text('')
                    }

                    // imei
                    // fungsi imei
                    const statusImei1 = await checkImei(txImei).then(function(response){

                        if(response === true){
                            $('#errImei1').text('Imei 1 sudah terdaftar atau duplikat')
                            return true; 
                        }else{
                            $('#errImei1').text('')
                        }
                    })

                    if(statusImei1 === true){
                        return;
                    }

                    const statusImei2 = await checkImei(txImei2).then(function(response){

                        if(response === true){
                            $('#errImei2').text('Imei 2 sudah terdaftar atau duplikat')
                            return true; 
                        }else{
                            $('#errImei2').text('')
                        }
                    })

                    if(statusImei2 === true){
                        return;
                    }

                    if(txImei === txImei2){
                        $('#errImei1').text('Imei 1 dan imei 2 tidak boleh sama')
                        $('#errImei2').text('Imei 2 dan imei 1 tidak boleh sama')
                        return;
                    }else{
                        $('#errImei1').text('')
                        $('#errImei2').text('')
                    }


                    // check uuid
                    const statusUuid = await checkUUID(txUUID).then(function(response){

                    if(response === true){
                        $('#errUUID').text('UUID sudah terdaftar atau duplikat')
                        return true; 
                    }else{
                        $('#errUUID').text('')
                    }
                    })

                    if(statusUuid === true){
                        return;
                    }


                    // check barcode label duplikat entry
                    if(txBarcodeLabel){
                        const statusBarcodeLabel = await checkBarcodeLabel(txBarcodeLabel).then(function(response){

                        // console.log(txBarcodeLabel);

                        if(response === true){
                            $('#errBarcodeLabel').text('Barcode sudah terdaftar atau duplikat')
                            return true; 
                        }else{
                            $('#errBarcodeLabel').text('')
                        }
                        })

                        if(statusBarcodeLabel === true){
                        return;
                        }
                    }
                    

                    // console.log(aa);
                    // return;

                    // await checkImei(txImei2).then(function(response){

                    //     if(response === true){
                    //         $('#errImei2').text('Imei 2 sudah terdaftar atau duplikat')
                    //         return; 
                    //     }else{
                    //         $('#errImei2').text('')
                    //     }
                    // })

                    // if($('#errImei1').text() !== "" || $('#errImei2').text() !== "") return;

                    // check jika status gambar kosong untuk webcam
                    if($('#checkUploadFoto').prop('checked') === false){
             

                        if(!$('#gambarDpnCamera').val()){
                            $('#errImage1').text('Foto depan tidak boleh kosong')
                            return
                        }else{
                            $('#errImage1').text('')
                        }

                        if(!$('#gambarBlkngCamera').val()){
                            $('#errImage2').text('Foto belakang tidak boleh kosong')
                            return
                        }else{
                            $('#errImage2').text('')
                        }
 
                    }else{
                
                        if(!$('#gambarDpn').val()){
                            $('#errImage1').text('Foto depan tidak boleh kosong')
                            return
                        }else{
                            $('#errImage1').text('')
                        }
                        if(!$('#gambarBlkng').val()){
                            $('#errImage2').text('Foto belakang tidak boleh kosong')
                            return
                        }else{
                            $('#errImage2').text('')
                        }
                    }
                   


                    sectionTwo.hide()
                    sectionThree.show()
                    $('#currentNumber').text('3');
                    $('#currentText').text('');
                    $('#btnSubmitMMS').text('Konfirmasi Pendaftaran')
                    $('#btnSubmitMMS').removeClass('btn-secondary')
                    $('#btnSubmitMMS').addClass('btn-primary')
                    $('#modalDaftarTitle').text('Konfirmasi Pendaftaran')
                }else if(sectionThree.is(':visible')){

                    $('#btnSubmitMMS').prop('type', 'submit')

                }
                
            }
            


            // end section modal

            // section view MMS
            pageBody.on('click', '.btnView', function(e){
                e.preventDefault()

                const dataId = $(this).data('id');

                if(dataId){

                    $.ajax({
                        url: '{{ route('getmmsbyid') }}', 
                        method: 'get', 
                        dataType: 'json', 
                        data: {dataId},
                    }).done(res => {

                        if(res.status !== 200){
                            return;
                        }


                        let imgDpn = res.dataMMS[0].img_dpn ? res.dataMMS[0].img_dpn : '';
                        let imgBlk = res.dataMMS[0].img_blk ? res.dataMMS[0].img_blk : '';

                        let date = new Date(res.dataMMS[0].waktu_pengajuan);
                        let newDate = `${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()}`;

                        let date2 = new Date(res.dataKaryawan[0].join_date);
                        let newDate2 = `${date2.getDate()}-${date2.getMonth() + 1}-${date2.getFullYear()}`;

                        // console.log(res.dataMMS);
                        // console.log(res.dataMMS);
                        
                        $('#txViewMerekHP').text(res.dataMMS[0].merek_hp ? res.dataMMS[0].merek_hp : '-')
                        $('#txViewTipeHP').text(res.dataMMS[0].tipe_hp ? res.dataMMS[0].tipe_hp : '-')
                        $('#txViewImei1').text(res.dataMMS[0].imei1 ? res.dataMMS[0].imei1 : '-')
                        $('#txViewImei2').text(res.dataMMS[0].imei2 ? res.dataMMS[0].imei2 : '-')
                        $('#txViewJenisPermohonan').text(res.dataMMS[0].jenis_permohonan ? res.dataMMS[0].jenis_permohonan : '-')
                        $('#txViewWaktuPengajuan').text(res.dataMMS[0].waktu_pengajuan ? res.dataMMS[0].waktu_pengajuan : '-')
                        $('#txViewWaktuPengajuan').text(newDate ? newDate : '-')
                        $('#txViewStatusPengajuan').text(res.dataMMS[0].status_pendaftaran_mms ? res.dataMMS[0].status_pendaftaran_mms : '-')
                        // $('#containerImgDpn').attr('src', `{{ asset('img/${imgDpn}') }}`);
                        // $('#containerImgBlk').attr('src', `{{ asset('img/${imgBlk}') }}`);
                        $('#containerImgDpn').attr('src', imgBlk);
                        $('#containerImgBlk').attr('src', imgBlk);
                        $('#valMMSId').val(res.dataMMS[0].id)
                        $('#valStatusId').val(res.dataMMS[0].status_pendaftaran_mms_id)
                        $('#txViewUUID').text(res.dataMMS[0].uuid ? res.dataMMS[0].uuid : '-')
                        $('#txViewBarcodeLabel').text(res.dataMMS[0].barcode_label ? res.dataMMS[0].barcode_label : '-')

                        // view slide 2
                        $('#txViewName').text(res.dataKaryawan[0].fullname ? res.dataKaryawan[0].fullname : '-')
                        $('#txViewBadge').text(res.dataKaryawan[0].badge_id ? res.dataKaryawan[0].badge_id : '-')
                        $('#txViewDept').text(res.dataKaryawan[0].dept_code ? res.dataKaryawan[0].dept_code : '-')
                        $('#txViewPosition').text(res.dataKaryawan[0].position_code ? res.dataKaryawan[0].position_code : '-')
                        $('#txViewJoinDate').text(newDate2 ? newDate2 : '-')


                        let containerRiwayatStatus = '';
                        let containerRiwayatClock = '';
                        let containerRiwayatStatusLength = res.dataRiwayat.length;

                        htmlTimeline = '';
                            if(res.dataRiwayat.length > 0){
                                containerRiwayatStatus = '<ul>';
                                $.each(res.dataRiwayat, (i, v) => {

                                    let date = new Date(v.createdate);
                                    let arrMonth = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"]
                                    let newDate = `${date.getDate()} ${arrMonth[date.getMonth()]} ${date.getFullYear()}`;
                                    let newTime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;

                                    htmlTimeline += `<li class="li-timeline"><p class="fw-bold mb-0">${v.stat_title}</p>
                                            <span class="text-muted" style="font-size: 11px">${v.stat_desc}</span>
                                        </li>`;
                                    if($('#containerTimeline').children().length > 0){
                                        $('#containerTimeline').children().remove()
                                    }

                                    

                                    if(i !== containerRiwayatStatusLength-1){
                                        containerRiwayatStatus += 
                                        `          
                                        <li class="step step--done">
                                            <div class="step__title">${v.stat_title}</div>
                                            <p class="step__detail">${v.stat_desc}.</p>
                                            <div class="step__circle">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 12l5 5l10 -10"></path>
                                                </svg>
                                            </div>
                                        </li>
                                        `;

                                    }
                                    
                                    containerRiwayatClock += 
                                    `
                                    <div style="margin-bottom:30px;">
                                        <p class="fw-bold mb-0">${newDate}</p>
                                        <span class="text-muted">${newTime}</span>
                                    </div> 
                                    `;
                                    
                                })

                                // console.log(res.dataRiwayat[containerRiwayatStatusLength-1].createdate);

                                if(res.dataRiwayat[containerRiwayatStatusLength-1].stat_title === "Selesai"){
                                    let date = new Date(res.dataRiwayat[containerRiwayatStatusLength-1].createdate);
                                    let arrMonth = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"]
                                    let newDate = `${date.getDate()} ${arrMonth[date.getMonth()]} ${date.getFullYear()}`;
                                    let newTime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;

                                    containerRiwayatStatus += 
                                    `<li class="step step--done">
                                        <div class="step__title">${res.dataRiwayat[containerRiwayatStatusLength-1].stat_title}</div>
                                        <p class="step__detail">${res.dataRiwayat[containerRiwayatStatusLength-1].stat_desc}.</p>
                                        <div class="step__circle">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg>
                                        </div>
                                    </li>`;

                                    // containerRiwayatClock += 
                                    // `
                                    // <div class="mb-4">
                                    //     <p class="fw-bold mb-0">${newDate}</p>
                                    //     <span class="text-muted">${newTime}</span>
                                    // </div> 
                                    // `;
                                }else{
                                    let date = new Date(res.dataRiwayat[containerRiwayatStatusLength-1].createdate);
                                    let arrMonth = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"]
                                    let newDate = `${date.getDate()} ${arrMonth[date.getMonth()]} ${date.getFullYear()}`;
                                    let newTime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;
                                    containerRiwayatStatus += 
                                    `<li class="step step--upcoming">
                                        <div class="step__title">${res.dataRiwayat[containerRiwayatStatusLength-1].stat_title}</div>
                                        <p class="step__detail">${res.dataRiwayat[containerRiwayatStatusLength-1].stat_desc}.</p>
                                        <div class="step__circle"></div>
                                    </li>`;
                                }

                                
                            }

                            

                            if(res.dataRiwayat2.length > 0){
                                $.each(res.dataRiwayat2, (i, v) => {

                                    containerRiwayatStatus += 
                                    `<li class="step step--upcoming">
                                        <div class="step__title">${v.stat_title}</div>
                                        <p class="step__detail">${v.stat_desc}.</p>
                                        <div class="step__circle"></div>
                                    </li>`;

                                });
                            }

                            // console.log(res.dataRiwayat2.length > 0);

                            containerRiwayatStatus += '</ul>';
                        
                        // console.log(res.dataRiwayat);
                            
                        $('#containerRiwayatStatus').children().remove()
                        $('#containerRiwayatStatus').html(containerRiwayatStatus);
                        $('#containerRiwayatClock').children().remove()
                        $('#containerRiwayatClock').html(containerRiwayatClock);

                        let htmlTanggapan = '';
                        if(res.dataTanggapan.length > 0){
                            $.each(res.dataTanggapan, (i, v) => {

                                let date = new Date(v.waktu);
                                let arrMonth = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"]
                                let newDate = `${date.getDate()} ${arrMonth[date.getMonth()]} ${date.getFullYear()}`;
                                let newTime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;

                                // htmlTanggapan += 
                                // `<div class="card mb-1">    
                                //             <div class="card-body d-flex justify-content-between">
                                //                 <div class="col-sm-2 border-end">
                                //                     <p class="mb-0 fw-bold text-muted">${newDate}</p>
                                //                     <p style="font-size: 12px" class="mb-0 fw-bold">Jam : ${newTime}</p>
                                //                 </div>
                                //                 <div class="col-sm-10 ms-2">
                                //                     <p class="mb-0 fw-bold">${v.fullname}</p>
                                //                     ${v.respon}
                                //                 </div>
                                //             </div>
                                //         </div>`;
                                    // <img class="rounded-circle" src="{{ asset('img/foto-blkng.png') }}" width="50" height="50">
                                let photoTanggapan = v.photo ? v.photo : '{{ asset('img/user.png') }}';
                                htmlTanggapan += 
                                `
                                <div class="card border border-1">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-6">
                                                <img class="rounded-circle" src="${photoTanggapan}" width="50" height="50">
                                                <span class="ms-3 fw-bold">${v.fullname}</span>
                                            </div>
                                            <div class="col-sm-6 text-end">
                                                <span style="font-size: 12px">${newDate} Jam: ${newTime}</span>                 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                ${v.respon}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                            })
                        }

                        // $('#containerTanggapan').html(htmlTanggapan);
                        $('#newContainerTanggapan').html(htmlTanggapan);

                        // if(res.dataRiwayat2.length > 0){
                        //     $.each(res.dataRiwayat2, (i, v) => {
                        //         htmlTimeline += `<li class="li-timeline"><p class="fw-bold mb-0">${v.stat_title}</p>
                        //                 <span class="text-muted" style="font-size: 11px">${v.stat_desc}</span>
                        //             </li>`;
                        //         if($('#containerTimeline').children().length > 0){
                        //             $('#containerTimeline').children().remove()
                        //         }
                        //     })
                        // }

                        // $('#containerTimeline').html(htmlTimeline)

                        const statusAktif = parseInt(res.dataMMS[0].is_active) === 1 ? '' : 'checked';
                        if(parseInt(res.dataMMS[0].is_active) === 1){
                            $('#stts').prop('checked', false)
                            $('#stts').val('0');
                        }else{
                            $('#stts').prop('checked', true)
                            $('#stts').val('1');

                        }


                        // set button hide
                        const statusId = res.dataMMS[0].status_pendaftaran_mms_id ? parseInt(res.dataMMS[0].status_pendaftaran_mms_id) : 0;
                        const roles = '{{ session()->get('loggedInUser')['session_roles'] }}'

                  
                        if(parseInt(roles) == '63'){
                            $('#btnEditBarcodeLabel').hide();
                            $('#btnEditUUID').show();
                            if(statusId == '2'){
                                $('#btnTerimaPengajuan').show();
                                $('#btnTotalPengajuan').show();
                                $('#btnSimpanTanggapan').show()
                            }else{
                                $('#btnTerimaPengajuan').hide();
                                $('#btnTotalPengajuan').hide();
                                $('#btnSimpanTanggapan').hide()
                            }
                        }else if(parseInt(roles) == '64'){
                            $('#btnEditBarcodeLabel').hide();
                            $('#btnEditUUID').show();
                            if(statusId == '2' || statusId == '4'){
                                $('#btnTerimaPengajuan').show();
                                $('#btnTotalPengajuan').show();
                                $('#btnSimpanTanggapan').show()
                            }else{
                                $('#btnTerimaPengajuan').hide();
                                $('#btnTotalPengajuan').hide();
                                $('#btnSimpanTanggapan').hide()
                            }
                        }else if(parseInt(roles) == '65'){
                            $('#btnEditBarcodeLabel').show();
                            $('#btnEditUUID').hide();
                            if(statusId == '7'){
                                $('#btnTerimaPengajuan').show();
                                $('#btnTotalPengajuan').show();
                                $('#btnSimpanTanggapan').show()
                            }else{
                                $('#btnTerimaPengajuan').hide();
                                $('#btnTotalPengajuan').hide();
                                $('#btnSimpanTanggapan').hide()
                            }
                        }else if(parseInt(roles) == '66'){
                            $('#btnEditBarcodeLabel').show();
                            $('#btnEditUUID').hide();
                            if(statusId == '7' || statusId == '9'){
                                $('#btnTerimaPengajuan').show();
                                $('#btnTotalPengajuan').show();
                                $('#btnSimpanTanggapan').show()
                            }else{
                                $('#btnTerimaPengajuan').hide();
                                $('#btnTotalPengajuan').hide();
                                $('#btnSimpanTanggapan').hide()
                            }
                        }


                        // if(parseInt(roles) === 64 && statusId === 4){
                        //     $('#btnTerimaPengajuan').hide();
                        //     $('#btnTotalPengajuan').hide();
                        // }

                        // if(parseInt(roles) !== 65 && statusId !== 7){
                        //     $('#btnTerimaPengajuan').hide();
                        //     $('#btnTotalPengajuan').hide();
                        // }

                        // if(parseInt(roles) !== 66 && statusId !== 9){
                        //     $('#btnTerimaPengajuan').hide();
                        //     $('#btnTotalPengajuan').hide();
                        // }

                        

                        if(statusId === 3 || statusId === 5 || statusId === 8 || statusId === 10 || statusId === 12) {
                            // $('#btnTerimaPengajuan').hide();
                            // $('#btnTotalPengajuan').hide();
                            $('#containerSetActive').show();
                            // $('#btnEditBarcodeLabel').show();
                        }else{
                            // $('#btnTerimaPengajuan').show();
                            // $('#btnTotalPengajuan').show();
                            $('#containerSetActive').hide();
                            // $('#btnEditBarcodeLabel').hide();
                        }

                        $('#modalView').modal('show')


                    })

                }

            })
            // end section view MMS



            // handle switch
            const btnMMS = $('#btn-mms')
            $('#btnViewInformasiPerangkat').click(e => {
                e.preventDefault()
                btnMMS.animate({left: '0'}, 5);
                $('#section__view__infomasiperangkat').show();
                $('#section__view__infomasipengguna').hide();
                $('#section__view__riwayatstatus').hide()
                $('#section__view__informasitanggapan').hide();
            })
            $('#btnViewInformasiPengguna').click(e => {
                e.preventDefault()
                btnMMS.animate({left: '215px'}, 5);
                $('#section__view__infomasipengguna').show();
                $('#section__view__infomasiperangkat').hide();
                $('#section__view__riwayatstatus').hide()
                $('#section__view__informasitanggapan').hide();
            })
            $('#btnViewRiwayat').click(e => {
                e.preventDefault()
                btnMMS.animate({left: '400px'}, 5);
                $('#section__view__infomasipengguna').hide();
                $('#section__view__infomasiperangkat').hide();
                $('#section__view__riwayatstatus').show()
                $('#section__view__informasitanggapan').hide();
            })
            $('#btnViewInformasiTanggapan').click(e => {
                e.preventDefault()
                btnMMS.animate({left: '576px'}, 5);
                $('#section__view__infomasipengguna').hide();
                $('#section__view__infomasiperangkat').hide();
                $('#section__view__riwayatstatus').hide()
                $('#section__view__informasitanggapan').show();
            })
            // end handle switch


            // handle find badge id
            $('#txBadge').keypress(e => {

                const value = e.target.value;

                if(e.which === 13){
                    getKaryawanById(value);
                }
            })


            const getKaryawanById = (badge) => {
                $.ajax({
                    url: '{{ route('karyawanbyid') }}',
                    method: 'GET', 
                    data: {badgeId: badge},
                }).done(res => {
                    console.log(res);
                    if(res.status !== 200){
                        $('#errBadge').text(res.message)
                        return
                    }else{
                        $('#errBadge').text('')
                    }

                    $('#txNama').val(res.data.fullname)
                    $('#txDepartmen').val(`${res.data.dept_code}-${res.data.dept_name}`)
                    $('#txPosisi').val(res.data.position_name)
                    $('#txMulaiMasuk').val(res.data.join_date)
                    $('#btnSubmitMMS').removeClass('btn-secondary')
                    $('#btnSubmitMMS').addClass('btn-primary')
                    $('#btnSubmitMMS').prop('disabled', false)


                });
            }

            const getMerekHPList = () => {
                let html = '';
                $.ajax({
                    url: '{{ route('merekhplist') }}', 
                    method: 'GET', 
                }).done(res => {
                    // console.log(res);

                    if(res.status === 200){

                        $.each(res.data, (i, v) => {
                            html += `<option value="${v.id_vlookup}">${v.name_vlookup}</option>`;
                        });

                        if($('#selectMerekHP').children().length > 0){
                            $('#selectMerekHP').children().remove()
                        }
                        $('#selectMerekHP').append(html);
                        if($('#selectMerekHPFilter').children().length > 0){
                            $('#selectMerekHPFilter').children().remove()
                        }
                        $('#selectMerekHPFilter').append(html);

                    }
                })
            }

            getMerekHPList();

            const getOsList = () => {
                let html = '';
                $.ajax({
                    url: '{{ route('oslist') }}', 
                    method: 'GET', 
                }).done(res => {
                    // console.log(res);

                    if(res.status === 200){

                        $.each(res.data, (i, v) => {
                            html += `<option value="${v.id_vlookup}">${v.name_vlookup}</option>`;
                        });

                        if($('#selectOs').children().length > 0){
                            $('#selectOs').children().remove()
                        }
                        $('#selectOs').append(html);
                        $('#selectOs').val('32');

                    }
                })
            }

            getOsList();

            const getMerekHPListFilter = () => {
                let html = '';
                $.ajax({
                    url: '{{ route('merekhplist') }}', 
                    method: 'GET', 
                }).done(res => {
                    // console.log(res);

                    if(res.status === 200){

                        html += `<option value="">ALL</option>`;

                        $.each(res.data, (i, v) => {
                            html += `<option value="${v.id_vlookup}">${v.name_vlookup}</option>`;
                        });

                        if($('#selectMerekHPFilter').children().length > 0){
                            $('#selectMerekHPFilter').children().remove()
                        }
                        $('#selectMerekHPFilter').append(html);

                    }
                })
            }

            getMerekHPListFilter();


            // get permohonan list filter
            const getMerekPermohonanFilter = () => {
                let html = '';
                $.ajax({
                    url: '{{ route('permohonanlist') }}', 
                    method: 'GET', 
                }).done(res => {
                    // console.log(res);

                    if(res.status === 200){

                        html += `<option value="">ALL</option>`;

                        $.each(res.data, (i, v) => {
                            html += `<option value="${v.id}">${v.kategori}</option>`;
                        });

                        if($('#selectPermohonan').children().length > 0){
                            $('#selectPermohonan').children().remove()
                        }
                        $('#selectPermohonan').append(html);

                    }
                })
            }

            getMerekPermohonanFilter();

            // get status permohonan list filter
            const getStatusPermohonanFilter = () => {
                let html = '';
                $.ajax({
                    url: '{{ route('statuspermohonanlist') }}', 
                    method: 'GET', 
                }).done(res => {
                    // console.log(res);

                    if(res.status === 200){

                        html += `<option value="">ALL</option>`;

                        $.each(res.data, (i, v) => {
                            html += `<option value="${v.id}">${v.stat_title}</option>`;
                        });

                        if($('#selectStatusPermohonan').children().length > 0){
                            $('#selectStatusPermohonan').children().remove()
                        }
                        $('#selectStatusPermohonan').append(html);

                    }
                })
            }

            getStatusPermohonanFilter();


            $('#formDaftar').on('submit', function(e){
                e.preventDefault();    

                $.ajax({
                        url: '{{ route('simpanmms') }}', 
                        method: 'POST', 
                        data: new FormData(this), 
                        cache: false,
                        processData: false,
                        contentType: false, 
                        dataType: 'json',
                    }).done(res => {

                        if(res.status !== 200){
                            showMessage('error', res.message);
                            return
                        }

                        if(res.status === 200){              
                            showMessage('success', res.message);
                        }

                        // set checked reset
                        if($('#containerImgDpn').is(':visible')){
                            $('#checkUploadFoto').click();
                        }

                        $('#btnSubmitMMS').prop('type', 'button')
                        $(this)[0].reset();
                        $('#currentNumber').text('1');
                        $('#currentText').text('Informasi Karyawan dan Jenis Permohonan');
                        $('#btnSubmitMMS').text('Selanjutnya')
                        $('#section__two').hide()
                        $('#section__three').hide()
                        $('#section__one').show()
                        modaldaftar.modal('hide');
                        getAllMmsList();

                    })

            })



            // button filter
            $('#btnFilter').click(function(e){
                e.preventDefault()

                $('#modalFilterData').modal('show')
            })

            // handle pencarian data
            $('#txSearch').keyup(()=>{
                getAllMmsList();
            })
            // end handle pen

            // handle button filter
            $('#btnFilterData').click(function(e){
                e.preventDefault()
                // const statusPermohonan = document.querySelector('input[name="rdStatusPermohonan"]:checked').value;
                getAllMmsList();
                $('#modalFilterData').modal('hide')
            })
            // end button filter

            // button reset
            $('#btnReset').click(function(e){
                e.preventDefault();
                $('#txSearch').val('');
                $('#selectMerekHPFilter').val('');
                $('#selectPermohonan').val('');
                $('#selectStatusPermohonan').val('');
                $('input[name="rdWaktuPengajuan"]').prop('checked', false);
                getAllMmsList();
            })
            // end button reset

            // handle gambar depan preview
            $('#gambarDpn').change(function(){
                let reader = new FileReader();

                reader.onload = (e) => {
                    $('#containerGambarDpn').attr('src', e.target.result)
                }
                reader.readAsDataURL(this.files[0]);
            })

            $('#gambarBlkng').change(function(){
                let reader = new FileReader();

                reader.onload = (e) => {
                    $('#containerGambarBlkng').attr('src', e.target.result)
                }
                reader.readAsDataURL(this.files[0]);
            })

            // handle modal daftar close
            $('#btnCloseModalDaftar').click(function(){
                // e.preventDefault();

                $('#btnSubmitMMS').prop('type', 'button')
                $('#formDaftar')[0].reset();
                $('#currentNumber').text('1');
                $('#currentText').text('Informasi Karyawan dan Jenis Permohonan');
                $('#btnSubmitMMS').text('Selanjutnya')
                $('#section__two').hide()
                $('#section__three').hide()
                $('#section__one').show()
                $('#containerUploadFoto').hide();
                $('#containerTakeFoto').show();
                modaldaftar.modal('hide');
            })


            // Handle modal view saat di close
            $('#modalView').on('hidden.bs.modal', function (event) {
                $('#btnViewInformasiPerangkat').click()
            });

            $('#modalDaftar').on('hidden.bs.modal', function (event) {
                $('#fotoDepanSuccess').hide();
                $('#fotoBelakangSuccess').hide();
                $('#checkUploadFoto').prop('checked', false);
            });

            // handle statusPengajuan
            $('#btnTotalPengajuan').click(function(e){
                e.preventDefault();
                updateStatusPengajuan('tolak')
            });

            $('#btnTerimaPengajuan').click(e => {
                e.preventDefault();

               

                // console.log(statusId);
                // return;

                updateStatusPengajuan('terima')
            })


            const updateStatusPengajuan = (setStatus='') => {

                const mmsId = $('#valMMSId').val();

                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    // text: "You won't be able to revert this!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6e7881',
                    confirmButtonText: 'Yakin!', 
                    cancelButtonText: 'Tidak'
                    }).then((result) => {
                    if (result.isConfirmed) {


                        $.ajax({
                            url: '{{ route('updatepengajuanmms') }}',
                            method: 'post', 
                            data: { 
                                _token: '{{ csrf_token() }}',
                                setStatus, 
                                mmsId
                            }, 
                            dataType: 'json',
                        }).done(res => {
                            // console.log(res);

                            if(res.status !== 200){
                                showMessage('error', res.message)
                                return;
                            }

                            showMessage('success', res.message);
                            $('#modalView').modal('hide')
                            getAllMmsList();
                        })
                        // Swal.fire(
                        // 'Deleted!',
                        // 'Your file has been deleted.',
                        // 'success'
                        // )
                    }
                })
            }

            $('#btnSimpanTanggapan').click(e => {
                e.preventDefault()

                const dataTanggapan = $('#txDeskripsi').val();
                const mmsId = $('#valMMSId').val();

                if(dataTanggapan === "" || dataTanggapan === null){
                    return;
                }

                $.ajax({
                    url: '{{ route('simpantanggapanmms') }}',
                    method: 'POST', 
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        dataTanggapan, 
                        mmsId
                    },
                }).done(res => {
                    // console.log(res);

                    if(res.status !== 200){
                        showMessage('error', res.message)
                        return
                    }

                    showMessage('success', res.message)
                    $('#txDeskripsi').summernote('code', '');

                    getDataTanggapan(mmsId);
                    // $('#modalView').modal('hide')
                    
                })

                // console.log(dataTanggapan);

                // $('#takeFotoDepan').click(function(e){
                //     e.preventDefault();
                // })
            

                // if($(this).children().length > 0){
                //     $(this).children().remove();
                // }

                // $('#btnSimpanTanggapan').text('Please wait..');
                // $('#btnSimpanTanggapan').prepend(loaderIcon);


            })

            // Webcam.set({
            //     width: 320, 
            //     height: 240,
            //     image_format: 'jpeg', 
            //     jpeg_quality: 100
            // });

            // Webcam.attach('#my_camera');

            // function take_picture(){
            //     Webcam.snap(function(data_uri){
            //         $(".image-tag").val(data_uri);
            //         document.getElementById('results').innerHTML = '<img src="' + data_uri + '" />';
            //     })
            // }


            const getDataTanggapan = (id) => {

                let idMMS = id;
                $.ajax({
                    url: '{{ route('tanggapanlist') }}',
                    method: 'GET', 
                    dataType: 'json',
                    data: {
                        idMMS
                    },
                }).done(res => {
                    // console.log(res);
                    let htmlTanggapan = '';

                    if(res.status === 200){
                        if(res.dataTanggapan.length > 0){
                            $.each(res.dataTanggapan, (i, v) => {

                                let date = new Date(v.waktu);
                                let arrMonth = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"]
                                let newDate = `${date.getDate()} ${arrMonth[date.getMonth()]} ${date.getFullYear()}`;
                                let newTime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;
                                let photoTanggapan = v.photo ? v.photo : '{{ asset('img/user.png') }}';
                                htmlTanggapan += 
                                `<div class="card border border-1">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-6">
                                                <img class="rounded-circle" src="${photoTanggapan}" width="50" height="50">
                                                <span class="ms-3 fw-bold">${v.fullname}</span>
                                            </div>
                                            <div class="col-sm-6 text-end">
                                                <span style="font-size: 12px">${newDate} Jam: ${newTime}</span>                 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                ${v.respon}
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                            })
                        }

                        if($('#newContainerTanggapan').children().length > 0){
                            $('#newContainerTanggapan').children().remove();
                        }

                        $('#newContainerTanggapan').html(htmlTanggapan);
                    }
                })
            }

            

            // camera init
            $(document).ready(function(){
                Webcam.set({
                    width: 320, 
                    height: 240, 
                    image_format: 'jpeg', 
                    jpeq_quality: 90
                });

                // handle button camera 1
                $('#btnCameraDepan').on('click', function(){
                    $('#modalCamera').modal('show');
                    $('#confirmphoto').hide();
                    $('#retakephoto').hide()
                    Webcam.reset();
                    Webcam.on('error', function() {
                        $('#modalCamera').modal('hide');
                        swal({
                            title: 'Warning', 
                            text: 'Please give permission to access your webcam',
                            icon: 'warning'
                        
                        });
                    });
                    Webcam.attach('#myCamera');
                });

                // handle button camera 2
                $('#btnCameraBelakang').on('click', function(){
                    $('#modalCamera2').modal('show');
                    $('#confirmphoto2').hide();
                    $('#retakephoto2').hide()
                    Webcam.reset();
                    Webcam.on('error', function() {
                        $('#modalCamera2').modal('hide');
                        swal({
                            title: 'Warning', 
                            text: 'Please give permission to access your webcam',
                            icon: 'warning'
                        
                        });
                    });
                    Webcam.attach('#myCamera2');
                });
                
                $('#takephoto').on('click', previewSnapShot);
                $('#retakephoto').on('click', retakeSnapShot)
                $('#confirmphoto').on('click', saveSnapShot);

                $('#takephoto2').on('click', previewSnapShot2);
                $('#retakephoto2').on('click', retakeSnapShot2)
                $('#confirmphoto2').on('click', saveSnapShot2);

                $('#btnCloseModalCamera').click(e=>{
                    e.preventDefault()
                    $('#modalCamera').modal('hide');
                    $('#takephoto').show();
                    $('#confirmphoto').hide();
                    $('#retakephoto').hide()
                    Webcam.reset();
                })

                $('#btnCloseModalCamera2').click(e=>{
                    e.preventDefault()
                    $('#confirmphoto2').hide();
                    $('#retakephoto2').hide()
                    $('#takephoto2').show();
                    $('#modalCamera2').modal('hide');
                    Webcam.reset();
                })

            })


            function saveSnapShot()
            {
                Webcam.snap(function(data_uri){
                    var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
                    $('#gambarDpnCamera').val(raw_image_data);
                    $('#containerGambarDpn').attr('src', data_uri)
                    $('#fotoDepanSuccess').show();
                });

                $('#retakephoto').hide();
                $('#confirmphoto').hide();
                $('#takephoto').show();
                $('#modalCamera').modal('hide');
                Webcam.reset();
            }

            function retakeSnapShot(){
                $('#retakephoto').hide()
                $('#confirmphoto').hide();
                $('#takephoto').show();
                Webcam.unfreeze();
            }


            function previewSnapShot(){
                $('#takephoto').hide();
                $('#confirmphoto').show();
                $('#retakephoto').show()
                Webcam.freeze();
            }

            function saveSnapShot2()
            {
                Webcam.snap(function(data_uri){
                    var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
                    $('#gambarBlkngCamera').val(raw_image_data);
                    $('#containerGambarBlkng').attr('src', data_uri)
                    $('#fotoBelakangSuccess').show();
                });

                $('#retakephoto2').hide();
                $('#confirmphoto2').hide();
                $('#takephoto2').show();
                $('#modalCamera2').modal('hide');
                Webcam.reset();
            }

            function retakeSnapShot2(){
                $('#retakephoto2').hide()
                $('#confirmphoto2').hide();
                $('#takephoto2').show();
                Webcam.unfreeze();
            }


            function previewSnapShot2(){
                $('#takephoto2').hide();
                $('#confirmphoto2').show();
                $('#retakephoto2').show()
                Webcam.freeze();
            }
            
            
            pageBody.on('click', '.viewMMS', function(e){
                e.preventDefault()

                const dataId = $(this).data('id');

                if(dataId){

                    $.ajax({
                        url: '{{ route('getmmsbyid') }}', 
                        method: 'get', 
                        dataType: 'json', 
                        data: {dataId},
                    }).done(res => {

                        if(res.status !== 200){
                            return;
                        }


                        let imgDpn = res.dataMMS[0].img_dpn ? res.dataMMS[0].img_dpn : '';
                        let imgBlk = res.dataMMS[0].img_blk ? res.dataMMS[0].img_blk : '';

                        let date = new Date(res.dataMMS[0].waktu_pengajuan);
                        let newDate = `${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()}`;

                        let date2 = new Date(res.dataKaryawan[0].join_date);
                        let newDate2 = `${date2.getDate()}-${date2.getMonth() + 1}-${date2.getFullYear()}`;

                        // console.log(res.dataMMS);
                        // console.log(res.dataMMS);
                        
                        $('#txViewMerekHP').text(res.dataMMS[0].merek_hp ? res.dataMMS[0].merek_hp : '-')
                        $('#txViewTipeHP').text(res.dataMMS[0].tipe_hp ? res.dataMMS[0].tipe_hp : '-')
                        $('#txViewImei1').text(res.dataMMS[0].imei1 ? res.dataMMS[0].imei1 : '-')
                        $('#txViewImei2').text(res.dataMMS[0].imei2 ? res.dataMMS[0].imei2 : '-')
                        $('#txViewJenisPermohonan').text(res.dataMMS[0].jenis_permohonan ? res.dataMMS[0].jenis_permohonan : '-')
                        $('#txViewWaktuPengajuan').text(res.dataMMS[0].waktu_pengajuan ? res.dataMMS[0].waktu_pengajuan : '-')
                        $('#txViewWaktuPengajuan').text(newDate ? newDate : '-')
                        $('#txViewStatusPengajuan').text(res.dataMMS[0].status_pendaftaran_mms ? res.dataMMS[0].status_pendaftaran_mms : '-')
                        // $('#containerImgDpn').attr('src', `{{ asset('img/${imgDpn}') }}`);
                        // $('#containerImgBlk').attr('src', `{{ asset('img/${imgBlk}') }}`);
                        $('#containerImgDpn').attr('src', imgDpn);
                        $('#containerImgBlk').attr('src', imgBlk);
                        $('#valMMSId').val(res.dataMMS[0].id)
                        $('#valStatusId').val(res.dataMMS[0].status_pendaftaran_mms_id)
                        $('#txViewUUID').text(res.dataMMS[0].uuid ? res.dataMMS[0].uuid : '-')
                        $('#txViewBarcodeLabel').text(res.dataMMS[0].barcode_label ? res.dataMMS[0].barcode_label : '-')

                        // view slide 2
                        $('#txViewName').text(res.dataKaryawan[0].fullname ? res.dataKaryawan[0].fullname : '-')
                        $('#txViewBadge').text(res.dataKaryawan[0].badge_id ? res.dataKaryawan[0].badge_id : '-')
                        $('#txViewDept').text(res.dataKaryawan[0].dept_code ? res.dataKaryawan[0].dept_code : '-')
                        $('#txViewPosition').text(res.dataKaryawan[0].position_code ? res.dataKaryawan[0].position_code : '-')
                        $('#txViewJoinDate').text(newDate2 ? newDate2 : '-')


                        let containerRiwayatStatus = '';
                        let containerRiwayatClock = '';
                        let containerRiwayatStatusLength = res.dataRiwayat.length;

                        htmlTimeline = '';
                            if(res.dataRiwayat.length > 0){
                                containerRiwayatStatus = '<ul>';
                                $.each(res.dataRiwayat, (i, v) => {

                                    let date = new Date(v.createdate);
                                    let arrMonth = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"]
                                    let newDate = `${date.getDate()} ${arrMonth[date.getMonth()]} ${date.getFullYear()}`;
                                    let newTime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;

                                    htmlTimeline += `<li class="li-timeline"><p class="fw-bold mb-0">${v.stat_title}</p>
                                            <span class="text-muted" style="font-size: 11px">${v.stat_desc}</span>
                                        </li>`;
                                    if($('#containerTimeline').children().length > 0){
                                        $('#containerTimeline').children().remove()
                                    }

                                    if(i !== containerRiwayatStatusLength-1){
                                        containerRiwayatStatus += 
                                        `          
                                        <li class="step step--done">
                                            <div class="step__title">${v.stat_title}</div>
                                            <p class="step__detail">${v.stat_desc}.</p>
                                            <div class="step__circle">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M5 12l5 5l10 -10"></path>
                                                </svg>
                                            </div>
                                        </li>
                                        `;

                                    }
                                    containerRiwayatClock += 
                                    `
                                    <div class="mb-5">
                                        <p class="fw-bold mb-0">${newDate}</p>
                                        <span class="text-muted">${newTime}</span>
                                    </div> 
                                    `;

                                    
                                })

                                if(res.dataRiwayat[containerRiwayatStatusLength-1].stat_title === "Selesai"){
                                    // let date = new Date(res.dataRiwayat[containerRiwayatStatusLength-1].createdate);
                                    // let arrMonth = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"]
                                    // let newDate = `${date.getDate()} ${arrMonth[date.getMonth()]} ${date.getFullYear()}`;
                                    // let newTime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;

                                    containerRiwayatStatus += 
                                    `<li class="step step--done">
                                        <div class="step__title">${res.dataRiwayat[containerRiwayatStatusLength-1].stat_title}</div>
                                        <p class="step__detail">${res.dataRiwayat[containerRiwayatStatusLength-1].stat_desc}.</p>
                                        <div class="step__circle">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                <path d="M5 12l5 5l10 -10"></path>
                                            </svg>
                                        </div>
                                    </li>`;

                                    containerRiwayatClock += 
                                    `
                                    <div class="mb-5">
                                        <p class="fw-bold mb-0">${newDate}</p>
                                        <span class="text-muted">${newTime}</span>
                                    </div> 
                                    `;
                                }else{
                                    containerRiwayatStatus += 
                                    `<li class="step step--upcoming">
                                        <div class="step__title">${res.dataRiwayat[containerRiwayatStatusLength-1].stat_title}</div>
                                        <p class="step__detail">${res.dataRiwayat[containerRiwayatStatusLength-1].stat_desc}.</p>
                                        <div class="step__circle"></div>
                                    </li>`;
                                }
                            }
                        
                        // console.log(res.dataRiwayat);

                        if(res.dataRiwayat2.length > 0){
                            $.each(res.dataRiwayat2, (i, v) => {

                                containerRiwayatStatus += 
                                `<li class="step step--upcoming">
                                    <div class="step__title">${v.stat_title}</div>
                                    <p class="step__detail">${v.stat_desc}.</p>
                                    <div class="step__circle"></div>
                                </li>`;

                            });
                        }


                        containerRiwayatStatus += '</ul>';
                            
                        $('#containerRiwayatStatus').children().remove()
                        $('#containerRiwayatStatus').html(containerRiwayatStatus);
                        $('#containerRiwayatClock').children().remove()
                        $('#containerRiwayatClock').html(containerRiwayatClock);

                        let htmlTanggapan = '';
                        if(res.dataTanggapan.length > 0){
                            $.each(res.dataTanggapan, (i, v) => {

                                let date = new Date(v.waktu);
                                let arrMonth = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"]
                                let newDate = `${date.getDate()} ${arrMonth[date.getMonth()]} ${date.getFullYear()}`;
                                let newTime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;

                                // htmlTanggapan += 
                                // `<div class="card mb-1">    
                                //             <div class="card-body d-flex justify-content-between">
                                //                 <div class="col-sm-2 border-end">
                                //                     <p class="mb-0 fw-bold text-muted">${newDate}</p>
                                //                     <p style="font-size: 12px" class="mb-0 fw-bold">Jam : ${newTime}</p>
                                //                 </div>
                                //                 <div class="col-sm-10 ms-2">
                                //                     <p class="mb-0 fw-bold">${v.fullname}</p>
                                //                     ${v.respon}
                                //                 </div>
                                //             </div>
                                //         </div>`;
                                    // <img class="rounded-circle" src="{{ asset('img/foto-blkng.png') }}" width="50" height="50">
                                let photoTanggapan = v.photo ? v.photo : '{{ asset('img/user.png') }}';
                                htmlTanggapan += 
                                `
                                <div class="card border border-1">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-6">
                                                <img class="rounded-circle" src="${photoTanggapan}" width="50" height="50">
                                                <span class="ms-3 fw-bold">${v.fullname}</span>
                                            </div>
                                            <div class="col-sm-6 text-end">
                                                <span style="font-size: 12px">${newDate} Jam: ${newTime}</span>                 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                ${v.respon}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `;
                            })
                        }

                        // $('#containerTanggapan').html(htmlTanggapan);
                        $('#newContainerTanggapan').html(htmlTanggapan);

                        // if(res.dataRiwayat2.length > 0){
                        //     $.each(res.dataRiwayat2, (i, v) => {
                        //         htmlTimeline += `<li class="li-timeline"><p class="fw-bold mb-0">${v.stat_title}</p>
                        //                 <span class="text-muted" style="font-size: 11px">${v.stat_desc}</span>
                        //             </li>`;
                        //         if($('#containerTimeline').children().length > 0){
                        //             $('#containerTimeline').children().remove()
                        //         }
                        //     })
                        // }

                        // $('#containerTimeline').html(htmlTimeline)

                        const statusAktif = parseInt(res.dataMMS[0].is_active) === 1 ? '' : 'checked';
                        if(parseInt(res.dataMMS[0].is_active) === 1){
                            $('#stts').prop('checked', false)
                            $('#stts').val('0');
                        }else{
                            $('#stts').prop('checked', true)
                            $('#stts').val('1');

                        }

                        const statusId = res.dataMMS[0].status_pendaftaran_mms_id ? parseInt(res.dataMMS[0].status_pendaftaran_mms_id) : 0;
                        const roles = '{{ session()->get('loggedInUser')['session_roles'] }}'

                        // console.log(parseInt(roles) === 64 && statusId === 4);

                        if(parseInt(roles) == '63'){
                            $('#btnEditBarcodeLabel').hide();
                            $('#btnEditUUID').show();      
                            if(statusId == '2'){
                                $('#btnTerimaPengajuan').show();
                                $('#btnTotalPengajuan').show();
                                $('#btnSimpanTanggapan').show()
                            }else{
                                $('#btnTerimaPengajuan').hide();
                                $('#btnTotalPengajuan').hide();
                                $('#btnSimpanTanggapan').hide()
                            }

                        }else if(parseInt(roles) == '64'){
                            $('#btnEditBarcodeLabel').hide();
                            $('#btnEditUUID').show();
                            if(statusId == '2' || statusId == '4'){
                                $('#btnTerimaPengajuan').show();
                                $('#btnTotalPengajuan').show();
                                $('#btnSimpanTanggapan').show()
                            }else{
                                $('#btnTerimaPengajuan').hide();
                                $('#btnTotalPengajuan').hide();
                                $('#btnSimpanTanggapan').hide()
                            }

                        }else if(parseInt(roles) == '65'){
                            $('#btnEditBarcodeLabel').show();
                            $('#btnEditUUID').hide();
                            if(statusId == '7'){
                                $('#btnTerimaPengajuan').show();
                                $('#btnTotalPengajuan').show();
                                $('#btnSimpanTanggapan').show()
                            }else{
                                $('#btnTerimaPengajuan').hide();
                                $('#btnTotalPengajuan').hide();
                                $('#btnSimpanTanggapan').hide()
                            }

                        }else if(parseInt(roles) == '66'){
                            $('#btnEditBarcodeLabel').show();
                            $('#btnEditUUID').hide();
                            if(statusId == '7' || statusId == '9'){
                                $('#btnTerimaPengajuan').show();
                                $('#btnTotalPengajuan').show();
                                $('#btnSimpanTanggapan').show()
                            }else{
                                $('#btnTerimaPengajuan').hide();
                                $('#btnTotalPengajuan').hide();
                                $('#btnSimpanTanggapan').hide()
                            }

                        }
                        
                        // set button hide
                        // const statusId = res.dataMMS[0].status_pendaftaran_mms_id ? parseInt(res.dataMMS[0].status_pendaftaran_mms_id) : 0;
                        if(statusId === 3 || statusId === 5 || statusId === 8 || statusId === 10 || statusId === 12) {
                            // $('#btnTerimaPengajuan').hide();
                            // $('#btnTotalPengajuan').hide();
                            $('#containerSetActive').show();
                            // $('#btnEditBarcodeLabel').show();
                        }else{
                            // $('#btnTerimaPengajuan').show();
                            // $('#btnTotalPengajuan').show();
                            $('#containerSetActive').hide();
                            // $('#btnEditBarcodeLabel').hide();
                        }

                        $('#modalView').modal('show')


                    })

                }
            })



            // image view
            // $('.imgView').click(function(e){
            //     e.preventDefault()
            //     console.log('dadwad');

            //     // if($(this).attr('src')){
            //     //     $('#imageView').attr('src', $(this).attr('src'))
            //     //     $('#modalViewGambar').modal('show')
            //     // }

            // })

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

            

            $('#stts').click(function(){

                const status = parseInt($('#stts').val());


                const valMMSId = $('#valMMSId').val();


                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    // text: "You won't be able to revert this!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6e7881',
                    confirmButtonText: 'Yakin!', 
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {

                        $.ajax({
                            url: '{{ route('setinactivemobile') }}',
                            method: 'GET', 
                            data: {valMMSId, status},
                        }).done(res => {

                            if(res.status === 400){
                                showMessage('error', res.message);
                                return;
                            }else{
                                if(status === 1){
                                    $('#stts').val('0');
                                }else{
                                    $('#stts').val('1');
                                }

                                showMessage('success', res.message);
                            }

                            
                        })

                    }
                });



                
             
            })


            $('#btnEditBarcodeLabel').click(e => {
                e.preventDefault();

                // let checkBL = checkBarcodeLabel()
                // return;
                $('#modalUpdateBarcodeLabel').modal('show');
            })

            $('#modalUpdateBarcodeLabel').on('hidden.bs.modal', function (event) {
                $('#txUpdateBarcodeLabel').val('');
                $('errUpdateBarcodeLabel').text('');
            });

            $('#btnUpdateBarcodeLabel').click(async e=>{
                e.preventDefault();

                const valMMSId = $('#valMMSId').val();
                const txUpdateBarcodeLabel = $('#txUpdateBarcodeLabel').val();

                if(!txUpdateBarcodeLabel){
                    $('#errUpdateBarcodeLabel').text('Barcode Label tidak boleh kosong')
                    return;
                }else{
                    $('#errUpdateBarcodeLabel').text('')
                }


                $.ajax({
                    url: '{{ route('updatebarcodelabel') }}',
                    method: 'get', 
                    dataType: 'json',
                    data: {valMMSId, txUpdateBarcodeLabel},
                }).done(res => {
                    // console.log(res);

                    if(res.status === 400){
                        showMessage('error', res.message)
                        return;
                    }else{
                        showMessage('success', res.message)
                        // console.log(res);
                        $('#txViewBarcodeLabel').text(res.barcode);
                        $('#modalUpdateBarcodeLabel').modal('hide');
                        getAllMmsList();
                    }
                })

                // check barcode label duplikat entry
                // const statusBarcodeLabel = await checkBarcodeLabel(txUpdateBarcodeLabel).then(function(response){

                //     if(response === true){
                //         $('#errUpdateBarcodeLabel').text('Barcode sudah terdaftar atau duplikat')
                //         return true; 
                //     }else{
                //         $('#errUpdateBarcodeLabel').text('')
                //     }
                // })

                // console.log(statusBarcodeLabel);
                // if(statusBarcodeLabel === true){
                //     return;
                // }

            })


            // update uuid
            $('#btnEditUUID').click(e => {
                e.preventDefault();
                $('#modalUpdateUUID').modal('show');
            })

            $('#modalUpdateUUID').on('hidden.bs.modal', function (event) {
                $('#txUpdateUUID').val('');
                $('errUpdateUUID').text('');
            });
            $('#btnUpdateUUID').click(function(e){
                e.preventDefault()

                const valMMSId = $('#valMMSId').val();
                const txUpdateUUID = $('#txUpdateUUID').val();

                if(!txUpdateUUID){
                    $('#errUpdateUUID').text('UUID tidak boleh kosong')
                    return;
                }else{
                    $('#errUpdateUUID').text('')
                }

                $.ajax({
                    url: '{{ route('updateuuid') }}',
                    method: 'get', 
                    dataType: 'json',
                    data: {valMMSId, txUpdateUUID},
                }).done(res => {
                    console.log(res);

                    if(res.status === 400){
                        showMessage('error', res.message)
                        return;
                    }else{
                        showMessage('success', res.message)
                        $('#txViewUUID').text(res.barcode);
                        $('#modalUpdateUUID').modal('hide');
                        getAllMmsList();
                    }
                })

            })
            // end

            // proses update tipe hp
            $('#btnEditTipeHp').click(e => {
                e.preventDefault();
                $('#modalUpdateTipeHp').modal('show');
            })

            $('#modalUpdateTipeHp').on('hidden.bs.modal', function (event) {
                $('#txUpdateTipeHp').val('');
                $('errUpdateTipeHp').text('');
            });

            $('#btnUpdateTipeHp').click(async e=>{
                e.preventDefault();
                const valMMSId = $('#valMMSId').val();
                const txUpdateTipeHp = $('#txUpdateTipeHp').val();

                if(!txUpdateTipeHp){
                    $('#errUpdateTipeHp').text('Tipe HP tidak boleh kosong')
                    return;
                }else{
                    $('#errUpdateTipeHp').text('')
                }

                $.ajax({
                    url: '{{ route('updatetipehp') }}',
                    method: 'get', 
                    dataType: 'json',
                    data: {valMMSId, txUpdateTipeHp},
                }).done(res => {
                    if(res.status === 400){
                        showMessage('error', res.message)
                        return;
                    }else{
                        showMessage('success', res.message)
                        $('#txViewTipeHP').text(txUpdateTipeHp);
                        $('#modalUpdateTipeHp').modal('hide');
                        getAllMmsList();
                    }
                })
            })
            // end


            $('#selectMerekHP').change(function(){

                // console.log($(this).val());
                if($(this).val() === '19') {
                    $('#selectOs').val('31')
                }else{
                    $('#selectOs').val('32')
                }

                if($(this).val() === "79"){
                    $('#containerMerekHpLain').show()
                }else{
                    $('#containerMerekHpLain').hide();
                }

            })

            $('#containerMerekHpLain').hide();



            // fungsi decrypt uuid
            const decryptUUID = (uuid="") => {
                // decryptuuid
                if(uuid !== ""){
                    $.ajax({
                        url: '{{ route('decryptuuid') }}', 
                        method: 'get', 
                        dataType: 'json', 
                        data: {uuid},
                    }).done(res => {
                        console.log(res);
                        if(res.status === 400){
                            showMessage('error', res.message);
                            return;
                        }
                        $('#txUUID').val(res.message);

                    })
                }
            }

            const decryptUUID1 = (uuid="", input="") => {
                // decryptuuid
                if(uuid !== ""){
                    $.ajax({
                        url: '{{ route('decryptuuid') }}', 
                        method: 'get', 
                        dataType: 'json', 
                        data: {uuid},
                    }).done(res => {
                        console.log(res);
                        if(res.status === 400){
                            showMessage('error', res.message);
                            return;
                        }
                        $(`#${input}`).val(res.message);

                    })
                }
            }

            $('#txUUID').keypress(function(e){

                let uuid = e.target.value;

                if (e.which === 13) {
                    decryptUUID(uuid);
                }
            })

            // updateuuid
            $('#txUpdateUUID').keypress(function(e){
                let uuid = e.target.value;
                if (e.which === 13) {

                    if($('#txUpdateUUID').val() !== ""){
                        $('#txUpdateUUID').val('');
                    }
                    
                    decryptUUID1(uuid, "txUpdateUUID");
                }
            })


            

        </script>

    @endsection
