<script>
    const btnImport = $('#btnImport');
    const modalImport = $('#modalImport');

    btnImport.click(e => {
        e.preventDefault();
        modalImport.modal('show');

        $('#uploadFile').val('');

    });

    $('#formImport').on('submit', function(e) {
        e.preventDefault();
        const uploadFile = $('#uploadFile').val();
        if (uploadFile == '') {
            $('#err-fileImport').removeClass('d-none');
        } else {
            $('#err-fileImport').addClass('d-none');
        }

        if (uploadFile != '') {
            $.ajax({
                    url: '{{ route('/internship/import') }}',
                    method: 'POST',
                    data: new FormData(this),
                    cache: false,
                    processData: false,
                    contentType: false,
                    beforeSend: () => {
                        $('#SpinnerBtnImport').removeClass('d-none')
                        $('#SpinnerBtnImport').prop('disabled', true);
                        $('#btnImportAttendance').hide();
                    }
                })
                .done(res => {
                    if (res.MSGTYPE == 'W') {
                        $('#SpinnerBtnImport').addClass('d-none')
                        $('#btnImportAttendance').show()
                        $('#SpinnerBtnImport').prop('disabled', false);
                        showMessage('warning', res.MSG)
                        return;
                    }

                    $('#SpinnerBtnImport').addClass('d-none')
                    $('#btnImportAttendance').show()
                    showMessage('success', "Internship Attendance was successfully imported!")
                    $('#modalImport').modal('hide');
                    $('#SpinnerBtnImport').prop('disabled', false);
                    $(this)[0].reset();

                    location.reload()

                })
                .fail(err => {
                    showMessage('error', 'Sorry! we failed to upload data')
                    $('#SpinnerBtnImport').addClass('d-none')
                    $('#btnImportAttendance').show();
                })
        }

    })
</script>
