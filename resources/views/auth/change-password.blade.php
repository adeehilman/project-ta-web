@extends('layouts.app')
@section('title', 'Ganti Password')


@section('content')

<div class="container-fluid">
    <div class="row d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-lg-4">

<div class="content-login">
    <div class="login">
         

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Change Password</h5>

                    <form id="formChangePassword">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="oldPasswordInput" class="form-label">Old Password*</label>
                                <input name="old_password" type="password" class="form-control" id="oldPasswordInput" placeholder="Old Password">
                                <span id="oldPassError" class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <label for="newPasswordInput" class="form-label">New Password*</label>
                                <input name="new_password" type="password" class="form-control" id="newPasswordInput" placeholder="New Password">
                                <span id="newPassError" class="text-danger"></span>
                            </div>
                            <div class="form-group">
                                <label for="confirmNewPasswordInput" class="form-label">Confirm New Password*</label>
                                <input name="new_password_confirmation" type="password" class="form-control" id="confirmNewPasswordInput" placeholder="Confirm New Password">
                                <span id="newPassConfirmError" class="text-danger"></span>
                            </div>

                        </div>

                        <div>
                            <button id="saveBtn" class="btn btn-primary btn-block btn-login">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        {{-- </div> --}}
    </div>
</div>
</div>

</div>
</div>
</div>

@endsection


@section('script')
<script>

    const btnSve = $('#saveBtn');

    btnSve.click(function(e){
        e.preventDefault();


        const oldPasswordInput = $('#oldPasswordInput').val();
        const newPasswordInput = $('#newPasswordInput').val();
        const confirmNewPasswordInput = $('#confirmNewPasswordInput').val();

        if(!oldPasswordInput){
            $('#oldPassError').text('Password lama tidak boleh kosong')
            return
        }else{
            $('#oldPassError').text('')
        }

        if(!newPasswordInput){
            $('#newPassError').text('Password tidak boleh kosong')
            return
        }else{
            $('#newPassError').text('')
        }

        if(!confirmNewPasswordInput){
            $('#newPassConfirmError').text('Confirm Password tidak boleh kosong')
            return
        }else{
            $('#newPassConfirmError').text('')
        }

        if(newPasswordInput !== confirmNewPasswordInput){
            $('#newPassConfirmError').text('Password baru tidak sama')
            return
        }else{
            $('#newPassConfirmError').text('')
        }


        const dataForm = $('#formChangePassword').serialize();

        // proses change password

        $.ajax({
            url: '{{ route('changPass') }}',
            method: 'POST', 
            data: dataForm, 
            dataType: 'json',
        }).done(res => {
            console.log(res);

            if(res.status === 200){
                Swal.fire({
                    icon: 'success',
                    title: res.message,
                    showConfirmButton: false,
                    timer: 2000
                }).then(e => {
                    window.location.assign("{{ route('auth.logout') }}");
                })

                

            }
        })


    });


</script>
@endsection