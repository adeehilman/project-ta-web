<script>

    // DATATABLE LIST PERSONAL

    $(document).ready(function() {
        $('#tablePersonalList').DataTable({
            searching: false,
            lengthChange: false,
            "bSort": true,
            "aaSorting": [],
            pageLength: 5,
            "lengthChange": false,
            responsive: true,
            language: { search: "" }
        });
    });

     // DATATABLE LIST RIWAYAT PENDIDIKAN

     $(document).ready(function() {
        $('#tableRiwayatPendidikan').DataTable({
            searching: false,
            lengthChange: false,
            "bSort": true,
            "aaSorting": [],
            pageLength: 10,
            "lengthChange": false,
            responsive: true,
            language: { search: "" }
        });
    });

     // DATATABLE LIST KONTAK

     $(document).ready(function() {
        $('#tableKontak').DataTable({
            searching: false,
            lengthChange: false,
            "bSort": true,
            "aaSorting": [],
            pageLength: 10,
            "lengthChange": false,
            responsive: true,
            language: { search: "" }
        });
    });

    
     // DATATABLE LIST DOMISILI

     $(document).ready(function() {
        $('#tableDomisili').DataTable({
            searching: false,
            lengthChange: false,
            "bSort": true,
            "aaSorting": [],
            pageLength: 10,
            "lengthChange": false,
            responsive: true,
            language: { search: "" }
        });
    });

</script>
<script>

    var currentUrl = window.location.href;
    var path = currentUrl.split('?')[0];
    var idParam = path.split('/').pop();

    $('.btnReject').click(function(e){

        $('#modalCloseTicketTolak').modal('show');

    });

    $('#btnSubmitReject').click(function(e){

        const id = idParam;
        const btnreject = $('btnSubmitReject');
        const reasonReject = $('#reasoncloseticketTolak').val();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');


        console.log(reasonReject);

        if (reasonReject == '' || reasonReject == null) {
            $('#err-reasoncloseticketTolak').removeClass('d-none');
        } else {
            $('#err-reasoncloseticketTolak').addClass('d-none');

            Swal.fire({
                title: "Apakah kamu ingin menolak pengajuan ini ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('tolakpengkinian') }}',
                        data: {
                            id: id,
                            badgeid: badgeid,
                            adminbadge: adminbadge,
                            alasan: reasonReject,
                            _token: csrfToken
                        },
                        beforeSend: function () {
                            btnreject.prop('disabled', true);
                        },
                        success: function (response) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: "Pengkinian data telah ditolak",
                                showConfirmButton: false,
                                timer: 3000
                            });

                            $('#modalCloseTicketTolak').modal('hide');
                            location.reload();
                        } // Moved the closing parenthesis here
                    });
                }
            });
        }

    });

    $('#modalCloseTicketTolak').on('hidden.bs.modal', function (e) {
        $('#err-reasoncloseticket').addClass('d-none');
        $('#reasoncloseticketTolak').val('')
    });




    // APPROVE

    $('.btnApprove').click(function(e){

        $('#modalCloseTicketSetuju').modal('show');

    });

    $('#btnSubmitApprove').click(function(e){

        const id = idParam;
        const btnapprove = $('btnSubmitApprove');
        const reasonApprove = $('#reasoncloseticketSetuju').val();
        const csrfToken = $('meta[name="csrf-token"]').attr('content');

                
        if (reasonApprove == '' || reasonApprove == null) {
                $('#err-reasoncloseticketSetuju').removeClass('d-none');
            } else {
                $('#err-reasoncloseticketSetuju').addClass('d-none');
        }

        if (
            reasonApprove != '' 
        ) {
        Swal.fire({
            title: "Apakah kamu menyetujui pengajuan ini ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya', 
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {

                // ui.item.find(".closed").removeClass("closed");
                // ui.item.find(".border-0.rounded").addClass("approved");

                $.ajax({
                        type: "POST",
                        url: '{{ route('terimapengkinian') }}',
                        data: {
                            id: id,
                            badgeid: badgeid,
                            adminbadge: adminbadge,
                            alasan: reasonApprove,
                            _token: csrfToken
                        },
                        beforeSend: function () {
                            btnapprove.prop('disabled', true);
                        },
                        success: function (response) {
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: "Pengkinian Data telah disetujui.",
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#modalCloseTicketSetuju').modal('hide');
                            // location.reload();
                        } // Moved the closing parenthesis here
                    });
            }
        });
    }

    });

    $('#modalCloseTicketSetuju').on('hidden.bs.modal', function (e) {
        $('#err-reasoncloseticketSetuju').addClass('d-none');
        $('#reasoncloseticketSetuju').val('')
    });


</script>