<script>
    const btnAdd = $('#btnAdd');
    const modalFormAdd = $('#modalAdd');

    btnAdd.click(e => {
        e.preventDefault();
        modalFormAdd.modal('show');
        $('#err-MeetingTitleAdd').addClass('d-none');
        $('#err-MeetingRoomAdd').addClass('d-none');
        $('#err-DateMeetingAdd').addClass('d-none');
        $('#err-StartMeetingAdd').addClass('d-none');
        $('#err-FinishMeetingAdd').addClass('d-none');
        $('#err-selectHost').addClass('d-none');
        $('#err-selectParticipan').addClass('d-none');
        $('#err-MeetingExtensionAdd').addClass('d-none');

        $('#titleAdd').val('')
        $('#RoomAdd').val('').trigger('change')
        $('#DateAdd').val('')
        $('#descAdd').val('')
        $('#startMeetingAdd').val('')
        $('#finishMeetingAdd').val('')
        $('#selectHostAdd').val('').trigger('change')
        $('#selectParticipanAdd').val('').trigger('change')
        $('#ExtensionAdd').val('')
        $('#accordionOthers .collapse').removeClass('show');
        $('#othersvisitorAdd').val('')
        $('input[type="checkbox"]').prop('checked', false);
        document.getElementById('ProjectInput').style.display = 'none';
        document.getElementById('customertName').style.display = 'none';
        document.getElementById('NoRadio').checked = true;
        document.getElementById('guestRadioNo').checked = true;

    });

    // Show dan hide project input
    function showInput() {
        document.getElementById('ProjectInput').style.display = 'block';
    }

    function hideInput() {
        document.getElementById('ProjectInput').style.display = 'none';
    }

    // Show dan hide customer input
    function showInputGuest() {
        document.getElementById('customertName').style.display = 'block';
        document.getElementById('customertName').querySelector('input').focus();
        
    }

    function hideInputGuest() {
        document.getElementById('customertName').style.display = 'none';
    }


    // Start Date Add
    flatpickr("#DateAdd", {
        minDate: "today",
        enableTime: false,
        dateFormat: "d/m/Y",
        minuteIncrement: 1
    });

    const startMeetingAdd = flatpickr("#startMeetingAdd", {
        enableTime: true,
        noCalendar: true,
        time_24hr: true,
        dateFormat: "H:i",
        minTime: "07:00",
        maxTime: "17:00",
    });

    const finishMeetingAdd = flatpickr("#finishMeetingAdd", {
        enableTime: true,
        noCalendar: true,
        time_24hr: true,
        dateFormat: "H:i",
        minTime: "18:00",
        maxTime: "21:00",
    });

    // Menambahkan event listener untuk perubahan waktu pada elemen startMeetingAdd
    startMeetingAdd.config.onChange.push(function(selectedDates, dateStr, instance) {
        // Mendapatkan waktu dari elemen startMeetingAdd
        const startTime = selectedDates[0];

        // Memperbarui konfigurasi elemen finishMeetingAdd
        finishMeetingAdd.set("minTime", startTime);

        // Mengosongkan nilai elemen finishMeetingAdd jika waktu yang dipilih lebih kecil dari waktu start
        if (finishMeetingAdd.selectedDates[0] < startTime) {
            finishMeetingAdd.clear();
        }

    });

    // Menambahkan event listener untuk perubahan waktu pada elemen finishMeetingAdd
    finishMeetingAdd.config.onChange.push(function(selectedDates, dateStr, instance) {
        // Mendapatkan waktu dari elemen finishMeetingAdd
        const finishTime = selectedDates[0];

        // Memperbarui konfigurasi elemen startMeetingAdd


        // Mengosongkan nilai elemen startMeetingAdd jika waktu yang dipilih lebih besar dari waktu finish
        if (startMeetingAdd.selectedDates[0] > finishTime) {
            startMeetingAdd.clear();
        }
    });




    $('#selectHostAdd').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#formAdd'),
        closeOnSelect: true,
        tags: false,
    });
    $('#RoomAdd').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#formAdd'),
        closeOnSelect: true,
        tags: false,
    });

    $('#selectParticipanAdd').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#formAdd'),
        closeOnSelect: true,
        tags: false,
    });

    // ketika form submit diklik
    $('#btnSimpanAdd').on('click', function(e) {
        e.preventDefault();


        const titleAdd = $('#titleAdd').val();
        const roomAdd = $('#RoomAdd').val();
        const dateAdd = $('#DateAdd').val();
        const DescAdd = $('#DescAdd').val();
        const othersvisitorAdd = $('#othersvisitorAdd').val();

        const startMeetingAdd = $('#startMeetingAdd').val();
        const finishMeetingAdd = $('#finishMeetingAdd').val();
        const hostAdd = $('#selectHostAdd').val();
        const badge_id = $('#selectParticipanAdd').val();
        const ExtensionAdd = $('#ExtensionAdd').val();
        const projectNameDetail = $('#ProjectNameAdd').val();
        const customertNameAdd = $('#customertNameAdd').val();



        if (titleAdd == '' || titleAdd == null) {
            $('#err-MeetingTitleAdd').removeClass('d-none');
        } else {
            $('#err-MeetingTitleAdd').addClass('d-none');
        }

        if (roomAdd == '' || roomAdd == null) {
            $('#err-MeetingRoomAdd').removeClass('d-none');
        } else {
            $('#err-MeetingRoomAdd').addClass('d-none');
        }

        if (dateAdd == '' || dateAdd == null) {
            $('#err-DateMeetingAdd').removeClass('d-none');
        } else {
            $('#err-DateMeetingAdd').addClass('d-none');
        }

        if (startMeetingAdd == '' || startMeetingAdd == null) {
            $('#err-StartMeetingAdd').removeClass('d-none');
        } else {
            $('#err-StartMeetingAdd').addClass('d-none');
        }

        if (finishMeetingAdd == '' || finishMeetingAdd == null) {
            $('#err-FinishMeetingAdd').removeClass('d-none');
        } else {
            $('#err-FinishMeetingAdd').addClass('d-none');
        }

        if (hostAdd == '' || hostAdd == null) {
            $('#err-selectHost').removeClass('d-none');
        } else {
            $('#err-selectHost').addClass('d-none');
        }

        // if (participant == '' || participant == null) {
        //     $('#err-selectParticipan').removeClass('d-none');
        // } else {
        //     $('#err-selectParticipan').addClass('d-none');
        // }

        if (ExtensionAdd == '' || ExtensionAdd == null) {
            $('#err-MeetingExtensionAdd').removeClass('d-none');
        } else {
            $('#err-MeetingExtensionAdd').addClass('d-none');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF dari meta tag
        const lineStatus = {};
        // chekk checkbox fasility
        $('[data-facilities]').each(function() {
            const id = $(this).attr('data-facilities'); // Get the value of data-line
            const isChecked = $(this).prop('checked') ? 'true' :
                'false'; // Check if checkbox is checked
            const operation = $(this).data('operation'); // Get the value of data-operation

            if (operation === 'insert') {
                lineStatus['facilities' + id] = isChecked; // Save checkbox status in the object
            }

            // Rename id and class attributes
            $(this).attr('id', 'facilities_' + id);
            $(this).removeClass('menuCheck').addClass('form-check-input');

            // console.log(lineStatus);
        });




        if (

            titleAdd != '' &&
            roomAdd != '' &&
            dateAdd != '' &&
            startMeetingAdd != '' &&
            finishMeetingAdd != '' &&
            hostAdd != '' &&
            ExtensionAdd != ''
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

                    // Get all keys from the lineStatus object
                    const lineKeys = Object.keys(lineStatus);

                    // Use reduce to build the data object
                    const data = lineKeys.reduce((result, key) => {
                        result[key.replace('facilities', 'facilities_')] = lineStatus[key];
                        return result;
                    }, {
                        _token: csrfToken,
                        titleAdd,
                        roomAdd,
                        dateAdd,
                        startMeetingAdd,
                        finishMeetingAdd,
                        hostAdd,
                        ExtensionAdd,
                        badge_id,
                        othersvisitorAdd,
                        DescAdd,
                        projectNameDetail,
                        customertNameAdd,
                    });

                    // console.log(data);

                    $.ajax({
                            url: '{{ route('/meeting/insert') }}',
                            method: 'POST',
                            data,

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
                            showMessage('success', "Data was successfully added!")
                            $('#modalAdd').modal('hide');
                            // $(this)[0].reset();

                            getListMeetingRoom();

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


    });



    // count di modal add
    $(document).ready(function() {
        var selectParticipanAdd = $('#selectParticipanAdd');

        function updateSelectedParticipantCountAdd() {
            var selectedCount = selectParticipanAdd.val() ? selectParticipanAdd.val().length : 0;
            $('#selectedParticipantCountAdd').text(selectedCount + ' Participant Selected');
        }

        selectParticipanAdd.on('change', updateSelectedParticipantCountAdd);

        // Inisialisasi jumlah yang dipilih saat halaman dimuat
        updateSelectedParticipantCountAdd();


    });



    // pagination dropdown host
    $(document).ready(function() {
        $('#selectHostAdd').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#formAdd'),
            closeOnSelect: true,
            ajax: {
                url: '/user/listEmployee', // URL untuk mengambil data
                dataType: 'json',
                delay: 250, // Waktu tunda sebelum permintaan dikirim
                processResults: function(data) {
                    return {
                        results: data.list_participant_w.map(function(item, index) {
                            var combinedText = data.list_participant_f[index] + ' (' + data
                                .list_participant_p[index] + ')';

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
    $(document).ready(function() {
        $('#selectParticipanAdd').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#formAdd'),
            closeOnSelect: true,
            ajax: {
                url: '/user/listEmployee', // URL untuk mengambil data
                dataType: 'json',
                delay: 250, // Waktu tunda sebelum permintaan dikirim
                processResults: function(data) {
                    return {
                        results: data.list_participant_w.map(function(item, index) {
                            var combinedText = data.list_participant_f[index] + ' (' +
                                data
                                .list_participant_p[index] + ')';

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

    // $('#selectHostAdd').on('change', function() {
    //     // Mendapatkan nilai dari input pertama
    //     var selectedValue = $(this).val();


    //     // Mengatur opsi yang dipilih di input kedua
    //     $('#selectParticipanAdd').val([selectedValue]).trigger('change');

    //     $('#selectParticipanAdd').on('select2:unselect', function(e) {
    //         var unselectedValue = e.params.data.id;

    //         if (unselectedValue === selectedValue) {
    //             $('#selectHostAdd option[value="' + unselectedValue + '"]').prop('disabled', false);
    //             $('#selectHostAdd').val(null).trigger('change');
    //         }
    //     });

    // });
    const meetingTimeInput = document.getElementById('meetingTime');

    meetingTimeInput.addEventListener('input', function() {
        const selectedTime = new Date(`1970-01-01T${this.value}`);

        const lowerBound1 = new Date(`1970-01-01T05:00:00`);
        const upperBound1 = new Date(`1970-01-01T18:00:00`);

        const lowerBound2 = new Date(`1970-01-02T00:00:00`);
        const upperBound2 = new Date(`1970-01-02T05:00:00`);

        if (
            (selectedTime >= lowerBound1 && selectedTime < upperBound1) ||
            (selectedTime >= lowerBound2 && selectedTime < upperBound2)
        ) {
            // Waktu yang dipilih berada dalam rentang yang valid
        } else {
            alert('Waktu yang dipilih harus antara 05:00 dan 18:00.');
            this.value = ''; // Menghapus nilai yang tidak valid
        }
    });


    // pagination participant add
    $(document).ready(function() {
        $('#selectParticipanAdd').select2({
            theme: "bootstrap-5",
            ajax: {
                url: '/meeting/listParticipant', // URL untuk mengambil data
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
            minimumInputLength: 3 // Jumlah karakter minimum sebelum pencarian dimulai


        });
    });



    // reset data modal add saat di close
    $('#btnAdd').on('click', function(e) {



    })
</script>
