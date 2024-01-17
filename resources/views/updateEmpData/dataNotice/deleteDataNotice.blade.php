<script>
    $(document).on('click', '#btndelete', function (e) {
    e.preventDefault();

    const id = $(this).data('id');
    console.log(id);

    Swal.fire({
        title: "Apakah kamu yakin menghapus Pengumuman?",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#6e7881',
        confirmButtonColor: '#dd3333',
        cancelButtonText: 'Tidak',
        confirmButtonText: 'Ya',
        reverseButtons: true,
        customClass: {
            confirmButton: "swal-confirm-right",
            cancelButton: "swal-cancel-left"
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "GET",
                url: '{{ route('hapusnotice') }}',
                data: {
                    id: id
                },
                success: function (response) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title:  response.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                    getListNotice();
                },
                error: function (error) {
                    // Handle error
                    console.log('AJAX request failed', error);
                }
            });
        }
    });
});

</script>