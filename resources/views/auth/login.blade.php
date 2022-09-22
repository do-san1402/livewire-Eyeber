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
                            <img src="{{ URL::asset('/assets/images/logo_line.png') }}" alt="" height="75"
                                class="logo logo-dark">
                        </a>
                    </div>
                </div>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">@lang('translation.Welcome_Back!')</h5>
                                <p class="text-muted"> @lang('translation.Sign_in_to_continue_to_Eyeber.')</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label" for="email">@lang('translation.Email')</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            name="email" value="{{ old('email') }}" id="email"
                                            placeholder="@lang('translation.Enter_email_address')">
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="float-end">
                                            @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}" class="text-muted">@lang('translation.Forgot_password?')</a>
                                            @endif
                                        </div>
                                        <label class="form-label" for="userpassword">@lang('translation.Password')</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            value="" name="password" id="userpassword" placeholder="@lang('translation.Enter_password')">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="auth-remember-check"
                                            name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="auth-remember-check">@lang('translation.Remember_me')</label>
                                    </div>

                                    <div class="mt-3 text-end">
                                        <button class="btn btn-primary w-sm waves-effect waves-light" type="submit"> @lang('translation.Login')</button>
                                    </div>

                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <p>© <script>
                                document.write(new Date().getFullYear())

                            </script> Eyeber <i class="mdi mdi-heart text-danger"></i></p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection
