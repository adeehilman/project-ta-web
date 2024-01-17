<script>
    // open modal Filter

    const btnFilter = $('#btnFilter');
    const modalFormFilter = $('#modalFilter');
    const btnFilterData = $('#btnFilterData');

    btnFilter.click(e => {
        e.preventDefault();
        modalFormFilter.modal('show');
    });


    // ketika form submit diklik
    $('#btnFilterData').on('click', function(e) {
        e.preventDefault();

        const txtSearch = $('#txSearch').val().toUpperCase();

        const selectRoom = $('#selectRoom').val();
        const selectStatus = $('#selectStatus').val();
        const filtertime = $('input[name="timeFilter"]:checked').val();
        const allRoomFilter = $('#allRoomFilter').is(':checked');



        if (selectRoom == '' || selectRoom == null) {
            $('#err-selectRoomFilter').removeClass('d-none');
        } else {
            $('#err-selectRoomFilter').addClass('d-none');
        }

        if (allRoomFilter == true) {
            $('#err-selectRoomFilter').addClass('d-none');
        }

        if (filtertime == '' || filtertime == null) {
            $('#err-filtertime').removeClass('d-none');
            return
        } else {
            $('#err-filtertime').addClass('d-none');
        }

        if (

            (allRoomFilter && filtertime != '') || // Jika checkbox "All Rooms" dicentang
            (selectRoom != '' && filtertime != '')
        ) {


            $.ajax({
                    url: '{{ route('/meeting/filter') }}',
                    method: 'get',
                    data: {
                        txSearch: txtSearch,
                        selectRoom,
                        filtertime,
                        selectStatus,
                    },
                    beforeSend: () => {
                        $('#containerMeeting').html(loadSpin)
                    }
                })
                .done(res => {
                    $('#containerMeeting').html(res)
                    $('#tableMeeting').DataTable({
                        searching: false,
                        lengthChange: false,
                        order: [], // Menghilangkan pengurutan default
                        columnDefs: [{
                                targets: 'sortable',
                                orderable: false
                            } // Mengaktifkan pengurutan pada kolom-kolom yang memiliki kelas "sortable"
                        ],
                    });
                    modalFormFilter.modal('hide');

                })
                .fail(err => {
                    showMessage('error', 'Sorry! we failed to filter data')
                })
        }


    });

    // reset data modal filter saat di close
    $('#btnFilter').on('click', function(e) {
        const modalFormFilter = $('#modalFilter')
        modalFormFilter.modal('show')
        $('#err-selectRoomFilter').addClass('d-none');
        $('#err-filtertime').addClass('d-none');
        $('#selectStatus').val('');
        $('#selectStatus').prop('selected', true);
        $('#allRoomFilter').prop('checked', false);

        $('#selectRoom').prop('disabled', false);

        $('#selectRoom').val([]).trigger('change');
        // $('input[name="timeFilter"]').prop('checked', false);

    });

    $('#allRoomFilter').on('change', function(e) {
        if (this.checked) {
            $('#selectRoom').val('');
            $('#selectRoom').prop('disabled', true);

            $('#selectedRoomCount').text('All Room Selected');
        } else {
            $('#selectRoom').prop('disabled', false);
            $('#selectedRoomCount').text('0 Room Selected');
        }


    });

    $('#btnResetF').on('click', function(e) {
        e.preventDefault();

        $('#err-selectRoomFilter').addClass('d-none');
        $('#err-filtertime').addClass('d-none');
        $('#selectStatus').val('');
        $('#selectStatus').prop('selected', true);

        $('#selectRoom').val([]).trigger('change');
        $('input[name="timeFilter"]').prop('checked', false);

    })

    // reset filter
    $('#btnReset').on('click', function(e) {
        e.preventDefault();

        const url = window.location.href
        console.log(url.includes("filter"));
        if (url.includes("filter") || url.includes("now")) {
            window.location.href = '{{ route('meeting') }}'
            return;
        } else {

            $('#modalFilter').val('')
            getListMeetingRoom()
            $('#txSearch').val('')

        }
    })
</script>
