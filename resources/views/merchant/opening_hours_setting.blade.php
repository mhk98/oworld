@extends('layouts.base')
@section('content')
<div id="addpost">
    <!-- Upload part Start -->
    <div id="upload-page">
        <div class="back-btn">
            <a href="{{ route('merchant.setting') }}"><i class="fas fa-angle-left"></i></a>
        </div>
        <h6>Store Operation Hours</h6>
        <form action="{{ route('merchant.storeOpeningHours') }}" method="post" enctype="multipart/form-data">
            @csrf
           
            <button class="btn" type="submit">Save Changes</button>
        </form>
    </div>
    <!-- Upload part End -->
</div>
<style>
    #upload-page {
        max-width: 700px !important;
        margin-bottom: 20px;
    }
</style>
@endsection