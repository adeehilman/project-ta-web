<script>
     $(document).on('click', '#btnedit', function (e) {
        e.preventDefault();
        const id = $(this).data('id');
        const description = $(this).data('description');
        const startdate = $(this).data('startdate');
        const enddate = $(this).data('enddate');
        const status = $(this).data('status');
        $('#idedit').val(id);

        $('#announcement-descriptionedit').val(description);
        $('#announcement-startdateedit').val(startdate);
        $('#announcement-enddateedit').val(enddate);

        if (status === 'Berlangsung') {
            $('#waktumulai').hide();
            $('#waktuakhir').removeClass('col-md-6').addClass('col-md-12');  // Mengubah col-md-6 menjadi col-md-12
        } else {
            $('#waktumulai').show();  // Menampilkan elemen waktumulai
            $('#waktuakhir').removeClass('col-md-12').addClass('col-md-6');  // Mengubah col-md-12 menjadi col-md-6
        }

        $("#announcement-descriptionedit").change(function (e) {
            e.preventDefault();
            $('#err-noticeDescriptionedit').addClass('d-none');
        });
        $("#announcement-startdateedit").change(function (e) {
            e.preventDefault();
            $('#err-pengumumanstartedit').addClass('d-none');
        });
        $("#announcement-enddateedit").change(function (e) {
            e.preventDefault();
            $('#err-pengumumanendedit').addClass('d-none');
        });

        $('#modalEditNotice').modal('show');
     });


     $(document).on( 'click','#editbtnnotice',function(e) {
            e.preventDefault();

            // Cek Deskripsi Pengumuman
            const btneditnotice = $('#editbtnnotice')
            const id = $('#idedit').val();
            const descriptionedit = $('#announcement-descriptionedit').val();
            const endDateedit = $('#announcement-enddateedit').val();
            const startDateedit = $('#announcement-startdateedit').val();
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            if (descriptionedit.trim() === '') {
                $('#err-noticeDescriptionedit').removeClass('d-none');
            } else {
                $('#err-noticeDescriptionedit').addClass('d-none');
            }

                if (startDateedit.trim() === '') {
                    $('#err-pengumumanstartedit').removeClass('d-none');
                } else {
                    $('#err-pengumumanstartedit').addClass('d-none');
                }
         

            if (endDateedit.trim() === '') {
                $('#err-pengumumanendedit').removeClass('d-none');
            } else {
                $('#err-pengumumanendedit').addClass('d-none');
            }

            if (descriptionedit !== '' && endDateedit !== '' && startDateedit !== '') {

                Swal.fire({
                    title: "Apakah kamu yakin ingin update pengumuman ini?",
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
                            type: "POST",
                            url: "{{ route('updatenotice') }}",
                            data: {
                                id: id,
                                desc: descriptionedit,
                                startdate: startDateedit,
                                enddate: endDateedit,
                                _token: csrfToken
                            },
                            beforeSend: function () {
                                btneditnotice.prop('disabled', true); 
                            },
                            success: function (response) {
                                if (response.success) {
                                    showMessage('success', 'Pengumuman Berhasil di Update');
                                    $('#modalEditNotice').modal('hide');
                                    getListNotice();
                                    btneditnotice.prop('disabled', false); 
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: response.error,
                                    });
                                    $('#modalEditNotice').modal('hide');
                                    getListNotice();
                                    btneditnotice.prop('disabled', false); 
                                }
                            },
                            error: function (xhr, textStatus, errorThrown) {
                                if (xhr.status === 400) {
                                    var errorResponse = JSON.parse(xhr.responseText);
                                    Swal.fire({
                                        title: errorResponse.error,
                                        icon: 'error',
                                        confirmButtonColor: '#db1717',
                                        confirmButtonText: 'OK'
                                    });
                                    btneditnotice.prop('disabled', false); 
                                } else {
                                    console.log('AJAX request failed', errorThrown);
                                }
                            }
                        });
                    }
                });

            } else {
                console.log('Please fill in all required fields before submitting.');
            }
        });
     


    

</script>