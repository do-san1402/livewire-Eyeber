@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.Login')
@endsection
@section('content')
    <div class="home-btn d-none d-sm-block">
        <a href="{{ route('admin.index') }}" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <a href="{{ route('admin.index') }}" class="mb-5 d-block auth-logo">
                            <img src="{{ URL::asset('/assets/images/logo-dark.png') }}" alt="" height="22"
                                class="logo logo-dark">
                            <img src="{{ URL::asset('/assets/images/logo-light.png') }}" alt="" height="22"
                                class="logo logo-light">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">Welcome Back !</h5>
                                <p class="text-muted">Sign in to continue to Eyever.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form action="{{ route('admin.index') }}">

                                    <div class="mb-3">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="Enter username">
                                    </div>

                                    <div class="mb-3">
                                        <div class="float-end">
                                            <a href="auth-recoverpw" class="text-muted">Forgot password?</a>
                                        </div>
                                        <label class="form-label" for="userpassword">Password</label>
                                        <input type="password" class="form-control" id="userpassword"
                                            placeholder="Enter password">
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="auth-remember-check">
                                        <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button class="btn btn-primary w-sm waves-effect waves-light" type="submit">Log
                                            In</button>
                                    </div>



                                    

                                    <div class="mt-4 text-center">
                                        <p class="mb-0">Don't have an account ? <a href="auth-register"
                                                class="fw-medium text-primary"> Signup now </a> </p>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <p>© <script>
                                document.write(new Date().getFullYear())

                            </script> Eyever. <i class="mdi mdi-heart text-danger"></i></p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection
