<script>
    // untuk menampilkan data List Room
    const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
                <div class="spinner-border d-flex justify-content-center align-items-center text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
            </div> `;

    const iconLoad = `<i class="bx bx-loader-alt bx-spin align-middle me-2"></i>`;

    // get list List Room
    const getListRoom = () => {
        const txtSearch = $('#txSearch').val().toUpperCase();
        // const sectionId = $('#selectSection').val()

        //  console.log('a');

        $.ajax({
                url: "{{ route('listRoom') }}",
                method: "GET",
                data: {
                    txSearch: txtSearch
                    // sectionId
                },
                beforeSend: () => {
                    $('#containerRoom').html(loadSpin)
                }
            })
            .done(res => {
                // console.log(res);
                $('#containerRoom').html(res)
                // $('#selectCustomerFilter').val('').select2({
                //     theme: "bootstrap-5",
                // });
                $('#tbl_roommeeting').DataTable({
                    searching: false,
                    lengthChange: false,
                    order: [], // Menghilangkan pengurutan default
                    columnDefs: [{
                            targets: 'sortable',
                            orderable: false
                        } // Mengaktifkan pengurutan pada kolom-kolom yang memiliki kelas "sortable"
                    ],
                });
            })
    }

    // insialisasi get data
    getListRoom()

    // insialisasi search ketika diketik
    $('#txSearch').keyup(function(e) {
        var inputText = $(this).val();
        if (inputText.length >= 1 || inputText.length == 0) {
            getListRoom();
        }
    });

    // $('#selectSection').on('change', function(e) {
    //     getListPicNotif()
    // })
</script>
