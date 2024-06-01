@extends('layouts.admin.base')
@section('title', 'Edit Featured Offer | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.featured-offers.index') }}">Featured Offer</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Featured Offer</li>
    </ol>
</nav>
<form action="{{ route('admin.featured-offers.update', $featuredOffer->id) }}" method="post" enctype="multipart/form-data" id="updateOffer">
    @csrf
    @method('PUT')
    <div class="row g-3">
        <div class="col-md-9">
            <div class="card my-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">Edit Featured Offer</h6>
                </div>
                <div class="card-body p-2">

                    <div class="multiple-uploader" id="imageUploader">
                        <div class="mup-msg">
                            <span class="mup-main-msg">Click to upload images.</span>
                            <span class="mup-msg" id="max-upload-number">Upload up to 10 images</span>
                            <span class="mup-msg">Only image files (PNG, GIF, JPEG, etc.) are allowed for upload.</span>
                        </div>
                        @error('offerImages')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    @if ($featuredOffer->images && count($featuredOffer->images) > 0)
                    <div class="row gallery-container g-3 mb-3">
                        @foreach($featuredOffer->images as $imageId => $image)
                        <div class="col-6 col-md-3 gallery-image" id="imageItem{{ $imageId }}">
                            <div class="gallery-item">
                                <img src="{{ asset('media/'.$image) }}" class="img-fluid rounded" alt="Image">
                                <span class="remove-icon" id="removeImageItem" data-image-id="{{ $imageId }}">
                                    <i class="fas fa-trash-alt"></i>
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $featuredOffer->title) }}" required>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description </label>
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ old('description', $featuredOffer->description) }}</textarea>
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
                            <option value="{{ $featuredSection->id }}" {{ $featuredOffer->featured_section_id == $featuredSection->id ? 'selected' : '' }}>
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
                            <option value="{{ $store->id }}" {{ $featuredOffer->store_id == $store->id ? 'selected' : '' }}>
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
                            <option value="{{ $i }}" {{ $featuredOffer->serial == $i ? 'selected' : '' }}>
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
                            <option value="active" {{ old('status', $featuredOffer->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="deactive" {{ old('status', $featuredOffer->status) == 'deactive' ? 'selected' : '' }}>Deactive</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <button class="btn btn-primary px-5" type="submit">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
<style>
    /* Style for remove icon */
    .gallery-item {
        position: relative;
    }

    /* Style for remove icon */
    .remove-icon {
        position: absolute;
        top: 5px;
        right: 5px;
        cursor: pointer;
        background-color: rgba(255, 255, 255, 0.7);
        padding: 6.5px;
        border-radius: 50%;
        font-size: 13px;
        color: #000;
        z-index: 2;
        width: 24px;
        height: 24px;
        line-height: 1;
    }

    /* Hover effect for remove icon */
    .remove-icon:hover {
        background-color: #ff0000;
        color: #fff;
    }
</style>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        // Initialize image uploader
        let imageUploader = new MultipleUploader('#imageUploader').init({
            maxUpload: 10,
            maxSize: 5,
            filesInpName: 'offerImages',
            formSelector: '#updateOffer'
        });


        // Remove Image Item
        $(document).on('click', '#removeImageItem', function(event) {
            var imageId = $(this).data('image-id');
            var offerId = '{{ $featuredOffer->id }}';
            var confirmation = confirm("Are you sure you want to delete this image?");

            if (confirmation) {
                $.ajax({
                    url: '{{ route("admin.featuredOffersRemoveImage") }}',
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        offerId: offerId,
                        imageId: imageId
                    },
                    success: function(response) {
                        $('#imageItem' + imageId).remove();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        var errorMessage = xhr.responseJSON.message;
                        if (errorMessage) {
                            alert(errorMessage);
                        } else {
                            alert("An error occurred while deleting the image.");
                        }
                    }
                });
            }
        });

    });
</script>
@endpush