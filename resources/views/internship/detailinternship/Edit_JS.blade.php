{{-- Function Modal Edit --}}
<script>
    // Show dan hide project input
    function showInput() {
        $('#timeInEdit').prop('disabled', false);
            $('#timeOutEdit').prop('disabled', false);
            const colImage = $('#colImage');
            const colImageOptional = $('#colImageOptional');

            // Sembunyikan elemen colImageOptional
            colImageOptional.addClass('d-none');

            const sickRadio = $('#sick');

            if (sickRadio.is(':checked')) {
                // Tampilkan elemen colImage
                colImage.removeClass('d-none');

            } else {
                // Sembunyikan elemen colImage
                colImage.addClass('d-none');
            }
        }

        function showInputOptional() {
            $('#timeInEdit').prop('disabled', false);
            $('#timeOutEdit').prop('disabled', false);
            const colImage = $('#colImage');
            const colImageOptional = $('#colImageOptional');

            // Sembunyikan elemen colImage
            colImage.addClass('d-none');

            // Tampilkan elemen colImageOptional
            colImageOptional.removeClass('d-none');
        }

        function hideInput() {

            $('#timeInEdit').prop('disabled', false);
            $('#timeOutEdit').prop('disabled', false);
            const colImage = $('#colImage');
            colImage.addClass('d-none');

            const colImageOptional = $('#colImageOptional');
            colImageOptional.addClass('d-none');
        }

        function hideInputAbsent() {

            $('#timeInEdit').prop('disabled', true);
            $('#timeOutEdit').prop('disabled', true);

            const colImage = $('#colImage');
            colImage.addClass('d-none');

            const colImageOptional = $('#colImageOptional');
            colImageOptional.addClass('d-none');
            }


    $(document).on('click', '.btnEdit', function(e) {

        const modalEdit = $('#modalEdit');
        modalEdit.modal('show')


        $('.radioAttend').prop('checked', false);

        e.preventDefault();
        var badgeId = $(this).data('id');
        var date = $(this).data('date');

        // console.log(badgeId, date);
        // lakukan ajax untuk mengambil image
        $.ajax({
            url: "{{ route('/internship/getValue') }}",
            method: "GET",
            data: {
                badgeId: badgeId,
                date
            },
        }).done(res => {
            // console.log(res);    
            const viewValue = res.viewValue;

            $('#badgeEdit').text(viewValue.badge_id);
            $('#fullnameEdit').text(viewValue.fullname);
            $('#deptEdit').text(viewValue.dept_name);
            $('#timeInEdit').val(viewValue.scanin);
            $('#timeOutEdit').val(viewValue.scanout);
            $('#idAttendance').val(viewValue.id);
            $('#imageAttachPermission').val(viewValue.attachment);
            $('#dateSubmit').val(viewValue.submit_date);

            const defaultStart = viewValue.scanin;
            const timeInEdit = flatpickr("#timeInEdit", {
                    enableTime: true,
                    noCalendar: true,
                    time_24hr: true,
                    defaultDate: defaultStart,
                });

            const defaulFinish = viewValue.scanout;
            const timeOutEdit = flatpickr("#timeOutEdit", {
                    enableTime: true,
                    noCalendar: true,
                    time_24hr: true,
                    defaultDate: defaulFinish,
                });

            // Simpan nilai viewValue.scanout dalam variabel untuk mempermudah akses
            const scanoutValue = viewValue.status;

            // Temukan radio button yang sesuai berdasarkan nilai scanout
            if (scanoutValue === 'Present') {
                $('#present').prop('checked', true);
            } else if (scanoutValue === 'Permission') {
                $('#permission').prop('checked', true);
            } else if (scanoutValue === 'Sick') {
                $('#sick').prop('checked', true);
            } else if (scanoutValue === 'Absent') {
                $('#timeInEdit').prop('disabled', true);
                $('#timeOutEdit').prop('disabled', true);
                $('#absent').prop('checked', true);
            } else {

            }

        })
    });
</script>

{{-- Function Update ajax --}}
<script>
    $('#formEditAttend').on('submit', function(e) {
        e.preventDefault();

        const id = $('#idAttendance').val();
        const badgeId = $('#badgeEdit').text();
        const fullnameEdit = $('#fullnameEdit').text();

        const attendOption = $('input[name=attendOption]:checked').val();
        const timeInEdit = $('#timeInEdit').val();
        const timeOutEdit = $('#timeOutEdit').val();
        const image = $('#imageAttachOptional').val();


        if (attendOption == '' || attendOption == null) {
            $('#err-attendOption').removeClass('d-none');
        } else {
            $('#err-attendOption').addClass('d-none');
        }


        if (attendOption != '' && attendOption != undefined) {
            Swal.fire({
                title: "Do you want to Edit this Event?",
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
                            url: "{{ route('/internship/update') }}",
                            method: "POST",
                            data: new FormData(this),
                            cache: false,
                            processData: false,
                            contentType: false,
                            beforeSend: () => {
                                $('#SpinnerBtnEdit').removeClass('d-none')
                                $('#SpinnerBtnEdit').prop('disabled', true);
                                $('#btnSimpanEdit').hide();
                            }
                        })
                        .done(res => {
                            showMessage('success', "Attachment was successfully update!")

                            if (res.MSGTYPE == 'W') {
                                $('#SpinnerBtnEdit').addClass('d-none')
                                $('#btnSimpanEdit').show();
                                $('#SpinnerBtnEdit').prop('disabled', false);
                                showMessage('warning', res.MSG)
                                return;
                            }else if (res.MSGTYPE == 'E') {
                                $('#SpinnerBtnEdit').addClass('d-none')
                                $('#btnSimpanEdit').show();
                                $('#SpinnerBtnEdit').prop('disabled', false);
                                showMessage('error', res.MSG)
                                return;
                            }
                            location.reload(true)
                            $('#modalEdit').modal('hide');
                        })
                        .fail(err => {
                            showMessage('error', "Sorry fail")
                            $('#SpinnerBtnEdit').addClass('d-none')
                                $('#SpinnerBtnEdit').prop('disabled', false);
                                $('#btnSimpanEdit').show();
                        })


                }
            })
        }
        // console.log(id,badgeId,fullnameEdit,attendOption,timeInEdit,timeOutEdit);


    })
</script>
