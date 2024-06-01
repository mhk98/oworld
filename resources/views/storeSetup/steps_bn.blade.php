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
    <div class="setup-steps-bn">
        <img src="{{ asset('static/images/steps_bn.png') }}" alt="Store Setup Steps">
        <a href="{{ route('merchant.pictureForm') }}" class="btn btn-default btn-lets-started">শুরু করি!</a>
    </div>
</div>
<!-- Store setup part end -->
@endsection