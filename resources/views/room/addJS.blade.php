<script>

    // open modal Add
    const btnAdd = $('#btnAdd');
    const modalFormAddRoom = $('#modalAddRoom');

    btnAdd.click(e => {
        e.preventDefault();
        modalFormAddRoom.modal('show');
    });

        // select floor
        // $('#addSelectFloor').select2({
        //     theme: "bootstrap-5",
        //     dropdownParent: $('#modalAddRoom'),
        //     allowClear: true
        // });

        // apabila file image di klik pada modal add
        $('#addImage1').on('change', function(e){
            const fileInput   = $('#addImage1')[0];
            const maxFileSize = 10240 * 10240 ;
            if(fileInput.files.length > 0){
                const fileSize = fileInput.files[0].size;
                if(fileSize >= maxFileSize){
                    showMessage('warning', 'Image size cannot be more than 10 MB');
                    $('#addImage1').val('')
                }
            } 
        })

        // apabila file image di klik pada modal add
        $('#addImage2').on('change', function(e){
            const fileInput   = $('#addImage2')[0];
            const maxFileSize = 10240 * 10240 ;
            if(fileInput.files.length > 0){
                const fileSize = fileInput.files[0].size;
                if(fileSize >= maxFileSize){
                    showMessage('warning', 'Image size cannot be more than 10 MB');
                    $('#addImage2').val('')
                }
            } 
        })

        // apabila file image di klik pada modal add
        $('#addImage3').on('change', function(e){
            const fileInput   = $('#addImage3')[0];
            const maxFileSize = 10240 * 10240 ;
            if(fileInput.files.length > 0){
                const fileSize = fileInput.files[0].size;
                if(fileSize >= maxFileSize){
                    showMessage('warning', 'Image size cannot be more than 10 MB');
                    $('#addImage3').val('')
                }
            } 
        })

        // Script untuk validasi form dan reset data pada modal Add Room

                // ketika form submit diklik
                $('#formAddRoom').on('submit', function(e) {
                    e.preventDefault();

                    // validasi modal add tidak boleh kosong
                    // $('#btnTambah').prepend(iconLoad);
                    // return;

                    const formData = new FormData($('#formAddRoom')[0]);
                    
                    const room_name = $('#addRoomName').val();
                    const floor = $('#addSelectFloor').val();
                    const capacity = $('#addCapacityRoom').val();
                    
                    const imgName1 = $('#addImage1').val();
                    const imgName2 = $('#addImage2').val();
                    const imgName3 = $('#addImage3').val();


                    if (room_name == '' || room_name == null) {
                        $('#err-RoomName').removeClass('d-none');
                    } else {
                        $('#err-RoomName').addClass('d-none');
                    }

                    if (floor == '' || floor == null) {
                        $('#err-SelectFloor').removeClass('d-none');
                    } else {
                        $('#err-SelectFloor').addClass('d-none');
                    }

                    if (capacity == '' || capacity == null) {
                        $('#err-Capacity').removeClass('d-none');
                    } else {
                        $('#err-Capacity').addClass('d-none');
                    }

                    if (imgName1 == '' || imgName1 == null) {
                        $('#err-RoomImage1').removeClass('d-none');
                    } else {
                        $('#err-RoomImage1').addClass('d-none');
                    }

                    if (imgName2 == '' || imgName2 == null) {
                        $('#err-RoomImage2').removeClass('d-none');
                    } else {
                        $('#err-RoomImage2').addClass('d-none');
                    }

                    if (imgName3 == '' || imgName3 == null) {
                        $('#err-RoomImage3').removeClass('d-none');
                    } else {
                        $('#err-RoomImage3').addClass('d-none');
                    }

                    if (

                        room_name != '' &&
                        floor != '' &&
                        capacity != '' &&
                        imgName1 != '' &&
                        imgName2 != '' &&
                        imgName3 != '' 
                    ) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });

                        $.ajax({
                                url: '{{ route('/Room/insert') }}',
                                method: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false, 

                                beforeSend: () => {
                                    $('#spinnerAdd').removeClass('d-none')
                                    $('#btnTambah').prop('disabled', true);
                                    $('#btnTambah').prepend(iconLoad);
                                }
                            })
                            .done(res => {
                                $('#btnTambah').prop('disabled', false);
                                $('#btnTambah').empty()
                                $('#btnTambah').text('Add Room')
                                if(res.MSGTYPE === "W"){
                                    showMessage('warning', res.MSG)
                                    $('#spinnerAdd').addClass('d-none')
                                    $('#btnTambah').prop('disabled', false);
                                    $('#btnTambah').show()
                                    return;
                                }

                                $('#spinnerAdd').addClass('d-none')
                                $('#btnTambah').show()
                                showMessage('success', "Data was successfully added!")
                                $('#modalAddRoom').modal('hide');
                                $(this)[0].reset();

                                $('#addRoomName').val('')
                                $('#addSelectFloor').val('')
                                $('#addCapacityRoom').val('')



                                getListRoom();

                            })
                            .fail(err => {
                                showMessage('error', 'Sorry! we failed to insert data')
                                $('#spinnerAdd').addClass('d-none')
                                $('#btnTambah').prop('disabled', false);
                                $('#btnTambah').show();
                            });
                    }


                });

                // reset data modal add saat di close
                $('#btnAdd').on('click', function(e) {
                    const modalAddRoom = $('#modalAddRoom')
                    modalAddRoom.modal('show')
                    $('#err-RoomName').addClass('d-none');
                    $('#err-SelectFloor').addClass('d-none');
                    $('#err-Capacity').addClass('d-none');
                    $('#err-RoomImage1').addClass('d-none');
                    $('#err-RoomImage2').addClass('d-none');
                    $('#err-RoomImage3').addClass('d-none');


                    $('#addRoomName').val('')
                    $('#addSelectFloor').val('').trigger('change')
                    $('#addCapacityRoom').val('')
                    $('#addImage1').val('')
                    $('#addImage2').val('')
                    $('#addImage3').val('')
                   
                })


</script>