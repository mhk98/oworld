@extends('layouts.admin.base')
@section('title', 'Set New Password | '.Helper::setting('site_name'))
@section('content')
<div class="page-content d-flex align-items-center justify-content-center">
    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            <div class="card">
                <div class="auth-form-wrapper px-3 px-lg-4 py-3 py-lg-4">
                    <a href="{{ route('index') }}" class="noble-ui-logo d-block mb-2">{{ Helper::setting('site_name') }}</a>
                    <h5 class="text-muted fw-normal mb-4">Set New Password.</h5>
                    <div class="flash">
                        @include('layouts.flash')
                    </div>
                    <form class="forms-sample" action="{{ route('admin_auth.new_password') }}" method="post">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
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
                        <div class="mb-3">
                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="password_confirmation"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Confirm Password" required>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="key"></i>
                                Save Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@php
Helper::visitor_store('Reset Password | '.Helper::setting('site_name'));
@endphp