<script>
    const btnAdd = $('#btnAdd');
    const modalFormAddUser= $('#modalAddUserRole');

        $('#selectEmployeeAdd').val('');
        $('#listView').val('')
        $('#selectRoleAdd').val('');
        $('#allListParticipant').prop('checked', false);

    btnAdd.click(e => {
        e.preventDefault();
        modalFormAddUser.modal('show');

        $('#selectEmployeeAdd').val('').trigger('change')

        $('#selectEmployeeAdd').val('');
        $('#listView').val('')
        $('#defaulView').text('')
        $('#selectRoleAdd').val('');
        $('#allListParticipant').prop('checked', false);
    });

    $('#selectEmployeeAdd').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#formAdd'),
        closeOnSelect: true,
        tags: false,
    });

     // select2 list view
     $('#listView').select2({
        theme: "bootstrap-5",
        width: '100%',
        dropdownParent: $('#formAdd'),
        closeOnSelect: false,
    });

    $('#selectRoleAdd').select2({
        theme: "bootstrap-5",
        dropdownParent: $('#formAdd'),
        closeOnSelect: true,
        tags: false,
    });


    $(document).ready(function() {
        $('#selectEmployeeAdd').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#formAdd'),
            closeOnSelect: true,
            ajax: {
                url: '/user/listEmployee', // URL untuk mengambil data
                dataType: 'json',
                delay: 250, // Waktu tunda sebelum permintaan dikirim
                processResults: function(data) {
                    return {
                        results: data.list_participant_w.map(function(item, index) {
                            var combinedText = data.list_participant_f[index] + ' (' + data
                                .list_participant_p[index] + ')';

                            return {
                                id: item,
                                text: combinedText
                            }

                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 3,


        });
    });

    $('#selectEmployeeAdd').on('select2:select', function(e) {
        // Mendapatkan nilai yang dipilih
        var selectedValue = e.params.data.id;

        console.log(selectedValue);
        // Melakukan AJAX request ke URL meeting berdasarkan nilai yang dipilih
        $.ajax({
            url: '{{ route('/userauthorize/getDept')}}',
            data: {
                selectedValue,
            },
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                $('#defaulView').text(response.DefaultDept);
                // Lakukan sesuatu dengan respons dari AJAX request
                console.log(response);
            },
            error: function(xhr, status, error) {
                // Tangani kesalahan jika ada
                console.error(error);
            }
        });
    });

    //  PROSES INSERT ke dalam database
    $('#formAdd').on('submit', function(e){
        e.preventDefault();


        const selectEmployeeAdd = $("#selectEmployeeAdd").val();
        if (selectEmployeeAdd == '' || selectEmployeeAdd == null) {
            $('#err-selectEmployeeAdd').removeClass('d-none');
        } else {
            $('#err-selectEmployeeAdd').addClass('d-none');
        }

        if(
            selectEmployeeAdd != ''
        ){
            Swal.fire({
                title: "Do you want to Add User Authorization ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed){
                    $.ajax({
                        url: '{{ route('/userauthorize/insert') }}',
                        method: 'POST',
                        data: $('#formAdd').serialize(),
                        beforeSend: () => {
                            $('#SpinnerBtnAdd').removeClass('d-none')
                            $('#SpinnerBtnAdd').prop('disabled', true);
                            $('#btnSimpanAdd').hide();
                        }
                    }).done(res => {
                        if (res.MSGTYPE == 'W') {
                            $('#SpinnerBtnAdd').addClass('d-none')
                            $('#btnSimpanAdd').show()
                            $('#SpinnerBtnAdd').prop('disabled', false);
                            showMessage('warning', res.MSG)
                            return;
                        }

                        $('#SpinnerBtnAdd').addClass('d-none')
                        $('#btnSimpanAdd').show()
                        $('#SpinnerBtnAdd').prop('disabled', false);
                        showMessage('success', "User Authorization has been Added")
                        $('#modalAddUserRole').modal('hide');
                        getListUserRole();
                        location.reload();

                    }).fail(err => {
                        $('#SpinnerBtnAdd').addClass('d-none')
                        $('#btnSimpanAdd').show()
                        $('#SpinnerBtnAdd').prop('disabled', false);
                    })
                }
            })
        }
        return;
    })

</script>
