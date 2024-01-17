<script>
    const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
                <div class="spinner-border d-flex justify-content-center align-items-center text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
            </div> `;

    // get list User
    const getListUser = () => {
        const txtSearch = $('#txSearch').val().toUpperCase();
        const positionId = $('#selectPosition').val();

        $.ajax({
                url: "{{ route('/user/getlistuser') }}",
                method: "GET",
                data: {
                    txSearch: txtSearch,
                    idPosition: positionId

                },
                beforeSend: () => {
                    $('#containerUser').html(loadSpin)
                }
            })
            .done(res => {
                $('#containerUser').html(res)
                $('#tableUser').DataTable({
                    searching: false,
                    lengthChange: false,
                    sort: true,
                });
            })
    }
    getListUser();

    // insialisasi search ketika diketik
    $('#txSearch').keyup(function(e) {
        var inputText = $(this).val();
        if (inputText.length >= 2 || inputText.length == 0) {
            getListUser();
        }
    })

   
</script>
