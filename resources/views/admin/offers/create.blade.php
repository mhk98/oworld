@extends('layouts.admin.base')
@section('title', 'Add New Offer | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.offers.index') }}">Offers</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add New Offer</li>
    </ol>
</nav>
<form action="{{ route('admin.offers.store') }}" method="post" enctype="multipart/form-data" id="offerForm">
    @csrf
    <div class="row g-3">
        <div class="col-md-9">
            <div class="card my-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">Add New Offer</h6>
                </div>
                <div class="card-body p-2">

                <div class="multiple-uploader" id="imageUploader">
                        <div class="mup-msg">
                            <span class="mup-main-msg">click to upload images.</span>
                            <span class="mup-msg" id="max-upload-number">Upload up to 10 images</span>
                            <span class="mup-msg">Only image files (PNG, GIF, JPEG, etc.) are allowed for upload.</span>
                        </div>
                        @error('offerImages')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category" required>
                            @if($categories->count() > 0)
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        @error('category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Store <span class="text-danger">*</span></label>
                        <select class="form-select @error('store_id') is-invalid @enderror" name="store_id" id="store" required>
                            @if($stores->count() > 0)
                            @foreach($stores as $store)
                            <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                                {{ $store->business_name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        @error('store_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Offer Expiration Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('offer_expiration') is-invalid @enderror" name="offer_expiration" value="{{ old('offer_expiration') }}" required>
                        @error('offer_expiration')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="private" {{ old('status', 'private') == 'private' ? 'selected' : '' }}>Private</option>
                            <option value="published" {{ old('status', 'pending') == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#category').select2();
        $('#store').select2();

        // image uploader
        let imageUploader = new MultipleUploader('#imageUploader').init({
            maxUpload: 10,
            maxSize: 5,
            filesInpName: 'offerImages',
            formSelector: '#offerForm'
        });
    });
</script>
@endpush