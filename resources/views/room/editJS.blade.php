<script>
    // open modal Edit
    $(document).on('click', '.btnEdit', function(e) {
        e.preventDefault();

        var RoomId = $(this).data('id');
        const modalFormEdit = $('#modalEditRoom');

        modalFormEdit.modal('show');

        // Ajax request
        $.ajax({
            url: "{{ route('/Room/edit') }}",
            method: "GET",
            data: {
                RoomId: RoomId
            },
            beforeSend: () => {

            },
            success: function(response) {
                const dataRoom = response.dataRoomId;

                // console.log(dataRoom.dept);
                $("#editRoomName").val(dataRoom.room_name);
                $("#editSelectFloor").val(dataRoom.floor).trigger('change.select2');
                $("#selectDeptEdit").val(dataRoom.dept).trigger('change');
                $("#editCapacityRoom").val(dataRoom.capacity);
                // $("#editImage1").text(dataRoom.roomimage_1);
                // $("#editImage2").val(dataRoom.roomimage_2);
                // $("#editImage3").val(dataRoom.roomimage_3);

                $(".image1trigger").val(dataRoom.roomimage_1)
                $(".image2trigger").val(dataRoom.roomimage_2)
                $(".image3trigger").val(dataRoom.roomimage_3)

                $('#editId').val(RoomId)




            },
            error: function(err) {

            }
        });
    });

    // saat submit form edit untuk update data
    $('#formEditRoom').on('submit', function(e) {
        e.preventDefault();
        // validasi process edit di modal edit
        const formData = new FormData($('#formEditRoom')[0]);

        const room_name = $('#editRoomName').val();
        const floor = $('#editSelectFloor').val();
        const capacity = $('#editCapacityRoom').val();

        const imgName1 = $('#editImage1').val();
        const imgName2 = $('#editImage2').val();
        const imgName3 = $('#editImage3').val();


        if (room_name == '' || room_name == null) {
            $('#err-RoomName2').removeClass('d-none');
        } else {
            $('#err-RoomName2').addClass('d-none');
        }

        if (floor == '' || floor == null) {
            $('#err-SelectFloor2').removeClass('d-none');
        } else {
            $('#err-SelectFloor2').addClass('d-none');
        }

        if (capacity == '' || capacity == null) {
            $('#err-Capacity2').removeClass('d-none');
        } else {
            $('#err-Capacity2').addClass('d-none');
        }

        // if (imgName1 == '' || imgName1 == null) {
        //     $('#err-RoomEditImage1').removeClass('d-none');
        // } else {
        //     $('#err-RoomEditImage1').addClass('d-none');
        // }

        // if (imgName2 == '' || imgName2 == null) {
        //     $('#err-RoomEditImage2').removeClass('d-none');
        // } else {
        //     $('#err-RoomEditImage2').addClass('d-none');
        // }

        // if (imgName3 == '' || imgName3 == null) {
        //     $('#err-RoomEditImage3').removeClass('d-none');
        // } else {
        //     $('#err-RoomEditImage3').addClass('d-none');
        // }

        if (room_name != '' && floor != '' && capacity != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            Swal.fire({
                title: "Do you want to edit this Room ?",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#6e7881',
                confirmButtonColor: '#dd3333',
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Yes',
                reverseButtons: true,
                customClass: {
                    confirmButton: "swal-confirm-right",
                    cancelButton: "swal-cancel-left"
                }
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: '{{ route('/Room/update') }}',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend: () => {
                            $('#spinnerAdd').removeClass('d-none')
                            $('#btnEdit').prop('disabled', true);
                            $('#btnEdit').prepend(iconLoad);
                        }
                    }).done(res => {
                        $('#btnEdit').prop('disabled', false);
                        $('#btnEdit').empty()
                        $('#btnEdit').text('Save')
                        if (res.MSGTYPE === "W") {
                            showMessage('warning', res.MSG)
                            return;
                        }

                        // $('#spinnerAdd').addClass('d-none')
                        // $('#btnEdit').show()
                        showMessage('success', "Data was successfully updated!")
                        $('#modalEditRoom').modal('hide');
                        $(this)[0].reset();

                        // $('#addRoomName').val('')
                        // $('#addSelectFloor').val('')
                        // $('#addCapacityRoom').val('')



                        getListRoom();

                    })
                    // .fail(err => {
                    //     showMessage('error', 'Sorry! we failed to insert data')
                    //     $('#spinnerAdd').addClass('d-none')
                    //     $('#btnTambah').show();
                    // });
                }
            })
        }
    })

    $('#modalEditRoom').on('hide.bs.modal', function(e) {
        $('#formEditRoom')[0].reset();
    });


    // reset data modal add saat di close
    $('#btnEdit').on('click', function(e) {
        const modalEditRoom = $('#modalEditRoom')
        modalEditRoom.modal('show')
        $('#err-RoomName2').addClass('d-none');
        $('#err-SelectFloor2').addClass('d-none');
        $('#err-Capacity2').addClass('d-none');
        // $('#err-RoomImage1').addClass('d-none');
        // $('#err-RoomImage2').addClass('d-none');
        // $('#err-RoomImage3').addClass('d-none');


    })
</script>
