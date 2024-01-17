<script>
    // open reschedule modal detail
    const btnReschedule = $('#btnReschedule');
    const modalReschedule = $('#modalReschedule');

    btnReschedule.click(function(e) {
        e.preventDefault();
        var meetingId = $(this).data('meetingIdEdit');

        // console.log(meetingId);
        $('#err-MeetingTitleEdit').addClass('d-none');
        $('#err-MeetingRoomEdit').addClass('d-none');
        $('#err-DateMeetingEdit').addClass('d-none');
        $('#err-StartMeetingEdit').addClass('d-none');
        $('#err-FinishMeetingEdit').addClass('d-none');
        $('#err-selectHostEdit').addClass('d-none');
        $('#err-selectParticipanEdit').addClass('d-none');
        $('#err-MeetingExtensionEdit').addClass('d-none');
        // document.getElementById('customertNameEdit').style.display = 'none';

        modalReschedule.modal('show');
    });



    // Show dan hide project input edit
    function showInputEdit() {
        document.getElementById('ProjectInputEdit').style.display = 'block';
        $('#ProjectNameEdit').prop('disabled', false); // Menggunakan .prop()
    }

    function hideInputEdit() {
        document.getElementById('ProjectInputEdit').style.display = 'none';
        $('#ProjectNameEdit').prop('disabled', true);

        $('#ProjectNameEdit').val('');
    }
     // Show dan hide customer input
     function showInputGuestEdit() {
        document.getElementById('customertNameEdit').style.display = 'block';
        document.getElementById('customertNameEdit').querySelector('input').focus();
        
    }

    function hideInputGuestEdit() {
        document.getElementById('customertNameEdit').style.display = 'none';
        $('#customerNameEditField').val('');

        var checkboxes = document.querySelectorAll('.menuCheckE');

        // Melakukan iterasi pada setiap checkbox
        checkboxes.forEach(function(checkbox) {
            // Memeriksa apakah checkbox memiliki ID yang sesuai dengan item ID
            var checkboxId = checkbox.getAttribute('data-facilities');
            checkbox.checked = false;
            
        });
        $('#othersvisitorEdit').val('');
        $('#descDetailEdit').val('');
    }



    // pagination dropdown host
    $(document).ready(function() {
        $('#selectHostEdit').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#formReschedule'),
            closeOnSelect: true,
            ajax: {
                url: '/user/listEmployee', // URL untuk mengambil data
                dataType: 'json',
                delay: 250, // Waktu tunda sebelum permintaan dikirim
                processResults: function(data) {
                    return {
                        results: data.list_participant_w.map(function(item, index) {
                            var combinedText = data.list_participant_w[index] + ' - ' + data
                                .list_participant_f[index];

                            return {
                                id: item,
                                text: combinedText
                            }
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 3,


        });

    });




    $('#selectHostEdit').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#formReschedule'),
        closeOnSelect: false,
        tags: true,
    });

    $('#selectParticipanEdit').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#formReschedule'),
        closeOnSelect: false,
        tags: true,
    });


    $(document).ready(function() {
        $('#selectParticipanEdit').select2({
            theme: "bootstrap-5",
            ajax: {
                url: '/meeting/listParticipant', // URL untuk mengambil data
                dataType: 'json',
                delay: 250, // Waktu tunda sebelum permintaan dikirim
                processResults: function(data) {
                    return {
                        results: data.list_participant_w.map(function(item, index) {
                            var combinedText = data.list_participant_f[index] + ' (' + data
                                .list_participant_p[index] + ')';
                            return {
                                id: item,
                                text: combinedText // Menggunakan list_participant_f untuk teks
                            }
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 3 // Jumlah karakter minimum sebelum pencarian dimulai

        });
    });


    // Start Date Add
    flatpickr("#DateDetailEdit", {
        minDate: "today",
        enableTime: false,
        dateFormat: "d/m/Y",
        minuteIncrement: 1
    });
</script>

<script>
    // modal cancel
    $('#formReschedule').on('submit', function(e) {

        e.preventDefault();
        const MeetingId = $('#meetingIdEdit').val();

        const MeetingTitle = $('#titleDetailEdit').val();
        const room_name = $('#RoomDetailEdit').val();
        const hostEdit = $('#HiddenHostEdit').val();
        const badge_id = $('#selectParticipanEdit').val();
        const DateMeeting = $('#DateDetailEdit').val();

        const StartMeeting = $('#startMeetingDetailEdit').val();
        const FinishMeeting = $('#finishMeetingDetailEdit').val();
        const Desc = $('#descDetailEdit').val();
        const othersvisitorEdit = $('#othersvisitorEdit').val();
        const statusEdit = $('#statusEdit').val();
        const ExtensionEdit = $('#ExtensionEdit').val();
        const ProjectNameEdit = $('#ProjectNameEdit').val();
        const customerNameEditField = $('#customerNameEditField').val();
        const NoGuestRadioEdit = $('#NoGuestRadioEdit').val();
        

        

        if (noRadioEdit === 'no') {
            console.log('2');
            let ProjectNameEdit = $('#ProjectNameEdit').val('');
        } else {
            console.log('1');
        }

        if (MeetingTitle == '' || MeetingTitle == null) {
            $('#err-MeetingTitleEdit').removeClass('d-none');
        } else {
            $('#err-MeetingTitleEdit').addClass('d-none');
        }

        if (room_name == '' || room_name == null) {
            $('#err-MeetingRoomEdit').removeClass('d-none');
        } else {
            $('#err-MeetingRoomEdit').addClass('d-none');
        }

        if (DateMeeting == '' || DateMeeting == null) {
            $('#err-DateMeetingEdit').removeClass('d-none');
        } else {
            $('#err-DateMeetingEdit').addClass('d-none');
        }

        if (StartMeeting == '' || StartMeeting == null) {
            $('#err-StartMeetingEdit').removeClass('d-none');
        } else {
            $('#err-StartMeetingEdit').addClass('d-none');
        }

        if (FinishMeeting == '' || FinishMeeting == null) {
            $('#err-FinishMeetingEdit').removeClass('d-none');
        } else {
            $('#err-FinishMeetingEdit').addClass('d-none');
        }

        if (hostEdit == '' || hostEdit == null) {
            $('#err-selectHostEdit').removeClass('d-none');
        } else {
            $('#err-selectHostEdit').addClass('d-none');
        }

        if (ExtensionEdit == '' || ExtensionEdit == null) {
            $('#err-MeetingExtensionEdit').removeClass('d-none');
        } else {
            $('#err-MeetingExtensionEdit').addClass('d-none');
        }


        const facilitiesStatus = {};
        // chekk checkbox fasility
        $('[data-facilities]').each(function() {
            const id = $(this).attr('data-facilities'); // Mengambil nilai data-line
            const isChecked = $(this).prop('checked') ? 'true' :
                'false'; // Mengecek apakah checkbox checked atau tidak
            facilitiesStatus['facilities' + id] = isChecked; // Menyimpan status checkbox dalam objek

            // console.log(facilitiesStatus);
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF dari meta tag




        if (

            MeetingTitle != '' &&
            room_name != '' &&
            DateMeeting != '' &&
            StartMeeting != '' &&
            FinishMeeting != '' &&
            ExtensionEdit != ''

        ) {


            // validasi process edit di tab process
            Swal.fire({
                title: "Do you want to Edit this Meeting?",
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

                    // reschedule checkbox edit
                    // Get all keys from the facilitiesStatus object
                    const facilitiesKey = Object.keys(facilitiesStatus);

                    // Use reduce to build the data object
                    const data = facilitiesKey.reduce((result, key) => {
                        result[key.replace('facilities', 'facilities_')] = facilitiesStatus[
                            key];
                        return result;
                    }, {
                        _token: csrfToken,
                        MeetingTitle,
                        room_name,
                        hostEdit,
                        badge_id,
                        DateMeeting,
                        StartMeeting,
                        FinishMeeting,
                        Desc,
                        othersvisitorEdit,
                        statusEdit,
                        ExtensionEdit,
                        MeetingId,
                        ProjectNameEdit,
                        customerNameEditField,
                        NoGuestRadioEdit,
                    });



                    $.ajax({
                            url: "{{ route('/meeting/update') }}",
                            method: 'POST',
                            data,
                            cache: false,
                            beforeSend: () => {
                                $('#SpinnerBtnEdit').removeClass('d-none')
                                $('#SpinnerBtnEdit').prop('disabled', true);
                                $('#btnSimpanReschedule').hide();
                            }
                        })
                        .done(res => {

                            if (res.MSGTYPE == 'W') {
                                $('#SpinnerBtnEdit').addClass('d-none')
                                $('#btnSimpanReschedule').show();
                                $('#SpinnerBtnEdit').prop('disabled', false);
                                showMessage('warning', res.MSG)
                                return;
                            } else if (res.MSGTYPE == 'E') {
                                $('#SpinnerBtnEdit').addClass('d-none')
                                $('#btnSimpanReschedule').show();
                                $('#SpinnerBtnEdit').prop('disabled', false);
                                showMessage('error', res.MSG)
                                return;
                            }
                            $('#SpinnerBtnEdit').prop('disabled', false);
                            $('#SpinnerBtnEdit').addClass('d-none')
                            $('#btnSimpanReschedule').show();

                            showMessage('success', "Successfully saved meeting changes!")
                            $('#modalReschedule').modal('hide');
                            $(this)[0].reset();


                            getListMeetingRoom();
                        })
                        .fail(err => {
                            showMessage('error', 'Sorry! we failed to update data')
                            $('#SpinnerBtnEdit').addClass('d-none')
                            $('#btnSimpanReschedule').show();
                            $('#btnCancelModal').show();
                        })
                }
            })
        }


    });
</script>
