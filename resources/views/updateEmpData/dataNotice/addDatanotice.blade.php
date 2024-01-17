<script>

    const btnaddpengumuman = $('#tambahpengumuman');
    const Modaltambahpengumuman = $('#exampleModal');

    const alexsirait = new Date();
    const year = alexsirait.getFullYear();
    const month = (alexsirait.getMonth() + 1).toString().padStart(2, '0');
    const date = alexsirait.getDate().toString().padStart(2, '0');
    const hours = alexsirait.getHours().toString().padStart(2, '0');
    const minutes = alexsirait.getMinutes().toString().padStart(2, '0');
    const formattedDateTime = `${year}-${month}-${date} ${hours}:${minutes}`;

btnaddpengumuman.click(e => {
    e.preventDefault();

    $('#announcement-start-date').val(formattedDateTime);
    $('#announcement-end-date').val(formattedDateTime);

    $("#announcement-description").blur(function (e) {
    
    $('#err-noticeDescription').addClass('d-none');
    });

    $("#announcement-start-date").change(function (e) {
        e.preventDefault();
        $('#err-pengumumanstart').addClass('d-none');
    });

    $("#announcement-end-date").change(function (e) {
        e.preventDefault();
        $('#err-pengumumanend').addClass('d-none');

        const endDate = $('#announcement-end-date').val();
        const startDate = $('#announcement-start-date').val();

        const endDateObj = new Date(endDate);
        const startDateObj = new Date(startDate);
       
        if (endDateObj < startDateObj) {
            showMessage('error', "Masukkan tanggal yang valid");
            $('#announcement-end-date').val(startDate);
        }

        if (endDateObj < alexsirait) {
            showMessage('error', "Masukkan tanggal yang valid");
            $('#announcement-end-date').val(startDate);
        }
        
    });

    
    Modaltambahpengumuman.modal('show');
});


    $(document).ready(function() {
        $('#announcement-now').change(function() {
        var checkbox = $(this);
        var startDateInput = $('#inputstart');
        var colBerakhir = $('#colberakhir');
        var errnotif = $('#err-pengumumanstart');

        if (checkbox.is(':checked')) {
            startDateInput.hide();
            $('#announcement-start-date').val(formattedDateTime);
            colBerakhir.removeClass('col-md-6').addClass('col-md-12');
        } else {
            startDateInput.show();
            colBerakhir.removeClass('col-md-12').addClass('col-md-6');
        }
        
        
    });

    
   
    $('#formtambahnotice').submit(function(e) {
            e.preventDefault();

            // Cek Deskripsi Pengumuman
            const btntambahnotice = $('#btntambahnotice')
            const description = $('#announcement-description').val();
            const endDate = $('#announcement-end-date').val();
            const startDate = $('#announcement-start-date').val();
            const checkbox = $('#announcement-now').is(':checked') ? 1 : 0;
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            if (description.trim() === '') {
                $('#err-noticeDescription').removeClass('d-none');
            } else {
                $('#err-noticeDescription').addClass('d-none');
            }

            if (!$('#announcement-now').is(':checked')) {
                if (startDate.trim() === '') {
                    $('#err-pengumumanstart').removeClass('d-none');
                } else {
                    $('#err-pengumumanstart').addClass('d-none');
                }
            }

            if (endDate.trim() === '') {
                $('#err-pengumumanend').removeClass('d-none');
            } else {
                $('#err-pengumumanend').addClass('d-none');
            }

            if (description !== '' && endDate !== '') {
                $.ajax({
                    type: "POST",
                    url: '{{ route('tambahnotice') }}',
                    data: {
                        endDate: endDate,
                        startDate: startDate,
                        description: description,
                        checkbox: checkbox,
                        _token: csrfToken
                    },
                    beforeSend: function () {
                        btntambahnotice.prop('disabled', true); 
                    },
                    success: function (response) {
                        Swal.fire({
                            title: response.message,
                            icon: 'success',
                            confirmButtonColor: '#db1717',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#exampleModal').modal('hide');
                                getListNotice();
                                btntambahnotice.prop('disabled', false); 
                            }
                        });
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        if (xhr.status === 400) {
                            var errorResponse = JSON.parse(xhr.responseText);
                            Swal.fire({
                                title: 'Error',
                                text: errorResponse.error,
                                icon: 'error',
                                confirmButtonColor: '#db1717',
                                confirmButtonText: 'OK'
                            });
                            btntambahnotice.prop('disabled', false);

                        } else {
                            console.log('AJAX request failed', errorThrown);
                        }
                    }
                });
            } else {
                console.log('Please fill in all required fields before submitting.');
            }
        });
    });


    $('#exampleModal').on('hidden.bs.modal', function (e) { 
        $('#announcement-description').val('');
        $('#announcement-start-date').val(formattedDateTime);
        $('#announcement-end-date').val(formattedDateTime);
    });

</script>