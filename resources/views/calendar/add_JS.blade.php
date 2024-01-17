<script>
    const btnAdd = $('#btnAddEvent');
    const modalFormAdd = $('#modalAdd');

    btnAdd.click(e => {
        e.preventDefault();
        modalFormAdd.modal('show');
        $('#err-selectEventCategory').addClass('d-none');
        $('#err-selectEventAdd').addClass('d-none');
        $('#err-DateEvent').addClass('d-none');
        $('#selectEventCategory').val();


    });


    // Start Date Add
    flatpickr("#DateEvent", {
        enableTime: false,
        dateFormat: "d/m/Y",
        minuteIncrement: 1,
        mode: "range"
    });


    $("#formAdd").on('submit', function(e) {
        e.preventDefault();

        const titleAdd = $('#titleAdd').val();
        const selectEventCategory = $('#selectEventCategory').val();
        const DateEvent = $('#DateEvent').val();




        if (titleAdd == '' || titleAdd == null) {
            $('#err-selectEventAdd').removeClass('d-none');
        } else {
            $('#err-selectEventAdd').addClass('d-none');
        }

        if (selectEventCategory == '' || selectEventCategory == null) {
            $('#err-selectEventCategory').removeClass('d-none');
        } else {
            $('#err-selectEventCategory').addClass('d-none');
        }
        if (DateEvent == '' || DateEvent == null) {
            $('#err-DateEvent').removeClass('d-none');
        } else {
            $('#err-DateEvent').addClass('d-none');
        }

        if (
            titleAdd != "" &&
            selectEventCategory != "" &&
            DateEvent != ""
        ) {
            Swal.fire({
                title: "Do you want to Add this Meeting?",
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
                            url: '{{ route('/calendar/insert') }}',
                            method: 'POST',
                            data: new FormData(this),
                            cache: false,
                            processData: false,
                            contentType: false,
                            beforeSend: () => {
                                $('#SpinnerBtnAdd').removeClass('d-none')
                                $('#SpinnerBtnAdd').prop('disabled', true);
                                $('#btnSimpanAdd').hide();
                            }
                        })
                        .done(res => {

                            if (res.MSGTYPE == 'W') {
                                $('#SpinnerBtnAdd').addClass('d-none')
                                $('#btnSimpanAdd').show()
                                $('#SpinnerBtnAdd').prop('disabled', false);
                                showMessage('warning', res.MSG)
                                return;
                            }

                            $('#SpinnerBtnAdd').prop('disabled', false);
                            $('#spinnerAdd').addClass('d-none')
                            $('#SpinnerBtnAdd').addClass('d-none')
                            $('#btnSimpanAdd').show()
                            showMessage('success', "Event was successfully added!")
                            $('#modalAdd').modal('hide');
                            // $(this)[0].reset();

                            location.reload(true)

                        })
                        .fail(err => {

                            showMessage('error', 'Sorry! we failed to insert data')
                            $('#spinnerAdd').addClass('d-none')
                            $('#SpinnerBtnAdd').addClass('d-none')
                            $('#btnSimpanAdd').show();
                        });

                }
            })





        }
    })



    // Submit From Date Select
</script>
