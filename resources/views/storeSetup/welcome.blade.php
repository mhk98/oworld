@extends('layouts.base')
@section('content')
<!-- Store setup logo start -->
<div class="store-setup-logo">
    <a href="{{ route('index') }}">
        <img src="{{ asset('static/images/logo.png') }}" alt="Logo">
    </a>
</div>
<!-- Store setup logo end -->

<!-- Store setup part start -->
<div class="store-setup-container">
    <div class="text-center">
        <div class="welcome-title">
            <h1>Welcome to</h1>
            <h1>O’World</h1>
        </div>
        <h4 class="welcome-sub-title">Complete your profile in 4 easy steps</h4>
        <div class="store-setup-btns">
            <a href="{{ route('merchant.stepsEn') }}" class="btn btn-default btn-setup-english">English</a>
            <a href="{{ route('merchant.stepsBn') }}" class="btn btn-default btn-setup-bangla"><span>বাংলা</span></a>
        </div>
    </div>
</div>
<!-- Store setup part end -->
@endsection