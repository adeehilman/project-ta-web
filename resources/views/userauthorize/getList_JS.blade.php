<script>
    // console.log('1');
    const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
                <div class="spinner-border d-flex justify-content-center align-items-center text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
            </div> `;

    

             
    // console.log(txtSearch);
    const getListUserRole = () => {

        const txtSearch = $('#txSearch').val().toUpperCase();   

        $.ajax({
            url: "{{ route('/userauthorize/getList')}}",
            method: "GET",
            data: {
                txSearch: txtSearch,
            },
            beforeSend: () => {
                $('#containerUserAuthorize').html(loadSpin)
            }
        })
        .done(res => {
            $('#containerUserAuthorize').html(res)
            $('#tableUserRole').DataTable({
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

    getListUserRole();

    $('#txSearch').keyup(function(e) {
        var inputText = $(this).val();
        if (inputText.length >= 2 || inputText.length == 0) {
            getListUserRole();
        }
        $('#resetButton').show();
    })

    // Jquery untuk Button reset
    $(document).ready(function() {
            $('#resetButton').hide();
            $('#selectPosition').change(function() {
                if ($(this).val() === 'allPosition') {
                    $('#resetButton').hide();
                } else {
                    $('#resetButton').show();
                }
            });

            // ketika button reset ditekan maka akan kembali ke opsi all position
            $('#resetButton').click(function() {
                $('#selectPosition').val('allPosition');
                $('#txSearch').val('');
                $(this).hide();
                getListUserRole();
            });
        });
</script>