@extends('layouts.admin.base')
@section('title', 'Reset Password | '.Helper::setting('site_name'))
@section('content')
<div class="page-content d-flex align-items-center justify-content-center">
    <div class="row w-100 mx-0 auth-page">
        <div class="col-md-8 col-xl-6 mx-auto">
            <div class="card">
                <div class="auth-form-wrapper px-3 px-lg-4 py-3 py-lg-4">
                    <a href="{{ route('index') }}" class="noble-ui-logo d-block mb-2">{{ Helper::setting('site_name') }}</a>
                    <h5 class="text-muted fw-normal mb-4">Reset Your Password.</h5>
                    <div class="flash">
                        @include('layouts.flash')
                    </div>
                    <form class="forms-sample" action="{{ route('admin_auth.reset_password') }}" method="post">
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
                        <div>
                            <button type="submit" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                                <i class="btn-icon-prepend" data-feather="key"></i>
                                Reset Password
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