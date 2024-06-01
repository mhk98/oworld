@extends('layouts.admin.base')
@section('title', 'Login | O\'World')
@section('content')
<div class="page-content d-flex align-items-center justify-content-center">
    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            <div class="card">
                <div class="auth-form-wrapper px-3 px-lg-4 py-3 py-lg-4">
                    <a href="{{ route('index') }}" class="noble-ui-logo d-block mb-2">O'World Administer</a>
                    <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>
                    <div class="flash">
                        @include('layouts.flash')
                    </div>
                    <form class="forms-sample" action="{{ route('adminAuth.login') }}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Email" required>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="remember" value="yes" id="authCheck">
                            <label class="form-check-label" for="authCheck">
                                Remember me
                            </label>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="log-in"></i>
                                Login
                            </button>
                        </div>
                        <a href="{{ route('adminAuth.resetPasswordForm') }}" class="d-block mt-2 text-muted">Forgot
                            password? reset now</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection