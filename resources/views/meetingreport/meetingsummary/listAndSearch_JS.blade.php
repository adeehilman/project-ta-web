{{-- 2 --}}

<script>
    const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
                <div class="spinner-border d-flex justify-content-center align-items-center text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
            </div> `;

    const getListSummaryMeeting = () => {
        const txtSearch = $('#txSearch').val().toUpperCase();
        const tahunDropdown = $('#tahunDropdown').val();
        const monthFilter = $('#monthFilter').val();
        const deptFilter = $('#selectDept').val();

        console.log(monthFilter);

        $.ajax({
                url: "{{ route('/meetingsummary/getList') }}",
                method: "GET",
                data: {
                    txSearch: txtSearch,
                    tahunDropdown,
                    monthFilter,
                    deptFilter,
                },
                beforeSend: () => {
                    $('#containerSummaryMeeting').html(loadSpin)
                }
            })
            .done(res => {
                // console.log(res);
                $('#containerSummaryMeeting').html(res)

                $('#tableSummary').DataTable({
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
    getListSummaryMeeting();

    // insialisasi search ketika diketik
    $('#txSearch').keyup(function(e) {
        var inputText = $(this).val();
        if (inputText.length >= 2 || inputText.length == 0) {
            getListSummaryMeeting();
        }
    })



    const btnReset = $('#btnReset');

    btnReset.click(e => {
        e.preventDefault();

        // modalFormExport.modal('show');
        $('#txSearch').val('');
        $('#monthFilter').val('');
        $('#selectDept').val('');
        var tahunSaatIni = new Date().getFullYear();
        $('#tahunDropdown').val(tahunSaatIni);

        getListSummaryMeeting();
    });


    $('#tahunDropdown').on('change', function(e) {
        getListSummaryMeeting();
    })
    $('#monthFilter').on('change', function(e) {
        getListSummaryMeeting();
    })
    $('#selectDept').on('change', function(e) {
        getListSummaryMeeting();
    })
</script>
