<script>
    $('#formEditEvent').on('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: "Do you want to Edit this Event?",
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
                        url: "{{ route('/calendar/update') }}",
                        method: "POST",
                        data: new FormData(this),
                        cache: false,
                        processData: false,
                        contentType: false,
                    })
                    .done(res => {
                        showMessage('success', "Event was successfully update!")


                        location.reload(true)
                        $('#modalEdit').modal('hide');
                    })


            }
        })
    })
</script>
