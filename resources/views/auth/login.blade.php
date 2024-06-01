@extends('layouts.base')
@section('content')
<!-- Content part start -->
<div class="pt-3 pt-md-4 pt-lg-5"></div>
<div class="auth-logo">
    <a href="{{ route('index') }}">
        <img src="{{ asset('static/images/logo.png') }}" class="img-fluid w-100" alt="">
    </a>
</div>
<div class="pb-3 pb-md-4 pb-lg-5"></div>
<div id="login-page">
    <div class="login">
        <form action="{{ route('auth.login') }}" method="POST" class="login-form">
            @csrf

            <div class="login-title">
                <h6>The biggest Plartform in bangladesh.</h6>
            </div>

            <div class="mb-4">
                <label for="identifier" class="form-label">Email</label>
                <input type="text" id="identifier" name="identifier" value="{{ old('identifier') }}" class="form-control @error('identifier') is-invalid @enderror" required>
                @error('identifier')
                <span class="invalid-feedback text-dark" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group password-input">
                    <input type="password" name="password" id="password" class="form-control">
                    <button type="button" class="btn btn-dark toggle-password"><i class="fas fa-eye-slash"></i></button>
                </div>
                @error('password')
                <span class="invalid-feedback text-dark" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="forget-pass">
                <p><a href="/" class="btn-link text-reset">Forgot Password?</a></p>
            </div>

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn login-btn">Login</button>
            </div>
        </form>

        {{---- <div class="login-option">
            <h6>or continue with</h6>

            <a href="#">
            <i class="fab fa-google"></i>
                <span>Google</span>
            </a>

            <a href="#">
                <i class="fab fa-facebook"></i>
                <span>Facebook</span>
            </a>
        </div> ----}}

        <div class="not-member">
            <p>Not a member? <a href="{{ route('auth.signUpForm') }}" class="sign-up-text">Sign Up</a></p>
        </div>
    </div>
</div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $(document).on('click', '.toggle-password', function() {
            var passwordField = $(this).closest('.input-group').find('input');
            var fieldType = passwordField.attr('type');
            if (fieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).html('<i class="fas fa-eye"></i>');
            } else {
                passwordField.attr('type', 'password');
                $(this).html('<i class="fas fa-eye-slash"></i>');
            }
        });
    });
</script>
@endpush