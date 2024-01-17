<script>
    // modal show modal export
    // open modal Export
    const btnExport = $('#btnDailyExport');
    const modalFormExport = $('#modalExportDaily');

    btnExport.click(e => {
        e.preventDefault();
        modalFormExport.modal('show');

        $('#dateRangeD').val('');
      
        // $('#allRoom').prop('checked', false)
        // showMessage('info', 'Under Development');

    });

    $('#formExportDaily').on('submit', function(e){
        e.preventDefault();

        Swal.fire({
            title: "Do you want to Export Daily?",
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
                const deptDaily = $('#selectDeptExportD').val().toUpperCase();
                const dateDaily = $('#dateRangeD').val();
                $.ajax({
                    url: "{{ route('/internship/dailyExport') }}", // Ganti dengan URL yang sesuai
                    type: 'GET',
                    data: {
                        deptDaily,
                        dateDaily,
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    beforeSend: () => {
                        $('#SpinnerBtnExportDaily').removeClass('d-none')
                        $('#SpinnerBtnExportDaily').prop('disabled', true);
                        $('#btnExportDaily').hide();
                    },
                    success: function(response) {

                        $('#SpinnerBtnExportDaily').addClass('d-none')
                        $('#btnExportDaily').show()
                        $('#SpinnerBtnExportDaily').prop('disabled', false);
                        // Buat objek URL untuk file blob
                        var blobUrl = URL.createObjectURL(response);

                        // Buat link untuk mengunduh file
                        var link = document.createElement('a');
                        link.href = blobUrl;
                        link.download = 'Daily_Internship_'+ dateDaily +'.xlsx';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        showMessage('success', "Meeting was succesfully export!")
                        $('#modalExportDaily').modal('hide');
                    },
                    error: function(error) {
                        showMessage('error', "Something wrong!")
                    }
                });


            }
        })
    })
   

    $('#btnsimpanExport').on("click", function(e) {

        e.preventDefault();
        const modalExport = $('#modalExport');



    })
</script>


<script>
     const btnExportMonthly = $('#btnMonthlyExport');
    const modalFormExportM = $('#modalExportMonthly');




    btnExportMonthly.click(e => {
        e.preventDefault();
        modalFormExportM.modal('show');
        // $('#allRoom').prop('checked', false)
        // showMessage('info', 'Under Development');
        $('#monthExport').val('');
    });

    $('#formExportMonthly').on('submit', function(e){
        e.preventDefault();

        Swal.fire({
            title: "Do you want to Export Monthly?",
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
                const deptMonthly = $('#selectDeptMonthly').val().toUpperCase();
                const monthExport = $('#monthExport').val();
                $.ajax({
                    url: "{{ route('/internship/monthExport') }}", // Ganti dengan URL yang sesuai
                    type: 'GET',
                    data: {
                        deptMonthly,
                        monthExport,
                    },
                    xhrFields: {
                        responseType: 'blob'
                    },
                    beforeSend: () => {
                        $('#SpinnerBtnExportMonthly').removeClass('d-none')
                        $('#SpinnerBtnExportMonthly').prop('disabled', true);
                        $('#btnExportMonthly').hide();
                    },
                    success: function(response) {
                        $('#SpinnerBtnExportMonthly').addClass('d-none')
                        $('#btnExportMonthly').show()
                        $('#SpinnerBtnExportMonthly').prop('disabled', false);

                        // Buat objek URL untuk file blob
                        var blobUrl = URL.createObjectURL(response);

                        // Buat link untuk mengunduh file
                        var link = document.createElement('a');
                        link.href = blobUrl;
                        link.download = 'Monthly_Internship_'+ monthExport +'.xlsx';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        showMessage('success', "Meeting was succesfully export!")
                        $('#modalExportMonthly').modal('hide');

                    },
                    error: function(error) {
                        $('#SpinnerBtnExportMonthly').addClass('d-none')
                        $('#btnExportMonthly').show()
                        $('#SpinnerBtnExportMonthly').prop('disabled', false);
                        showMessage('error', "Something wrong!")
                    }
                });


            }
        })
    })

    // Month select Plugin 
    const monthFilterInput = document.getElementById('monthExport');

    // Inisialisasi flatpickr
    const flatpickrInstance = flatpickr(monthFilterInput, {
        plugins: [
            new monthSelectPlugin({
                shorthand: true,
                dateFormat: "F",
                altFormat: "F",
                theme: "light"
            })
        ]
    });


</script>