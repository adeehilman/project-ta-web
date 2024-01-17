@extends('layouts.app')
@section('title', 'Kritik dan Saran')


@section('content')

 <!-- modified modal Show Loker-->

 <div class="modal fade" data-bs-backdrop="static" id="modalShow" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Informasi Kritik dan Saran </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalShowBody">              
                <ul class="nav nav-tabs py-1 border     rounded bg-danger" id="myTab" role="tablist" style="--bs-bg-opacity: .2;">
                    <li class="nav-item" role="presentation">
                      <button class="nav-link text-dark rounded active" id="detail-kritik-dan-saran-tab" data-bs-toggle="tab" data-bs-target="#detail-kritik-dan-saran-tab-pane" type="button" role="tab" aria-controls="detail-kritik-dan-saran-tab-pane" aria-selected="true">Detail Kritik dan Saran</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link rounded text-dark" id="informasi-pengirim-tab" data-bs-toggle="tab" data-bs-target="#informasi-pengirim-tab-pane" type="button" role="tab" aria-controls="informasi-pengirim-tab-pane" aria-selected="false">Informasi Pengirim</button>
                    </li>
                    <li class="nav-item" role="presentation">
                      <button class="nav-link rounded text-dark" id="riwayat-status-tab" data-bs-toggle="tab" data-bs-target="#riwayat-status-tab-pane" type="button" role="tab" aria-controls="riwayat-status-tab-pane" aria-selected="false">Riwayat Status</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link rounded text-dark" id="tanggapan-tab" data-bs-toggle="tab" data-bs-target="#tanggapan-tab-pane" type="button" role="tab" aria-controls="tanggapan-tab-pane" aria-selected="false">Tanggapan</button>
                      </li>
                  </ul>
                 
            </div>
            {{-- <div class="modal-footer d-flex justify-content-start">
                <button type="button" id="btnModalEdit" class="btn border" data-bs-dismiss="modal" style="text-decoration: none; font-size: 12px; width: 214px; height: 41px;">
                  <img src={{ asset('img/edit.png') }} style="vertical-align:middle;"></img>
                  <span>Edit Lowongan Kerja</span>
                </button>
                <button type="button" style="font-size: 12px; width: 205px; height: 41px;" id="btnSubmitRepair" class="btn border">
                  <img src={{ asset('img/share.png') }} style="vertical-align:middle;"></img>
                  <span>Bagikan Lowongan</span>
                </button>
                <button type="button" style="font-size: 12px; width: 124px; height: 41px;" id="btnOpenModalHapus" class="btn border">
                  <img src={{ asset('img/trash.png') }} style="vertical-align:middle;"></img>
                  <span>Hapus</span>
                </button>
            </div> --}}
        </div>
    </div>
  </div>

  
    <div class="wrappers">
        <div class="wrapper_content">

            <!-- modal -->
            <div class="modal fade" data-bs-backdrop="static" id="modalFiter" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Pengaduan Pelanggaran</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formFilter" style="font-size: 14px;">
                                <div class="row mb-3">
                                    <div class="col-sm-10">
                                        <p>Kategori</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rdCategory"
                                                id="sAplikasi" value="41">
                                            <label class="form-check-label" for="sAplikasi">Aplikasi</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rdCategory"
                                                id="sPerusahan" value="42">
                                            <label class="form-check-label" for="sPerusahan">Perusahaan</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <p>Rentang Waktu</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rdRentangWaktu"
                                                id="sJamTerakhir" value="1">
                                            <label class="form-check-label" for="sJamTerakhir">24
                                                Jam Terakhir</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rdRentangWaktu"
                                                id="sSeminggu" value="7">
                                            <label class="form-check-label" for="sSeminggu">1
                                                Minggu Terakhir</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rdRentangWaktu"
                                                id="sSebulan" value="30">
                                            <label class="form-check-label" for="sSebulan">1
                                                Bulan Terakhir</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <p>Status</p>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rdStatus"
                                                id="sBelumTanggapi" value="1">
                                            <label class="form-check-label" for="sBelumTanggapi">Belum ditanggapi</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="rdStatus"
                                                id="sDitanggapi" value="2">
                                            <label class="form-check-label" for="sDitanggapi">Sudah ditanggapi</label>
                                        </div>
                                    </div>
                                </div>

                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                                style="text-decoration: none;">Batal</button>
                            <button type="button" id="btnFilter" class="btn btn-primary">Tampilkan Hasil</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end modal -->
            <div class="row me-1">
                <div class="col-sm-6">
                    <p class="h4 mt-6">
                        Kritik dan Saran
                    </p>
                </div>

                <div class="col-sm-12 mt-2 d-flex justify-content-between">
                    <div class="d-flex gap-1">
                        <input id="txSearch" type="text"
                            style="width: 50px; min-width: 250px; font-size: 12px; padding-left: 30px; 
                    background-image: url('{{ asset('img/search.png') }}'); background-repeat: no-repeat; 
                    background-position: left center;"
                            class="form-control rounded-3" placeholder="Cari Pengirim">
                        <button id="btnModalFilter" style="font-size: 12px;" type="button"
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
                    <span style="font-size: 12px;" id="textJumlahTampilan">
                        {{-- Menampilkan {{count($suggestion)}} dari total {{$suggestion->total()}} Pengirim  --}}
                   </span>
                </div>

                <div id="containerTableKritik" class="col-sm-12 mt-1">
                    <table class="table table-responsive table-hover">
                        <thead>
                            <tr style="color: #CD202E; height: 10px;" class="table-danger">
                                <th class="p-3" scope="col">Pengirim</th>
                                <th class="p-3" scope="col">Kategori</th>
                                <th class="p-3" scope="col">Kritik dan Saran</th>
                                <th class="p-3" scope="col">Waktu Submit</th>
                                <th class="p-3" scope="col">Jam</th>
                                <th class="p-3" scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @foreach ($suggestion as $item)
                                @php 
                                    /* decode utk bug g bs akses status */
                                    $data = json_decode($item);
                                    $kategori = $data->kategori;
                                @endphp
                                <tr style="color: gray;" data-id={{ $item->id }} data-href="{{ route('profil') }}" class="table-row">
                                    <td class="p-3">{{ $item->pengirim->fullname ?? '' }}</td>
                                    <td class="p-3">{{ $kategori->nama ?? '' }}</td>
                               
                                    <td class="p-3">{{ $item->created_at ? date('d M Y', strtotime($item->created_at)) : '' }}</td>
                                    <td class="p-3">{{ $item->created_at ? date('H:i', strtotime($item->created_at)) : '' }}</td>
                                    <td class="p-3">
                                        <img src="{{ asset('img/checklist.png') }}">
                                        {!! ($status->deskripsi ?? null) === 'sudah ditanggapi' ? 
                                        '<img src="img/checklist.png"> <span>Sudah Ditanggapi</span>' 
                                        : '<img src="img/vector.png"> <span>Belum Ditanggapi</span>' 
                                        !!}
                                    </td>
                                </tr>
                            @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>





    {{-- modal view --}}
    <div class="modal fade" data-bs-backdrop="static" id="modalView" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered" style="height: 600px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalViewTitle">Informasi Kritik Saran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size: 14px">

                    <div class="row mb-3">
                        <div class="col-sm-12">
                            <div class="button-box-kritik d-flex">
                                <div id="btn-kritik"></div>
                                <button id="btnViewInformasiKritik" type="button" class="toggle-btn-kritik">Detail Kritik dan Saran</button>
                                <button id="btnViewInformasiPengirim" type="button" class="toggle-btn-kritik">Informasi Pengirim</button>
                                <button id="btnViewRiwayat" type="button" class="toggle-btn-kritik">Riwayat Status</button>
                                <button id="btnViewInformasiTanggapan" type="button" class="toggle-btn-kritik">Tanggapan</button>
                            </div>
                        </div>
                    </div>

                    

                    <div id="section__view__infomasikritik" style="height: 500px">
                        <div class="row mx-2 my-2">
                            <p class="fw-bold mt-2">Informasi Kritik dan Saran</p>
                            <div class="col-sm-4">
                                <p class="mb-2">Kategori</p>
                                <p class="mb-2">Waktu Submit</p>
                                <p class="mb-2">Jam</p>
                                <p class="mb-2">Status</p>
                                <p class="mb-2">Kritik dan Saran</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="mb-2" id="txViewKategori"></p>
                                <p class="mb-2" id="txViewWaktu"></p>
                                <p class="mb-2" id="txViewJam"></p>
                                <p class="mb-2" style="color: blue" id="txViewStatus"></p>
                                <p class="mb-2" id="txViewKritik" style="word-wrap: break-word !important; max-width:400px"></p>
                            </div>
                        </div>

                        <div class="row mb-3 mx-2">
                            <p class="fw-bold mt-2">Dokumen Pendukung</p>  
                            <div class="col-sm-12">
                                <img width="80" id="viewImage" src="http://webapp-new.satnusa.com:8080/kritiksaran/1685072575.jpg" alt="">
                            </div>
                        </div>

                    </div>

                    <div id="section__view__infomasipengirim" style="height: 500px">
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
                        {{-- <div class="row mx-2 my-2">
                            <p class="fw-bold mt-2">Riwayat Status</p>
                            <div id="containerTimelineJam" class="col-sm-2">
                                <p class="fw-bold mb-0">Hari ini</p>
                                <span class="text-muted">10.00</span>
                            </div>
                            <div class="col-sm-10">
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
                            </div>
                        </div> --}}

                        <div class="row mx-2 my-2">
                            <p class="h5 fw-bold mt-2 mb-4">Riwayat Status</p>
                            <div id="containerRiwayatClock" style="padding: 10px;" class="col-sm-2">
                            </div>
                            <div id="containerRiwayatStatus" class="col-sm-10">
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
                                <button id="btnSimpanTanggapan" type="button" class="btn btn-outline-danger btn-sm mt-2">Tanggapi</button>
                            </div>
                            <div class="col-sm-12 my-auto mt-3">
                                {{-- <div class="text-center">Belum ada Tanggapan Sama Sekali</div> --}}

                                {{-- <div class="row-mb-3 d-flex justify-content-center">
                                    
                                    <div id="containerTanggapan" class="col-md-11">

                                    </div>

                                </div> --}}

                                <div class="row mb-3" id="newContainerTanggapan">
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <input type="hidden" id="valKritikId" name="valKritikId">
                    {{-- <button type="button" id="btnTotalPengajuan" class="btn btn-link" style="text-decoration: none">Tolak Pengajuan</button> --}}
                    <button type="button" id="btnSelesai" class="btn btn-primary">Selesai</button>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal view --}}

    {{-- modal view gambar --}}
    <div class="modal fade" data-bs-backdrop="static" id="modalViewGambar" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalViewTitle">View Gambar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" style="font-size: 14px">

                    <div id="containerGambarView" class="text-center">
                        <img id="viewImgFluid" src="" alt="" class="img-fluid" style="max-height: 700px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal view gambar --}}


@endsection

@section('script')

    <script>
        const btnModal = $('#btnModalFilter');
        const modalForm = $('#modalFiter');
        const modalShow = $('#modalShow');
        const selectCustomer = $('#selectCustomer');
        const selectModelCustomer = $('#selectModelCustomer');
        const btnSubmitRepair = $('#btnSubmitRepair');
        const tableRow = $('.table-row');
        const pageBody = $('body');

        $('#section__view__infomasipengirim').hide();
        $('#section__view__riwayatstatus').hide()
        $('#section__view__informasitanggapan').hide();


        tableRow.on('click', function(e) {
            let id = $(this).data('id');
            $('#myTab').after("");

            const selectedKritik = kritik?.data?.find(item => item.id === id);
            modalShow.modal('show');

            const tabContent = $(`
                <div class="tab-content mt-2 p-2" id="myTabContent">
                    <div class="tab-pane fade show active mt-2" id="detail-kritik-dan-saran-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        <h5>Informasi Kritik dan Saran</h5>
                        <table width="100%">
                            <tr class="text-start">
                                <td class="text-secondary">
                                    Kategori
                                </td>
                                <td width="50%">
                                    ${selectedKritik.id}
                                </td>
                            </tr>
                            <tr class="text-start">
                                <td class="text-secondary">
                                    Waktu Submit
                                </td>
                                <td width="50%">
                                    ${new Date(selectedKritik.created_at).toLocaleString('en-US', {
                                        year: 'numeric',
                                        month: 'long',
                                        day: 'numeric',
                                    })}
                                </td>
                            </tr>
                            <tr class="text-start">
                                <td class="text-secondary">
                                    Jam
                                </td>
                                <td width="50%">
                                    ${new Date(selectedKritik.created_at).toLocaleString('en-US', {
                                        hour: 'numeric',
                                        minute: 'numeric',
                                    })}
                                </td>
                            </tr>
                            <tr class="text-start">
                                <td class="text-secondary">
                                    Status
                                </td>
                                <td width="50%">
                                </td>
                            </tr>
                            <tr class="text-start">
                                <td class="text-secondary">
                                    Kritik dan Saran
                                </td>
                                <td width="50%">
                               
                                </td>
                            </tr>
                            <tr class="text-start">
                                <td class="text-secondary">
                                    Dokumen Pendukung
                                </td>
                                <td width="50%">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="informasi-pengirim-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        <h5>Informasi Pengirim</h5>
                        <table>
                            <tr class="text-start">
                                <td class="text-secondary">Nama</td>
                                <td width="50%">${selectedKritik.pengirim.fullname}</td>
                            </tr>
                            <tr class="text-start">
                                <td class="text-secondary">Badge</td>
                                <td width="50%">${selectedKritik.pengirim.employee_no}</td>
                            </tr>
                            <tr class="text-start">
                                <td class="text-secondary">Departemen</td>
                                <td width="50%"></td>
                            </tr>
                            <tr class="text-start">
                                <td class="text-secondary">Posisi</td>
                                <td width="50%"></td>
                            </tr>
                            <tr class="text-start">
                                <td class="text-secondary">Mulai Masuk</td>
                                <td width="50%"></td>
                            </tr>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="riwayat-status-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">2</div>
                    <div class="tab-pane fade" id="tanggapan-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">3</div>
                    </div>
            `);

            $('#myTab').after(tabContent)
        });

        btnModal.click(e => {
            e.preventDefault();
            modalForm.modal('show');

            getDataCustomer()

        });



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

        

        // get data kritik dan saran
        const getDataKritik = (
            fStatus=""
        ) => {

            const filter = '{{ $filterData }}'

            if(filter){
                fStatus = "1"
            }


            const txSearch = $('#txSearch').val();
            const sKategori = $('input[name="rdCategory"]:checked').val()
            const sWaktu = $('input[name="rdRentangWaktu"]:checked').val()
            const sStatus = $('input[name="rdStatus"]:checked').val()


            $.ajax({
                url: '{{ route('kritiklist') }}', 
                method: 'GET', 
                data: {txSearch, sKategori, sWaktu, sStatus, fStatus},
            }).done(res => {

                if($('#containerTableKritik').children().length > 0){
                    $('#containerTableKritik').children().remove()
                }

                $('#containerTableKritik').html(res);
                $('#tableKritik').DataTable({
                    searching: false,
                    lengthChange: false, 
                    "bSort": false,
                });
            })

        }

        getDataKritik();

        $('#txSearch').keyup(()=>{
            getDataKritik();
        })


        // section view Kritik dan Saran
        pageBody.on('click', '.btnView', function(e){
            e.preventDefault()

            const roles = '{{ session()->get('loggedInUser')['session_roles'] }}'

            const dataId = $(this).data('id');

            if(dataId){

                $.ajax({
                    url: '{{ route('getkritikbyid') }}', 
                    method: 'get', 
                    dataType: 'json', 
                    data: {dataId},
                }).done(res => {
                    console.log(res);

                    let is_anonymous = parseInt(res.dataKritik[0].is_anonymous);
                    let isName = (is_anonymous === 1 ?  'Dirahasiakan' : (res.dataKaryawan[0].fullname ? res.dataKaryawan[0].fullname : '-')); 
                    let isBadge = (is_anonymous === 1 ?  'Dirahasiakan' : (res.dataKaryawan[0].badge_id ? res.dataKaryawan[0].badge_id : '-')); 
                    let isDept = (is_anonymous === 1 ?  'Dirahasiakan' : (res.dataKaryawan[0].dept_code ? res.dataKaryawan[0].dept_code : '-')); 
                    let isPosition = (is_anonymous === 1 ?  'Dirahasiakan' : (res.dataKaryawan[0].position_code ? res.dataKaryawan[0].position_code : '-')); 
                    let isJoinDate = (is_anonymous === 1 ?  'Dirahasiakan' : (res.dataKaryawan[0].newDateJoinKaryawan ? res.dataKaryawan[0].newDateJoinKaryawan : '-')); 

                    if(res.status !== 200){
                        return;
                    }

                    let gambar = res.dataKritik[0].file_upload ? res.dataKritik[0].file_upload : null;
                    let urlgambar;

                    if(gambar === null){
                        urlgambar = '{{ asset('img/no-image-available.png') }}';
                    }else{
                        urlgambar = 'https://webapi.satnusa.com/kritiksaran/'+gambar;
                    }

                    // console.log(res.dataKritik[0].file_upload);
                    // let urlgambar = 'https://webapi.satnusa.com/kritiksaran/'+gambar;

                    
                    // Detail kritik dan saran
                    let date1 = new Date(res.dataKritik[0].createdate);
                    let arrMonth1 = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"]
                    let newDate1 = `${date1.getDate()} ${arrMonth1[date1.getMonth()]} ${date1.getFullYear()}`;
                    let newTime1 = `${date1.getHours().toString().padStart(2, '0')}:${date1.getMinutes().toString().padStart(2, '0')}`;


                    $('#valKritikId').val(dataId);
                    $('#txViewKategori').text(res.dataKritik[0].kategori_name ? res.dataKritik[0].kategori_name : '-')
                    $('#txViewWaktu').text(newDate1 ? newDate1 : '-')
                    $('#txViewJam').text(newTime1 ? newTime1 : '-')
                    $('#txViewStatus').text(res.dataKritik[0].status_title ? res.dataKritik[0].status_title : '-')
                    $('#txViewKritik').text(res.dataKritik[0].description ? res.dataKritik[0].description : '-')
                    $('#viewImage').attr('src', urlgambar)

                    // view slide 2
                    let dateJoinKaryawan = new Date(res.dataKaryawan[0].join_date);
                    let newDateJoinKaryawan = `${dateJoinKaryawan.getDate()} ${arrMonth1[dateJoinKaryawan.getMonth()]} ${dateJoinKaryawan.getFullYear()}`;

                    $('#txViewName').text(isName)
                    $('#txViewBadge').text(isBadge)
                    $('#txViewDept').text(isDept)
                    $('#txViewPosition').text(isPosition)
                    $('#txViewJoinDate').text(isJoinDate)


                    let containerRiwayatStatus = '';
                    let containerRiwayatClock = '';
                    let containerRiwayatStatusLength = res.dataRiwayat.length;

                    htmlTimeline = '';
                    htmlTimelineJam = '';
                    if(res.dataRiwayat.length > 0){
                        containerRiwayatStatus = '<ul>';
                        $.each(res.dataRiwayat, (i, v) => {


                            // let date = new Date(v.createdate);
                            // let arrMonth = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"]
                            // let newDate = `${date.getDate()} ${arrMonth[date.getMonth()]} ${date.getFullYear()}`;
                            // let newTime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;
                            let date = new Date(v.createdate);
                            let arrMonth = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"]
                            let newDate = `${date.getDate()} ${arrMonth[date.getMonth()]} ${date.getFullYear()}`;
                            let newTime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;

                            htmlTimeline += 
                            `<li class="li-timeline"><p class="fw-bold mb-2">${v.stat_title}</p>
                            <span class="text-muted" style="font-size: 11px">${v.stat_desc}</span>
                            </li>`;

                            htmlTimelineJam += 
                            `<p class="fw-bold mb-0">${newDate}</p>
                            <span class="text-muted">${newTime}</span>`;

                            
                            // if(i !== containerRiwayatStatusLength-1){

                                if(v.stat_title !== "Selesai"){
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

                                

                            // }
                            containerRiwayatClock += 
                            `
                            <div class="mb-4">
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

                                // containerRiwayatClock += 
                                // `
                                // <div class="mb-4">
                                //     <p class="fw-bold mb-0">${newDate}</p>
                                //     <span class="text-muted">${newTime}</span>
                                // </div> 
                                // `;
                        }
                        // else{
                        //     containerRiwayatStatus += 
                        //     `<li class="step step--upcoming">
                        //         <div class="step__title">${res.dataRiwayat[containerRiwayatStatusLength-1].stat_title}</div>
                        //         <p class="step__detail">${res.dataRiwayat[containerRiwayatStatusLength-1].stat_desc}.</p>
                        //         <div class="step__circle"></div>
                        //     </li>`;
                        // }

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

                    containerRiwayatStatus += '</ul>';


                    $('#containerRiwayatStatus').children().remove()
                    $('#containerRiwayatStatus').html(containerRiwayatStatus);
                    $('#containerRiwayatClock').children().remove()
                    $('#containerRiwayatClock').html(containerRiwayatClock);


                    // console.log(`count ==> `, res.dataRiwayat2.length);

                    


                    // if($('#containerTimeline').children().length > 0){
                    //     $('#containerTimeline').children().remove()
                    // }
                    // $('#containerTimeline').html(htmlTimeline)
                    // if($('#containerTimelineJam').children().length > 0){
                    //     $('#containerTimelineJam').children().remove()
                    // }
                    // $('#containerTimelineJam').html(htmlTimelineJam)



                    // container tanggapan
                    let htmlTanggapan = '';
                    if(res.dataTanggapan.length > 0){
                        $.each(res.dataTanggapan, (i, v) => {

                            let date = new Date(v.waktu);
                            let arrMonth = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agt", "Sep", "Okt", "Nov", "Des"]
                            let newDate = `${date.getDate()} ${arrMonth[date.getMonth()]} ${date.getFullYear()}`;
                            let newTime = `${date.getHours().toString().padStart(2, '0')}:${date.getMinutes().toString().padStart(2, '0')}`;

                            // htmlTanggapan += 
                            // `<div class="card mb-1">    
                            //     <div class="card-body d-flex justify-content-between">
                            //         <div class="col-sm-2 border-end">
                            //             <p class="mb-0 fw-bold text-muted">${newDate}</p>
                            //             <p style="font-size: 12px" class="mb-0 fw-bold">Jam : ${newTime}</p>
                            //         </div>
                            //         <div class="col-sm-10 ms-2">
                            //             <p class="mb-0 fw-bold">${v.fullname}</p>
                            //             ${v.respon}
                            //         </div>
                            //     </div>
                            // </div>`;
                                // console.log(v.photo);
                            let photoTanggapan = v.photo ? v.photo : '{{ asset('img/user.png') }}';
                            let fullname = v.fullname ? v.fullname : '-';

                            if(parseInt(v.is_anonymous) === 1){
                                    photoTanggapan = '{{ asset('img/user.png') }}';
                                    fullname = 'DIRAHASIAKAN';
                            }

                            // let photoTanggapan = v.photo ? v.photo : '{{ asset('img/user.png') }}';
                                htmlTanggapan += 
                                `
                                <div class="card border border-1 mb-1">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-6">
                                                <img class="rounded-circle" src="${photoTanggapan}" width="50" height="50">
                                                <span class="ms-3 fw-bold">${fullname}</span>
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

                    if($('#newContainerTanggapan').children().length > 0){
                        $('#newContainerTanggapan').children().remove()
                    }
                    $('#newContainerTanggapan').html(htmlTanggapan)

                    // set button hide
                    const statusId = res.dataKritik[0].status_kritiksaran ? parseInt(res.dataKritik[0].status_kritiksaran) : 0;
                    // console.log(res.dataKritik[0].status_kritiksaran);
                    

                    // if(parseInt(roles) === 63){

                    //     if(statusId === 4) {
                    //         $('#btnSelesai').hide();
                    //         $('#btnSimpanTanggapan').hide()
                    //     }else{
                    //         $('#btnSelesai').show();
                    //         $('#btnSimpanTanggapan').show()
                    //     }

                    // }


                    if(parseInt(roles) === 63){

                        $('#btnSelesai').hide();

                        if(statusId === 4){
                            $('#btnSimpanTanggapan').hide()
                        }

                    }else if(parseInt(roles) === 64){

                        $('#btnSelesai').show();
                        
                        if(statusId === 4) {
                            $('#btnSelesai').hide();
                            $('#btnSimpanTanggapan').hide()
                        // }else{
                        //     $('#btnSelesai').show();
                        //     $('#btnSimpanTanggapan').show()
                        }
                    }

                    // else{
                    //     $('#btnSelesai').hide();
                    //     $('#btnSimpanTanggapan').hide()
                    // }

                    // if(parseInt(roles) === 64){
                    //     if(statusId === 4) {
                    //         $('#btnSelesai').hide();
                    //         $('#btnSimpanTanggapan').hide()
                    //     }
                    // }


                })

            }
            
        
            // console.log(parseInt(roles));
            // if(!parseInt(roles) === 64){
            //     // $('#btnSelesai').hide()
            // }else{
            //     $('#btnSimpanTanggapan').show()
            //     // $('#btnSelesai').show()
            // }
            
            $('#modalView').modal('show')


            
        });



        // handle switch
        const btnKRITIK = $('#btn-kritik')
            $('#btnViewInformasiKritik').click(e => {
                e.preventDefault()
                btnKRITIK.animate({left: '0'}, 5);
                $('#section__view__infomasikritik').show();
                $('#section__view__infomasipengirim').hide();
                $('#section__view__riwayatstatus').hide()
                $('#section__view__informasitanggapan').hide();
            })
            $('#btnViewInformasiPengirim').click(e => {
                e.preventDefault()
                btnKRITIK.animate({left: '215px'}, 5);
                $('#section__view__infomasipengirim').show();
                $('#section__view__infomasikritik').hide();
                $('#section__view__riwayatstatus').hide()
                $('#section__view__informasitanggapan').hide();
            })
            $('#btnViewRiwayat').click(e => {
                e.preventDefault()
                btnKRITIK.animate({left: '400px'}, 5);
                $('#section__view__infomasipengirim').hide();
                $('#section__view__infomasikritik').hide();
                $('#section__view__riwayatstatus').show()
                $('#section__view__informasitanggapan').hide();
            })
            $('#btnViewInformasiTanggapan').click(e => {
                e.preventDefault()
                btnKRITIK.animate({left: '572px'}, 5);
                $('#section__view__infomasipengirim').hide();
                $('#section__view__infomasikritik').hide();
                $('#section__view__riwayatstatus').hide()
                $('#section__view__informasitanggapan').show();
            })
            // end handle switch

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

            $('#btnSimpanTanggapan').click(e => {
                e.preventDefault()

                const roles = '{{ session()->get('loggedInUser')['session_roles'] }}'

                // console.log(roles); return;

                if(!parseInt(roles) === 64 || !parseInt(roles) === 63){
                    showMessage('error', 'Anda tidak boleh menanggapi')
                    return;
                }

                const dataTanggapan = $('#txDeskripsi').val();
                const kritikId = $('#valKritikId').val();

                if(dataTanggapan === "" || dataTanggapan === null){
                    showMessage('error', 'Komentar tidak boleh kosong')
                    return;
                }

                $.ajax({
                    url: '{{ route('simpantanggapankritik') }}',
                    method: 'POST', 
                    dataType: 'json',
                    data: {
                        _token: '{{ csrf_token() }}',
                        dataTanggapan, 
                        kritikId
                    },
                }).done(res => {

                    if(res.status !== 200){
                        showMessage('error', res.message)
                        return
                    }

                    showMessage('success', res.message)
                    $('#txDeskripsi').summernote('code', '');

                    getDataTanggapan(kritikId);
                    
                })

            })

            const getDataTanggapan = (id) => {

                let idKritik = id;
                $.ajax({
                    url: '{{ route('tanggapanlistkritik') }}',
                    method: 'GET', 
                    dataType: 'json',
                    data: {
                        idKritik
                    },
                }).done(res => {

                    let htmlTanggapan = '';

                    if(res.status === 200){
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

                        if($('#newContainerTanggapan').children().length > 0){
                            $('#newContainerTanggapan').children().remove();
                        }

                        $('#newContainerTanggapan').html(htmlTanggapan);
                    }
                })
            }



            $('#modalView').on('hidden.bs.modal', function () {

                getDataKritik();
            })


            $('#btnFilter').click(function(e){
                e.preventDefault()

                

                // const sKategori = $('input[name="rdCategory"]:checked').val()
                // const sWaktu = $('input[name="rdRentangWaktu"]:checked').val()
                // const sStatus = $('input[name="rdStatus"]:checked').val()

                // console.log({
                //     kategori: sKategori,
                //     waktu: sWaktu,
                //     status: sStatus,
                // });
                getDataKritik();
                modalForm.modal('hide');
            });


            $('#btnReset').click(function(e){
                e.preventDefault();

                window.location.href = '{{ route('kritik') }}'
                $('#txSearch').val('');
                $('input[name="rdCategory"]').prop('checked', false);
                $('input[name="rdRentangWaktu"]').prop('checked', false);
                $('input[name="rdStatus"]').prop('checked', false);
                getDataKritik();
            })


            $('#btnSelesai').click(function(e){
                e.preventDefault()

                const valKritikId = $('#valKritikId').val()
                console.log(valKritikId);

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6e7881',
                    confirmButtonText: 'Ya', 
                    cancelButtonText: 'Tidak'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('selesaikritiksaran') }}', 
                            method: 'POST', 
                            dataType: 'json', 
                            data: {
                                _token: '{{ csrf_token() }}',
                                valKritikId, 
                            },
                        }).done(res => {

                            if(res.status !== 200){
                                showMessage('error', res.message);
                                return;
                            }
                            showMessage('success', res.message);
                            $('#modalView').modal('hide');
                            getDataKritik();

                        })
                    }
                })
            })


            $('#viewImage').click(function(e){
                e.preventDefault()
                const img = $(this).attr('src');
                $('#viewImgFluid').attr('src', img)
                $('#modalViewGambar').modal('show')
                // console.log('aaa');
            })

            // fungsi untuk set hide kritik
            const setIsHide = (id, m) => {
                $.ajax({
                    url: '{{ route('kritiksethide') }}', 
                    data: {_token: '{{ csrf_token() }}', id, m}, 
                    method: 'post',
                }).done(res => {
                    const {status} = res
                    const {message} = res.respon
                    if(status !== 200){
                        showMessage('error', 'Something went wrong, please try again')
                        console.log(message);
                    }
                    console.log(res);
                    kritiklist();
                })
            }

            pageBody.on('change', '.cKritikHide', function(e){
                e.preventDefault()
                const id = $(this).data('id')
                if(id){
                    const isCheck = $(this).is(':checked');
                    if(isCheck === true){
                        setIsHide(id, 'hide');
                    }else{
                        setIsHide(id, 'unhide');
                    }
                }
            })

            


    </script>

@endsection
