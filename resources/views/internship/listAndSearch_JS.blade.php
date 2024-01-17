{{-- 2 --}}

{{-- Function List, Search,Filter --}}
<script>
    const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
                <div class="spinner-border d-flex justify-content-center align-items-center text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
            </div> `;

    const getListInternship = () => {
        const txtSearch = $('#txSearch').val().toUpperCase();
        const tahunDropdown = $('#tahunDropdown').val();
        const monthFilter = $('#monthFilter').val();
        const deptFilter = $('#selectDept').val();
        const dateRange = $('#dateRange').val();
        const selectDeptFilter = $('#selectDeptFilter').val();



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
            txSearch: txtSearch,
            selectDeptFilter,
            dateRange,
        });
        $.ajax({
                url: "{{ route('/internship/getList') }}",
                method: "GET",
                data,
                beforeSend: () => {
                    $('#containerInternship').html(loadSpin)
                }
            })
            .done(res => {

                $('#containerInternship').html(res)

                $('#tableInternship').DataTable({
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
    getListInternship();

    // insialisasi search ketika diketik
    $('#txSearch').keyup(function(e) {
        var inputText = $(this).val();
        if (inputText.length >= 2 || inputText.length == 0) {
            getListInternship();
        }
    })



    const btnReset = $('#btnReset');

    btnReset.click(e => {
        e.preventDefault();

        // modalFormExport.modal('show');
        $('#txSearch').val('');
        $('#monthFilter').val('');
        $('#selectDept').val('');

        var tahunSekarang = new Date().getFullYear();
        // Mengatur nilai dropdown tahun
        $('#tahunDropdown').val(tahunSekarang);
        const dateRange = $('#dateRange').val('');
        $('input[type="checkbox"]').prop('checked', false);
        const selectDeptFilter = $('#selectDeptFilter').val('').trigger('change');

        getListInternship();
    });


    $('#tahunDropdown').on('change', function(e) {
        getListInternship();
    })
    $('#monthFilter').on('change', function(e) {
        getListInternship();
    })
    $('#selectDept').on('change', function(e) {
        getListInternship();
    })

    /** 
     * Fungsi filter
     **/
    const btnFilter = $('#btnFilter');
    const modalFormFilter = $('#modalFilter');
    const btnFilterData = $('#btnFilterData');

    btnFilter.click(e => {
        e.preventDefault();
        modalFormFilter.modal('show');
    });

    // Date Range
    flatpickr("#dateRange", {
        enableTime: false,
        dateFormat: "d/m/Y",
        minuteIncrement: 1,
        mode: "range"
    });
    // Date Range
    flatpickr("#dateRangeD", {
        enableTime: false,
        dateFormat: "d/m/Y",
        minuteIncrement: 1,
        mode: "range"
    });
</script>

{{-- Function Modal View Attachment --}}
<script>
    $(document).on('click', '.btnAttach', function(e) {
        const modalViewAttach = $('#modalView');
        modalViewAttach.modal('show')

        e.preventDefault();
        var badgeId = $(this).data('id');
        var date = $(this).data('date');

        console.log(badgeId, date);
        // lakukan ajax untuk mengambil image
        $.ajax({
            url: "{{ route('/internship/getAttach') }}",
            method: "GET",
            data: {
                badgeId: badgeId,
                date
            },
        }).done(res => {
            console.log(res);
            const viewAttachment = res.viewAttachment;

            console.log(viewAttachment);
            $('#img-attach').attr('src', viewAttachment.attachment);
        })
    });
</script>
