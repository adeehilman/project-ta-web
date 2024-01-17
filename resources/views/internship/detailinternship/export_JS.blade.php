<script>
    // open modal Export
    const btnExportsDetail = $('#btnExportsDetail');
    const modalFormExport = $('#modalExport');


    const BadgeId = '{{ $attend->badge_id }}';
    const Fullname = '{{ $attend->fullname }}';
    const DeptName = '{{ $attend->dept_name }}';
    const totPresent = '{{ $attend->total_present }}';
    const totAbsent = '{{ $attend->total_absent }}';
    const totNotAttend = '{{ $attend->total_not_attend }}';

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
            const monthFilter = $('#bulanDropdown').val();
            const yearFilter = $('#tahunDropdown').val();
            const EmployeeNo = $('#EmployeeNo').text();
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('/internship/detailInternship/personExport') }}", // Ganti dengan URL yang sesuai
                    type: 'GET',
                    data: {
                        monthFilter,
                        yearFilter,
                        badge_id: EmployeeNo,
             
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
                        link.download = 'Daily_Internship_'+ EmployeeNo +'.xlsx';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        showMessage('success', "Report was succesfully export!")

                    },
                    error: function(error) {
                        showMessage('error', "Something wrong!")
                    }
                });


            }
        })

    });
</script>
