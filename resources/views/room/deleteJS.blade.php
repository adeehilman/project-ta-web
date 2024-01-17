<script>
    // // open modal delete
    $(document).on('click', '.btnDelete', function(e) {
        const id = $(this).data('id');

        Swal.fire({
            title: "Are you sure want to delete room ?",
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
                // lakukan ajax

                $.ajax({
                        url: '{{ url('/Room/delete') }}',
                        method: 'GET',
                        data: {
                            id: id
                        },
                        beforeSend: () => {

                        }
                    })
                    .done(res => {
                        showMessage('success', 'The room has been successfully deleted');
                        setTimeout(() => location.reload(), 2500)
                    })
                    .fail(err => {
                        showMessage('error', 'Sorry! we failed to delete room')
                    })
            }
        })
    });


    //code farhan

    // const btnDelete = $('#btnDelete');
    // const modalFormDelete = $('#modalDeleteRoom');

    // $(document).on('click', '.btnDelete', function(e){
    //     e.preventDefault();
    //     modalFormDelete.modal('show');
    // })

    // // // Jquery Sweetalert jika berhasil klik button delete
    // $(document).ready(function() {
    //     $('#deleteButton').click(function(event) {
    //         event.preventDefault();
    //         Swal.fire({
    //             icon: 'success',
    //             title: 'Success',
    //             text: 'Room has been deleted',
    //             confirmButtonColor: '#CD202e',
    //         }).then(function(result) {
    //             if (result.isConfirmed) {
    //                 $('#modalDetailRoom').modal('hide');
    //                 $('#modalDeleteRoom').modal('hide');
    //             }
    //         });
    //     });
    // });
</script>
