@extends('layouts.app')
@section('title', 'Profil Karyawan')

@section('content')

    <div class="wrappers">
        <div class="wrapper_content">

            <!-- modal reset password -->
            <div class="modal fade" data-bs-backdrop="static" id="modalResetPassword" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 25%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Reset Password</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formInputRepair"
                                style="font-size: 14px; display: flex; flex-direction: column; align-items: center;">
                                <img src="{{ asset('img/warning.png') }}"
                                    style=" height: auto; margin-bottom: 10px; align-self: center;">
                                <span style="text-align: center;">Apakah kamu yakin untuk reset password akun mysatnusa
                                    karyawan tersebut?</span>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="font-size: 12px; width: 120px; height: 30px;"
                                id="btnResetPassword" class="btn btn-primary">Reset Password</button>
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                                style="text-decoration: none; font-size: 12px; width: 150px; height: 30px;">Batalkan</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal reset password-->

            <!-- modal result reset password -->
            <div class="modal fade" data-bs-backdrop="static" id="modalResult" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 25%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"><strong>Pemberitahuan</strong></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formInputRepair"
                                style="font-size: 14px; display: flex; flex-direction: column; align-items: center;">
                                <img src="{{ asset('img/checklist1.png') }}"
                                    style=" height: auto; margin-bottom: 10px; align-self: center;">
                                <span style="text-align: center; font-weight: bold; font-size: 16px;">Password berhasil
                                    direset</span>
                                <span style="text-align: center;">Berikut ini adalah Password baru yang digunakan karyawan
                                    untuk
                                    login ke aplikasi MySatnusa.</span>

                                <span style="text-align: center; color: red; font-size: 16px;">1234satnusa
                                    <img src="{{ asset('img/copy.png') }}" style="height: auto; margin-left: 5px;"></span>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('profil') }}" type="button"
                                style="font-size: 12px; width: 400px; height: 30px;" id="btnResetPassword"
                                class="btn btn-primary">Oke</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal result reset password-->

            <!-- modal Notifikasi -->
            <div class="modal fade" data-bs-backdrop="static" id="modalNotifikasiSimpan" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 25%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel"><strong>Notifikasi</strong></h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="formInputRepair"
                                style="font-size: 14px; display: flex; flex-direction: column; align-items: center;">
                                <img src="{{ asset('img/checklist2.png') }}"
                                    style=" height: auto; margin-bottom: 10px; align-self: center;">
                                <span style="text-align: center; font-weight: bold; font-size: 16px;">Data Karyawan Telah
                                    diperbaharui</span>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('profil') }}" type="button"
                                style="font-size: 12px; width: 400px; height: 30px;" id="btnOke"
                                class="btn btn-primary">Oke</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end modal Notifikasi -->

            <div class="row me-3">
                <div class="col-sm-12 mb-3">
                    <p class="h4 mt-6">
                        Profil Karyawan
                    </p>
                    <a href="{{ route('list') }}" style="text-decoration: none">
                    <span class="text-muted"><i class="bx bx-chevron-left"></i> Kembali ke List Karyawan</span>
                    </a>
                    <button class="btn btn-outline-danger btn-sm float-end" id="btnModalReset">Reset Password</button>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-12">
                        <div class="card border-0" style="height: 600px">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist"
                                            aria-orientation="vertical">
                                            <a class="nav-link mb-2 active" id="v-pills-home-tab" data-bs-toggle="pill"
                                                href="#v-pills-profile" role="tab" aria-controls="v-pills-home"
                                                aria-selected="true">Informasi Karyawan</a>
                                            <a class="nav-link mb-2" id="v-pills-profile-tab" data-bs-toggle="pill"
                                                href="#v-pills-kontak" role="tab" aria-controls="v-pills-profile"
                                                aria-selected="false">Kontak dan Alamat</a>
                                            <a class="nav-link mb-2" id="v-pills-messages-tab" data-bs-toggle="pill"
                                                href="#v-pills-perangkat" role="tab" aria-controls="v-pills-messages"
                                                aria-selected="false">Perangkat Karyawan</a>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="tab-content text-muted mt-4 mt-md-0" id="v-pills-tabContent">
                                            <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel"
                                                aria-labelledby="v-pills-home-tab">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">Informasi Karyawan</h5>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-2 m-3">
                                                                <img width="100" height="100" class="border-0 rounded-circle imgView"
                                                                    src="{{ $listview[0]->img_user }}" alt="">
                                                            </div>
                                                            <div class="col-sm-4 mt-3">
                                                                <p class="mb-0 fw-bold">Nama</p>
                                                                <p class="mb-2">{{ $listview[0]->fullname }}</p>
                                                                <p class="mb-0 fw-bold">No. RFID</p>
                                                                <div class="input-group mb-3">
                                                                    <input type="text" style="width: 250px" class="form-control" id="txRfid" name="txRfid" value="{{ $listview[0]->rfid_no }}">
                                                                    <button class="btn btn-outline-danger" type="button" id="btnSimpanRFID"><i class="bx bxs-edit"></i></button>
                                                                    <span id="errTxRfid" class="text-danger"></span>
                                                                </div>
                                                                <p class="mb-0 fw-bold">PT</p>
                                                                <p class="mb-2">{{ $listview[0]->pt_name }}</p>
                                                                <p class="mb-0 fw-bold">Line Code</p>
                                                                <p class="mb-2">{{ $listview[0]->line_code }}</p>
                                                                <p class="mb-0 fw-bold">Mulai Kerja</p>
                                                                <p class="mb-2">{{ date('d M Y', strtotime($listview[0]->join_date)) }}</p>
                                                            </div>
                                                            <div class="col-sm-5 mt-3">
                                                                <p class="mb-0 fw-bold">Badge</p>
                                                                <p class="mb-3">{{ $listview[0]->badge_id }}</p>
                                                                <p class="mb-0 fw-bold">Jenis Kelamin</p>
                                                                <p class="mb-3">{{ $listview[0]->gender_name }}</p>
                                                                <p class="mb-0 fw-bold">Departmen</p>
                                                                <p class="mb-2">{{ $listview[0]->dept_name }}</p>
                                                                <p class="mb-0 fw-bold">Posisi</p>
                                                                <p class="mb-2">{{ $listview[0]->position_name }}</p>
                                                                <p class="mb-0 fw-bold">Tanggal Lahir</p>
                                                                <p class="mb-2">{{ date('d M Y', strtotime($listview[0]->tgl_lahir)) }}</p>
                                                            </div>
                                                        </div>

                                                        @php
                                                        $statusKaryawan = $listview ? $listview[0]->mulai_kontrak : '';
                                                        @endphp

                                                        {!! $statusKaryawan ? '<div class="row mb-3">
                                                            <div class="col-sm-2 m-3"></div>
                                                            <div class="col-sm-4">
								<p class="mb-0 fw-bold">Tanggal Mulai</p>
                                                                <input type="text" class="form-control dateMulai" id="dateMulai" name="dateMulai">
                                                            </div>
                                                            <div class="col-sm-4">
								<p class="mb-0 fw-bold">Tanggal Selesai</p>
                                                                <input type="text" class="form-control dateSelesai" id="dateSelesai" name="dateSelesai">
                                                            </div>
                                                            <div class="col-sm-1">
								<p class="mb-0 fw-bold text-white">a</p>
                                                                <button id="btnSimpanMasaKontrak" class="btn btn-outline-primary">Simpan</button>
                                                            </div>
                                                        </div>' : '' !!}

                                                        

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-kontak" role="tabpanel"
                                                aria-labelledby="v-pills-profile-tab">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-2">Kontak dan Alamat</h5>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-6">
                                                                <label class="" for="">No Handphone
                                                                    1</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $listview[0]->no_hp }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="15" name="txNoHp" id="txNoHp">
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="">No Handphone 2 (Opsional)</label>
                                                                <input type="text" class="form-control" name="txNoHp2" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="15" id="txNoHp2"
                                                                    value="{{ $listview[0]->no_hp2 }}">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-6">
                                                                <label class="" for="">Telp Rumah
                                                                    (Opsional)</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $listview[0]->home_telp }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="15" name="txNoTelp" id="txNoTelp">
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="">Email (Opsional)</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $listview[0]->email }}" name="txEmail" id="txEmail">
                                                                <span id="errEmail" class="text-danger"></span>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-6">
                                                                <label class="" for="">Kecamatan</label>
                                                                <select class="form-select" id="selectKecamatan" name="selectKecamatan">
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="">Kelurahan</label>
                                                                <select class="form-select" id="selectKelurahan" name="selectKelurahan">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-12">
                                                                <p>Alamat Lengkap</p>
                                                                <textarea class="form-control" value="{{$dataAlamat ? $dataAlamat[0]->alamat : ''}}" name="deskripsi" id="deskripsi" rows="3">{{$dataAlamat ? $dataAlamat[0]->alamat : ''}}</textarea>
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-12 text-end">
                                                                <button type="button" class="btn btn-link" id="btnModalTolak" style="text-decoration: none;">Batal</button>
                                                                <button type="button" id="btnSimpanAlamat"
                                                                class="btn btn-primary">Simpan Perubahan</button>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="v-pills-perangkat" role="tabpanel"
                                                aria-labelledby="v-pills-messages-tab">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-3">Perangkat Karyawan</h5>
                                                        <div id="containerTableMMS" class="col-sm-12 mt-1">
                                                            <table class="table table-responsive table-hover"
                                                                style="max-width: 1000px;">
                                                                <thead>
                                                                    <tr style="color: #CD202E; height: -10px;"
                                                                        class="table-danger">
                                                                        <th class="p-3" scope="col">Model</th>
                                                                        <th class="p-3" scope="col">Brand</th>
                                                                        <th class="p-3" scope="col">OS</th>
                                                                        <th class="p-3" scope="col">Versi Aplikasi
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    {{-- @foreach ($dataPerangkat as $row)

                                                                    <tr>
                                                                        <td class="p-3"></td>
                                                                        <td class="p-3"></td>
                                                                        <td class="p-3"></td>
                                                                        <td class="p-3"></td>
                                                                    </tr>
                                                                        
                                                                    @endforeach --}}
                                                                        {{-- {{ dd($dataPerangkat) }} --}}
                                                                    {{-- <tr>
                                                                        <td class="p-3">Realme 6</td>
                                                                        <td class="p-3">Realme</td>
                                                                        <td class="p-3">
                                                                            <img src="{{ asset('img/android.png') }}">
                                                                            Android
                                                                        </td>
                                                                        <td class="p-3">1.1.0</td>

                                                                    </tr>
                                                                    <tr>
                                                                        <td class="p-3">IPhone 14 Pro Max</td>
                                                                        <td class="p-3">Apple</td>
                                                                        <td class="p-3">
                                                                            <img src="{{ asset('img/ios.png') }}">
                                                                            IOS
                                                                        </td>
                                                                        <td class="p-3">1.1.0</td>
                                                                    </tr> --}}
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="font-size: 12px; color: #60625D; margin-bottom: 5px;">Dibuat Oleh</div>
                                <div style="font-size: 14px; font-weight: semi-bold; margin-bottom: 5px;">
                                    {{ $listview[0]->pembuat ? $listview[0]->pembuat : '-' }}</div>
                                <div style="font-size: 12px; color: #60625D; margin-bottom: 5px;">Dibuat pada</div>
                                <div style="font-size: 14px; font-weight: semi-bold; margin-bottom: 5px;">
                                    {{ date('d M Y', strtotime($listview[0]->createdate)) }}</div>
                                <div style="font-size: 12px; color: #60625D; margin-bottom: 5px;">Diedit Oleh</div>
                                <div style="font-size: 14px; font-weight: semi-bold; margin-bottom: 5px;">
                                    {{ $listview[0]->pengedit }}</div>
                                <div style="font-size: 12px; color: #60625D; margin-bottom: 5px;">Diedit Pada</div>
                                <div style="font-size: 14px; font-weight: semi-bold; margin-bottom: 5px;">
                                    {{ date('d M Y', strtotime($listview[0]->updatedate)) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            {{-- batas --}}
        </div>

    </div>
    </div>

    </div>
    </div>
    </div>
    </div>
    </div>


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
  {{-- end modal view Export --}}

@endsection

@section('script')

    <script>
        // const btnreset = $('#btnModalReset');
        const modalFormReset = $('#modalResetPassword');

        // const btnResetOke = $('#btnResetPassword');
        const modalFormResult = $('#modalResult');

        const btnsimpan = $('#btnModalSimpan');
        const modalFormNotifikasi = $('#modalNotifikasiSimpan');

        // btnreset.click(e => {
        //     e.preventDefault();
        //     modalFormReset.modal('show');

        // });

        // btnResetOke.click(e => {
        //     e.preventDefault();
        //     modalFormResult.modal('show');

        // });

        let dateMulai = flatpickr(".dateMulai", {
            dateFormat: "d-m-Y",
            defaultDate: "today",
        });

        let dateSelesai = flatpickr(".dateSelesai", {
            dateFormat: "d-m-Y",
            defaultDate: "today",
        });

        btnsimpan.click(e => {
            e.preventDefault();
            modalFormNotifikasi.modal('show');

        });

        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("active");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.classList.add("active");
        }



        // update RFID karyawan 
        $('#btnUpdateRFID').click(function(e) {
            e.preventDefault();

            updateEmployee();

              
        });

            


        const updateEmployee = () => {
            

            const roles = '{{ session()->get('loggedInUser')['session_roles'] }}'

            if(parseInt(roles) === 64 || parseInt(roles) === 63){
                const badge = '{{ $listview[0]->badge_id }}';
                const rfidNo = $('#txRfid').val();
                const txNoHp = $('#txNoHp').val();
                const txNoHp2 = $('#txNoHp2').val();
                const txNoTelp = $('#txNoTelp').val();
                const txEmail = $('#txEmail').val();
                const selectKecamatan = $('#selectKecamatan').val();
                const selectKelurahan = $('#selectKelurahan').val();
                const deskripsi = $('#deskripsi').val();

                if(txEmail !== ""){
                    let validateEmail = isEmail(txEmail);
    
                    if(validateEmail === false){
                        $('#errEmail').text('Tidak sesuai format email')
                        return
                    }else{
                        $('#errEmail').text('')
                    }
                }


                if (badge) {
                    $.ajax({
                        url: '{{ route('updaterfid') }}',
                        method: 'post',
                        data: {
                            _token: '{{ csrf_token() }}',
                            badge,
                            rfidNo,
                            txNoHp,
                            txNoHp2,
                            txNoTelp,
                            txEmail,
                            selectKecamatan,
                            selectKelurahan,
                            deskripsi
                        },
                        dataType: 'json',
                        beforeSend: () => {
                            $('#btnUpdateRFID').prop('disabled', true);
                            $('#btnSimpanAlamat').prop('disabled', true);
                        },
                    }).done(res => {
    
                        $('#btnUpdateRFID').prop('disabled', false);
                        $('#btnSimpanAlamat').prop('disabled', false);

                        if (res.status === 200) {
                            showMessage('success', res.message);

                            setTimeout(() => {
                                window.location.reload();
                            }, 3000);
                        }


                    })
                }
            }else{
                showMessage('error', 'Anda tidak punya otoritas mengubah data ini');
            }

            
        }


        // ambil data alamat
        // const getDataAlamat = () => {

        // const badge = '{{ $listview[0]->badge_id }}';

        // $.ajax({
        //     url: '{{ route('alamatbybadge') }}',
        //     method: 'GET',
        //     dataType: 'json',
        //     data: {
        //         badge
        //     },
        // }).done(res => {
        //     // console.log(res);

            

        //     // $('#selectKecamatan').val(res.data[0].kecamatan);
        //     // $('#selectKelurahan').val(res.data[0].kelurahan);
        //     // $('#deskripsi').val(res.data[0].alamat);
        // });
        // }

        // getDataAlamat();


        

        const getAllKecamatan = () => {

            let html = '';

            $.ajax({
                url: '{{ route('kecamatanlist') }}',
                method: 'GET',
                dataType: 'json',
            }).done(res => {

                console.log(res);

                html += `<option value="">-- Pilih --</option>`;

                if (res.status === 200) {

                    $.each(res.data, (i, v) => {
                        html += `<option value="${v.id}">${v.kecamatan}</option>`;
                    })

                    // if ($('#selectKecamatan').children().length > 0) {
                    // }
                    
                    $('#selectKecamatan').children().remove();
                    $('#selectKecamatan').html(html);
                    
                    // console.log(res);
                    $('#selectKecamatan').val('{{ $dataAlamat ? $dataAlamat[0]->kecamatan : 0}}');
                    getAllKelurahan('{{ $dataAlamat ? $dataAlamat[0]->kecamatan : 0 }}')

                    // getAllKelurahan(res.data[0].id);
                    // if(!$('#selectKecamatan') === ""){
                    // }
                    
                }
            })
        }

        getAllKecamatan();



        // trigger change kecamatan
        $('#selectKecamatan').change(function() {
            const id = $(this).val();
            getAllKelurahan(id);
        })

        // kelurahan list
        const getAllKelurahan = (id="1") => {

            // console.log(id);

            let html = '';

            $.ajax({
                url: '{{ route('kelurahanlist') }}',
                method: 'GET',
                dataType: 'json',
                data: {
                    id
                },
            }).done(res => {

                html += `<option value="">-- Pilih --</option>`;
                // console.log(res ?);


                if (res.status === 200) {

                    $.each(res.data, (i, v) => {
                        html += `<option value="${v.id}">${v.kelurahan}</option>`;
                    })

                    // if ($('#selectKelurahan').children().length > 0) {
                    // }
                    
                    $('#selectKelurahan').children().remove();
                    $('#selectKelurahan').html(html);
                    $("#selectKelurahan").val('{{ $dataAlamat ? $dataAlamat[0]->kelurahan : 0 }}');
                }
            })
        }

        getAllKelurahan();



        // kelurahan list
        

        


        

        // ambil data mms
        const getAllMmsByBadge = () => {

            const badge = '{{ $listview[0]->badge_id }}';

            $.ajax({
                url: '{{ route('mmslistbybadge') }}',
                method: 'GET',
                data: {
                    badge
                },
            }).done(res => {
                // console.log(res);
                $('#containerTableMMS').html(res);
            })
        }

        getAllMmsByBadge();

        // update alamat
        $('#btnSimpanAlamat').click(function(e) {
            e.preventDefault();
            updateEmployee();
        })

        $('#btnSimpanRFID').click(function(e){
            e.preventDefault();

            Swal.fire({
                title: 'Apakah kamu yakin?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6e7881',
                confirmButtonText: 'Yakin!', 
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateEmployee();
                }
            })

        })

        function isEmail(email) {
            var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email);
        }

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

        $('#btnModalReset').click(function(e){
            e.preventDefault();

            const roles = '{{ session()->get('loggedInUser')['session_roles'] }}'

            if(parseInt(roles) === 64 || parseInt(roles) === 63){
                const badge = '{{ $listview[0]->badge_id }}';

            Swal.fire({
                title: 'Apakah kamu yakin untuk mereset password?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6e7881',
                confirmButtonText: 'Yakin!', 
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '{{ route('resetpasswordprofile') }}',
                        method: 'GET', 
                        data: {badge}
                    }).done(res => {
                        // console.log(res);

                        if(res.status !== 200){
                            showMessage('error', res.message);
                            return;
                        }

                        showMessage('success', res.message);
                    })
                }
            });

            }else{
                showMessage('error', 'Kamu tidak punya akses')
            }

        })


        if($('#dateSelesai').is(':visible')){
            // $('#dateMulai').val('{{ $listview[0]->mulai_kontrak }}')
            // dateMulai = flatpickr(".dateMulai", {
            //     dateFormat: "d-m-Y",
            //     defaultDate: "{{ $listview[0]->mulai_kontrak }}",
            // });
            // console.log('{{ $listview[0]->mulai_kontrak }}');

            // dateMulai.setDate('2019-01-02');
            // console.log();
            // $('#dateMulai').val('{{ $listview[0]->mulai_kontrak }}');
            // dateMulai = flatpickr(".dateMulai", {
            //     minDate: "2019-01-02",
            //     dateFormat: "d-m-Y",
            // })

            // let date = new Date('{{ $listview[0]->mulai_kontrak }}');
            // let newDate = 

            // dateMulai.setDate("2019-01-02", "d-m-Y")
            $('#dateMulai').val('{{ $listview[0]->mulai_kontrak }}');
            $('#dateSelesai').val('{{ $listview[0]->selesai_kontrak }}');
        }

        // console.log($('#dateSelesai').is(':visible'));

        $('#btnSimpanMasaKontrak').click(e => {
            e.preventDefault()

            Swal.fire({
                title: 'Apakah kamu yakin?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6e7881',
                confirmButtonText: 'Yakin!', 
                cancelButtonText: 'Tidak'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateMasaKontrak();
                }
            })

            
        })

        const updateMasaKontrak = () => {
            const dateMulai = $('#dateMulai').val()
            const dateSelesai = $('#dateSelesai').val()
            const badge = '{{ $listview[0]->badge_id }}';

            $.ajax({
                url: '{{ route('updatemasakontrak') }}', 
                method: 'GET', 
                data: {dateMulai, dateSelesai, badge},
                dataType: 'json',
            }).done(res => {

                if(res.status !== 200){
                    showMessage('error', res.message);
                    return;
                }

                showMessage('success', res.message);
                // console.log(res);
                setTimeout(() => {
                    window.location.reload();
                }, 2500);
            })

        }

    </script>

@endsection
