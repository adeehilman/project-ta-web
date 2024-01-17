@extends('layouts.app')
@section('title', 'Lowongan Kerja')


@section('content')

    <div class="wrappers">
        <div class="wrapper_content">

            {{-- modal dialig detail --}}
            <div class="modal fade" data-bs-backdrop="static" id="modalDetail" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 60%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Informasi Lowongan Kerja</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="overflow: scroll; height: 600px;  overflow-x: hidden;">
                            <a id="detail-link" href="{{ url(asset('/lokerimg/loker.jpg')) }}">
                                <img src="{{ asset('/lokerimg/loker.jpg') }}" alt="img-loker" class="rounded imgView"
                                    width="100%" height="200px" id="detail-img" style="object-fit: cover">
                            </a>
                            <table style="font-size: 16px; padding-left: 10px; margin-top: 30px;">
                                <tr>
                                    <td style="width: 200px; color: gray;">Posisi</td>
                                    <td style="color: black;" id="detail-posisi"></td>
                                </tr>

                                <tr>
                                    <td style="width: 200px; color: gray;">Waktu Posting</td>
                                    <td style="color: black;" id="detail-posting"></td>
                                </tr>

                                <tr>
                                    <td style="width: 200px; color: gray;">Mulai Berlaku</td>
                                    <td style="color: black;" id="detail-mulai-dari"></td>
                                </tr>

                                <tr>
                                    <td style="width: 200px; color: gray;">Berlaku Sampai</td>
                                    <td style="color: black;" id="detail-berlaku-sampai"></td>
                                </tr>

                                <tr>
                                    <td style="width: 200px; color: gray;">Di Buat Oleh</td>
                                    <td style="color: black;" id="detail-createby"></td>
                                </tr>

                                <tr>
                                    <td style="width: 200px; color: gray;">Di Perbarui Oleh</td>
                                    <td style="color: black;" id="detail-updateby"></td>
                                </tr>

                                <tr>
                                    <td style="width: 200px; color: gray;">Status</td>
                                    <td style="color: black;" id="detail-status"></td>
                                </tr>

                            </table>

                            <p style="width: 200px; color: gray; margin-top: 20px;">Deskripsi</p>
                            <p id="detail-deskripsi"></p>

                        </div>
                        <div class="modal-footer justify-content-start">
                            <button id="detail-btn-edit" class="btn btn-outline-secondary rounded-3 detail-btn-edit"
                                data-bs-toggle="modal"><i class='bx bxs-pencil'
                                    style="font-size: 13px; padding-right: 5px;"></i>Edit Lowongan Kerja</button>
                            {{-- <button class="btn btn-outline-secondary rounded-3"><i class='bx bxs-share-alt' style="font-size: 13px; padding-right: 5px;"></i>Bagikan Lowongan</button> --}}
                            <button id="detail-btn-hapus" class="btn btn-outline-secondary rounded-3 detail-btn-hapus"><i
                                    class='bx bx-trash' style="font-size: 13px; padding-right: 5px;"></i>Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end modal detail --}}

            {{-- modal dialog add --}}
            <div class="modal fade" data-bs-backdrop="static" id="modalAdd" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 60%;">
                    <div class="modal-content">
                        <form method="POST" id="formLoker">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Lowongan Kerja</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="padding: 30px;">
                                @csrf
                                <div class="row mb-3" style="font-size: 12px;">
                                    <div class="col-sm-12">
                                        <p><b>Posisi</b></p>
                                        <input type="val" class="form-control" style="font-size: 12px;"
                                            placeholder="Ketikkan Posisi Lowongan Kerja" name="posisi" id="posisi">
                                    </div>
                                </div>

                                <div class="row mb-3" style="font-size: 12px;">
                                    <div class="col-sm-6">
                                        <p><b>Mulai Berlaku</b></p>
                                        <input type="date" class="form-control" style="font-size: 12px;"
                                            id="mulai_berlaku" name="mulai_berlaku" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><b>Berlaku Sampai</b></p>
                                        <input type="date" class="form-control" style="font-size: 12px;"
                                            id="berlaku_sampai" name="berlaku_sampai" value="{{ date('Y-m-d') }}"
                                            required>
                                    </div>
                                </div>
                                <div class="row mb-3" style="font-size: 12px;">
                                    <div class="col-sm-12">
                                        <p><b>Deskripsi</b></p>
                                        {{-- <textarea class="form-control" style="font-size: 12px; height: 80px;" name="deskripsi" id="deskripsi"></textarea> --}}
                                        <textarea id="summernote" name="deskripsi"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3" style="font-size: 12px;">
                                    <div class="col-sm-12">
                                        <p><b>Upload Gambar(PNG/JPG)</b></p>
                                        <input type="file" class="form-control" name="gambar" id="gambar"
                                            aria-describedby="basic-addon2">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-end">
                        </form>
                        <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                            style="val-decoration: none; font-size: 12px;  height: 30px;">Batal</button>
                        <button class="btn btn-primary" type="button"
                            style="font-size: 12px;  height: 30px; display: none;" id="SpinnerLokerAdd">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Loading...
                        </button>
                        <button type="submit" style="font-size: 12px;  height: 30px;" id="btnSubmitLokerAdd"
                            class="btn btn-primary">Tambahkan Lowongan</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- end modal add --}}

        {{-- modal dialog edit --}}
        <div class="modal fade" data-bs-backdrop="static" id="modalEdit" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 60%;">
                <div class="modal-content">
                    <form method="POST" id="formLokerEdit">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Lowongan Kerja</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="padding: 30px;">
                            @csrf

                            <div class="row mb-3" style="font-size: 12px">
                                <input type="hidden" name="id_lowongan" id="edit-id-lowongan">
                            </div>

                            <div class="row mb-3" style="font-size: 12px;">
                                <div class="col-sm-12">
                                    <p><b>Posisi</b></p>
                                    <input type="text" class="form-control" style="font-size: 12px;"
                                        placeholder="Ketikkan Posisi Lowongan Kerja" name="posisi" id="edit-posisi">
                                </div>
                            </div>

                            <div class="row mb-3" style="font-size: 12px;">
                                <div class="col-sm-6">
                                    <p><b>Mulai Berlaku</b></p>
                                    <input type="date" class="form-control" style="font-size: 12px;"
                                        name="mulai_berlaku" id="edit-mulai-berlaku" value="{{ date('Y-m-d') }}">
                                </div>
                                <div class="col-sm-6">
                                    <p><b>Berlaku Sampai</b></p>
                                    <input type="date" class="form-control" style="font-size: 12px;"
                                        name="berlaku_sampai" id="edit-berlaku-sampai" value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <div class="row mb-3" style="font-size: 12px;">
                                <div class="col-sm-12">
                                    <p><b>Deskripsi</b></p>
                                    {{-- <textarea class="form-control" style="font-size: 12px; height: 80px;" name="deskripsi" id="deskripsi"></textarea> --}}
                                    <textarea id="summernote-edit" name="deskripsi"></textarea>
                                </div>
                            </div>
                            <div class="row mb-3" style="font-size: 12px;">
                                <div class="col-sm-12">
                                    <p><b>Upload Gambar(PNG/JPG)</b></p>
                                    <input type="file" class="form-control" name="gambar"
                                        aria-describedby="basic-addon2">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-end">
                    </form>
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                        style="text-decoration: none; font-size: 12px;  height: 30px;">Batal</button>
                    <button class="btn btn-primary" type="button" style="font-size: 12px;  height: 30px; display: none;"
                        id="SpinnerLokerEdit">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                    <button type="submit" style="font-size: 12px;  height: 30px;" id="btnSubmitLokerEdit"
                        class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal edit --}}

    {{-- modal dialog filter --}}
    <div class="modal fade" data-bs-backdrop="static" id="modalFilter" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 20%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Pencarian Lowongan Kerja</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formInputRepair">
                        <div class="row mb-3" style="font-size: 12px;">
                            <div class="col-sm-12">
                                <p>Berlaku Dari</p>
                                <input type="date" class="form-control me-2 rounded-3"
                                    style="width: 335px; font-size: 12px;" id="filter-berlaku-dari">
                            </div>
                        </div>

                        <div class="row mb-3" style="font-size: 12px;">
                            <div class="col-sm-12">
                                <p>Berlaku Sampai</p>
                                <input type="date" class="form-control me-2 rounded-3"
                                    style="width: 335px; font-size: 12px;" id="filter-berlaku-sampai">
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btnFilter" class="btn btn-primary">Tampilkan Hasil</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal dialog filter --}}

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



    <div class="row me-1">
        <div class="col-sm-6">
            <p class="h4 mt-6">
                Lowongan Kerja
            </p>
        </div>

        <div class="col-sm-12 mt-2 d-flex justify-content-between">
            <div class="d-flex gap-1">
                <input type="text" id="txSearch"
                    style="width: 50px; min-width: 200px; font-size: 12px; padding-left: 30px; 
                    background-image: url('{{ asset('img/search.png') }}'); background-repeat: no-repeat; 
                    background-position: left center;"
                    class="form-control rounded-3" placeholder="Posisi, Di Buat Oleh" autocomplete="off">
                <button id="btnModalRepair" style="font-size: 12px;" type="button"
                    class="btn btn-outline-danger rounded-3" data-bs-toggle="modal" data-bs-target="#modalFilter">
                    <i class='bx bx-slider p-1'></i>
                    Filter
                </button>
                <button id="btnReset" style="font-size: 12px;" type="button" class="btn text-danger rounded-3"><i
                        class="bx bx-refresh"></i>
                    Reset Filter
                </button>
            </div>
            <div class="d-flex gap-1">
                <button id="btnTambahLowongan" type="button" style="font-size: 12px; margin-right: 5px;"
                    class="btn btn-danger rounded-3 align-self-center btn-tambah-loker" data-bs-toggle="modal">
                    Tambah Lowongan Kerja
                </button>
            </div>
        </div>

        <div class="text-end col-sm-9 d-flex mt-2 mb-2 rounded-3">
            {{-- <span style="font-size: 12px;">Menampilkan 7 dari 4.348 Karyawan</span> --}}
        </div>
        <div id="containerLokerTable" class="col-sm-12 mt-1"></div>
    </div>
    </div>

    </div>
    </div>

@endsection

@section('script')

    <script>
        const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
                <div class="spinner-border d-flex justify-content-center align-items-center text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
            </div> `;

        // get list employee
        const getLokerList = () => {

            const txSearch = $('#txSearch').val();
            const txBerlakuDari = $('#filter-berlaku-dari').val();
            const txBerlakuSampai = $('#filter-berlaku-sampai').val();

            $.ajax({
                url: '{{ route('list_loker') }}',
                method: 'GET',
                data: {
                    txSearch,
                    txBerlakuDari,
                    txBerlakuSampai
                },
                beforeSend: () => {
                    $('#containerLokerTable').html(loadSpin);
                }
            }).done(res => {

                $('#containerLokerTable').html(res);
                $('#tableLoker').DataTable({
                    searching: false,
                    lengthChange: false,
                    sort: false,
                });
            })
        }

        getLokerList();

        // ketika type search diketik
        $('#txSearch').keyup(function() {
            $('#filter-berlaku-dari').val('');
            $('#filter-berlaku-sampai').val('');
            getLokerList();
        })

        $(document).ready(function() {
            $('#summernote').summernote({
                placeholder: 'Tuliskan deskripi pekerjaan',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['font', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol']],
                ]
            });

            $('#summernote-edit').summernote({
                placeholder: 'Tuliskan deskripi pekerjaan',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['font', ['bold', 'italic', 'underline']],
                    ['para', ['ul', 'ol']],
                ]
            });
        })

        // ketika row tabel di klik, dan saat sudah di render semua
        $(document).on('click', '.detail-loker', function() {
            var id_lowongan = $(this).data('id');

            // maka panggil ajax
            $.ajax({
                    url: '{{ route('detail_loker') }}',
                    method: 'GET',
                    data: {
                        id_loker: id_lowongan
                    },
                    beforeSend: () => {

                    }
                })
                .done(res => {

                    const img = res.file_upload ? `{{ asset('/lokerimg/${res.file_upload}') }}` :
                        `{{ asset('/lokerimg/loker.jpg') }}`;

                    $('#detail-btn-hapus').attr('data-id', res.id);
                    $('.detail-btn-hapus').data('id', res.id);
                    $('#detail-btn-edit').attr('data-id', res.id);
                    $('.detail-btn-edit').data('id', res.id);
                    $('#detail-link').attr('href', img);
                    $('#detail-img').attr('src', img);
                    $('#detail-posisi').text(res.posisi)
                    $('#detail-posting').text(res.createdate)
                    $('#detail-mulai-dari').text(res.mulai_berlaku)
                    $('#detail-berlaku-sampai').text(res.berlaku_sampai)
                    $('#detail-status').html(res.status_new)
                    $('#detail-deskripsi').html(res.desc)
                    $('#detail-createby').text(res.createby)
                    if (res.updateby == null) {
                        $('#detail-updateby').text('-')
                    }
                    if (res.updateby != null) {
                        $('#detail-updateby').text(res.updateby)
                    }
                });
        });

        // ketika button hapus lowongan diklik, lakukan hal berikut
        $('#detail-btn-hapus').on('click', function(e) {

            const roles = '{{ session()->get('loggedInUser')['session_roles'] }}'

            if (parseInt(roles) === 64 || parseInt(roles) === 63) {

                const id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah kamu yakin ingin menghapus lowongan kerja tersebut?',
                    text: "Data yang dihapus tidak bisa dipulihkan kembali",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Batalkan',
                    confirmButtonText: 'Ya, Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {

                        // lakukan query ajax untuk insert ke database
                        $.ajax({
                            url: '{{ route('hapus_loker') }}',
                            method: 'GET',
                            data: {
                                id: id
                            },
                            dataType: 'json',
                            beforeSend: () => {

                            },
                        }).done(res => {
                            $('#modalDetail').modal('hide');
                            $('#detail-btn-hapus').attr('data-id', '');
                            getLokerList();
                            Swal.fire(
                                'Deleted!',
                                'Lowongan Kerja Berhasil di Hapus',
                                'success'
                            )
                        }).fail(err => {
                            // err.responseJSON.message
                            showMessage('error', 'Something went wrong!');
                        });
                    }
                })

            } else {
                showMessage('error', 'Kamu tidak punya akses')
                return
            }

        });

        // ketika button simpan lowongan di klik, lakukan submit
        $('#formLoker').on('submit', function(e) {
            e.preventDefault()

            const posisi = $('#posisi').val();
            if (posisi == '') {
                showMessage('error', 'Textbox Posisi tidak boleh kosong');
                return
            }

            const mulai_berlaku = $('#mulai_berlaku').val();
            const berlaku_sampai = $('#berlaku_sampai').val();

            if (berlaku_sampai < mulai_berlaku) {
                showMessage('error', 'Range tanggal tidak dizinkan, periksa kembali');
                return
            }

            const deskripsi = $('#summernote').summernote('code');
            if (deskripsi == '<p><br></p>') {
                showMessage('error', 'Textbox Deskripsi tidak boleh kosong');
                return
            }

            const file = $('#gambar').val();
            if (file == '') {
                showMessage('error', 'File tidak boleh kosong');
                return
            }

            if (
                posisi != '',
                deskripsi != '',
                file != ''
            ) {
                // lakukan query ajax untuk insert ke database
                $.ajax({
                    url: '{{ route('insert_loker') }}',
                    method: 'POST',
                    data: new FormData(this),
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    beforeSend: () => {
                        $('#SpinnerLokerAdd').show()
                        $('#btnSubmitLokerAdd').hide();
                    },
                }).done(res => {
                    $('#SpinnerLokerAdd').hide()
                    $('#btnSubmitLokerAdd').show();
                    showMessage('success', 'Berhasil insert data');
                    $('#modalAdd').modal('hide');
                    $(this)[0].reset();
                    $('#summernote').summernote('code', '');
                    $('#summernote-edit').summernote('code', '');
                    getLokerList();
                }).fail(err => {
                    // err.responseJSON.message
                    showMessage('error', 'Terjadi kesalahan saat menyimpan data');
                    $('#SpinnerLokerAdd').hide()
                    $('#btnSubmitLokerAdd').show();
                });
            }


        });

        // ketika button hapus lowongan diklik, lakukan hal berikut
        $(document).on('click', '.detail-btn-edit', function() {

            const roles = '{{ session()->get('loggedInUser')['session_roles'] }}'

            if (parseInt(roles) === 64 || parseInt(roles) === 63) {
                $('#modalEdit').modal('show')
            } else {
                showMessage('error', 'Kamu tidak punya akses')
            }

            var id_lowongan = $(this).data('id');
            // console.log(id_lowongan);
            // // maka panggil ajax
            $.ajax({
                    url: '{{ route('detail_loker') }}',
                    method: 'GET',
                    data: {
                        id_loker: id_lowongan
                    },
                    beforeSend: () => {

                    }
                })
                .done(res => {

                    const img = res.file_upload ? `{{ asset('/lokerimg/${res.file_upload}') }}` :
                        `{{ asset('/lokerimg/loker.jpg') }}`;

                    $('#edit-id-lowongan').val(res.id)
                    $('#edit-posisi').val(res.posisi)
                    $('#edit-mulai-berlaku').val(res.mulai_berlaku_asli)
                    $('#edit-berlaku-sampai').val(res.berlaku_sampai_asli)
                    $('#summernote-edit').summernote('code', res.desc)
                });
        });

        // ketika button simpan perubahan di klik, lakukan submit
        $('#formLokerEdit').on('submit', function(e) {
            e.preventDefault()

            // lakukan query ajax untuk insert ke database
            $.ajax({
                url: '{{ route('update_loker') }}',
                method: 'POST',
                data: new FormData(this),
                cache: false,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: () => {
                    $('#SpinnerLokerEdit').show()
                    $('#btnSubmitLokerEdit').hide();
                },
            }).done(res => {
                $('#SpinnerLokerEdit').hide()
                $('#btnSubmitLokerEdit').show();
                showMessage('success', 'Berhasil update data');
                $('#modalEdit').modal('hide');
                $(this)[0].reset();
                $('#summernote').summernote('code', '');
                $('#summernote-edit').summernote('code', '');
                getLokerList();
            }).fail(err => {
                // err.responseJSON.message
                $('#SpinnerLokerEdit').hide()
                $('#btnSubmitLokerEdit').show();
                showMessage('error', 'Silahkan lengkapi form');
            });
        });

        // ketika btn filter di klik maka load get loker list
        $('#btnFilter').on('click', function(e) {
            e.preventDefault();
            getLokerList();
            $('#modalFilter').modal('hide')
        });

        $('#modalFilter').on('shown.bs.modal', function() {
            var currentDate = new Date();
            currentDate.setDate(1);
            var lastDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
            var endDate = lastDate.toISOString().slice(0, 10);
            var startDate = currentDate.toISOString().slice(0, 10);
            $('#filter-berlaku-dari').val(startDate);
            $('#filter-berlaku-sampai').val(endDate);
        });

        $('#btnTambahLowongan').on('click', function() {
            const roles = '{{ session()->get('loggedInUser')['session_roles'] }}'

            if (parseInt(roles) === 64 || parseInt(roles) === 63) {
                $('#modalAdd').modal('show')
            } else {
                showMessage('error', 'Kamu tidak punya akses')
            }
        })

        $('.imgView').click(function(e) {
            e.preventDefault()

            if ($(this).attr('src')) {
                $('#imageView').attr('src', $(this).attr('src'))
                $('#modalViewGambar').modal('show')
            }

        })

        $('#btnReset').click(function(e) {
            e.preventDefault();
            $('#filter-berlaku-dari').val('');
            $('#filter-berlaku-sampai').val('');
            getLokerList();
        })
    </script>

@endsection
