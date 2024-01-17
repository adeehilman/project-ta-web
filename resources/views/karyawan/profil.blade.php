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

             <!-- modal insert password untuk edit no kk -->
             <div class="modal fade" data-bs-backdrop="static" id="modalEditNokk" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 25%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Masukkan Password</h1>
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form id="formInputPassword" class="mb-2" style="font-size: 14px; display: flex; flex-direction: column; align-items: center;">
                                <div class="input-group">
                                    <input type="password" title="Silahkan isi jika ingin melakukan perubahan" class="form-control" id="passwordUser" name="passwordUser" placeholder="Password">
                                </div>
                            </form>
                            <div id="errpasswordUser" class="text-danger"></div>
                            <span style="font-size: 14px;">Isi Password Anda Untuk Menampilkan dan Mengubah No KK</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                            style="text-decoration: none; font-size: 14px; width: 150px; height: 40px;">Batal</button>
                            <button type="button" style="font-size: 14px; width: 120px; height: 40px;"
                                id="btnInsertPassword" class="btn btn-primary">Lanjutkan</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end insert password untuk edit no kk-->

            <!-- modal insert password untuk melihat dan download dokumen karyawan-->
            <div class="modal fade" data-bs-backdrop="static" id="modalDownloadDokumen" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 25%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="exampleModalLabel">Masukkan Password</h1>
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                        </div>
                        <div class="modal-body">
                            <form id="formInputPasswordDokumen" class="mb-2" style="font-size: 14px; display: flex; flex-direction: column; align-items: center;">
                                <div class="input-group">
                                    <input type="password" title="Silahkan isi jika ingin melakukan perubahan" class="form-control" id="passwordUserDok" name="passwordUserDok" placeholder="Password">
                                </div>
                            </form>
                            <div id="errpasswordUserDok" class="text-danger"></div>
                            <span style="font-size: 14px;">Isi Password Anda Untuk Menampilkan dan Mendownload Dokumen</span>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-dismiss="modal"
                            style="text-decoration: none; font-size: 14px; width: 150px; height: 40px;">Batal</button>
                            <button type="button" style="font-size: 14px; width: 120px; height: 40px;"
                                id="btnInsertPasswordDok" class="btn btn-primary">Lanjutkan</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end insert password untuk melihat dan download dokumen karyawan-->

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
                                            <a class="nav-link mb-2 ajsff active" id="v-pills-home-tab" data-bs-toggle="pill"
                                                href="#v-pills-profile" role="tab" aria-controls="v-pills-home"
                                                aria-selected="true">Informasi Karyawan</a>
                                            <a class="nav-link mb-2" id="v-pills-privacy-info-tab" data-bs-toggle="pill"
                                                href="#v-pills-privacy-info" role="tab" aria-controls="v-pills-privacy-info"
                                                aria-selected="false">Informasi Pribadi</a>
                                            <a class="nav-link mb-2" id="v-pills-profile-tab" data-bs-toggle="pill"
                                                href="#v-pills-kontak" role="tab" aria-controls="v-pills-profile"
                                                aria-selected="false">Kontak dan Domisili</a>
                                            <a class="nav-link mb-2" id="v-pills-employee-document-tab" data-bs-toggle="pill"
                                                href="#v-pills-employee-document" role="tab" aria-controls="v-pills-employee-document"
                                                aria-selected="false">Dokumen Karyawan</a>
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
                                                        <h5 class="card-title fw-bold">Informasi Karyawan</h5>

                                                        <div class="row mb-3">
                                                            <div class="col-sm-2 m-3">
                                                                <img width="100" height="100" class="border-0 rounded-circle imgView"
                                                                    src="{{ $listview[0]->img_user }}" alt="">
                                                            </div>
                                                            <div class="col-sm-4 mt-3">
                                                                <p class="mb-0 fw-bold" id="nama" name="kategori">Nama</p>
                                                                <div class="input-group mb-2">
                                                                    <input type="text" title="Silahkan isi jika ingin melakukan perubahan" class="form-control" id="txNama" name="txNama" value="{{ $listview[0]->fullname }}">
                                                                </div>
                                                                    <div id="errTxNama" class="text-danger"></div>

                                                                <p class="mb-0 fw-bold" id="no_rfid" name="kategori">No. RFID</p>
                                                                <div class="input-group mb-2">
                                                                    <input type="text" title="Silahkan isi jika ingin melakukan perubahan" class="form-control" id="txRfid" name="txRfid" value="{{ $listview[0]->rfid_no }}">
                                                                </div>
                                                                    <div id="errTxRfid" class="text-danger"></div>

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
                                                                <p class="mb-0 fw-bold">Departemen</p>
                                                                <p class="mb-2">{{ $listview[0]->dept_name }}</p>
                                                                <p class="mb-0 fw-bold">Posisi</p>
                                                                <p class="mb-2">{{ $listview[0]->position_name }}</p>
                                                                <p class="mb-0 fw-bold">Tanggal Lahir</p>
                                                                <p class="mb-2">{{ date('d M Y', strtotime($listview[0]->tgl_lahir)) }}</p>
                                                            </div>
                                                            <div class="text-end">
                                                                <button type="button" id="btnBatalKaryawan" class="btn btn-link" style="text-decoration: none;">Batal</button>
                                                                <button type="button" id="btnSimpanPerubahan" class="btn btn-primary">Simpan Perubahan</button>
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
                                            
                                            <div class="tab-pane fade" id="v-pills-privacy-info" role="tabpanel" aria-labelledby="v-pills-privacy-info-tab">
                                                <!-- Konten untuk Privacy Info -->
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-2 fw-bold">Informasi Pribadi</h5>
                                                      
                                                        <div class="row mb-3 mt-3">
                                                            <div class="col-sm-6 mb-3">
                                                                <label for="">No. KK</label>
                                                                <div class="input-group">
                                                                    @php
                                                                        $nokk = isset($listprivasi[0]) ? $listprivasi[0]->nokk : null;
                                                                            if ($nokk !== null) {
                                                                                try {
                                                                                    $nokk = Crypt::decryptString($nokk);
                                                                                    $asterisks = str_repeat('*', strlen($nokk));
                                                                                } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                                                                                    $asterisks = '<span class="text-danger">Error melakukan decrypt nokk</span>';
                                                                                }
                                                                            } else {
                                                                              
                                                                                $asterisks = ''; 
                                                                            }
                                                                    @endphp
                                                                    <input type="text" title="Silahkan isi jika ingin melakukan perubahan" class="form-control" id="txNoKK" name="txNoKK" value="{{ $nokk  }}" placeholder="Masukkan No.KK" disabled>
                                                                    <button id="btnEditNokk" class="btn btn-outline-primary" type="button">
                                                                    <i class="mt-1 bx bxs-show fs-4"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6 mb-3">
                                                                <label for="SelectPendidikanTerakhir">Pendidikan Terakhir</label>
                                                                <select class="form-select" id="SelectPendidikanTerakhir" name="pendidikan">
                                                                    <option value="" disabled {{ empty($listprivasi[0]) ? 'selected' : '' }}>-- Pilih Pendidikan Terakhir --</option>
                                                                    <option value="SD/MI" {{ isset($listprivasi[0]) ? $listprivasi[0]->pendidikan == 'SD/MI' ? 'selected' : '' : '-' }}>SD/MI</option>
                                                                    <option value="SMP/MTS" {{ isset($listprivasi[0]) ? $listprivasi[0]->pendidikan == 'SMP/MTS' ? 'selected' : '' : '-' }}>SMP/MTS</option>
                                                                    <option value="SMA/SMK/MA" {{ isset($listprivasi[0]) ? $listprivasi[0]->pendidikan == 'SMA/SMK/MA' ? 'selected' : '' : '-' }}>SMA/SMK/MA</option>
                                                                    <option value="Diploma I" {{ isset($listprivasi[0]) ? $listprivasi[0]->pendidikan == 'Diploma I' ? 'selected' : '' : '-' }}>Diploma I</option>
                                                                    <option value="Diploma II" {{ isset($listprivasi[0]) ? $listprivasi[0]->pendidikan == 'Diploma II' ? 'selected' : '' : '-' }}>Diploma II</option>
                                                                    <option value="Diploma III" {{ isset($listprivasi[0]) ? $listprivasi[0]->pendidikan == 'Diploma III' ? 'selected' : '' : '-' }}>Diploma III</option>
                                                                    <option value="Diploma IV" {{ isset($listprivasi[0]) ? $listprivasi[0]->pendidikan == 'Diploma IV' ? 'selected' : '' : '-' }}>Diploma IV</option>
                                                                    <option value="Sarjana" {{ isset($listprivasi[0]) ? $listprivasi[0]->pendidikan == 'Sarjana' ? 'selected' : '' : '-' }}>Sarjana</option>
                                                                    <option value="Magister" {{ isset($listprivasi[0]) ? $listprivasi[0]->pendidikan == 'Magister' ? 'selected' : '' : '-' }}>Magister</option>
                                                                    <option value="Doctor" {{ isset($listprivasi[0]) ? $listprivasi[0]->pendidikan == 'Doctor' ? 'selected' : '' : '-' }}>Doctor</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6 mb-3">
                                                                <label for="SelectStatusPernikahan">Status Pernikahan</label>
                                                                <select class="form-select" id="SelectStatusPernikahan" name="statusnikah">
                                                                    <option value="" disabled {{ empty($listprivasi[0]) ? 'selected' : '' }}>-- Pilih Status Pernikahan --</option>
                                                                    <option value="Belum Menikah" {{ isset($listprivasi[0]) ? $listprivasi[0]->statusnikah == 'Belum Menikah' ? 'selected' : '' : '-'  }}>Belum Menikah</option>
                                                                    <option value="Menikah" {{ isset($listprivasi[0]) ? $listprivasi[0]->statusnikah == 'Menikah' ? 'selected' : '' : '-'  }}>Menikah</option>
                                                                    <option value="Cerai Hidup" {{ isset($listprivasi[0]) ? $listprivasi[0]->statusnikah == 'Cerai Hidup' ? 'selected' : '' : '-'  }}>Cerai Hidup</option>
                                                                    <option value="Cerai Mati" {{ isset($listprivasi[0]) ? $listprivasi[0]->statusnikah == 'Cerai Mati' ? 'selected' : '' : '-'  }}>Cerai Mati</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6 mb-3">
                                                                <label for="">Jurusan</label>
                                                                <input type="text" title="Silahkan isi jika ingin melakukan perubahan" class="form-control" id="txJurusan" name="txJurusan" value="{{ isset($listprivasi[0]) ? $listprivasi[0]->jurusan : ''}}" placeholder="Masukkan Jurusan">
                                                            </div>
                                                            <div class="col-sm-6 mb-3">
                                                                <label for="SelectAgama">Agama</label>
                                                                <select class="form-select" id="SelectAgama" name="agama">
                                                                    <option value="" disabled {{ empty($listprivasi[0]) ? 'selected' : '' }}>-- Pilih Agama --</option>
                                                                    @foreach ($listagama as $agama)
                                                                        <option value="{{ $agama->name }}" {{ isset($listprivasi[0]) ? $listprivasi[0]->agama == $agama->name ? 'selected' : '' : '-'  }}>{{ $agama->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <div class="col-sm-6 mb-3">
                                                                <label for="">Tahun Lulus</label>
                                                                <input type="text" title="Silahkan isi jika ingin melakukan perubahan" class="form-control" id="txTahunLulus" name="txTahunLulus" value="{{ isset($listprivasi[0]) ? $listprivasi[0]->tahunlulus : ''}}" placeholder="Masukkan Tahun Lulus">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-12 text-end">
                                                                <button type="button" class="btn btn-link" id="btnBatalPribadi" style="text-decoration: none;">Batal</button>
                                                                <button type="button" id="btnSimpanDataPrivasi"
                                                                class="btn btn-primary">Simpan Perubahan</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="tab-pane fade" id="v-pills-kontak" role="tabpanel"
                                                aria-labelledby="v-pills-profile-tab">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-2 fw-bold">Kontak</h5>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-6">
                                                                <label class="" for="">Personal Email</label>
                                                                <input type="text" class="form-control" value="{{ $listview[0]->email }}" name="txEmail" id="txEmail" placeholder="Masukkan Personal Email">
                                                                <span id="errEmail" class="text-danger"></span>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="">No. Handphone</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $listview[0]->no_hp }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="15" name="txNoHp" id="txNoHp" placeholder="Masukkan No.Handphone">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-6">
                                                                <label class="" for="">No. Handphone 2
                                                                    (Opsional)</label>
                                                                    <input type="text" class="form-control" name="txNoHp2" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="15" id="txNoHp2"
                                                                    value="{{ $listview[0]->no_hp2 }}" placeholder="Masukkan No.Handphone 2">
                                                               
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="">No Telpon (Opsional)</label>
                                                                <input type="text" class="form-control"
                                                                value="{{ $listview[0]->home_telp }}" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="15" name="txNoTelp" id="txNoTelp" placeholder="Masukkan No.Telepon">
                                                            </div>
                                                        </div>
                                                        <h5 class="card-title mb-2 fw-bold">Domisili</h5>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-12">
                                                                <p>Alamat</p>
                                                                <textarea class="form-control" value="{{$dataAlamat ? $dataAlamat[0]->alamat : ''}}" name="deskripsi" id="deskripsi" rows="3" placeholder="Masukkan Alamat">{{$dataAlamat ? $dataAlamat[0]->alamat : ''}}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-3">
                                                                <label class="" for="">RT</label>
                                                                 <input type="number" id="txRt" value="{{$dataAlamat ? $dataAlamat[0]->rt : ''}}" class="form-control" placeholder="Masukkan No.RT">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label for="">RW</label>
                                                                <input type="number" id="txRw" value="{{$dataAlamat ? $dataAlamat[0]->rw : ''}}" class="form-control" placeholder="Masukkan No.RW">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label class="" for="">Kecamatan</label>
                                                                <select class="form-select" value="{{$dataAlamat ? $dataAlamat[0]->kecamatan : ''}}" id="selectKecamatan" name="selectKecamatan">
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <label for="">Kelurahan</label>
                                                                <select class="form-select" value="{{$dataAlamat ? $dataAlamat[0]->kelurahan : ''}}" id="selectKelurahan" name="selectKelurahan">
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-sm-12 text-end">
                                                                <button type="button" class="btn btn-link" id="btnBatalKontakDomisili" style="text-decoration: none;">Batal</button>
                                                                <button type="button" id="btnSimpanAlamat" class="btn btn-primary" >Simpan Perubahan</button>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tab-pane fade" id="v-pills-employee-document" role="tabpanel"
                                                aria-labelledby="v-pills-employee-document-tab">
                                                <!-- Konten untuk Employee Document -->
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title fw-bold">Dokumen Karyawan</h5>
                                                        <div class="col-sm-12 mb-3 text-end">
                                                            <button type="button" id="btnDownloadDokumen" class="btn btn-danger">
                                                                <img style="margin-right: 5px;" src="{{ asset('icons/download.svg') }}" alt="Download Icon"> Download
                                                            </button>
                                                        </div>
                                                        <div class="table-responsive">
                                                            <table id="tableDokumenKaryawan" class="table table-responsive table-hover" style="font-size: 15px">
                                                                <thead>
                                                                    <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                                                                        <th class="p-2" scope="col">Kategori Dokumen</th>
                                                                        <th class="p-2" scope="col">Nama Dokumen</th>
                                                                        <th class="p-2" scope="col">Terakhir Diperbarui</th>
                                                                </thead>
                                                                <tbody>
                                                                    @if($listDokumen && count($listDokumen) > 0)
                                                                        <tr>
                                                                            <td class="p-2">{{$listDokumen[0]->kategori_name}}</td>
                                                                            <td>
                                                                                @php
                                                                                    $decryptedFilename = Crypt::decryptString($listDokumen[0]->filename);
                                                                                @endphp
                                                                                <div id="dokumen" href="{{ asset('documents/' . $decryptedFilename) }}" target="_blank" rel="noopener noreferrer">
                                                                                    {{ $decryptedFilename }}
                                                                                </div>
                                                                            </td>
                                                                            <td class="p-2">{{ \Carbon\Carbon::parse($listDokumen[0]->updatedate)->format('j M Y') }}</td>
                                                                        </tr>
                                                                    @else
                                                                        <tr>
                                                                            <td class="p-2"></td>
                                                                            <td class="text-center p-2">No data available</td>
                                                                            <td class="p-2"></td>
                                                                        </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                            <div class="tab-pane fade" id="v-pills-perangkat" role="tabpanel"
                                                aria-labelledby="v-pills-messages-tab">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title mb-3 fw-bold">Perangkat Karyawan</h5>
                                                        <div id="containerTableMMS" class="col-sm-12 mt-1">
                                                            <table id="tablePerangkatKaryawan" class="table table-responsive table-hover" style="font-size: 15px;">
                                                                <thead>
                                                                    <tr style="color: #CD202E; font-size: 15px; height: -10px;"class="table-danger">
                                                                        <th class="p-3" scope="col">Model</th>
                                                                        <th class="p-3" scope="col">Brand</th>
                                                                        <th class="p-3" scope="col">OS</th>
                                                                        <th class="p-3" scope="col">Versi Aplikasi</th>
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

$(document).ready(function () {
            // Set the "v-pills-home-tab" as the default active tab
            $('#v-pills-home-tab').addClass('active');

            // Show the corresponding tab content
            var tabName = $('#v-pills-home-tab').attr('href');
            $(tabName).show();
        });
        var txNamaValueReset = '{{ isset($listview[0]->fullname) ? $listview[0]->fullname : "" }}';
        var txRfidValueReset = '{{ isset($listview[0]->rfid_no) ? $listview[0]->rfid_no : "" }}';
        var txEmailValueReset = '{{ isset($listview[0]->email) ? $listview[0]->email : "" }}';
        var txNohpValueReset = '{{ isset($listview[0]->no_hp) ? $listview[0]->no_hp : "" }}';
        var txNohp2ValueReset = '{{ isset($listview[0]->no_hp2) ? $listview[0]->no_hp2 : "" }}';
        var txNoTelpValueReset = '{{ isset($listview[0]->home_telp) ? $listview[0]->home_telp : "" }}';

        var txDeskripsiValueReset = '{{ isset($dataAlamat[0]->alamat) ? $dataAlamat[0]->alamat : "" }}';
        var txRtValueReset = '{{ isset($dataAlamat[0]->rt) ? $dataAlamat[0]->rt : "" }}';
        var txRwValueReset = '{{ isset($dataAlamat[0]->rw) ? $dataAlamat[0]->rw : "" }}';
        var txKecamatanValueReset = '{{ isset($dataAlamat[0]->kecamatan) ? $dataAlamat[0]->kecamatan : "" }}';
        var txKelurahanValueReset = '{{ isset($dataAlamat[0]->kelurahan) ? $dataAlamat[0]->kelurahan : "" }}';

        var txNokkValueReset = '{{ $asterisks }}';
        var txPendidikanValueReset = '{{ isset($listprivasi[0]->pendidikan) ? $listprivasi[0]->pendidikan : "" }}';
        var txPernikahanValueReset = '{{ isset($listprivasi[0]->statusnikah) ? $listprivasi[0]->statusnikah : "" }}';
        var txJurusanValueReset = '{{ isset($listprivasi[0]->jurusan) ? $listprivasi[0]->jurusan : "" }}';
        var txAgamaValueReset = '{{ isset($listprivasi[0]->agama) ? $listprivasi[0]->agama : "" }}';
        var txTahunLulusValueReset = '{{ isset($listprivasi[0]->tahunlulus) ? $listprivasi[0]->tahunlulus : "" }}';
    </script>
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
                const nama = $('#txNama').val();
                const rfidNo = $('#txRfid').val();
                const txNoHp = $('#txNoHp').val();
                const txNoHp2 = $('#txNoHp2').val();
                const txNoTelp = $('#txNoTelp').val();
                const txEmail = $('#txEmail').val();
                const txRt = $('#txRt').val();
                const txRw = $('#txRw').val();
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
                    Swal.fire({
                        title: 'Menyimpan perubahan...',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        html: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                        onBeforeOpen: () => {
                            Swal.showLoading();
                        }
                    });


                    $.ajax({
                        url: '{{ route('updaterfid') }}',
                        method: 'post',
                        data: {
                            _token: '{{ csrf_token() }}',
                            badge,
                            nama,
                            rfidNo,
                            txNoHp,
                            txNoHp2,
                            txNoTelp,
                            txEmail,
                            txRt,
                            txRw,
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

        const updatePrivasi = () => {
            

            const roles = '{{ session()->get('loggedInUser')['session_roles'] }}'

            if(parseInt(roles) === 64 || parseInt(roles) === 63){
                const badge = '{{ $listview[0]->badge_id }}';
                let nokk = $('#txNoKK').val();
                const pendidikan = $('#SelectPendidikanTerakhir').val();
                const pernikahan = $('#SelectStatusPernikahan').val();
                const jurusan = $('#txJurusan').val();
                const agama = $('#SelectAgama').val();
                const tahunLulus = $('#txTahunLulus').val();

                if ($('#txNoKK').prop('disabled')) {
                    const nokkOriginal=  '{{ $nokk }}';
                    nokk = nokkOriginal;
                }

                if (badge) {
                    $.ajax({
                        url: '{{ route('updateprivasi') }}',
                        method: 'post',
                        data: {
                            _token: '{{ csrf_token() }}',
                            badge,
                            nokk,
                            pendidikan,
                            pernikahan,
                            jurusan,
                            agama,
                            tahunLulus
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

                html += `<option value="" selected disabled>-- Pilih Kecamatan --</option>`;

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

                    
                    if (!$('#selectKecamatan').val()) {
                        $('#selectKecamatan').val('');
                    }
                    
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

                html += `<option value="" selected disabled>-- Pilih Kelurahan --</option>`;
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

                    if (!$('#selectKelurahan').val()) {
                        $('#selectKelurahan').val('');
                    }
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

        // btn batal informasi kontak dan domisili
        $('#btnBatalKontakDomisili').click(function() {

            $('#txEmail').val(txEmailValueReset);
            $('#txNoHp').val(txNohpValueReset);
            $('#txNoHp2').val(txNohp2ValueReset);
            $('#txNoTelp').val(txNoTelpValueReset);
            $('#deskripsi').val(txDeskripsiValueReset);
            $('#txRt').val(txRtValueReset);
            $('#txRw').val(txRwValueReset);
            $('#selectKecamatan').val(txKecamatanValueReset);
            $('#selectKelurahan').val(txKelurahanValueReset);

            $("#btnSimpanAlamat").prop("disabled", true);

        });


        $('#btnSimpanPerubahan').click(function(e){
            e.preventDefault();

            var txNama = $('#txNama').val();
            var txRfid = $('#txRfid').val();

            // Menghapus pesan kesalahan sebelumnya
            $('#errTxNama').text('');
            $('#errTxRfid').text('');

            if (txNama.trim() === '' || txRfid.trim() === '') {
                if (txNama.trim() === '') {
                    $('#errTxNama').text('Nama tidak boleh kosong!');
                }
                if (txRfid.trim() === '') {
                    $('#errTxRfid').text('No. RFID tidak boleh kosong!');
                }
                return;
            }

            Swal.fire({
                title: 'Apakah kamu yakin ingin menyimpan perubahan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6e7881',
                confirmButtonText: 'Ya', 
                cancelButtonText: 'Tidak',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    updateEmployee();
                }
            });

        });

        $('#btnBatalKaryawan').click(function() {

            $('#txNama').val(txNamaValueReset);
            $('#txRfid').val(txRfidValueReset);

            $("#btnSimpanPerubahan").prop("disabled", true);

            $('#errTxNama').text('');
            $('#errTxRfid').text('');


        });

        // btn batal informasi kontak dan domisili
        $('#btnBatalPribadi').click(function() {

            $('#txNoKK').val(txNokkValueReset);
            $('#SelectPendidikanTerakhir').val(txPendidikanValueReset);
            $('#SelectStatusPernikahan').val(txPernikahanValueReset);
            $('#txJurusan').val(txJurusanValueReset);
            $('#SelectAgama').val(txAgamaValueReset);
            $('#txTahunLulus').val(txTahunLulusValueReset);

            $("#btnSimpanDataPrivasi").prop("disabled", true);
            $("#txNoKK").prop("disabled", true);

        });

        $('#btnSimpanDataPrivasi').click(function(e){
            e.preventDefault();

            Swal.fire({
                title: 'Apakah kamu yakin ingin menyimpan perubahan?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6e7881',
                confirmButtonText: 'Ya', 
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    updatePrivasi();
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
    <script>
        // Untuk handle button simpan perubahan di info karyawan 
        $(document).ready(function () {
            updateSimpanPerubahanButton();

            $("#txNama, #txRfid").on("input", function () {
                updateSimpanPerubahanButton();
            });

            function updateSimpanPerubahanButton() {

                var txNamaValue = $("#txNama").val();
                var txRfidValue = $("#txRfid").val();

                var changesExist = (txNamaValue !== "{{ $listview[0]->fullname }}" || txRfidValue !== "{{ $listview[0]->rfid_no }}");

                $("#btnSimpanPerubahan").prop("disabled", !changesExist);
            }
        });

        // Untuk handle button simpan perubahan di info privasi 
        document.addEventListener('DOMContentLoaded', function () {
            function isFormChanged() {
                var formValues = {
                    txNoKK: document.getElementById('txNoKK').value,
                    pendidikan: document.getElementById('SelectPendidikanTerakhir').value,
                    statusnikah: document.getElementById('SelectStatusPernikahan').value,
                    txJurusan: document.getElementById('txJurusan').value,
                    agama: document.getElementById('SelectAgama').value,
                    txTahunLulus: document.getElementById('txTahunLulus').value
                };

                var initialFormValues = {
                    txNoKK: '{{ isset($listprivasi[0]) && $listprivasi[0]->nokk ? Crypt::decryptString($listprivasi[0]->nokk) : '' }}',
                    pendidikan: '{{ isset($listprivasi[0]) ? $listprivasi[0]->pendidikan : '-' }}',
                    statusnikah: '{{ isset($listprivasi[0]) ? $listprivasi[0]->statusnikah : '-' }}',
                    txJurusan: '{{ isset($listprivasi[0]) ? $listprivasi[0]->jurusan : '' }}',
                    agama: '{{ isset($listprivasi[0]) ? $listprivasi[0]->agama : '-' }}',
                    txTahunLulus: '{{ isset($listprivasi[0]) ? $listprivasi[0]->tahunlulus : '' }}'
                };
                
                if (!initialFormValues.txNoKK) {
                    // Handle the case where Crypt::decryptString returns null or an error
                    console.error('Error decrypting data or data is null for txNoKK');
                    // You can choose to set a default value or handle the error in another way
                    // For now, setting it to an empty string
                    initialFormValues.txNoKK = '';
                }

                for (var key in formValues) {
                    if (formValues[key] !== initialFormValues[key]) {
                        return true; 
                    }
                }

                return false;
            }

            function updateButtonState() {
                var btnSave = document.getElementById('btnSimpanDataPrivasi');
                btnSave.disabled = !isFormChanged();
            }

            updateButtonState();

            var formInputs = document.querySelectorAll('input, select');
            formInputs.forEach(function (input) {
                input.addEventListener('input', updateButtonState);
            });

        });

        // Untuk handle button simpan perubahan di info kontak dan domisili 

        
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initial form values
        function getInitialFormValues() {
            return {
                txEmail: '{{ $listview[0]->email }}',
                txNoHp: '{{ $listview[0]->no_hp }}',
                txNoHp2: '{{ $listview[0]->no_hp2 }}',
                txNoTelp: '{{ $listview[0]->home_telp }}',
                deskripsi: '{{ $dataAlamat ? $dataAlamat[0]->alamat : '' }}',
                txRt: '{{ $dataAlamat ? $dataAlamat[0]->rt : '' }}',
                txRw: '{{ $dataAlamat ? $dataAlamat[0]->rw : '' }}',
                selectKecamatan: '{{ $dataAlamat ? $dataAlamat[0]->kecamatan : '' }}',
                selectKelurahan: '{{ $dataAlamat ? $dataAlamat[0]->kelurahan : '' }}',
            };
        }

        // Function to check if the form is changed
        function isFormChanged() {
            var formInputs = document.querySelectorAll('#txEmail, #txNoHp, #txNoHp2, #txNoTelp, #deskripsi, #txRt, #txRw, #selectKecamatan, #selectKelurahan');

            for (var i = 0; i < formInputs.length; i++) {
                var input = formInputs[i];
                var inputValue = input.value;
                var initialFormValue = initialFormValues[input.id];

                if (inputValue !== initialFormValue) {
                    return true;
                }
            }

            return false;
        }

        // Function to update button state
        function updateButtonState() {
            var btnSaveAlamat = document.getElementById('btnSimpanAlamat');
            btnSaveAlamat.disabled = !isFormChanged();
        }

        // Initial button state
        var initialFormValues = getInitialFormValues();

        // Add input event listeners
        var formInputsAlamat = document.querySelectorAll('#txEmail, #txNoHp, #txNoHp2, #txNoTelp, #deskripsi, #txRt, #txRw, #selectKecamatan, #selectKelurahan');
        formInputsAlamat.forEach(function (input) {
            input.addEventListener('change', updateButtonState);
            input.addEventListener('input', updateButtonState);
        });
    });
</script>
<script>
    // DATATABLE LIST DOKUMEN

    $(document).ready(function() {
        $('#tableDokumenKaryawan').DataTable({
            searching: false,
            lengthChange: false,
            "bSort": true,
            "aaSorting": [],
            pageLength: 5,
            "lengthChange": false,
            responsive: true,
            language: { search: "" },
        });
    });

     // DATATABLE LIST PERANGKAT

     $(document).ready(function() {
        $('#tablePerangkatKaryawan').DataTable({
            searching: false,
            lengthChange: false,
            "bSort": true,
            "aaSorting": [],
            pageLength: 5,
            "lengthChange": false,
            responsive: true,
            language: { search: "" }
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#txTahunLulus", {
            dateFormat: "Y-m-d",  
            enableTime: false,
            maxDate: "today",
            enable: true,
        });
    });
</script>
<script>
    // Hidden no kk jadi bintang-bintang
    $(document).ready(function () {
        var originalValue = $('#txNoKK').val();
        var isMasked = true;

        // Inisialisasi dengan format awal
        $('#txNoKK').val(maskKK(originalValue));

        $('#txNoKK').on('input', function () {
            if (isMasked) {
                isMasked = false;
                $(this).val(originalValue);
            }
        });

        $('#btnToggleNokk').click(function () {
            if (isMasked) {
                $(this).val(maskKK(originalValue));
            } else {
                $(this).val(originalValue);
            }

            isMasked = !isMasked;
        });

        function maskKK(value) {
            var firstTwoChars = value.substring(0, 2);
            var lastTwoChars = value.substring(value.length - 2);
            
            var middleStars = '*'.repeat(value.length - 4);

            return firstTwoChars + middleStars + lastTwoChars;
        }
    });

    
    // form isi password untuk mengisi no kk
    $('#btnEditNokk').click(e => {
            e.preventDefault()

            const modalEditNokk = $('#modalEditNokk');

            modalEditNokk.modal('show'); 
    });

    $('#passwordUser').on('keyup', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#formInputRepair').submit();
            return false;

        }
    });

    $('#formInputPassword').on('submit', function(e) {
        e.preventDefault();

        const txPassword = $('#passwordUser').val();
        // const badge = '{{ $listview[0]->badge_id }}';
      
        // Menghapus pesan kesalahan sebelumnya
        $('#errpasswordUser').text('');
        $('#passwordUser').text('');

        if (txPassword.trim() === '') {
            $('#errpasswordUser').text('Password tidak boleh kosong!');
            return;
        }

        $.ajax({
            url: '{{ route('cekpassword') }}', 
            method: 'GET', 
            data: {txPassword},
            dataType: 'json',
        }).done(res => {
            if (res.status === 200) {
                // Handle success
                showMessage('success', res.messages);

                $('#txNoKK').val('{{ $nokk }}');
                $('#txNoKK').prop('disabled', false);

                $('#modalEditNokk').modal('hide'); 

            } else {
                // Handle error
                showMessage('error', res.messages);
            }
            
        });
        
    });

    $('#btnInsertPassword').click(function(e) {
        e.preventDefault();
        $('#formInputPassword').submit();
    });

    $('#modalEditNokk').on('hidden.bs.modal', function (e) {
        $('#errpasswordUser').addClass('d-none');
        $('#passwordUser').val('')
    });


    $('#formInputPasswordDokumen').on('submit', function(e) {
        e.preventDefault();

        const txPasswordDok = $('#passwordUserDok').val();
        // const badge = '{{ $listview[0]->badge_id }}';
      
        // Menghapus pesan kesalahan sebelumnya
        $('#errpasswordUserDok').text('');
        $('#passwordUserDok').text('');

        if (txPasswordDok.trim() === '') {
            $('#errpasswordUserDok').text('Password tidak boleh kosong!');
            return;
        }

        $.ajax({
            url: '{{ route('cekpassword') }}', 
            method: 'GET', 
            data: {txPasswordDok},
            dataType: 'json',
        }).done(res => {
            if (res.status === 200) {
                // Handle success
                showMessage('success', res.messages);

                $('#dokumen').replaceWith(function() {
                    return $('<a>', { id: 'dokumen', href: $(this).attr('href'), target: '_blank', rel: 'noopener noreferrer', text: $(this).text() });
                });

                $('#modalDownloadDokumen').modal('hide'); 

            } else {
                // Handle error
                showMessage('error', res.messages);
            }
            
        });
        
    });

    $('#btnInsertPasswordDok').click(function(e) {
        e.preventDefault();
        $('#formInputPasswordDokumen').submit();
    });

    $('#modalDownloadDokumen').on('hidden.bs.modal', function (e) {
        $('#errpasswordUserDok').addClass('d-none');
        $('#passwordUserDok').val('')
    });



</script>
<script>
    document.getElementById('txNama').addEventListener('input', function (event) {
        let inputValue = event.target.value;

        // Remove any digits
        inputValue = inputValue.replace(/\d/g, '');

        // Convert to uppercase
        inputValue = inputValue.toUpperCase();

        // Update the input value
        event.target.value = inputValue;
    });
</script>
<script>
    document.getElementById('txNoKK').addEventListener('input', function (event) {
        let inputValue = event.target.value;

        // Remove any non-numeric characters
        inputValue = inputValue.replace(/\D/g, '');

        // Update the input value
        event.target.value = inputValue;
    });
</script>
<script>
    // form isi password untuk melihat dan mendownload dokumen karyawan
    $('#btnDownloadDokumen').click(e => {
            e.preventDefault()

            const modalDownloadDokumen = $('#modalDownloadDokumen');

            modalDownloadDokumen.modal('show'); 
    });
</script>
<script>
    // // Script untuk menyimpan status tab aktif
    // $(document).ready(function () {
    //     $('.nav-link').on('click', function () {
    //         var tabId = $(this).attr('id');
    //         localStorage.setItem('activeTab', tabId);
    //     });

    //     // Saat halaman dimuat, periksa apakah ada tab yang aktif yang disimpan di localStorage
    //     var activeTab = localStorage.getItem('activeTab');
    //     if (activeTab) {
    //         $('#' + activeTab).tab('show');
    //     }
    // });

</script>


@endsection
