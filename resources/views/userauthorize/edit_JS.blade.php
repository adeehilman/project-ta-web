<script>
     // Jquery untuk Modal Edit User Role
     $(document).on('click', '.btnEdit', function(e) {
        e.preventDefault();

        var UserId = $(this).data('id');
        const modalFormEdit = $('#modalEditUserRole');
        $('#selectEmployeeEdit').val('');
        $('#listViewEdit').val('')
        $('#selectRoleEdit').val('');
        $('#allListParticipantEdit').prop('checked', false);

        modalFormEdit.modal('show');

        $('#selectRoleEdit').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#formEdit'),
            closeOnSelect: true,
            tags: false,
        });

        $('#selectEmployeeEdit').select2({
            theme: "bootstrap-5",
            dropdownParent: $('#formEdit'),
            closeOnSelect: true,
            tags: false,
        });

        $('#listViewEdit').select2({
            theme: "bootstrap-5",
            width: '100%',
            dropdownParent: $('#formEdit'),
            closeOnSelect: false,
        });

        // Ajax request
        $.ajax({
            url: "{{ route('/userauthorize/getVal')}}",
            method: "GET",
            data: {
                UserId: UserId
            },
            dataType: "JSON",
            async: false,
            success: function(response) {
                const valueDept = response.valueDept;
                const checkParticipant = response.checkParticipant;
                const roleInput = response.roleInput.rolemeeting;
                const checkAllDept = response.checkAllDept;
                
                console.log(response);
                $('#selectEmployeeEdit').val(UserId).trigger('change');
                $('#hiddenBadge ').val(UserId).trigger('change');
                
                if (checkParticipant) {
                    $('#allListParticipantEdit').prop('checked', true);
                } else {
                    $('#allListParticipantEdit').prop('checked', false);
                }

                if(checkAllDept === 0){
                    $('#allListViewDeptEdit').prop('checked', false);
                }else{
                    $('#allListViewDeptEdit').prop('checked', true);
                }
                
                // array dept list
                const newArray = valueDept.map(option => {
                    return option; // Sesuaikan dengan format opsi yang valid
                });

                const deptCodeArray = newArray.map(item => item.dept_code);

                // console.log(newArray);
                // Menetapkan nilai pada elemen #listViewEdit
                $('#listViewEdit').val(deptCodeArray).trigger('change');
                
                $('#selectRoleEdit').val(roleInput).trigger('change');

                // $('#listViewEdit').val(valueDept).trigger('change');
                
               




            },
            error: function(err) {
                // console.log(err);
            }
        });
    });


    // DEPARTMENT//
    $('#allListViewDeptEdit').change(function() {
        if (this.checked) {
            $('#listViewEdit option').prop('selected', true);
            $('#listViewEdit').trigger('change');
            $('#allListViewDeptEdit').prop('checked', true)
        } else {
            $('#listViewEdit option').prop('selected', false);
            $('#listViewEdit').trigger('change');
        }
    });

    
    $('#formEdit').on('submit', function(e){
        e.preventDefault();

       
            Swal.fire({
                title: "Are you sure want to edit User Authorization ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                reverseButtons: true
            }).then((result) => { 
                if (result.isConfirmed){
                    $.ajax({
                        url: '{{ route('/userauthorize/update') }}',
                        method: 'POST',
                        data: $('#formEdit').serialize(),
                        beforeSend: () => {
                            $('#SpinnerBtnEdit').removeClass('d-none')
                            $('#SpinnerBtnEdit').prop('disabled', true);
                            $('#btnSimpanedit').hide();
                        }
                    }).done(res => {
                        if (res.MSGTYPE == 'W') {
                            $('#SpinnerBtnEdit').addClass('d-none')
                            $('#btnSimpanEdit').show()
                            $('#SpinnerBtnEdit').prop('disabled', false);
                            showMessage('warning', res.MSG)
                            return;
                        }

                        $('#SpinnerBtnEdit').addClass('d-none')
                        $('#btnSimpanEdit').show()
                        $('#SpinnerBtnEdit').prop('disabled', false);
                        showMessage('success', "User Authorization has been Added")
                        $('#modalEditUserRole').modal('hide');
                        getListUserRole();
                        window.location.reload();

                    }).fail(err => {
                        $('#SpinnerBtnEdit').addClass('d-none')
                        $('#btnSimpanEdit').show()
                        $('#SpinnerBtnEdit').prop('disabled', false);
                    })
                }
            })
        
        return;
    })
</script>