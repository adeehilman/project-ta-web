@extends('layouts.app')
@section('title', 'Detail Pengkinian Data Process')

@section('content')
<style>
  .accordion-button:not(.collapsed) {
    background-color: #f8d7da;
    color: black;
  }

</style>



    <div class="wrappers">
        <div class="wrapper_content">

            
            <!-- modal close -->
            <div class="modal fade" data-bs-backdrop="static" id="modalCloseTicketTolak" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalAddTitle">Alasan Menolak</h1>
                            <button type="button" id="btnClosed" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <form id="formClose">
                            <div class="modal-body" style="font-size: 15px;">
                                <div class="row mb-3 mt-3">
                                    <div class="col-sm-12">
                                        <label>Alasan</label>
                                        <div>
                                            <textarea class="mt-2" id="reasoncloseticketTolak" name="reasoncloseticketTolak" style="border-radius: 10px; height: 100px; width: 770px; border-color: #ccc; padding: 20px"></textarea>
                                        </div>
                                        <div id="err-reasoncloseticketTolak" class="text-danger d-none">
                                            Kolom Alasan Tidak Boleh Kosong
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-dismiss="modal" style="text-decoration: none;">Cancel</button>
                            <button type="submit" id="btnSubmitReject" class="btn btn-primary">Tolak</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end modal close -->


            <!-- modal close -->
            <div class="modal fade" data-bs-backdrop="static" id="modalCloseTicketSetuju" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5 fw-bold" id="modalAddTitle">Alasan Menerima</h1>
                            <button type="button" id="btnClosed" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <form id="formClose">
                            <div class="modal-body" style="font-size: 15px;">
                                <div class="row mb-3 mt-3">
                                    <div class="col-sm-12">
                                        <label>Alasan</label>
                                        <div>
                                            <textarea class="mt-2" id="reasoncloseticketSetuju" name="reasoncloseticketSetuju" style="border-radius: 10px; height: 100px; width: 770px; border-color: #ccc; padding: 20px"></textarea>
                                        </div>
                                        <div id="err-reasoncloseticketSetuju" class="text-danger d-none">
                                            Kolom Alasan Tidak Boleh Kosong
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-dismiss="modal" style="text-decoration: none;">Cancel</button>
                            <button type="submit" id="btnSubmitApprove" class="btn btn-primary">Terima</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end modal close -->
        

            <div class="row me-1">
                <div class="col-sm-6">
                    <a href="#" onclick="redirectToPreviousWindow(); return false;" style="text-decoration: none">
                        <span class="text-black back"><i class="bx bx-chevron-left"></i> Back </span>
                    </a>
                    
                </div>

                <div class="col-sm-12 d-flex justify-content-between">
                   
                        <span class="h3 mt-3 fw-bold">
                            Detail Pengkinian Data 
                        </span>
                    
                    <div class="mt-3 gap-1">
                        <button style="font-size: 15px; color:red;" type="button"
                            class="btn rounded-3 btnReject">
                            Tolak
                        </button>
                        <button style="font-size: 15px;" type="button"
                            class="btn btn-danger rounded-3 btnApprove">
                            Terima
                        </button>
                    </div>
                </div>
                

                <div class="row mb-3 mt-3">
                    <div class="col-sm-12">
                       
                    <div class="row mb-3">
                        <div class="col-xl-6 col-md-6">
                            <div class="card shadow border-0">
                                <div class="card-body">
                                    <div class="tabsMenu">
                                        <input type="radio" class="hidden" id="multitabs1" name="mtabs" checked>
                                        <input type="radio" class="hidden" id="multitabs2" name="mtabs">
                                        <div class="tabsHead fw-bold">
                                            <label for="multitabs1" class="active" id="tab1"
                                                style="cursor: pointer">Info</label>
                                            <label for="multitabs2" class="tabs" id="tab3"
                                                style="cursor: pointer">Tanggapan</label>
                                        </div>
                                        <div class="tabsContent">
                                            <div class="tabsContent1">
                                                <div>
                                                    <div class="d-sm-flex gap-3">
                                                        <table class="ms-2" style="font-size: 15px; line-height: 2;">
                                                            <tr>
                                                                <td style="width: 200px; color: gray;">Kategori</td>
                                                                <td style="color: black;" id="detailkategori" ></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:  200px; color: gray;">Karyawan</td>
                                                                <td style="color: black;" id="detailnamajabatan"></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="accordion mt-4" id="accordionExample">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingOne">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                                    <span style="font-size: 14px;">Perbandingan Data Sebelumnya dan Data Sekarang</span>
                                                                </button>
                                                            </h2>
                                                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="max-height: 400px;">
                                                            <div class="accordion-body">
                                                                <div class="table-responsive">
                                                                <table id="tablePersonalList" class="table table-responsive table-hover" style="font-size: 13px">
                                                                    <thead>
                                                                        <tr style="color: #CD202E; height: 10px;" class="table-danger ">
                                                                            <th class="p-2" scope="col">Kategori</th>
                                                                            <th class="p-2" scope="col">Tipe Data</th>
                                                                            <th class="p-2" scope="col">Data Lama</th>
                                                                            <th class="p-2" scope="col">Data Baru</th>
                                                                            <th class="p-2" scope="col">Dokumen</th>
                                                                            <!-- <th class="p-2" scope="col">Action</th> -->
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($infotable as $item)
                                                                            <tr>
                                                                                <td class="p-2">{{$item->Kategori}}</td>
                                                                                <td class="p-2">{{$item->Detail}}</td>
                                                                                <td class="p-2">
                                                                                    @if ($item->Detail == 'No. KK')
                                                                                        @if ($item->fullname)
                                                                                            @php
                                                                                                try {
                                                                                                    echo @Crypt::decryptString($item->fullname);
                                                                                                } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                                                                                                    echo '<span class="text-danger">Error decrypting fullname</span>';
                                                                                                }
                                                                                            @endphp
                                                                                        @else
                                                                                            <span class="text-danger">Error decrypting fullname</span>
                                                                                        @endif
                                                                                    @else
                                                                                        {{$item->fullname}}
                                                                                    @endif
                                                                                </td>
                                                                                <td class="p-2">
                                                                                    @if ($item->Detail == 'No. KK')
                                                                                        @if ($item->newdata)
                                                                                            @php
                                                                                                try {
                                                                                                    echo @Crypt::decryptString($item->newdata);
                                                                                                } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                                                                                                    echo '<span class="text-danger">Error decrypting newdata</span>';
                                                                                                }
                                                                                            @endphp
                                                                                        @else
                                                                                            <span class="text-danger">Error decrypting newdata</span>
                                                                                        @endif
                                                                                    @else
                                                                                        {{$item->newdata}}
                                                                                    @endif
                                                                                </td>
                                                                                <td class="p-2">
                                                                                    @if ($item->dok_nama)
                                                                                        @php
                                                                                            try {
                                                                                                echo @Crypt::decryptString($item->dok_nama);
                                                                                            } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                                                                                                echo '<span class="text-danger">Error decrypting data</span>';
                                                                                            }
                                                                                        @endphp
                                                                                    @endif
                                                                                </td>
                                                                                <!-- <td>
                                                                                    <a class="btn btnDetail" data-id="2" data-bs-toggle="modal"> <img src="{{ asset('icons/Eye.svg') }}"></a>
                                                                                </td> -->
                                                                            </tr>
                                                                        @endforeach                                                                  
                                                                    </tbody>
                                                                    
                                                                    
                                                                </table>
                                                                </div>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="tabsContent2">
                                                <div>
                                                    <div class="mb-1">
                                                        <div class="me-2">
                                                            <textarea class="form-control" style="height: 200px;" id="txDeskripsi" name="txDeskripsi"></textarea>
                                                        </div>
                                                        <button class="btn btn-sm btn-danger mt-3 fw text-center float-end" id="btnKirimTanggapan">Tambah Tanggapan</button>
                                                        </br>
                                                        </br>
                                                        <p class="fw-bold mt-5">Riwayat Tanggapan</p>
                                                        <div class="mt-3" id="containerTanggapan" style="max-height: 268px; overflow-y: scroll; overflow-x: hidden;">
                                                          
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="card shadow border-0">
                                <div class="card-body">
                                    <div class="d-flex flex-wrap align-items-center mb-2">
                                        <h5 class="fw-bold me-2">Riwayat Status</h5>
                                    </div>
                                    <hr>
                                    <div class="col-xl-12" style="height: 620px; overflow-x: hidden; overflow-y: auto;">

                                    {{-- Card Riwayat --}}
                                    <div class="tabsContent3" style="height:460px">
                                        <div class="row mb-1">
                                            <div class="row mx-2 my-2 d-flex">
                                                <div id="containerRiwayatClock" class="col-sm-3">
                                                    @foreach ($dataRiwayat as $item)
                                                        <div class="mb-2" style="height: 60px; width: auto; overflow-y: auto; overflow-x: hidden;">
                                                            <p class="fw-bold mb-2">{{ $item->date }}</p>
                                                            <span class="text-muted">{{ $item->time }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                        
                                                <div id="containerRiwayatStatus" class="col-sm-9">
                                                    <ul class="">
                                                        @foreach ($dataRiwayat as $item)
                                                            <li class="step step--done pb-3" style="height: 68px;">
                                                                <div class="d-flex align-items-center mb-4">
                                                                    <div class="step__circle">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="25" height="25" viewBox="0 0 25 25" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                                            <path d="M5 12l5 5l10 -10"></path>
                                                                        </svg>
                                                                    </div>
                                                                    <div class="ms-2">
                                                                        <div class="step__title text-dark">{{ $item->status ? $item->status : '-' }}</div>
                                                                        @if ($item->status == 'Ditolak' && $item->alasan)
                                                                            <p class="text-secondary">{{ $item->alasan }}</p>
                                                                        @elseif ($item->status == 'Selesai' && $item->alasan)
                                                                            <p class="text-secondary">{{ $item->alasan }}</p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    

                           
                    </div>      
                    

                           
                 </div>
                 </div>
                    
                    
                 </div> 
                    
                    
                </div>
            </div>
               
                </div>

            </div>
        </div>
    </div>

@endsection

@section('script')
@include('updateEmpData.dataProcess.modalProcess_JS')

<script>
    
    
    function redirectToPreviousWindow() {
    window.history.back();
    }


    var detailpengkinian = @json($detailpengkinian);
    var userInfo = @json($userInfo);

    let adminbadge = userInfo.badge_id;

    console.log(adminbadge);

    let namakaryawan = detailpengkinian.namakaryawan;
    let badgeid = detailpengkinian.badgeid;
    let deptcode = detailpengkinian.deptcode;
    let positioncode = detailpengkinian.positioncode;
    let kategori = detailpengkinian.kategori;
    let statusid = detailpengkinian.id_status;

    $('#detailkategori').text(kategori);
    $('#detailnamajabatan').text(namakaryawan + ' (' + badgeid + '), ' + deptcode + '-' + positioncode);

 
var currentUrl = window.location.href;
var path = currentUrl.split('?')[0];
var idParam = path.split('/').pop();

const getlistTanggapan = () => {
    var id = idParam;

    $.ajax({
        type: 'GET',
        url: '/dataProcess/detail/' + id,
        dataType: 'json',
        success: function (response) {
            // Handle the response data here
            console.log(response);
            $("#containerTanggapan").empty();

            // Assuming 'response' is an array of items
            response.forEach(function (item) {
                var card = $('<div class="card border border-1 mb-3"></div>');
                var cardBody = $('<div class="card-body"></div>');
                var row1 = $('<div class="row mb-3"></div>');
                var col1 = $('<div class="col-sm-6"></div>');
                var img = $('<img class="rounded-circle" src=" '+ item.photo +' " width="50" height="50">');
                var span1 = $('<span class="ms-3 fw-bold">' + item.fullname + '</span>');
                var col2 = $('<div class="col-sm-6 text-end"></div>');
                var span2 = $('<span style="font-size: 12px">' + item.date + ' ' + item.time + '</span>');
                var row2 = $('<div class="row"></div>');
                var col3 = $('<div class="col-sm-12">' + item.respon + '</div>');

                col1.append(img).append(span1);
                col2.append(span2);
                row1.append(col1).append(col2);
                row2.append(col3);
                cardBody.append(row1).append(row2);
                card.append(cardBody);

                // Append the created card to a container on your page
                $('#containerTanggapan').append(card);
            });
        },
        error: function (error) {
            console.log('Error:', error);
        }
    });
};

getlistTanggapan();

    // HANDLE SHOW BUTTON MENGGUNAKAN ID PER CARD
    $(document).ready(function () {
    const detailId = statusid;

    console.log('ini detail id :', detailId);

    function toggleButtons(detailId) {
        $('.btnReject, .btnApprove').hide();

        if (detailId === 1) { 
            $('.btnReject, .btnApprove').show();
        }
    }

    toggleButtons(detailId);
});

</script>

<script>
    //summernote init
    $(document).ready(function() {
    // $('#txDeskripsi').summernote({
           // placeholder: 'Tulis Tanggapan',
            //tabsize: 2,
           // height: 120,
           // toolbar: [
           //     ['font', ['bold', 'italic', 'underline']],
             //   ['para', ['ul', 'ol']],
          //  ]
       // }); 

        $('#btnKirimTanggapan').click(function() {
            const btntanggapan = $('#btnKirimTanggapan');
            var tanggapan = $('#txDeskripsi').val();
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            var currentUrl = window.location.href;
            var path = currentUrl.split('?')[0];
            var idParam = path.split('/').pop();
  

            console.log(idParam)

            let userinfo = @json($userInfo);
            var badgeid = userinfo.badge_id;

            if (tanggapan.trim() !== '') {
               $.ajax({
                    type: "POST",
                    url: "{{ route('tambahtanggapan') }}",
                    data: {
                        id: idParam,
                        badgeid: badgeid,
                        tanggapan: tanggapan,
                        _token: csrfToken
                    },
                    dataType: "json",
                    beforeSend: function () {
                        btntanggapan.prop('disabled', true); 
                    },
                    success: function (response) {
                        showMessage('success', 'Tanggapan Berhasil Ditambahkan.');
                        btntanggapan.prop('disabled', false);
                        $('#txDeskripsi').val('');
                        getlistTanggapan();
                    },
                    error: function (error) {
                        console.error(error); 
                    }
                });
                
            } else {
                showMessage('error','Tanggapan tidak boleh kosong.');
            }
        });

    });
</script>



@endsection
