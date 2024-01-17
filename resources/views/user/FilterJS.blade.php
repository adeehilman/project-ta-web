{{-- ketika select position filter di pilih --}}
<script>
    // Ketika dropdown "Select Position" berubah
    $('#selectPosition').on('change', function() {
        getFilterUser();
    });

    // Fungsi untuk mendapatkan data user dengan filter
    const getFilterUser = () => {
        const positionId = $('#selectPosition').val();

        $.ajax({
                url: "{{ route('/user/getfilteruser') }}",
                method: "GET",
                data: {
                    idPosition: positionId
                },
                beforeSend: () => {
                    $('#containerUser').html(loadSpin);
                }
            })
            .done(res => {
                $('#containerUser').html(res);
                $('#tableUser').DataTable({
                    searching: false,
                    lengthChange: false,
                    order: [],
                    columnDefs: [{
                        targets: 'sortable',
                        orderable: true
                    }]
                });
            })
    }




    //  btn reset  
    $('#btnReset').on('click', function(e) {
        $('#selectPosition').val('').trigger('change')
        getListUser()
        $('#txSearch').val('')
    })
</script>
