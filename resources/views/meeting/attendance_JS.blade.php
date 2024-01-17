<script>
    const btnAttendance = $('#btnAttendance');
    const modalAttendance = $('#modalAttendance');

    btnAttendance.click(function(e) {
        e.preventDefault();
        // var meetingId = $(this).data('meetingIdEdit');



        modalAttendance.modal('show');
    });



    $('#btnSimpanAttend').on('click', function(e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        const meetingIdAttend = $('#meetingIdAttend').val();

        const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF dari meta tag
        const lineStatus = {};
        // chekk checkbox fasility
        $('[data-attendance]').each(function() {
            const id = $(this).attr('data-attendance'); // Get the value of data-line
            const isChecked = $(this).prop('checked') ? 'true' :
                'false'; // Check if checkbox is checked
            const operation = $(this).data('operation'); // Get the value of data-operation

            if (operation === 'insert') {
                lineStatus['attendance' + id] = isChecked; // Save checkbox status in the object
            }

            // Rename id and class attributes
            $(this).attr('id', 'attendance_' + id);
            $(this).removeClass('menuCheck').addClass('form-check-input');

            // console.log(lineStatus);
        });

        const lineKeys = Object.keys(lineStatus);

        // Use reduce to build the data object
        const data = lineKeys.reduce((result, key) => {
            result[key.replace('attendance', 'attendance_')] = lineStatus[key];
            return result;
        }, {
            _token: csrfToken,
            meetingId: meetingIdAttend,
        });

        console.log(data);
        $.ajax({
                url: '{{ route('/meeting/attendance') }}',
                method: 'POST',
                data,

                beforeSend: () => {
                    $('#SpinnerBtnAttend').removeClass('d-none')
                    $('#SpinnerBtnAttend').prop('disabled', true);
                    $('#btnSimpanAttend').hide();
                }
            })
            .done(res => {

                if (res.MSGTYPE == 'W') {
                    $('#SpinnerBtnAttend').addClass('d-none')
                    $('#btnSimpanAttend').show()
                    $('#SpinnerBtnAttend').prop('disabled', false);
                    showMessage('warning', res.MSG)
                    return;
                }

                $('#SpinnerBtnAttend').prop('disabled', false);

                $('#SpinnerBtnAttend').addClass('d-none')
                $('#btnSimpanAttend').show()
                showMessage('success', "Attendance has succesfully updated!")
                $('#modalAttendance').modal('hide');
                // $(this)[0].reset();

                getListMeetingRoom();

            })
            .fail(err => {

                showMessage('error', 'Sorry! we failed to insert data')

                $('#SpinnerBtnAttend').addClass('d-none')
                $('#btnSimpanAttend').show();
            });

    })
</script>
