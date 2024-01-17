@extends('layouts.app')
@section('title', 'Pemberitahuan')

@section('content')

<div class="wrappers">
    <div class="wrapper_content">

 <!-- modified modal Filter -->
 {{-- <div class="modal fade" data-bs-backdrop="static" id="modalRepairData" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered" style="width: 50%;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Filter Pencarian Pemberitahuan</h1>
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
                            <p>Status</p>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radioRejectCategory"
                                    id="radioFunction" value="29">
                                <label class="form-check-label" for="radioFunction">Sudah Diumumkan</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="radioRejectCategory"
                                    id="radioVisual" value="30">
                                <label class="form-check-label" for="radioVisual">Belum Diumumkan</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3" style="font-size: 12px; display: flex; flex-direction: row;">
                        <div class="col-sm-12">
                            <p>Rentang Terakhir</p>
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
                    style="text-decoration: none; font-size: 12px; width: 300px; height: 30px;">Batal</button>
                <button type="button" style="font-size: 12px; width: 330px; height: 30px;"
                    id="btnSubmitRepair" class="btn btn-primary">Tampilkan Hasil</button>
            </div>

        </div>
    </div>
</div>
<!-- end modal Filter -->  --}}

 <!-- modified modal Buat -->
 <div class="modal fade" data-bs-backdrop="static" id="modalInput" tabindex="-1" id="modalPemberitahuan">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Pemberitahuan Baru</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formInput" method="POST">
                    @csrf
                    <div class="row mb-3" style="font-size: 12px;">
                        <div class="col-sm-6">
                            <p>Judul</p>
                            <input type="text" class="form-control" placeholder="Masukkan Judul" name="txJudul" id="txJudul">
                            <span id="errJudul" class="text-danger"></span>
                        </div>
                        <div class="col-sm-6">
                            <p>Deskripsi</p>
                            {{-- <textarea name="txDeskripsi" id="txDeskripsi" rows="3" class="form-control"></textarea> --}}
                            <textarea id="txDeskripsi" name="txDeskripsi"></textarea>
                            <span id="errDeskripsi" class="text-danger"></span>
                        </div>
                    </div>

                    <div class="row mb-3" style="font-size: 12px;">
                        <div class="col-sm-6">
                            <p>Penerima</p>
                            <select class="form-select" id="selectGroup" name="selectGroup">
                            </select>
                            <span id="errGroup" class="text-danger"></span>
                        </div>
                        <div class="col-sm-6">
                            <p>Upload Gambar(PNG/JPG)</p>
                            <input type="file" class="form-control-file" name="gambar" id="gambar">
                            <span id="errImage" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <input type="checkbox" id="is_sent_now" name="is_sent_now" checked>
                            <label for="is_sent_now">Posting Sekarang</label>
                        </div>
                       
                        {{-- <div class="col-sm-6">
                            <input type="checkbox" id="is_sent_public" name="is_sent_public" checked>
                            <label for="is_sent_public">Post Pemberitahuan untuk Publik</label>
                        </div> --}}
                    </div>
                    <div class="row mb-3" style="font-size: 12px;">
                        <div class="col-sm-6" id="waktu_pemberitahuan_container">
                          <label for="waktu_pemberitahuan">Waktu Pemberitahuan</label>
                          <input type="text"  class="form-control dateWaktu" id="waktu_pemberitahuan" name="waktu_pemberitahuan">
                          <span id="errwaktu_pemberitahuan" class="text-danger"></span>
                        </div>
                        <div class="col-sm-6" id="jam_pemberitahuan_container">
                          <label for="jam_pemberitahuan">Jam Pemberitahuan</label>
                          <input type="text"  class="form-control jamWaktu" id="jam_pemberitahuan" name="jam_pemberitahuan">
                          <span id="errjam_pemberitahuan" class="text-danger"></span>
                        </div>
                      </div>

                      <div class="modal-footer">
                        <input type="hidden" id="pemberitahuanID" name="pemberitahuanID">
                        <button type="button" class="btn btn-link d-inline-block" data-bs-dismiss="modal" style="text-decoration: none;">Batal</button>
                        <button type="submit" id="btnSubmit" class="btn btn-primary d-inline-block">Simpan</button>
                    </div>

                </form>

            </div>
            
        </div>
    </div>
</div>
<!-- end modal Buat -->

        <div class="row me-3">
            <div class="col-sm-6">
                <p class="h4 mt-6">
                    Pemberitahuan
                </p>
            </div>
            <div class="col-sm-12 mt-2 d-flex justify-content-between">
                <div class="d-flex gap-1">
                    <input id="txSearch" type="text" style="width: 200px; min-width: 200px; font-size: 12px; padding-left: 30px; 
                    background-image: url('{{ asset('img/search.png') }}'); background-repeat: no-repeat; 
                    background-position: left center;" class="form-control rounded-3" placeholder="Cari Pemberitahuan">
                    {{-- <button id="" style="font-size: 12px;" type="button" class="btn btn-outline-danger rounded-3">
                        <i class='bx bx-slider p-1'></i>
                        Filter
                    </button>  --}}
                </div>       
                <div class="d-flex gap-1">
                    <button id="btnModalRepair" class="btn btn-danger rounded-3" type="button" style="font-size: 12px;">
                        <i class="bi bi-plus-circle-fill me-1"></i>
                        Tambah Pemberitahuan
                    </button>
                </div>
            </div>
            
            <div class="text-end col-sm-9 d-flex mt-2 mb-2 rounded-3">
                <span style="font-size: 12px;" id="textJumlahTampilan">
                     {{-- Menampilkan {{count($pemberitahuan)}} dari total {{$pemberitahuan->total()}} Pemberitahuan  --}}
                </span>
            </div>

            <div id="containerTablePemberitahuan" class="col-sm-12 mt-1">
                <table id="tablePemberitahuan" class="table table-responsive table-hover">
                    <thead>
                        <tr style="color: #CD202E; height: -10px;" class="table-danger">
                            <th class="p-3" scope="col">Judul</th>
                            <th class="p-3" scope="col">Penerima</th>
                            <th class="p-3" scope="col">Pengirim</th>
                            <th class="p-3" scope="col">Waktu Pemberitahuan</th>
                            <th class="p-3" scope="col">Gambar</th>
                            <th class="p-3" scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($pemberitahuan as $data)
                            <tr style="color: gray;" class="table-row" data-id={{ $data->id }}>
                                <td class="p-3">{{ $data->judul }}</td>
                                <td class="p-3">{{ $data->pengirim->fullname }}</td>
                                <td class="p-3">{{ $data->penerima->nama_grup }}</td>
                                <td class="p-3">{{ date('d M Y',strtotime($data->waktu_pemberitahuan)) }}</td>
                                <td class="p-3">{{ $data->penerima->file_upload }}</td>
                                <td class="p-3">
                                <img src="{{ asset('img/checklist.png') }}">
                                    Sudah Diumumkan
                                </a>
                                </td>
                            </tr>
                        @endforeach --}}

                    </tbody>

                </table>


            </div>

            {{-- {{ $pemberitahuan->links() }} --}}
        </div>
    </div>

@endsection

@section('script')

<script>
  const btnModal = $('#btnModalRepair');
  const modalForm = $('#modalInput');
  const selectCustomer = $('#selectCustomer');
  const selectModelCustomer = $('#selectModelCustomer');
  const btnSubmitRepair = $('#btnSubmitRepair');
  const tabelPemberitahuan = $('#tabelPemberitahuan');
  const textJumlahTampilan = $('#textJumlahTampilan');
  const tableRow = $('.table-row');
  const deskripsi = $('#deskripsi');
  const penerima = $('#penerima');
  const token = $('#_token');
  const judul = $('#judul');
  const isSentPublic   = $('input[name="is_sent_public"]');
  const isSentNow   = $('input[name="is_sent_now"]');
  const waktuPemberitahuan   = $('#waktu_pemberitahuan');
  const jamPemberitahuan   = $('#jam_pemberitahuan');
  const csrfToken = $('meta[name="csrf-token"]').attr('content');
  const pageBody = $('body');
  const loaderIcon = `<i class='bx bx-loader bx-spin align-middle me-2'></i>`;


  const tanggal = flatpickr(".dateWaktu", {
                                dateFormat: "d-m-Y",
                                defaultDate: "today",
                            });

const jam = flatpickr(".jamWaktu", {
    enableTime: true, 
    noCalendar: true, 
    defaultDate: `${new Date().getHours()}:${new Date().getMinutes()}`,
    dateFormat: "H:i", 
    time_24hr: true,
});


                            
    
    

  function displayError(errors, dom, errorProp) {
    const error = errors[errorProp]?.map(message => `<span class="text-danger p-2 errorText">${message}</span>`).join('');

    if (error) {
        dom.after(`${error}`);
    }
  }

  tableRow.on('click', function() {
    let id = $(this).data('id');
    window.location = `/pemberitahuan/${id}`
  });

$('#waktu_pemberitahuan_container').hide();
$('#jam_pemberitahuan_container').hide();

  isSentNow.on('click', function() {
    $('#waktu_pemberitahuan_container').toggle();
    $('#jam_pemberitahuan_container').toggle();
  });



    // $(document).ready(function() {
    //     $.ajax({
    //         url: '/api/pemberitahuan/list', // replace with your API endpoint
    //         type: 'GET',
    //         dataType: 'json',
    //         success: function(response) {
    //             // handle successful response
    //             const {total, data} = response.data;

    //             // update text total tampilan
    //             textJumlahTampilan.text(`Menampilkan ${data.length} dari ${total} Pemberitahuan`);

    //             // update isi tabel
    //             const {}
    //             const newRow = data.map(notification => {
    //             return `
    //             <tr style="color: gray;">
    //                 <td class="p-3">${data.judul}</td>
    //                 <td class="p-3">${data.penerima}</td>
    //                 <td class="p-3">HR General Affair</td>
    //                 <td class="p-3">27 Maret 2023</td>
    //                 <td class="p-3">Gambar.png</td>
    //                 <td class="p-3">
    //                     <img src="{{ asset('img/checklist.png') }}">
    //                     Sudah Diumumkan
    //                     </a>
    //                 </td>
    //             </tr>
    //             `
    //             })   
    //         },
    //         error: function(xhr, status, error) {
    //         // handle error response
    //         console.log(xhr.responseText);
    //         }
    //     });
    // });

  btnModal.click(e => {
    e.preventDefault();

    const roles = '{{ session()->get('loggedInUser')['session_roles'] }}'

    if(parseInt(roles) === 64 || parseInt(roles) === 63){
        modalForm.modal('show');
    }else{
        showMessage('error', 'Kamu tidak punya akses')
    }

  });


//   handle edit
pageBody.on('click', '.btnEdit', function(e) {
    const dataId = $(this).data('id');

    if(dataId){

        $.ajax({
            url: '{{ route('getpemberitahuanbyid') }}',
            method: 'GET', 
            data: {dataId},
            dataType: 'json',
        }).done(res => {
            console.log(res);

            if(res.status !== 200){
                return;
            }

            $('#btnSubmit').text('Update Perubahan')
            $('#txJudul').val(res.data.judul)
            // $('#txJudul').val(res.data.judul)
            $('#txDeskripsi').summernote('code', res.data.deskripsi);
            $('#selectGroup').val(res.data.receive_by)
            $('#is_sent_now').click();
            $('#pemberitahuanID').val(res.data.id);

            $('#waktu_pemberitahuan').val(`${new Date(res.data.waktu_pemberitahuan).getDate()}-${new Date(res.data.waktu_pemberitahuan).getMonth()+1}-${new Date(res.data.waktu_pemberitahuan).getFullYear()}`)
            $('#jam_pemberitahuan').val(`${new Date(res.data.waktu_pemberitahuan).getHours().toString().padStart(2, '0')}:${new Date(res.data.waktu_pemberitahuan).getMinutes().toString().padStart(2, '0')}`)

            if(parseInt(res.data.is_sent) === 1){
                $('#is_sent_now').prop('disabled', true)
                $('#waktu_pemberitahuan').prop('disabled', true)
                $('#jam_pemberitahuan').prop('disabled', true)
                $('#selectGroup').prop('disabled', true)
            }else{
                $('#is_sent_now').prop('disabled', false)
                $('#waktu_pemberitahuan').prop('disabled', false)
                $('#jam_pemberitahuan').prop('disabled', false)
                $('#selectGroup').prop('disabled', false)
            }
            
            // return;

            // if(res.data.waktu_pemberitahuan !== null){
            // }

            modalForm.modal('show');

        })

        // modalForm.modal('show');
    }
})


$('#modalInput').on('hidden.bs.modal', function (event) {

    // if(!$('#is_sent_now').is('checked')) {
    //     $('#is_sent_now').click();
    //     $('#is_sent_now').prop('checked', true)
    // }

    // if(!$('#is_sent_now').is('disabled')) {
    //     $('#is_sent_now').prop('disabled', false);
    // }

    if($('#is_sent_now').is(':checked') === false) $('#is_sent_now').click();
    $('#waktu_pemberitahuan_container').hide();
    $('#jam_pemberitahuan_container').hide();

    if($('#selectGroup').is(':disabled') === true) $('#selectGroup').prop('disabled', false);

    $('#is_sent_now').prop('disabled', false);
    $('#is_sent_now').prop('checked', true);


    // console.log($('#is_sent_now').is(':checked') === false);

    $('#waktu_pemberitahuan').prop('disabled', false)
    $('#jam_pemberitahuan').prop('disabled', false)
    $('#txDeskripsi').summernote('code', '');
    $('#txJudul').val('');
    $('#selectGroup').val("1")
    $('#btnSubmit').text('Simpan')
    // $('#btnViewInformasiPerangkat').click()
});







  // select model


//   btnSubmitRepair.click(function(e) {
//     e.preventDefault();

//     const input = $('input[type="file"]')[0];
//     const file = input.files[0];

//     if (file) {
//         const reader = new FileReader();
//         reader.onload = function(e) {
//             const image = e.target.result;
//         }
//         reader.readAsDataURL(file);
//     }


//       const formData = new FormData();
//       formData.append('image', file);
//       formData.append('_token', token.val());
//       formData.append('judul', judul.val());
//       formData.append('deskripsi', deskripsi.val());
//       formData.append('penerima', penerima.val());
//       formData.append('isSentPublic', isSentPublic.is(':checked'));
//       formData.append('isSentNow', isSentNow.is(':checked'));
//       formData.append('waktu_pemberitahuan', waktuPemberitahuan.val() );
//       formData.append('jam_pemberitahuan', jamPemberitahuan.val() );

        

//       $.ajax({
//       url: '/pemberitahuan', 
//       data: formData, 
//       method: 'POST', 
//       dataType: 'json', 
//       contentType: false,
//       processData: false,
//       headers: {
//         'X-CSRF-TOKEN': csrfToken,
        
//     },
//       beforeSend: () => {

//       }, 
//       success: res => {
//             location.reload();
//             // const newNotification = res.data;
//             // const newTableRow = `
//             // <tr style="color: gray;" class="table-row" data-id="${newNotification.id}">
//             //     <td class="p-3">${newNotification.judul }</td>
//             //     <td class="p-3">${newNotification.pengirim.fullname}</td>
//             //     <td class="p-3">${newNotification.penerima.nama_grup}</td>
//             //     <td class="p-3">${newNotification.waktu_pemberitahuan}</td>
//             //     <td class="p-3">${newNotification.file_upload }</td>
//             //     <td class="p-3">
//             //         <img src="{{ asset('img/checklist.png') }}">
//             //             Sudah Diumumkan
//             //         </a>
//             //     </td>
//             // </tr>
//             // `;

//             // tabelPemberitahuan.append(newTableRow);
//       },
//       error: res => {
//         const errorText = $('.errorText').remove();
//         if (res.status === 422) {
//             displayError(res.responseJSON.messages, judul, 'judul');
//             displayError(res.responseJSON.messages, deskripsi, 'deskripsi');
//             displayError(res.responseJSON.messages, penerima, 'penerima');

//             // console.log(res);
//         }
//       }
//     })


//   });


  const getGroupList = () => {
    let html = '';
    $.ajax({
        url: '{{ route('grouplist') }}', 
        method: 'GET', 
        dataType: 'json',
    }).done(res => {
        // console.log(res);

        if(res.status === 200){
            $.each(res.data, (i, v) => {
                html += `<option value="${v.id}">${v.nama_grup}</option>`;
            })
        }

        if($('#selectGroup').children().lenght > 0){
            $('#selectGroup').children().remove()
        }

        $('#selectGroup').html(html);
    })
  }

  getGroupList();



    $('#formInput').on('submit', function(e){
        e.preventDefault();

        const judul = $('#txJudul').val()
        const deskripsi = $('#txDeskripsi').val()
        const input = $('#gambar').val();
        const btnText = $('#btnSubmit').text();

        if(!judul){
            $('#errJudul').text('Judul tidak boleh kosong');
            return;
        }else{
            $('#errJudul').text('');
        }

        if(!deskripsi){
            $('#errDeskripsi').text('Deskripsi tidak boleh kosong');
            return;
        }else{
            $('#errDeskripsi').text('');
        }

        if(btnText === "Simpan"){
            if(!input){
                Swal.fire({
                    title: 'Apakah anda yakin tidak melampirkan gambar?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6e7881',
                    confirmButtonText: 'Lanjutkan Posting', 
                    cancelButtonText: 'Upload gambar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route('simpanpemberitahuan') }}', 
                            method: 'POST', 
                            data: new FormData(this), 
                            cache: false,
                            processData: false,
                            contentType: false, 
                            dataType: 'json', 
                            beforeSend: function(){
                                $('#btnSubmit').prepend(loaderIcon)
                                $('#btnSubmit').prop('disabled', true)
                                $('#btnSubmit').text('Please wait')         
                            }
                        }).done(res => {
                            $('#btnSubmit').remove()
                            $('#btnSubmit').prop('disabled', false)
                            $('#btnSubmit').text('Simpan')

                            if(res.status === 200){
                                showMessage('success', res.message);
                                $(this)[0].reset();
                                $('#txDeskripsi').summernote('code', '');
                                getPemberitahuanList();
                                modalForm.modal('hide');
                            }

                        })
                    }else{
                        return
                    }
                })
            }else{

                $.ajax({
                    url: '{{ route('simpanpemberitahuan') }}', 
                    method: 'POST', 
                    data: new FormData(this), 
                    cache: false,
                    processData: false,
                    contentType: false, 
                    dataType: 'json',
                }).done(res => {
                    if(res.status === 200){
                        showMessage('success', res.message);
                        $(this)[0].reset();
                        $('#txDeskripsi').summernote('code', '');
                        getPemberitahuanList();
                        modalForm.modal('hide');
                    }

                })

            }
        }


        if(btnText === "Update Perubahan"){

            $.ajax({
                url: '{{ route('updatepemberitahuan') }}', 
                method: 'POST', 
                data: new FormData(this), 
                cache: false,
                processData: false,
                contentType: false, 
                dataType: 'json',
            }).done(res => {

                if(res.status !== 200){
                    showMessage('error', res.message);
                    return;
                }

           
                showMessage('success', res.message);
                $(this)[0].reset();
                $('#txDeskripsi').summernote('code', '');
                $('#btnSubmit').text('Simpan')
                getPemberitahuanList();
                modalForm.modal('hide');
            

            })
        }

        

        


        



        // return;


        


        // console.log(input);
        // return;

        // if($('#is_sent_now').is(':checked'))

        // if($('#is_sent_now').is(':checked') === false){

        // }

 
        // return;


        
    })


    // $('#btnSubmit').click(function(e){
    //     e.preventDefault()

    //     console.log('e');
    // })

    // handle pemberitahuan list
    const getPemberitahuanList = () => {

        const txSearch = $('#txSearch').val();

        let html = '';
        $.ajax({
            url: '{{ route('pemberitahuanlist') }}', 
            method: 'GET', 
            data: {txSearch},
        }).done(res => {
            // console.log(res);

            if($('#containerTablePemberitahuan').children().lenght > 0){
                $('#containerTablePemberitahuan').children().remove();
            }

            $('#containerTablePemberitahuan').html(res)

            $('#tablePemberitahuan').DataTable({
                searching: false,
                lengthChange: false,
                "bSort": false,
            });
        })
    }

    getPemberitahuanList();


    $('#txSearch').keyup(()=>{
        getPemberitahuanList();
    })


     // summernote init
     $(document).ready(function(){
                $('#txDeskripsi').summernote({
                    placeholder: 'Tuliskan deskripi pekerjaan',
                    tabsize: 2,
                    height: 120,
                    toolbar: [
                        ['font', ['bold', 'italic', 'underline']],
                        ['para', ['ul', 'ol']],
                    ]
                });
            });




</script>

@endsection