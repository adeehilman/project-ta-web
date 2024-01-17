@extends('layouts.app')
@section('title', 'LPB')

@section('content')

    <div class="wrappers">
        <div class="wrapper_content">
            <!-- modal Filter-->
            <div class="modal fade" data-bs-backdrop="static" id="modalView" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered" style="width: 50%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Informasi Perangkat Bermasalah</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {{-- <form id="formInputRepair"> --}}
                                {{-- <div class="row row-cols-1 row-cols-md-2 g-4">
                                    <div class="col-sm-6">
                                        <div class="card p-2">
                                        <p class="fw-bold">New Satnusa</p>
                                        <div class="clickable-text mb-2" onclick="toggleRadioCheck(this)">
                                            <div class="fw-bold">Apple</div>
                                            <div style="color: #60625D; margin-bottom: 5px;">Iphone 13 Plus</div>
                                            <div style="color: #60625D; margin-bottom: 5px;">UUID123049501</div>
                                            <div style="color: #60625D; margin-bottom: 5px;">123456789012345</div>
                                            <div style="color: #60625D; margin-bottom: 5px;">123456789012345</div>
                                        </div>
                                        <div class="clickable-text" onclick="toggleRadioCheck(this)">
                                            <div class="fw-bold">Apple</div>
                                            <div style="color: #60625D; margin-bottom: 5px;">Redmi Note 7</div>
                                            <div style="color: #60625D; margin-bottom: 5px;">UUID123049501</div>
                                            <div style="color: #60625D; margin-bottom: 5px;">123456789012345</div>
                                            <div style="color: #60625D; margin-bottom: 5px;">123456789012345</div>
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-sm-6">
                                    <div class="card p-2">
                                        <p class="fw-bold">Old satnusa</p>
                                        <div class="form-check hidden" id="radioOption1">
                                            <input class="form-check-input" type="radio" name="radioRejectCategory" id="radioFunction" value="29">
                                            <label class="form-check-label" for="radioFunction">
                                                Iphone 13 Plus<br/>
                                                UUID123049506<br/>
                                                123456789012345<br/>
                                                -</label>
                                        </div>
                                        <div class="form-check hidden" id="radioOption2">
                                            <input class="form-check-input" type="radio" name="radioRejectCategory" id="radioVisual" value="30">
                                            <label class="form-check-label" for="radioVisual">
                                                Redmi Note 7<br/>
                                                UUID123049506<br/>
                                                123456789012345<br/>
                                                123456789012345</label>
                                        </div>
                                        <div class="form-check hidden" id="radioOption3">
                                            <input class="form-check-input" type="radio" name="radioRejectCategory" id="radioVisual" value="30">
                                            <label class="form-check-label" for="radioVisual">
                                                Samsung Galaxy Note 7<br/>
                                                UUID123049506<br/>
                                                123456789012345<br/>
                                                -</label>
                                        </div>
                                        <div class="form-check hidden" id="radioOption4">
                                            <input class="form-check-input" type="radio" name="radioRejectCategory" id="radioVisual" value="30">
                                            <label class="form-check-label" for="radioVisual">
                                                Itel P40<br/>
                                                UUID123049506<br/>
                                                123456789012345<br/>
                                                123456789012345</label>
                                        </div>
                                    </div>
                                </div> --}}
                                    
                                {{-- </div> --}}

                            {{-- </form> --}}

                                <div class="row mb-3">
                                    <div class="col-sm-6">
                                        <p>New Mysatnusa</p>
                                        <div class="card" style="font-size: 12px; min-height:400px;">
                                            <div id="containerListNew" class="card-body">

                                                {{-- <div class="row mb-1 mx-2" style="min-height: 110px;">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="col-sm-12 mb-0">
                                                                <div class="form-check">
                                                                    <input class="form-check-input border-danger" type="radio" name="rdNew">
                                                                    <label class="form-check-label" for="">
                                                                      Tipe: A3 <br>
                                                                      Merek: Samsung <br>
                                                                      New uuid: dw89dhaw-dwauhdu-daw
                                                                    </label>
                                                                  </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-1 mx-2" style="min-height: 110px;">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="col-sm-12 mb-0">
                                                                <div class="form-check">
                                                                    <input class="form-check-input border-danger" type="radio" name="rdNew">
                                                                    <label class="form-check-label" for="">
                                                                      Tipe: A3 <br>
                                                                      Merek: Samsung <br>
                                                                      New uuid: dw89dhaw-dwauhdu-daw
                                                                    </label>
                                                                  </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-1 mx-2" style="min-height: 110px;">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="col-sm-12 mb-0">
                                                                <div class="form-check">
                                                                    <input class="form-check-input border-danger" type="radio" name="rdNew">
                                                                    <label class="form-check-label" for="">
                                                                      Tipe: A3 <br>
                                                                      Merek: Samsung <br>
                                                                      New uuid: dw89dhaw-dwauhdu-daw
                                                                    </label>
                                                                  </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-1 mx-2" style="min-height: 110px;">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="col-sm-12 mb-0">
                                                                <div class="form-check">
                                                                    <input class="form-check-input border-danger" type="radio" name="rdNew">
                                                                    <label class="form-check-label" for="">
                                                                      Tipe: A3 <br>
                                                                      Merek: Samsung <br>
                                                                      New uuid: dw89dhaw-dwauhdu-daw
                                                                    </label>
                                                                  </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-1 mx-2" style="min-height: 110px;">
                                                    <div class="card">
                                                        <div class="card-body">
                                                            <div class="col-sm-12 mb-0">
                                                                <div class="form-check">
                                                                    <input class="form-check-input border-danger" type="radio" name="rdNew">
                                                                    <label class="form-check-label" for="">
                                                                      Tipe: A3 <br>
                                                                      Merek: Samsung <br>
                                                                      New uuid: dw89dhaw-dwauhdu-daw
                                                                    </label>
                                                                  </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <p>Old Mysatnusa</p>
                                        <div class="card" style="font-size: 12px; min-height:400px;">
                                            <div id="containerListOld" class="card-body">

                                                {{-- <div class="row mb-1 mx-2" style="min-height: 110px;">
                                                    <div class="card">
                                                        <div class="card-body">

                                                            <div class="col-sm-12 mb-0">
                                                                <div class="form-check">
                                                                    <input class="form-check-input border-danger" type="radio" name="rdOld">
                                                                    <label class="form-check-label" for="">
                                                                        Tipe: A3 <br>
                                                                        Merek: Samsung <br>
                                                                        New uuid: dw89dhaw-dwauhdu-daw <br>
                                                                        Imei: 1029381207897
                                                                    </label>
                                                                  </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-1 mx-2" style="min-height: 110px;">
                                                    <div class="card">
                                                        <div class="card-body">

                                                            <div class="col-sm-12 mb-0">
                                                                <div class="form-check">
                                                                    <input class="form-check-input border-danger" type="radio" name="rdOld">
                                                                    <label class="form-check-label" for="">
                                                                        Tipe: A3 <br>
                                                                        Merek: Samsung <br>
                                                                        New uuid: dw89dhaw-dwauhdu-daw <br>
                                                                        Imei: 1029381207897
                                                                    </label>
                                                                  </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-1 mx-2" style="min-height: 110px;">
                                                    <div class="card">
                                                        <div class="card-body">

                                                            <div class="col-sm-12 mb-0">
                                                                <div class="form-check">
                                                                    <input class="form-check-input border-danger" type="radio" name="rdOld">
                                                                    <label class="form-check-label" for="">
                                                                        Tipe: A3 <br>
                                                                        Merek: Samsung <br>
                                                                        New uuid: dw89dhaw-dwauhdu-daw <br>
                                                                        Imei: 1029381207897
                                                                    </label>
                                                                  </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-1 mx-2" style="min-height: 110px;">
                                                    <div class="card">
                                                        <div class="card-body">

                                                            <div class="col-sm-12 mb-0">
                                                                <div class="form-check">
                                                                    <input class="form-check-input border-danger" type="radio" name="rdOld">
                                                                    <label class="form-check-label" for="">
                                                                        Tipe: A3 <br>
                                                                        Merek: Samsung <br>
                                                                        New uuid: dw89dhaw-dwauhdu-daw <br>
                                                                        Imei: 1029381207897
                                                                    </label>
                                                                  </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-1 mx-2" style="min-height: 110px;">
                                                    <div class="card">
                                                        <div class="card-body">

                                                            <div class="col-sm-12 mb-0">
                                                                <div class="form-check">
                                                                    <input class="form-check-input border-danger" type="radio" name="rdOld">
                                                                    <label class="form-check-label" for="">
                                                                        Tipe: A3 <br>
                                                                        Merek: Samsung <br>
                                                                        New uuid: dw89dhaw-dwauhdu-daw <br>
                                                                        Imei: 1029381207897
                                                                    </label>
                                                                  </div>
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
                            <input type="hidden" id="badgeId"> 
                            <button type="button" id="btnKonfirm" class="btn btn-primary">Konfirmasi Perangkat</button>

                        </div>

                    </div>
                </div>
            </div>
            <!-- end modal Filter-->
            <div class="row me-3">
                <div class="col-sm-6">
                    <p class="h4 mt-6">
                        List Perangkat Bermasalah
                    </p>
                </div>
                <div class="row mb-1 mt-3">
                    <div class="col-sm-12 d-flex gap-1">
                        <input id="txSearch" type="text" style="width: 250px; min-width: 250px;"
                            class="form-control rounded-3" placeholder="Search here">
            
                    </div>
                </div>

                <div id="containerListPB" class="col-sm-12 mt-1">
              
                </div>
            </div>
        </div>

    @endsection

    @section('script')
        <script>
            const btnfilter = $('#btnView');
            const modalFormFilter = $('#modalView');
            const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
              <div class="spinner-border d-flex justify-content-center align-items-center text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
            </div>`;
            const loaderIcon = `<i class='bx bx-loader bx-spin align-middle me-2'></i>`
            const pageBody = $('body');

            btnfilter.click(e => {
                e.preventDefault();
                modalFormFilter.modal('show');

            });
    
            function toggleColor(element) {
            var textItems = element.getElementsByClassName("text-item");
            for (var i = 0; i < textItems.length; i++) {
                textItems[i].classList.toggle("clicked");
            }
        }

            function toggleRadioCheck(element) {
            element.classList.toggle("clicked");

            if (element.classList.contains("clicked")) {
                document.getElementById("radioOption1").classList.remove("hidden");
                document.getElementById("radioOption2").classList.remove("hidden");
                document.getElementById("radioOption3").classList.remove("hidden");
                document.getElementById("radioOption4").classList.remove("hidden");
            } else {
                document.getElementById("radioOption1").classList.add("hidden");
                document.getElementById("radioOption2").classList.add("hidden");
                document.getElementById("radioOption3").classList.add("hidden");
                document.getElementById("radioOption4").classList.add("hidden");
            }
        }

        


            const litPerangkatBermasalah = () => {
                const txSearch = $('#txSearch').val();
                $.ajax({
                    url:'{{route('listpb')}}',
                    method: 'get', 
                    data: {txSearch},
                    beforeSend: function(){
                        $('#containerListPB').html(loadSpin)
                    }
                }).done(res=>{
                    $('#containerListPB').html(res);
                    $('#tableListPB').DataTable({
                        searching: false,
                        lengthChange: false,
                        "bSort": false,
                    });
                })
            }

            litPerangkatBermasalah();

            $('#txSearch').keyup(()=>{
                litPerangkatBermasalah()
            })


            const listDetailPerangkat = (badge) => {
                $.ajax({
                            url: '{{ route('getlistpbbybadge') }}', 
                            data: {badge},
                            method: 'get', 
                            beforeSend: function(){
                                $('#containerListNew').html(loadSpin);
                                $('#containerListOld').html(loadSpin);
                            }
                        }).done(res => {
                            console.log(res);
                            let html = '';
                            let htmlOld = '';

                            if(res.status === 200){

                                $('#badgeId').val(badge);

                                if(res.data.length > 0){

                                    $.each(res.data, (i, v) => {


                                        html += 
                                        `
                                        <div class="row mb-1 mx-2" style="min-height: 110px;">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="col-sm-12 mb-0">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input border-danger" type="radio" name="rdNew" value="${v.id}" id="${v.id}" data-uuid="${v.uuid_new}">
                                                                        <label class="form-check-label" for="${v.id}">
                                                                        Tipe: ${v.tipe_hp} <br>
                                                                        Merek: ${v.merek_hp} <br>
                                                                        New uuid: ${v.uuid_new}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                        `;

                                    })
                                    
                                }else{
                                    html += '<p>Tidak ada data</p>';
                                }

                                $('#containerListNew').children().remove();
                                $('#containerListNew').html(html);

                                if(res.dataOld.length > 0){
                                // old
                                $.each(res.dataOld, (i, v) => {


                                    htmlOld += 
                                    `
                                    <div class="row mb-1 mx-2" style="min-height: 110px;">
                                                    <div class="card">
                                                        <div class="card-body">

                                                            <div class="col-sm-12 mb-0">
                                                                <div class="form-check">
                                                                    <input class="form-check-input border-danger" type="radio" id="${v.id}" name="rdOld" value="${v.id}" data-uuid="${v.uuid}>
                                                                    <label class="form-check-label" for="${v.id}">
                                                                        Tipe: ${v.tipe_hp} <br>
                                                                        Merek: ${v.merek_hp} <br>
                                                                        Old uuid: ${v.uuid} <br>
                                                                        Imei: ${v.imei1}
                                                                    </label>
                                                                  </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                    `;

                                })
                                
                            }else{
                                htmlOld += '<p>Tidak ada data</p>';
                            }

                            $('#containerListOld').children().remove();
                            $('#containerListOld').html(htmlOld);

                            }else{
                                html += '<p>Tidak ada data</p>';
                                htmlOld += '<p>Tidak ada data</p>';
                                $('#containerListNew').children().remove();
                                $('#containerListNew').html(html);
                                $('#containerListOld').children().remove();
                                $('#containerListOld').html(htmlOld);
                            }



                            
                        })
            }

            pageBody.on('click', '.btnView', function(e){
                e.preventDefault()

                const badge = $(this).data('id');

                // console.log(badge);

                const roles = '{{ session()->get('loggedInUser')['session_roles'] }}'

                if(parseInt(roles) === 64 || parseInt(roles) === 63){

                    if(badge){

                        listDetailPerangkat(badge);

                        $('#modalView').modal('show');
                    }
                }else{
                    showMessage('error', 'Kamu tidak punya akses')
                }

                
            })


            // konfirmasi perangkat
            $('#btnKonfirm').click(function(e){

                const badge = $('#badgeId').val();
                
                // return;
                // console.log(badge);
                // return;

                const idNew = $('input[name="rdNew"]:checked').val();
                const newUuid = $('input[name="rdNew"]:checked').data('uuid');
                const idOld = $('input[name="rdOld"]:checked').val();
                const oldUuid = $('input[name="rdOld"]:checked').data('uuid');

                if(!idNew){
                    showMessage('error', 'Data New Mysatnusa belum ditentukan')
                    return
                }
                if(!idOld){
                    showMessage('error', 'Data Old Mysatnusa belum ditentukan')
                    return
                }

                $.ajax({
                    url: '{{ route('updatepb') }}',
                    method: 'post', 
                    data: {
                        _token: '{{ csrf_token() }}',
                        idNew, 
                        newUuid,
                        idOld,
                        oldUuid, 
                        badge
                    }
                }).done(res=>{

                    if(res.status === 200){
                        showMessage('success', res.message);
                        listDetailPerangkat(badge);
                    }
                    // console.log(res);
                })

                listDetailPerangkat(badge);
            })


            $('#modalView').on('hidden.bs.modal', function () {
                litPerangkatBermasalah();
            })

        </script>

    @endsection
