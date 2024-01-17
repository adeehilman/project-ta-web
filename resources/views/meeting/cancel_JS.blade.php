{{-- tombol cancel dan modal cancel --}}
<script>
    //summernote init
    $(document).ready(function() {
        $('#txDeskripsiCancel').summernote({
            placeholder: 'Insert Reason',
            tabsize: 2,
            height: 120,
            toolbar: [], // Menghilangkan toolbar
            styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'], // Mematikan gaya teks
            dialogsInBody: true, // Menjamin dialog modal muncul di atas modal Bootstrap lainnya

        });
    });
</script>

<script>
    // reset data modal add saat di close
    $('#btnCancel').on('click', function(e) {
        const modalCancelRoom = $('#modalCancel')
        modalCancelRoom.modal('show')
        $('#err-cancel').addClass('d-none');


        $('#txDeskripsiCancel').summernote('code', '');
    });


    // modal cancel
    $('#formCancelMeeting').on('submit', function(e) {

        e.preventDefault();
        // validasi process edit di tab process


        const txDeskripsi = $('#txDeskripsiCancel').val();

        if (txDeskripsi == '' || txDeskripsi == null) {
            $('#err-cancel').removeClass('d-none');
        } else {
            $('#err-cancel').addClass('d-none');
        }


        if (
            txDeskripsi != ''
        ) {
            Swal.fire({
                title: "Do you want to cancel this Meeting?",
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
                            url: "{{ route('/meeting/cancelMeeting') }}",
                            method: 'POST',
                            data: new FormData(this),
                            cache: false,
                            processData: false,
                            contentType: false,
                            beforeSend: () => {
                                $('#SpinnerBtnCancel').removeClass('d-none')
                                $('#SpinnerBtnCancel').prop('disabled', true);
                                $('#btnCancelModal').hide();
                            }
                        })
                        .done(res => {

                            if (res.MSGTYPE == 'W') {
                                $('#SpinnerBtnCancel').addClass('d-none')
                                $('#SpinnerBtnCancel').prop('disabled', false);
                                $('#tabBtnEditProcess').show()
                                showMessage('warning', res.MSG)
                                return;
                            }

                            $('#SpinnerBtnCancel').addClass('d-none')
                            $('#btnCancelModal').show();
                            $('#SpinnerBtnCancel').prop('disabled', false);
                            showMessage('success', "Meeting successfully Canceled!")
                            $('#modalCancel').modal('hide');
                            $(this)[0].reset();


                            getListMeetingRoom();
                        })
                        .fail(err => {
                            showMessage('error', 'Sorry! we failed to update data')
                            $('#SpinnerBtnCancel').addClass('d-none')

                            $('#btnCancelModal').show();
                        })
                }
            })
        }
    });
</script>
