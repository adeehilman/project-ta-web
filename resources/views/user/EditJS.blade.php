<script>
    // open modal Edit
    $(document).on('click', '.btnEdit', function(e) {
        e.preventDefault();

        var UserId = $(this).data('id');
        const modalFormEdit = $('#modalEditUser');

        modalFormEdit.modal('show');

        // Ajax request
        $.ajax({
            url: "{{ route('/user/edit') }}",
            method: "GET",
            data: {
                UserId: UserId
            },
            beforeSend: () => {

            },
            success: function(response) {

                console.log(`edit`,response);

                const dataUser = response.dataUserId;

                $("#selectEmployeeEdit").val(dataUser.badge_id);
                $("#editPosition").val(dataUser.user_level)
                // $("#editStatus").val(dataUser.is_active);

                if(dataUser.is_active > 0){
                    $('#editStatus').prop('checked', true)
                }else{
                    $('#editStatus').prop('checked', false)

                }


                // $('#editId').val(RoomId)




            },
            error: function(err) {

            }
        });
    });

    // saat submit form edit untuk update data
    $('#formEditUser').on('submit', function(e) {
        e.preventDefault();
        // validasi process edit di modal edit
        // const formData = new FormData($('#formEditUser')[0]);

        const badge_id = $('#selectEmployeeEdit').val();
        const user_level = $('#editPosition').val();
        const status_account = $('#editStatus').is(':checked') === true ? 1 : 0;


        if (badge_id == '' || badge_id == null) {
            $('#err-employeeEdit').removeClass('d-none');
        } else {
            $('#err-employeeEdit').addClass('d-none');
        }

        if (user_level == '' || user_level == null) {
            $('#err-positionEdit').removeClass('d-none');
        } else {
            $('#err-positionEdit').addClass('d-none');
        }

        // if (status_account == '' || status_account == null) {
        //     $('#err-statusEdit').removeClass('d-none');
        // } else {
        //     $('#err-statusEdit').addClass('d-none');
        // }


        if (badge_id != '' && user_level != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })

            Swal.fire({
                title: "Do you want to edit this user ?",
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
                        url: '{{ route('/user/update') }}',
                        method: 'POST', 
                        data: {
                            badge_id, user_level, status_account
                        },
                        // data: formData, 
                        // processData: false,
                        // contentType: false,
                        beforeSend: () => {
                  
                        }
                    }).done(res => {
                        $('#btnEdit').prop('disabled', false);
                        $('#btnEdit').empty()
                        $('#btnEdit').text('Save')
                        if (res.MSGTYPE === "W") {
                            showMessage('warning', res.MSG)
                            return;
                        }

                        showMessage('success', "Data was successfully updated!")
                        $('#modalEditUser').modal('hide');
                        $(this)[0].reset();


                        getListUser();

                    })
                    .fail(err => {
                        showMessage('error', 'Sorry! we failed to insert data')
                        $('#spinnerAdd').addClass('d-none')
                        $('#btnEdit').show();
                    });
                }
            })
        }
    })


    // reset data modal add saat di close
    $('#btnEdit').on('click', function(e) {
        const modalEditRoom = $('#modalEditUser')
        modalEditRoom.modal('show')
        $('#err-employeeEdit').addClass('d-none');
        $('#err-positionEdit').addClass('d-none');
        $('#err-statusEdit').addClass('d-none');
       


    })
</script>
