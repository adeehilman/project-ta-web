<script>
    // modal show modal export
    // open modal Export
    const btnExport = $('#btnExport');
    const modalFormExport = $('#modalExport');

    const btnExportResult = $('#btnExportResult');
    btnExport.click(e => {
        e.preventDefault();
        modalFormExport.modal('show');

    });



    btnExportResult.click(e => {
        const selectExport = $('#selectRoom2').val();

        const selectStatusExport = $('#selectStatusExport').val();
        const filtertimeExport = $('input[name="timeFilterExport"]:checked').val();
        const allRoomFilterExport = $('#allRoomFilterExport').is(':checked');

        e.preventDefault();
        Swal.fire({
            title: "Do you want to Export Meeting?",
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
                    url: "{{ route('/meeting/export') }}", // Ganti dengan URL yang sesuai
                    type: 'GET',
                    data: {
                        selectExport,
                        selectStatusExport,
                        filtertimeExport,
                        allRoomFilterExport,
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
                        $('#modalExport').modal('hide');

                    },
                    error: function(error) {
                        showMessage('error', "Something wrong!")
                    }
                });


            }
        })

    });
    // 



    // // Checkbox All Room

    $('#allRoomExport').on('change', function(e) {
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

    $('#btnResetExport').on('click', function(e) {
        e.preventDefault();

        $('#selectStatusExport').val('');
        $('#selectSselectStatusExporttatus').prop('selected', true);

        $('#selectRoom2').val([]).trigger('change');
        $('input[name="timeFilterExport"]').prop('checked', false);

    })




    // modal show modal export
</script>
