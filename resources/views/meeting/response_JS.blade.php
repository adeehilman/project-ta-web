{{-- last --}}
<script>
    $(document).ready(function() {
        $('#txDeskripsiResponse').summernote({
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
    $('#btnResponse').on('click', function(e) {
        e.preventDefault(); // Pastikan ini ada di awal
        // ...
    });

    $(document).ready(function() {

        $('#btnResponse').on('click', function(e) {

            e.preventDefault();

            const txDeskripsiResponse = $('#txDeskripsiResponse').summernote('code');
            // Hanya teks tanpa tag HTML

            const txDeskripsiResponseCek = $('#txDeskripsiResponse').val();
            const cleanedText = txDeskripsiResponse.replace(/<\/?[^>]+(>|$)/g, ""); // Hapus tag HTML   

            if (txDeskripsiResponseCek == '' || txDeskripsiResponseCek == null) {
                $('#err-response').removeClass('d-none');
            } else {
                $('#err-response').addClass('d-none');
            }

            if (
                txDeskripsiResponseCek != ''
            ) {
                Swal.fire({
                    title: "Do you want to add response to this Meeting?",
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
                        const meetingIdResponse = $('#meetingIdResponse').val();
                        $.ajax({
                                url: '{{ route('/meeting/response') }}',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    txDeskripsiResponse: cleanedText,
                                    meetingIdResponse: meetingIdResponse
                                },
                                beforeSend: () => {
                                    $('#SpinnerBtnResponse').removeClass('d-none');
                                    $('#SpinnerBtnResponse').prop('disabled', true);
                                    $('#btnResponse').hide();
                                },

                            }).done(res => {

                                if (res.MSGTYPE == 'W') {
                                    $('#SpinnerBtnResponse').addClass('d-none')
                                    $('#btnResponse').show();
                                    $('#SpinnerBtnResponse').prop('disabled', false);
                                    showMessage('warning', res.MSG)
                                    return;
                                } else if (res.MSGTYPE == 'E') {
                                    $('#SpinnerBtnResponse').addClass('d-none')
                                    $('#btnResponse').show();
                                    $('#SpinnerBtnResponse').prop('disabled', false);
                                    showMessage('error', res.MSG)
                                    return;
                                }
                                $('#SpinnerBtnResponse').prop('disabled', false);
                                $('#SpinnerBtnResponse').addClass('d-none')
                                $('#btnResponse').show();

                                showMessage('success',
                                    "Successfully saved meeting changes!")
                                $('#modalDetail').modal('hide');



                                getListMeetingRoom();
                            })
                            .fail(err => {
                                showMessage('error', 'Sorry! we failed to update data')
                                $('#SpinnerBtnResponse').addClass('d-none')
                                $('#btnResponse').show();
                                $('#btnCancelModal').show();
                            });
                    }
                });
            }



        });
    });
</script>
