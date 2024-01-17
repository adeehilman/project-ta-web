{{-- btn add --}}
    <script>
        const btnAdd = $('#btnAdd');
        const modalFormAdd = $('#modalAddUser');

  
        btnAdd.click(e => {
            e.preventDefault();
            modalFormAdd.modal('show');
        });


        // ketika button simpan User di klik, lakukan submit

        
        $('#formAddUser').on('submit', function(e) {
            e.preventDefault();

             // validasi Position dropdown
             const Employee = $('#selectEmployeeAdd').val();
            if (Employee === ''  || Employee == null) {
                $('#err-employeeAdd').removeClass('d-none');
                return;
            } else {
                $('#err-employeeAdd').addClass('d-none');
            }

            // validasi Position dropdown
            const position = $('#selectPositionAdd').val();
            if (position === '' || position == null) {
                $('#err-positionAdd').removeClass('d-none');
                return;
            } else {
                $('#err-positionAdd').addClass('d-none');
            }

            // // validasi employee number tidak lebih dari 6 angka
            // if(employeeNo.length > 10){
            //     showMessage('warning', 'Employee Number max length 10')
            //     return;
            // }

            if (
                Employee != '' &&
                position != '' 
            ) {
            $.ajax({
                url: '{{ route('/user/insert') }}',
                method: 'POST',
                data: $(this).serialize(),
                
            }).done(res => {
                console.log(res);

                if (res.MSGTYPE === 'S') {
                    showMessage('success', 'Data User has been successfully saved.')
                    $('#formAddUser')[0].reset();
                    $('#modalAddUser').modal('hide');
                    $(this)[0].reset();
                    getListUser();
                }

                if (res.MSGTYPE !== 'S') {
                    showMessage('error', res.MSG)
                    return;
                }

                        
                    })
                    .fail(err => {
                        

                    })
                 }
                });


            // reset data modal add saat di close
            $('#btnAdd').on('click', function(e) {
                const modalFormAdd = $('#modalAddUser')
                modalFormAdd.modal('show')

                $('#err-employeeAdd').addClass('d-none');
                $('#err-positionAdd').addClass('d-none');
                   
                $('#selectEmployeeAdd').val('').trigger('change')
                $('#selectPositionAdd').val('').trigger('change')

            });


        // select2 position Add
        $(document).ready(function() {
            
            $('#selectEmployeeAdd').select2({
                theme: "bootstrap-5", 
                dropdownParent: $('#modalAddUser'),
                // ajax: {
                //     url: '/meeting/listParticipant', // URL untuk mengambil data
                //     dataType: 'json',
                //     delay: 250, // Waktu tunda sebelum permintaan dikirim
                //     processResults: function(data) {
                //         return {
                //             results: data.list_participant_w.map(function(item, index) {
                //                 return {
                //                     id: item,
                //                     text: data.list_participant_f[
                //                         index] // Menggunakan list_participant_f untuk teks
                //                 }
                //             })
                //         };
                //     },
                //     cache: true
                // },
                // minimumInputLength: 3 // Jumlah karakter minimum sebelum pencarian dimulai

            });
        });


       

       

</script>