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
    <div class="setup-steps-eng">
        <img src="{{ asset('static/images/steps_en.png') }}" alt="Store Setup Steps">
        <a href="{{ route('merchant.pictureForm') }}" class="btn btn-default btn-lets-started">Let's get started!</a>
    </div>
</div>
<!-- Store setup part end -->
@endsection