{{-- 3 --}}

{{-- Fungsi Modal Filter (Show Result) --}}
<script>
    $('#formFilterTime').on('submit', function(e) {
        e.preventDefault();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        const txtSearch = $('#txSearch').val().toUpperCase();

        const selectDeptFilter = $('#selectDeptFilter').val();
        const dateRange = $('#dateRange').val();
        const csrfToken = $('meta[name="csrf-token"]').attr('content'); // Ambil token CSRF dari meta tag
        const lineStatus = {};
        // chekk checkbox fasility
        $('[data-attendance]').each(function() {
            const id = $(this).attr('data-attendance'); // Get the value of data-line
            const isChecked = $(this).prop('checked') ? 'true' :
                'false'; // Check if checkbox is checked
            const operation = $(this).data('operation'); // Get the value of data-operation

            if (operation === 'filter') {
                lineStatus['attendance' + id] = isChecked; // Save checkbox status in the object
            }

            // Rename id and class attributes
            $(this).attr('id', 'attendance_' + id);
            $(this).removeClass('menuCheck').addClass('form-check-input');

            // console.log(lineStatus);
        });

        const lineKeys = Object.keys(lineStatus);

        // Use reduce to build the data object
        const data = lineKeys.reduce((result, key) => {
            result[key.replace('attendance', 'attendance_')] = lineStatus[key];
            return result;
        }, {
            _token: csrfToken,
            selectDeptFilter,
            dateRange,
            txtSearch,
        });

        // console.log(data);
        $.ajax({
                url: "{{ route('/internship/getListF') }}",
                method: 'POST',
                data,

                beforeSend: () => {

                }
            })
            .done(res => {

                if (res.MSGTYPE == 'W') {
                    $('#SpinnerBtnAttend').addClass('d-none')
                    $('#btnSimpanAttend').show()
                    $('#SpinnerBtnAttend').prop('disabled', false);
                    showMessage('warning', res.MSG)
                    return;
                }
                $('#modalFilter').modal('hide');
                // $(this)[0].reset();

                getListInternship();
                flatpickr('#dateRange').clear();
                flatpickr('#dateRange').set('mode', 'range');
                $('input[type="checkbox"]').prop('checked', false);
                const selectDeptFilter = $('#selectDeptFilter').val('').trigger('change');
            })
            .fail(err => {

                showMessage('error', 'Sorry! we failed to filter data')

                $('#SpinnerBtnAttend').addClass('d-none')
                $('#btnSimpanAttend').show();
            });

    })
</script>
