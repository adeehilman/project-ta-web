<script>
    // open modal Export
    const btnExportsDetail = $('#btnExportsDetail');
    const modalFormExport = $('#modalExport');


    const ParticipantBadge = '{{ $total->participant }}';
    const Fullname = '{{ $total->fullname }}';
    const DeptName = '{{ $total->dept_name }}'
    const TimeDetail = '{{ $time }}';
    const TimeDB = '{{ $total->meeting_dates }}';
    const TotMeeting = '{{ $total->tot_meeting }}';
    const Kehadiran = '{{ $total->kehadiran }}';
    const Absent = '{{ $total->absent }}';

    console.log(Fullname);



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
                    url: "{{ route('/meetingsummary/exportDetail') }}", // Ganti dengan URL yang sesuai
                    type: 'GET',
                    data: {
                        ParticipantBadge,
                        Fullname,
                        DeptName,
                        TimeDetail,
                        TimeDB,
                        TotMeeting,
                        Kehadiran,
                        Absent,
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

                        showMessage('success', "Meeting was succesfully export!")

                    },
                    error: function(error) {
                        showMessage('error', "Something wrong!")
                    }
                });


            }
        })

    });
</script>
