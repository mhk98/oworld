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
    <div class="store-details-title">
        <h2>Store Details</h2>
    </div>

    <div class="setup-external-links">
        <form action="{{ route('merchant.externalLinks') }}" method="post" enctype="multipart/form-data" id="externalLinksForm">
            @csrf

            <div class="px-5">
                <h3 class="external-links-title text-start">External Links <span>(optional)</span></h6>

                    <!-- Facebook URL -->
                    <h6 class="facebook-link text-start d-flex mb-4">
                        <img src="{{ asset('static/images/fb2.jpg') }}" alt="Facebook">
                        {{ ucfirst(Helper::socialMediaUsername($store->facebook, 'facebook')) }}
                    </h6>

                    <!-- Twitter URL -->
                    <div class="mb-4">
                        <label class="form-label">Twitter URL <i class="fab fa-twitter"></i></label>
                        <input type="url" name="twitter" class="form-control" placeholder="Your Twitter URL">
                    </div>

                    <!-- Instagram URL -->
                    <div class="mb-4">
                        <label class="form-label">Instagram URL <i class="fab fa-instagram"></i></label>
                        <input type="url" name="instagram" class="form-control" placeholder="Your Instagram URL">
                    </div>

                    <!-- LinkedIn URL -->
                    <div class="mb-4">
                        <label class="form-label">LinkedIn URL <i class="fab fa-linkedin"></i></label>
                        <input type="url" name="linkedin" class="form-control" placeholder="Your LinkedIn URL">
                    </div>

                    <!-- Website URL -->
                    <div class="mb-4">
                        <label class="form-label">Website URL <i class="fas fa-globe"></i></label>
                        <input type="url" name="website" class="form-control" placeholder="Your Website URL">
                    </div>
            </div>

            <div class="store-setup-btns pt-4 d-flex justify-content-between">
                <a href="{{ route('merchant.categoryForm') }}" class="btn btn-default btn-back">Back</a>
                <button type="submit" class="btn btn-default btn-next">Next</button>
            </div>
        </form>
    </div>

    <ul class="page-dots text-center pt-3">
        <li class="active">
            <a href="javascript:void(0);">
                <i class="fas fa-circle"></i>
            </a>
        </li>
        <li class="active">
            <a href="javascript:void(0);">
                <i class="fas fa-circle"></i>
            </a>
        </li>
        <li class="active">
            <a href="javascript:void(0);">
                <i class="fas fa-circle"></i>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);">
                <i class="far fa-circle"></i>
            </a>
        </li>
    </ul>
</div>
<!-- Store setup part end -->
@endsection