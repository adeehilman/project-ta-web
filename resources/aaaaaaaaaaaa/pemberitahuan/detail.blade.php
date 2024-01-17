@extends('layouts.app')
@section('title', 'Informasi Pemberitahuan')

@section('content')
<div class="wrappers">
  <div class="wrapper_content">
    <div class="modal fade" data-bs-backdrop="static" id="modalRepairData" tabindex="-1">
      <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 40%;">
          <div class="modal-content">
              <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pemberitahuan</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form id="formInputRepair" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                      <div class="row mb-3" style="font-size: 12px;">
                          <div class="col-sm-6">
                              <p>Judul</p>

                            {{-- {{ dd($dataStatusBaca) }} --}}


                              {{-- <input type="text" value="{{ $dataPemberitahuan->judul }}" class="form-control" style="font-size: 12px;"
                                  placeholder="Masukkan Judul" required name="judul" id="judul"> --}}
                          </div>
                          <div class="col-sm-6">
                              <p>Deskripsi</p>
                              {{-- <input type="text" value="{{ $pemberitahuan->deskripsi }}" class="form-control" style="font-size: 12px; height: 80px;"
                                  placeholder="Masukkan Deskripsi" required name="deskripsi" id="deskripsi"> --}}
                          </div>
                      </div>
                      <div class="row mb-3" style="font-size: 12px;">
                          <div class="col-sm-6">
                              <p>Penerima</p>
                              <select class="form-select" id="penerima" name="penerima"
                                  style="font-size: 12px;">
                                  <option value="">Ketik atau Pilih Penerima Grup PKB</option>
                                  {{-- @foreach ($pemberitahuan->grup_karyawan as $grupKaryawan)
                                      <option value="{{ $grupKaryawan->id_grup }}" {{ $pemberitahuan->receive_by == $grupKaryawan->id_grup ? 'selected' : '' }}>{{ $grupKaryawan->nama_grup }}</option>
                                  @endforeach --}}
                              </select>
                          </div>
                          <div class="col-sm-6">
                              <p>Upload Gambar(PNG/JPG)</p>
                              <input type="file" class="form-control-file" style="font-size: 12px;"
                              name="gambar" id="gambar">
                          </div>
                      </div>
                      <div class="row mb-3" style="font-size: 12px;">
                          <div class="col-sm-6">
                              <input type="checkbox" id="isSentNow" name="is_sent_now">
                              <label for="is_sent_now">Posting Sekarang</label>
                          </div>
                          <div class="col-sm-6">
                              {{-- <input type="checkbox" id="isSentPublic" name="is_sent_public" 
                              {{ $pemberitahuan->is_sent_public ? 'checked' : '' }} > --}}
                              <label for="is_sent_public">Post Pemberitahuan untuk Publik</label>
                          </div>
                      </div>
                      <div class="row mb-3" style="font-size: 12px;">
                        <div class="col-sm-6 " id="waktu_pemberitahuan_container">
                          <label for="waktu_pemberitahuan">Waktu Pemberitahuan</label>
                          {{-- <input type="date" value="{{ date('Y-m-d', strtotime($pemberitahuan->waktu_pemberitahuan)) }}" class="form-control" id="waktu_pemberitahuan" name="waktu_pemberitahuan"> --}}
                        </div>
                        <div class="col-sm-6 " id="jam_pemberitahuan_container">
                          <label for="jam_pemberitahuan" >Jam Pemberitahuan</label>
                          {{-- <input type="time" value="{{ date('H:i', strtotime($pemberitahuan->waktu_pemberitahuan)) }}" class="form-control" id="jam_pemberitahuan" name="jam_pemberitahuan"> --}}
                        </div>
                      </div>
                      <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                  </form>
  
              </div>
              <div class="modal-footer d-flex flex-nowrap justify-content-end">
                  <button type="button" class="btn btn-link d-inline-block" data-bs-dismiss="modal" style="text-decoration: none; font-size: 12px; width: 105px; height: 30px;">Batal</button>
                  <button type="button" style="font-size: 12px; width: 190px; height: 30px;" id="btnSubmitUpdate" class="btn btn-primary d-inline-block">Simpan Perubahan</button>
                </div>
          </div>
      </div>
    </div>

    {{-- <div class="row me-3">
      <div class="col-sm-12">
          <p class="h4 mt-6">
            Informasi Pemberitahuan
          </p>
      </div>

    </div>

    <div class="row mb-3">
      <div class="col-sm-6 border">

      </div>
      <div class="col-sm-6 border">
      </div>
    </div> --}}
    <div class="row mb-3">
      <div class="col-sm-12">
        <h3>Informasi Pemberitahuan</h3>
      <a class="btn" href="/pemberitahuan" role="button" class="text-start">< Kembali ke Pemberitahuan</a>
      </div>
      
    </div>
   

    <div class="row mb-3">
      <div class="col-sm-6">

        <div class="card" style="height: auto; min-height: 582px;">
          <div class="card-title">
            <h5 class="p-3">Informasi Pemberitahuan</h5>
          </div>
          <div class="card-body">

            <div class="row mb-3 text-center">
              <div class="col-sm-12">
                <img class="img-fluid imgView" src="{{ asset('img') . '/' . $dataPemberitahuan[0]->image }}" class="img-fluid" style="max-width: 300px">
              </div>
            </div>

            <div class="row mb-0" style="font-size: 12px;">
              <div class="col-sm-6">
                <span>Judul</span>
              </div>
              <div class="col-sm-6">
                <span>{{ $dataPemberitahuan[0]->judul }}</span>
              </div>
            </div>

            <div class="row mb-0" style="font-size: 12px;">
              <div class="col-sm-6">
                <span>Penerima</span>
              </div>
              <div class="col-sm-6">
                <span>{{ $dataPemberitahuan[0]->receive_by  }}</span>
              </div>
            </div>

            <div class="row mb-0" style="font-size: 12px;">
              <div class="col-sm-6">
                <span>Waktu Pemberitahuan</span>
              </div>
              <div class="col-sm-6">
                <span>{{ date('d M y', strtotime($dataPemberitahuan[0]->waktu_pemberitahuan)) }}</span>
              </div>
            </div>

            <div class="row mb-0" style="font-size: 12px;">
              <div class="col-sm-6">
                <span>Dibuat Oleh</span>
              </div>
              <div class="col-sm-6">
                <span>{{ $dataPemberitahuan[0]->sent_by }}</span>
              </div>
            </div>

            <div class="row mb-0" style="font-size: 12px;">
              <div class="col-sm-6">
                <span>Diperbaharui Oleh</span>
              </div>
              <div class="col-sm-6">
                <span>{{ $dataPemberitahuan[0]->updateby }}</span>
              </div>
            </div>

            <div class="row mb-0" style="font-size: 12px;">
              <div class="col-sm-6">
                <span>Status</span>
              </div>
              <div class="col-sm-6">
                <span>{!! $dataPemberitahuan[0]->is_sent == '1' ? '<i class="bx bxs-check-circle text-success"></i> Sudah diumumkan' : '<i class="bx bxs-check-circle text-secondary"></i> Belum diumumkan' !!}</span>
              </div>
            </div>

            <div class="row mb-0" style="font-size: 12px;">
              <div class="col-sm-6">
                <span>Deskripsi</span>
              </div>
              <div class="col-sm-12">
                @php $statusLength = false;
                @endphp 
                @if (strlen($dataPemberitahuan[0]->deskripsi) > 700)
                @php $statusLength = true;
                @endphp 
                @endif
                <span id="containerDeskripsi">{!! substr($dataPemberitahuan[0]->deskripsi, 0, 700) !!} {!! $statusLength == true ? '... <span id="viewMore" class="text-danger fw-bold" style="cursor: pointer;">Lihat detail</span>' : '' !!}</span>
              </div>
            </div>


          </div>
        </div>

      </div>

      {{-- table --}}
      <div class="col-sm-6">

        <div class="card" style="height: auto; min-height: 582px;">
          <div class="card-body">

            <h5 class="mb-3">Jumlah Karyawan Yang Membaca : {{ $jumlahPembaca }}</h5>

            <div class="row-mb-3">
              <table id="tablePenerima" class="table table-responsive table-hover">
                <thead>
                    <tr style="color: #CD202E; height: -10px;" class="table-danger">
                        <th class="p-3 text-start" scope="col">Nama Lengkap Karyawan</th>
                        <th class="p-3 text-start" scope="col">Terkirim</th>
                        <th class="p-3 text-start" scope="col">Dibaca</th>
                    </tr>
                </thead>
                <tbody>
                  @foreach ($dataStatusBaca as $row)
                <tr>
                  <td style="text-align: left !important;">{{ $row->fullname }}</td>
                  <td>
                    <i class="bx bxs-check-circle text-success"></i>
                  </td>
                  <td>
                    {!! $row->status == 'DIBACA' ? '<i class="bx bxs-check-circle text-success"></i>' : '<i class="bx bxs-check-circle text-secondary"></i>' !!}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
            </div>

          </div>
        </div>

      </div>
    </div>



    {{-- <h3>Informasi Pemberitahuan</h3>
    <a class="btn" href="/pemberitahuan" role="button">< Kembali ke Pemberitahuan</a> --}}

    {{-- grid with 2 columns --}}
    {{-- <div class="container text-center mt-2"> --}}
      {{-- <div class="row">
        <div class="col p-3 border border-secondary rounded me-3" style="max-width: 600px">
          <h5 class="text-start">Informasi Pemberitahuan</h5>
          <img class="img-fluid imgView" src="{{ asset('img') . '/' . $dataPemberitahuan[0]->image }}" class="img-fluid" style="max-width: 300px">

          <table class="mt-4">
            <tr>
              <td class="text-start text-secondary" >Judul</td>
              <td class="text-start ps-4" width="50%">{{ $dataPemberitahuan[0]->judul }}</td>
            </tr> --}}
            {{-- <tr>
              <td class="text-start text-secondary" >Sub Judul</td>
              <td class="text-start ps-4"> {{ $dataPemberitahuan->sub_judul  }}</td>
            </tr> --}}
            {{-- <tr>
              <td class="text-start text-secondary" >Penerima</td>
              <td class="text-start ps-4"> {{ $dataPemberitahuan[0]->receive_by  }}</td>
            </tr>
            <tr>
              <td class="text-start text-secondary" >Waktu Pemberitahuan</td>
              <td class="text-start ps-4">{{ date('d M y', strtotime($dataPemberitahuan[0]->waktu_pemberitahuan)) }}</td>
            </tr>
            <tr>
              <td class="text-start text-secondary" >Dibuat Oleh</td>
              <td class="text-start ps-4"> {{ $dataPemberitahuan[0]->sent_by }}</td>
            </tr>
            <tr>
              <td class="text-start text-secondary" >Diperbaharui Oleh</td>
              <td class="text-start ps-4">{{ $dataPemberitahuan[0]->updateby }}</td>
            </tr>
            <tr>
              <td class="text-start text-secondary" >Status</td>
              <td class="text-start ps-4">{!! $dataPemberitahuan[0]->is_sent == '1' ? '<i class="bx bxs-check-circle text-success"></i> Sudah diumumkan' : '<i class="bx bxs-check-circle text-secondary"></i> Belum diumumkan' !!}</td> --}}
              {{-- <td class="text-start ps-4">{{ $dataStatusTerkirim}}</td> --}}
            {{-- </tr>
            <tr>
              <td class="text-start text-secondary" >Deskripsi</td> --}}
              {{-- <td class="text-start" >{{ $dataPemberitahuan[0]->deskripsi }}</td> --}}
            {{-- </tr>
            <tr>
            </tr>
          </table>
          <div class="row" style="font-size: 12px;">
            <div class="col-sm-12 text-wrap">
              <p style="word-wrap: break-word;overflow-wrap: break-word;">
                {!! substr($dataPemberitahuan[0]->deskripsi, 0, 400) !!}
              </p>
            </div>
          </div> --}}
          {{-- <p class="text-wrap"></p> --}}

          {{-- <div class="container p-0 mt-4 d-flex justify-content-start">
            <button class="btn border me-2 align-items-baseline" id="btnModal">
              <img src={{ asset('img/edit.png') }} style="vertical-align:middle;"></img>
                Edit Pemberitahuan
              </button>
            <button class="btn border">
              <img src={{ asset('img/trash.png') }}></img>
              Hapus</button>
          </div> --}}
        {{-- </div>
        <div class="col p-3 border border-secondary rounded">
          <h5 class="text-start">Penerima</h5>
          <table id="tablePenerima" class="table table-responsive table-hover">
            <thead>
                <tr style="color: #CD202E; height: -10px;" class="table-danger">
                    <th class="p-3 text-start" scope="col">Nama Lengkap Karyawan</th>
                    <th class="p-3 text-start" scope="col">Terkirim</th>
                    <th class="p-3 text-start" scope="col">Dibaca</th>
                </tr>
            </thead>
            <tbody> --}}
              {{-- @foreach ($pemberitahuan->semuaPenerima as $penerima)
                <tr>
                  <td>{{ $penerima->receiver->fullname }}</td>
                  <td>
                    <img src="{{ $penerima->is_sent ? asset('img/checklist.png') : asset('img/vector.png')}}">
                    </img>
                  </td>
                  <td>
                    <img src="{{ $penerima->is_sent ? asset('img/checklist.png') : asset('img/vector.png')}}">
                  </img>
                  </td>
                </tr>
              @endforeach --}}
              {{-- @foreach ($dataStatusBaca as $row)
                <tr>
                  <td style="text-align: left !important;">{{ $row->fullname }}</td>
                  <td>
                    <i class="bx bxs-check-circle text-success"></i>
                  </td>
                  <td>
                    {!! $row->status == 'DIBACA' ? '<i class="bx bxs-check-circle text-success"></i>' : '<i class="bx bxs-check-circle text-secondary"></i>' !!}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div> --}}
    {{-- </div> --}}
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
    const btnModal = $('#btnModal');
    const modalForm = $('#modalRepairData');
    const btnSubmitUpdate = $('#btnSubmitUpdate');
    const deskripsi = $('#deskripsi');
    const penerima = $('#penerima');
    const token = $('#_token');
    const judul = $('#judul');
    const isSentNow = $('#isSentNow');
    const isSentPublic   = $('#isSentPublic');
    const waktuPemberitahuan   = $('#waktu_pemberitahuan');
    const jamPemberitahuan   = $('#jam_pemberitahuan');
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

   

    btnModal.on('click', function(e) {
      e.preventDefault();
      modalForm.modal('show');

    });

    isSentNow.on('click', function() {
      $('#waktu_pemberitahuan_container').toggleClass('d-none');
      $('#jam_pemberitahuan_container').toggleClass('d-none');
    });

    btnSubmitUpdate.on('click', function(e) {
      e.preventDefault();

      const input = $('input[type="file"]')[0];
    const file = input.files[0];

    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const image = e.target.result;
        }
        reader.readAsDataURL(file);
    }

      const formData = new FormData();
      formData.append('_method', 'PUT');
      formData.append('image', file);
      formData.append('_token', token.val());
      formData.append('judul', judul.val());
      formData.append('deskripsi', deskripsi.val());
      formData.append('penerima', penerima.val());
      formData.append('isSentPublic', isSentPublic.is(':checked'));
      formData.append('isSentNow', isSentNow.is(':checked'));
      formData.append('waktu_pemberitahuan', waktuPemberitahuan.val() );
      formData.append('jam_pemberitahuan', jamPemberitahuan.val() );


      // const datas = {
      //   _token: token.val(),
      //   judul: judul.val(),
      //   deskripsi: deskripsi.val(),
      //   penerima: penerima.val(),
      //   isSentPublic: isSentPublic.is(':checked'),
      //   isSentNow: isSentNow.is(':checked'),
      //   waktu_pemberitahuan: waktuPemberitahuan.val(),
      //   jam_pemberitahuan: jamPemberitahuan.val(),
      // }

      $.ajax({
        url: `/pemberitahuan/${pemberitahuan.id}`, 
        data: formData, 
        method: 'POST', 
        dataType: 'json', 
        contentType: false,
      processData: false,
        headers: {
          'X-CSRF-TOKEN': csrfToken,
      },
        beforeSend: () => {

        }, 
        success: res => {
          console.log(res);
              location.reload();
              // const newNotification = res.data;
              // const newTableRow = `
              // <tr style="color: gray;" class="table-row" data-id="${newNotification.id}">
              //     <td class="p-3">${newNotification.judul }</td>
              //     <td class="p-3">${newNotification.pengirim.fullname}</td>
              //     <td class="p-3">${newNotification.penerima.nama_grup}</td>
              //     <td class="p-3">${newNotification.waktu_pemberitahuan}</td>
              //     <td class="p-3">${newNotification.file_upload }</td>
              //     <td class="p-3">
              //         <img src="{{ asset('img/checklist.png') }}">
              //             Sudah Diumumkan
              //         </a>
              //     </td>
              // </tr>
              // `;

              // tabelPemberitahuan.append(newTableRow);
        },
        error: res => {
          const errorText = $('.errorText').remove();
          if (res.status === 422) {
              displayError(res.responseJSON.messages, judul, 'judul');
              displayError(res.responseJSON.messages, deskripsi, 'deskripsi');
              displayError(res.responseJSON.messages, penerima, 'penerima');

              // console.log(res);
          }
        }
      })
    });


    $('#tablePenerima').DataTable();


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


    $('body').on('click', '#viewMore', function(e){
      e.preventDefault();

      $('#containerDeskripsi').html(`{!! $dataPemberitahuan[0]->deskripsi !!} ... <span id="hideMore" style="cursor: pointer;" class="fw-bold text-danger">Lebih sedikit</span> `)

      // console.log('working');
    })

    $('body').on('click', '#hideMore', function(e){
      e.preventDefault();
      // console.log(('lebih sedikit'));
      $('#containerDeskripsi').html(`{!! substr($dataPemberitahuan[0]->deskripsi, 0, 700) !!} ... <span id="viewMore" class="text-danger fw-bold" style="cursor: pointer;">Lihat detail</span>`);
    })

  </script>
@endsection