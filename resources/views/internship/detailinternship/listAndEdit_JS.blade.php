{{-- 2 --}}

<script>
    const loadSpin = `<div class="d-flex justify-content-center align-items-center mt-5">
                <div class="spinner-border d-flex justify-content-center align-items-center text-danger" role="status"><span class="visually-hidden">Loading...</span></div>
            </div> `;
    // open modal Detail
    const btnDetail = $('#btnDetail');
    const modalDetail = $('#modalDetail');

    const EmployeeNo = $('#EmployeeNo').text();
    const getDetailInternship = () => {
        const monthFilter = $('#bulanDropdown').val();
        const yearFilter = $('#tahunDropdown').val();

        $.ajax({
                url: "{{ route('/internship/detailInternship/getList') }}",
                method: "GET",
                data: {
                    badge_id: EmployeeNo,
                    monthFilter,
                    yearFilter,
                },
                beforeSend: () => {
                    $('#containerDetailIntern').html(loadSpin)
                }
            })
            .done(res => {

                $('#containerDetailIntern').html(res)

                $('#tableDetailIntern').DataTable({
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
            .fail(err => {
                console.log('error', err);
            })


    }
    const getDescInternship = () => {
        const monthFilter = $('#bulanDropdown').val();
        const yearFilter = $('#tahunDropdown').val();
        const EmployeeNo = $('#EmployeeNo').text();
        $.ajax({
                url: "{{ route('/internship/detailInternship/filter') }}",
                method: "GET",
                data: {
                    monthFilter,
                    yearFilter,
                    badge_id: EmployeeNo,
                }
            }).done(res => {
                // $('#ContainerDetailIntern').html(res)
              const Value = res.viewValue;

                console.log(res);
                $('#totalAttend').text(Value.total_present);
                $('#NotAttend').text(Value.total_not_attend);
                $('#Absent').text(Value.total_absent);
                
            });
    }

    getDescInternship();
    getDetailInternship();

    $('#bulanDropdown').on('change', function(e) {
        getDetailInternship();
        getDescInternship();
    })
    $('#tahunDropdown').on('change', function(e) {
        getDetailInternship();
    })

    $('#bulanDropdown').select2({
        theme: "bootstrap-5",
        minimumResultsForSearch: -1
    });
    $('#tahunDropdown').select2({
        theme: "bootstrap-5",
        minimumResultsForSearch: -1

    });
</script>

{{-- Function Modal View Attachment di Detail Internship --}}
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
