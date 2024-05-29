@extends('layouts.app')
@section('title', 'Login Page')

@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center min-vh-100">
            <div class="col-lg-4">
                <div class="card shadow border-0" style="border-radius: 15px;">
                    <span class="mb-3 mt-5 text-center">
                        <p class="h3 fw-semibold">Login</p>

                    </span>
                    <div class="card-body p-5">

                        <form action="#" method="POST" id="formLogin">
                            @csrf
                            <div class="form-group mb-3">
                                <label for=""><span style="font-size: 12px;">No Badge</span></label>
                                <input type="text" name="employee_no" id="employee_no" class="form-control"
                                    placeholder="Insert your Badge Number">
                                <div class="invalid-feedback"></div>
                            </div>


                            <div class="form-group mb-3">
                                <label for=""><span style="font-size: 12px;">Password</span></label>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Insert Password">
                                <div class="invalid-feedback"></div>
                            </div>

                            {{-- <div class="form-group form-check mt-1 mb-3">
                            <label for="check_simpanakun"><span class="mt-1" style="font-size: 12px;">
                                <input id="check_simpanakun" type="checkbox" class="form-check-input mt-2">Save Account</span>
                            </label>

                        </div> --}}


                            <div class="mb-3 d-grid">
                                <button class="btn btn-primary d-none" type="button" id="SpinnerBtnAdd">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Loading...
                                </button>
                                <button type="submit" id="btnSubmit" class="btn btn-primary">Login</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        const formLogin = $('#formLogin');
        const loaderIcon = `<i class='bx bx-loader bx-spin align-middle me-2'></i>`
        const btnSubmit = $('#btnSubmit')

        formLogin.submit(function(e) {
            e.preventDefault();


            $.ajax({
                url: '{{ route('auth.login') }}',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: () => {
                    spinner('SpinnerBtnAdd', 'btnSubmit');
                },
                success: res => {



                    if (res.status === 400) {
                        loaderIcon.remove();
                        showError('error', res.messages.employee_no)
                        showError('error', res.messages.password)
                    }

                    if (res.status === 401) {

                        showMessage('error', res.messages);
                        hideSpinner('SpinnerBtnAdd', 'btnSubmit');
                    }

                    if (res.status === 200) {
                        if (parseInt(res.role) === 2) {
                            window.location = '{{ route('userauthorize') }}';
                        } else {

                            removeValidationClass(formLogin);
                            formLogin[0].reset()
                            // showMessage('success', 'Data berhasil tersimpan');
                            window.location = '{{ route('meeting') }}'
                            console.log(res);
                    }
                    btnSubmit.children().remove();
                }
                }
            })
        })
    </script>
@endsection
