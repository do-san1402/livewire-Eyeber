@extends('layouts.master-without-nav')
@section('title')
    @lang('translation.Reset_password')
@endsection
@section('content')

    <div class="home-btn d-none d-sm-block">
        <a href="{{ route('admin.index') }}" class="text-dark"><i class="mdi mdi-home-variant h2"></i></a>
    </div>
    <div class="account-pages my-5  pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">

                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div>
                        <a href="{{ route('admin.index') }}" class="mb-5 d-block auth-logo">
                            <img src="{{ URL::asset('/assets/images/logo_line.png') }}" alt="" height="75"
                                class="logo logo-dark">
                        </a>
                        <div class="card">

                            <div class="card-body p-4">

                                <div class="text-center mt-2">
                                    <h5 class="text-primary">@lang('translation.Reset_password')</h5>
                                    <p class="text-muted">@lang('translation.Reset_password_with_Eyeber')</p>
                                </div>
                                <div class="p-2 mt-4">
                                    @if (session('status'))
                                        <div class="alert alert-success mb-4" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <form method="POST" action="{{ route('password.email') }}">
                                        @csrf

                                        <div class="mb-3">
                                            <label class="form-label" for="email">@lang('translation.Email')</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" id="email"
                                                placeholder="@lang('translation.Enter_email')">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="mt-3 text-end">
                                            <button class="btn btn-primary w-sm waves-effect waves-light"
                                                type="submit">@lang('translation.Reset')</button>
                                        </div>


                                        <div class="mt-4 text-center">
                                            <p class="mb-0">@lang('translation.Remember_it_?') <a href="{{ url('login') }}"
                                                    class="fw-medium text-primary">@lang('translation.Signin') </a></p>
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
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
@endsection
