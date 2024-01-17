<script>
    // modal show modal export
    // open modal Export
    const btnExport = $('#btnExportSummary');
    const modalFormExport = $('#modalExport');




    btnExport.click(e => {
        e.preventDefault();
        // modalFormExport.modal('show');
        // $('#allRoom').prop('checked', false)
        // showMessage('info', 'Under Development');


        Swal.fire({
            title: "Do you want to Export Meeting Summary?",
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
                const txtSearch = $('#txSearch').val().toUpperCase();
                const tahunDropdown = $('#tahunDropdown').val();
                const monthFilter = $('#monthFilter').val();
                const deptFilter = $('#selectDept').val();
                $.ajax({
                    url: "{{ route('/meetingsummary/export') }}", // Ganti dengan URL yang sesuai
                    type: 'GET',
                    data: {
                        txSearch: txtSearch,
                        tahunDropdown,
                        monthFilter,
                        deptFilter,
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
                        link.download = 'Meeting_Summary_Report.xlsx';
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

    // // Checkbox All Room

    $('#allRoom').on('change', function(e) {
        const isChecked = $(this).prop('checked');
        $(this).val(true)
        if (isChecked) {
            $tes = $('#selectRoom2').val(['']).trigger('change');
            $('#selectRoom2').prop('disabled', true)

            $('#selectedRoomCountExport').text('All Room Selected');

        } else {
            $('#selectRoom2').prop('disabled', false)
            $('#selectedRoomCountExport').text('0 Room Selected');
        }
    })






    $('#btnsimpanExport').on("click", function(e) {

        e.preventDefault();
        const modalExport = $('#modalExport');


        // // Cek apakah semua validasi telah terpenuhi
        // if ($('#err-selectroomexport').hasClass('d-none') && $('#err-selecttimeexport').hasClass('d-none')) {
        //     Swal.fire({
        //         position: 'center',
        //         icon: 'success',
        //         title: "Meeting List data has been exported.",
        //         showConfirmButton: false,
        //         timer: 3000
        //     });

        //     // modalExport.modal('hide');
        // }


        // // validasi room dropdown
        // const roomSelected = $('#selectRoom2').val()
        // let justChecking = true;
        // const isChecked = $('#allRoom').prop('checked');

        // if (isChecked == false) {
        //     if (roomSelected == '') {
        //         $('#err-selectroomexport').removeClass('d-none');
        //         let justChecking = false;

        //     } else {
        //         $('#err-selectroomexport').addClass('d-none');
        //     }
        // } else {
        //     $('#err-selectroomexport').addClass('d-none');
        // }


        // if (
        //     //  
        // ) {

        //     $.ajax({
        //             url: '{{ route('/meeting/export') }}',
        //             method: 'get',
        //             data: {
        //                 // selectRoom2
        //             },
        //             beforeSend: () => {
        //                 $('#containerMeeting').html(loadSpin)
        //             }
        //         })
        //         .done(res => {
        //             showMessage('success', 's')

        //         })
        //         .fail(err => {
        //             showMessage('error', 'Sorry! we failed to filter data')
        //         })



        // } else {
        //     console.log('gagal')
        // }


    })
</script>
