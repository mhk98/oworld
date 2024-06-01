@extends('layouts.admin.base')
@section('title', 'Add New Offer | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.featured-offers.index') }}">Featured Offers</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add New Offer</li>
    </ol>
</nav>
<form action="{{ route('admin.featured-offers.store') }}" method="post" enctype="multipart/form-data" id="offerContent">
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
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Section <span class="text-danger">*</span></label>
                        <select class="form-select @error('featured_section_id') is-invalid @enderror" name="featured_section_id">
                            @if($featuredSections->count() > 0)
                            @foreach($featuredSections as $featuredSection)
                            <option value="{{ $featuredSection->id }}" {{ old('featured_section_id') == $featuredSection->id ? 'selected' : '' }}>
                                {{ $featuredSection->title }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        @error('featured_section_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stores <span class="text-danger">*</span></label>
                        <select class="form-select @error('store_id') is-invalid @enderror" id="stores-select" name="store_id">
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
                        <label class="form-label">Serial <span class="text-danger">*</span></label>
                        <select class="form-select @error('serial') is-invalid @enderror" name="serial" required>
                            @for ($i = 1; $i <= 20; $i++) 
                            <option value="{{ $i }}" {{ old('serial') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                            @endfor
                        </select>
                        @error('serial')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="deactive" {{ old('status', 'deactive') == 'deactive' ? 'selected' : '' }}>Deactive</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <button class="btn btn-primary px-5" type="submit">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        // image uploader
        let imageUploader = new MultipleUploader('#imageUploader').init({
            maxUpload: 10,
            maxSize: 5,
            filesInpName: 'offerImages',
            formSelector: '#offerContent'
        });
    });
</script>
@endpush