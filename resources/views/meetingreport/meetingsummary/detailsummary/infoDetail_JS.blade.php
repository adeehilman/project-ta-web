{{-- 2 --}}

<script>
    const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
                <div class="spinner-border d-flex justify-content-center align-items-center text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
            </div> `;
    // open modal Detail
    const btnDetail = $('#btnDetail');
    const modalDetail = $('#modalDetail');

    $(document).on('click', '.btnDetail', function(e) {

        e.preventDefault();
        var meetingId = $(this).data('id');
        //  console.log(meetingId);

        $('#listOfParticipants').empty();
        $('#listOfTanggapan').empty();
        $('#noRespon').empty();
        $('#listOfParticipantAttend').empty();


        $('#txDeskripsiResponse').summernote('code', '');
        const modalDetail = $('#modalDetail');
        modalDetail.modal('show')

        $.ajax({
                url: "{{ route('/meeting/getDetail') }}",
                method: "GET",
                data: {
                    meetingId: meetingId
                },
                beforeSend: () => {

                }
            })
            .done(res => {
                // console.log(res);

                const infoBooking = res.DetailMeeting
                let roomName = infoBooking.room_name;

                $("#titleDetail").text(infoBooking.title_meeting);
                $("#descDetail").text(infoBooking.description);
                $("#roomDetail").text(infoBooking.room_name);
                $("#floorDetail").text(infoBooking.floor);
                $("#dateDetail").text(infoBooking.meeting_date + ',    ' + infoBooking.meeting_start +
                    ' - ' +
                    infoBooking.meeting_end);
                $("#participantDetail").text(infoBooking.participant_count + ' People');

                $("#visitorDetail").text(infoBooking.jumlah_tamu ? infoBooking.jumlah_tamu + ' People' :
                    '-');
                $("#startMeetingDetail").text(infoBooking.meeting_start);
                $("#finishMeetingDetail").text(infoBooking.meeting_end);
                $("#bookingByDetail").text(infoBooking.fullname + '    (' + infoBooking.booking_by + ')');
                $("#bookingByBadgeDetail").text(infoBooking.booking_by);
                $("#statusDetail").text(infoBooking.status_name_eng);
                $("#ProjectNameDetailTextMeetingSummary").text(infoBooking.project ? infoBooking.project :
                    '-');
                $("#reasonDetail").text(infoBooking.reason ? null : '-');
                const fasilitasList = res.FasilitasList;

                $('#participantLabel').text('Participant (' + infoBooking.participant_count + ')');
                $('#AttendanceCount').text('Attendance (' + infoBooking.kehadiran_count + '/' +
                    infoBooking
                    .participant_count + ')');


                // Inisialisasi array kosong untuk menyimpan nama fasilitas
                const fasilitasArray = [];
                // Menggunakan $.each untuk menggabungkan nama fasilitas ke dalam array
                $.each(fasilitasList, function(index, fasilitas) {
                    fasilitasArray.push(fasilitas.nama_fasilitas);
                });
                // Menggabungkan array nama fasilitas menjadi satu string dengan koma sebagai pemisah
                let resultString = fasilitasArray.join(', ');

                // Mengganti dengan "-" jika resultString kosong
                resultString = resultString ? resultString : '-';
                // Menetapkan teks hasilnya ke elemen dengan id "facilityDetail"
                $("#facilityDetail").text(resultString);
                $("#bookingTime").text(infoBooking.booking_date);
                $("#createdBy").text((infoBooking.recepcionist ? infoBooking.recepcionist : infoBooking
                    .fullname) + '    (' + (infoBooking.createby ? infoBooking.createby :
                    infoBooking.booking_by) + ')');


                //get data modal edit untuk buton edit meeting di modal detail

                $("#titleDetailEdit").val(infoBooking.title_meeting);
                $("#HiddenHostEdit").val(infoBooking.badge_id);
                $("#ExtensionEdit").val(infoBooking.ext);
                $("#othersvisitorEdit").val(infoBooking.jumlah_tamu === 0 ? null : infoBooking.jumlah_tamu);
                $("#DateDetailEdit").val(infoBooking.meeting_date);
                $("#startMeetingDetailEdit").val(infoBooking.meeting_start);
                $("#finishMeetingDetailEdit").val(infoBooking.meeting_end);
                $("#descDetailEdit").val(infoBooking.description);
                $("#statusEdit").val(infoBooking.statusId);
                $("#selectHostEdit").val(infoBooking.badge_id).trigger('change.select2');
                $("#selectedParticipantCount").text(infoBooking.participant_count + ' Participant Selected')
                $("#RoomDetailEdit").val(infoBooking.roommeeting_id).trigger('change.select2');

                const FasilitasId = res.FasilitasList.map(v => v.meetingfasilitas_id);



                for (let number of FasilitasId) {
                    const checkbox = $(`#facilities_edit_${number}`);

                    const isChecked = true; // Anda ingin semua checkbox yang ada dalam array ini di-check
                    checkbox.prop('checked', isChecked);
                }


                // console.log(infoBooking.meetingId)
                $("#meetingId").val(infoBooking.meetingId);
                $("#meetingIdResponse").val(infoBooking.meetingId);
                $("#meetingIdEdit").val(infoBooking.meetingId);
                $("#meetingIdAttend").val(infoBooking.meetingId);

                dataRiwayatById(meetingId);

            })


        $.ajax({
                url: "{{ route('/meeting/getParticipant') }}",
                method: "GET",
                data: {
                    meetingId: meetingId
                },
                beforeSend: () => {

                }
            })
            .done(res => {
                // console.log('data partisipan')

                const participant = res.ParticipantTabs
                const LParticipant = res.editParticipant

                // console.log(LParticipant);
                // untuk menampilkan edit pada input
                $("#selectParticipanEdit").val(LParticipant).trigger('change.select2');






                const listOfParticipants = $('#listOfParticipants');

                // Menambahkan elemen participant ke dalam listOfParticipants
                $.each(participant, function(index, participant) {
                    const participantHtml = `
                        <div class="col-4">
                            <div class="participant" style="display: flex; align-items: center; margin-bottom: 20px; margin-right: 20px;">
                                <div class="avatar">
                                    <img src="${participant.img_user}" alt="${participant.fullname}" class="participant-img">
                                    <div class="status" id="status_${participant.kehadiran}_${participant.participant}" >
                                        <i class='bx bx-check'></i>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="participant-info" style=" display: flex; flex-direction: column;">
                                            <span class="participant-name fw-bold" style="margin: 0; line-height: 1.5; font-size: 15px;">${participant.fullname}</span>
                                            <span class="participant-role" style="margin-top: -5px; font-size: 13px;">${participant.position_name}</span>
                                            <span class="participant-badge" style="margin-top: -5px; font-size: 13px;">${participant.participant}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;


                    // Menambahkan participantHtml ke listOfParticipants
                    listOfParticipants.append(participantHtml);
                    const statusElement = document.getElementById('status_' + participant
                        .kehadiran + '_' + participant.participant);
                    // console.log(statusElement);
                    if (participant.kehadiran == 1) {


                    } else {
                        statusElement.classList.add('hidden');
                    }
                });


                // Setelah elemen-elemen telah ditambahkan ke dokumen, jalankan loop untuk mengatur tampilan status

                const listOfParticipantAttend = $('#listOfParticipantAttend');
                const allAttendanceCheckbox = `
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="selectAllAttendance">
                        <label class="form-check-label" for="selectAllAttendance">
                            All Attendance
                        </label>
                    </div>
                `;
                // Menambahkan allAttendanceCheckbox ke listOfParticipants
                listOfParticipantAttend.prepend(allAttendanceCheckbox);



                // Menangani peristiwa saat checkbox "All Attendance" diubah
                $('#selectAllAttendance').on('change', function() {
                    const isChecked = $(this).prop('checked');
                    $('.menuCheck').prop('checked', isChecked);
                });



                $.each(participant, function(index, participant) {
                    const participantHtml = `
                    <div class="form-check mt-2">
                                            <input class="form-check-input menuCheck" type="checkbox"
                                                data-attendance="${participant.participant}" value="${participant.participant}"
                                                id="attendance${participant.participant}"
                                                name="attendance${participant.participant}" data-operation="insert">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                ${participant.fullname}
                                            </label>
                                        </div>
    `;

                    // Menambahkan participantHtml ke listOfParticipants
                    listOfParticipantAttend.append(participantHtml);

                });

                const selectAllAttendanceCheckbox = $('#selectAllAttendance');
                const menuCheckboxes = $('.menuCheck');
                // Menangani peristiwa saat setiap kotak centang "menuCheck" diubah
                selectAllAttendanceCheckbox.on('change', function() {
                    const isChecked = $(this).prop('checked');
                    menuCheckboxes.prop('checked', isChecked);
                });

                // Menangani peristiwa saat setiap kotak centang "menuCheck" diubah
                menuCheckboxes.on('change', function() {
                    // Memeriksa apakah semua kotak centang (kecuali "All Attendance") dicentang
                    const allChecked = menuCheckboxes.length === menuCheckboxes.filter(':checked')
                        .length;
                    selectAllAttendanceCheckbox.prop('checked', allChecked);
                });
                // menuCheckboxes.on('change', function() {
                //     // Memeriksa apakah semua kotak centang (kecuali "All Attendance") dicentang
                //     const allChecked = menuCheckboxes.length === menuCheckboxes.filter(':checked')
                //         .length;

                //     console.log(allChecked)
                //     if (allChecked == true) {
                //         const isChecked = $(this).prop('checked');
                //         $('#selectAllAttendance').prop('checked', isChecked);
                //     } else {
                //         $('#selectAllAttendance').prop('checked', false);

                //     }
                //     // const isChecked = $(this).prop('checked');

                // });


                const attendanceId = res.ParticipantTabs.map(v => v.kehadiran);

                const participanId = res.ParticipantTabs.map(v => v.participant);
                // console.log(attendanceId);

                for (let i = 0; i < Math.min(attendanceId.length, participanId.length); i++) {
                    if (attendanceId[i] === 1) {
                        const checkbox = $(`#attendance${participanId[i]}`);
                        const isChecked = true;
                        checkbox.prop('checked', isChecked);
                    }
                }

                // for (let number of participanId) {

                //     const checkbox = $(`#attendance${number}`);
                //     const isChecked =
                //         true; // Anda ingin semua checkbox yang ada dalam array ini di-check
                //     checkbox.prop('checked', isChecked);
                //     // Mendapatkan indeks dari elemen di array attendanceId

                // }

            })




        function convertDateToRelative(dateString) {
            const today = new Date();
            const targetDate = new Date(dateString);

            // const timeDiff = today - targetDate;
            // const daysDiff = timeDiff / (1000 * 60 * 60 * 24);

            const timeDiff = today - targetDate;
            const secondsDiff = timeDiff / 1000; // Ubah ke detik

            if (secondsDiff < 20) {
                return 'Just now';
            } else if (secondsDiff < 60) {
                return Math.floor(secondsDiff) + ' second ago';
            } else if (secondsDiff < 300) {
                const minutes = Math.floor(secondsDiff / 60);
                const roundedMinutes = Math.ceil(minutes / 5) * 5;
                return `${roundedMinutes} minutes ago`;
            } else if (secondsDiff < 3600) {
                const minutes = Math.floor(secondsDiff / 60);
                const roundedMinutes = Math.ceil(minutes / 5) * 5;
                return `${roundedMinutes} minutes ago`;
            } else if (secondsDiff < 7200) {
                return '1 hour ago';
            } else if (secondsDiff < 14400) {
                return '2 hours ago';
            } else if (secondsDiff < 21600) {
                return '3 hours ago';
            } else if (secondsDiff < 25200) {
                return 'Today';
            } else if (secondsDiff < 604800) {
                const days = Math.floor(secondsDiff / 86400);
                return `${days} days ago`;
            } else if (secondsDiff < 1209600) {
                return '1 weeks ago';
            } else if (secondsDiff < 2419200) {
                const weeks = Math.floor(secondsDiff / 604800);
                return `${weeks} weeks ago`;
            } else if (secondsDiff < 2678400) {
                return '1 month ago';
            } else if (secondsDiff < 5356800) {
                const months = Math.floor(secondsDiff / 2419200);
                return `${months} months ago`;
            }
            // if (daysDiff < 1) {
            //     return 'Today';
            // } else if (daysDiff < 2) {
            //     return 'Yesterday';
            // } else if (daysDiff < 7) {
            //     return Math.floor(daysDiff) + ' days ago';
            // } else if (daysDiff < 30) {
            //     const weeks = Math.floor(daysDiff / 7);
            //     return weeks + ' weeks ago';
            // } else {
            //     const months = Math.floor(daysDiff / 30);
            //     return months + ' months ago';
            // }
        }
        $.ajax({
                url: "{{ route('/meeting/getTanggapan') }}",
                method: "GET",
                data: {
                    meetingId: meetingId
                },
                beforeSend: () => {

                }
            })
            .done(res => {
                const tanggapan = res.TanggapanList;


                const listOfTanggapan = $('#listOfTanggapan');
                const noRespon = $('#noRespon');

                if (tanggapan.length === 0) {
                    noRespon.append(
                        ' <div class="mt-5"style="text-align: center;" color="#D3D3D3;">There has been no response</div>'
                    );
                } else {
                    $.each(tanggapan, function(index, tanggapan) {
                        const createdDate = new Date(tanggapan
                            .createdate); // Ubah string menjadi objek tanggal
                        const relativeDate = convertDateToRelative(
                            createdDate); // Gunakan objek tanggal dalam fungsi
                        const tanggapanHtml = `
                    <div class="card-body  mt-4 mx-2 my-2 mb-4">
                                                        <div class="row">
                                                            <div class="col-10">
                                                                <div class="response"
                                                                    style="display: flex; align-items: center; margin-bottom: 20px; margin-right: 20px;">
                                                                    <img src=${tanggapan.img_user}
                                                                        alt="${tanggapan.fullname}"
                                                                        class="participant-img"
                                                                        style="width: 50px; height: 50px; border-radius: 50%; margin-right: 10px;">
                                                                    <div class="row">
                                                                        <div class="col-sm-12">
                                                                            <div class="participant-info"
                                                                                style=" display: flex; flex-direction: column;">
                                                                                <span class="participant-name fw-bold"
                                                                                    style="margin: 0; line-height: 1.5; font-size: 15px;">${tanggapan.fullname}</span>
                                                                                <span class="participant-role"
                                                                                    style="margin-top: -5px; font-size: 11px;">${tanggapan.position_name}</span>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-2 mt-2">
                                                                <p class="fs-6 text-muted" style="float:right;">${relativeDate}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <span>${tanggapan.tanggapan}</span>
                                                        </div>
                                                    </div>
                                                    <hr
                                                        style=" border: none; border-top: 1px solid #a5a5a5; margin: 0; clear: both;" />
                    `;

                        // Menambahkan tanggapanHtml ke listOfTanggapan
                        listOfTanggapan.append(tanggapanHtml);
                    });
                }



            })

    });

    // get history by meeting id
</script>

<script>
    const dataRiwayatById = (
        meetingId = ""
    ) => {

        function convertDateToRelative(dateString) {
            const today = new Date();
            const targetDate = new Date(dateString);

            const timeDiff = today - targetDate;
            const daysDiff = timeDiff / (1000 * 60 * 60 * 24);

            if (daysDiff < 1) {
                return 'Today';
            } else if (daysDiff < 2) {
                return 'Yesterday';
            } else if (daysDiff < 7) {
                return Math.floor(daysDiff) + ' days ago';
            } else if (daysDiff < 30) {
                const weeks = Math.floor(daysDiff / 7);
                return weeks + ' weeks ago';
            } else {
                const months = Math.floor(daysDiff / 30);
                return months + ' months ago';
            }
        }

        // memformat menjadi 13 Jul 2023
        function formatDate(dateString) {
            const options = {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            };
            const targetDate = new Date(dateString);

            return targetDate.toLocaleString('en-GB', options);
        }

        function extractTime(dateTimeString) {
            const targetDate = new Date(dateTimeString);
            const hours = targetDate.getHours().toString().padStart(2, '0');
            const minutes = targetDate.getMinutes().toString().padStart(2, '0');

            return `${hours}:${minutes}`;
        }


        // console.log('a');
        if (meetingId !== "") {
            $.ajax({
                url: '{{ route('requestriwayatbyid') }}',
                method: 'get',
                data: {
                    meetingId
                },
                beforeSend: function() {
                    $('#containerRiwayatClock').empty()
                    $('#containerRiwayatStatus').html(loadSpin);
                }
            }).done(res => {

                const {
                    response
                } = res
                let htmlRight = '';

                if (response.data.length > 0) {
                    // html left
                    // console.log(res)
                    let htmlLeft = '';
                    $.each(response.data, (i, v) => {
                        const relativeDate = convertDateToRelative(v.createdate);
                        const formattedDate = formatDate(v.createdate);
                        const extractedTime = extractTime(v.createdate);
                        htmlLeft +=
                            ` 

                            <div class="mb-4">
                                <p class="fw-bold mb-0">${formattedDate}</p>
                                <span class="text-muted">${extractedTime}</span>
                            </div>
                                        

                            `;


                    })
                    $('#containerRiwayatClock').html(htmlLeft);
                    // end html left
                    // html right

                    // kode backup history

                    // <li class="step step--done">
                    //         <div class="step__title text-dark">${v.status_name_eng} ${v.rolelevel_name} - (${v.createby})</div>
                    //         <p class="step__detail text-secondary">${v.remark === null ? '' : 'Remark: ' + v.remark}</p>
                    //         ${v.remark === null ? '<p class="mb-0 step__detail text-secondary text-white">-</p>' : ''}
                    //         <div class="step__circle">
                    //             <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    //                 <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    //                 <path d="M5 12l5 5l10 -10"></path>
                    //             </svg>
                    //         </div>
                    //     </li>

                    htmlRight += '<ul>';
                    $.each(response.data, (i, v) => {
                        htmlRight +=
                            `
                            
                            <li class="step step--done">
                                <div class="step__title text-dark">${v.status_name_eng} - (${v.createby})</div>
                                <p class="step__detail ${v.remark == '' || v.remark == null ? 'text-white' : 'text-secondary'}">${v.remark == '' || v.remark == null ? "-" : v.remark}</p>
                                <div class="step__circle">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M5 12l5 5l10 -10"></path>
                                    </svg>
                                </div>
                            </li>


                           
                            
                            `;
                    })
                    htmlRight += '</ul>';
                    // end html right
                    $('#containerRiwayatStatus').html(htmlRight);
                } else {
                    $('#containerRiwayatClock').empty()
                    $('#containerRiwayatStatus').empty()
                    $('#containerRiwayatStatus').html('<p>Dont have history for this record.</p>');
                }
            })
        }
    }
</script>
