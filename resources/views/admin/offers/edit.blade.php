@extends('layouts.admin.base')
@section('title', 'Edit Offer | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.offers.index') }}">Offers</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Offer</li>
    </ol>
</nav>
<form action="{{ route('admin.offers.update', $offer->id) }}" method="post" enctype="multipart/form-data" id="editOffer">
    @csrf
    @method('put')
    <div class="row g-3">
        <div class="col-md-9">
            <div class="card my-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">Edit Offer</h6>
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

                    @if ($offer->images && count($offer->images) > 0)
                    <div class="row gallery-container g-3 mb-3">
                        @foreach($offer->images as $imageId => $image)
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
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category" required>
                            @if($categories->count() > 0)
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $offer->category_id == $category->id ? 'selected' : '' }}>
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
                            <option value="{{ $store->id }}" {{ $offer->store_id == $store->id ? 'selected' : '' }}>
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
                        <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="3">{{ $offer->description }}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Offer Expiration Date <span class="text-danger">*</span></label>
                        @php
                        $formattedDate = isset($offer->offer_expiration) ? \Carbon\Carbon::parse($offer->offer_expiration)->format('Y-m-d') : '';
                        @endphp
                        <input type="date" class="form-control @error('offer_expiration') is-invalid @enderror" name="offer_expiration" value="{{ $formattedDate }}" required>
                        @error('offer_expiration')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="pending" {{ $offer->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="private" {{ $offer->status == 'private' ? 'selected' : '' }}>Private</option>
                            <option value="published" {{ $offer->status == 'published' ? 'selected' : '' }}>Published</option>
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
        $('#category').select2();
        $('#store').select2();

        // image uploader
        let imageUploader = new MultipleUploader('#imageUploader').init({
            maxUpload: 10,
            maxSize: 5,
            filesInpName: 'offerImages',
            formSelector: '#editOffer'
        });

        $(document).on('click', '#removeImageItem', function(event) {
    var imageId = $(this).data('image-id');
    var offerId = '{{ $offer->id }}';
    var confirmation = confirm("Are you sure you want to delete this image?");

    if (confirmation) {
        $.ajax({
            url: '{{ route("admin.offers.removeImage") }}',
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