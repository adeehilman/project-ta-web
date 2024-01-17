<script>
    // open modal Export
    const btnExportsDetail = $('#btnExportsDetail');
    const modalFormExport = $('#modalExport');


    const IdRoom = '{{ $total->id }}';
    const HeadDataRoom = '{{ $total->room_name }}';
    const TimeDetail = '{{ $time }}';
    const TimeDB = '{{ $total->meeting_dates }}';
    const TotMeeting = '{{ $total->meeting_count }}';

    // console.log(Fullname);



    btnExportsDetail.click(e => {
        e.preventDefault();
        // modalFormExport.modal('show');
        // $('#allRoom').prop('checked', false)
        // showMessage('info', 'Under Development');


        Swal.fire({
            title: "Do you want to Export Detail Meeting?",
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
                    url: "{{ route('/roomsummary/exportDetail') }}", // Ganti dengan URL yang sesuai
                    type: 'GET',
                    data: {
                        HeadDataRoom,
                        TimeDetail,
                        TimeDB,
                        TotMeeting,
                        IdRoom,
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    success: function(response) {
                        // Buat objek URL untuk file blob
                        var blobUrl = URL.createObjectURL(response);

                        // Buat link untuk mengunduh file
                        var link = document.createElement('a');
                        link.href = blobUrl;
                        link.download = 'Meeting_Report.xlsx';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        showMessage('success',
                            "Room Summary Detail was succesfully export!")

                    },
                    error: function(error) {
                        showMessage('error', "Something wrong!")
                    }
                });


            }
        })

    });
</script>
