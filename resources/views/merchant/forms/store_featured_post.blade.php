<form action="{{ route('merchant.storeSetting') }}" method="post" id="featuredPostForm" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="step" value="featured_post">
    <div class="mb-4 w-50">
        <select name="featured_post_type" class="form-select">
            <option value="menu" {{ $store->featured_post_type == 'menu' ? 'selected' : '' }}>Menu</option>
            <option value="products_and_services" {{ $store->featured_post_type == 'products_and_services' ? 'selected' : '' }}>Products and Services</option>
            <option value="packages" {{ $store->featured_post_type == 'packages' ? 'selected' : '' }}>Packages</option>
        </select>
        @error('featured_post_type')
        <span class="invalid-feedback text-dark" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="multiple-uploader" id="featuredPostUploader">
        <div class="mup-msg">
            <span class="mup-main-msg">click to upload images.</span>
            <span class="mup-msg" id="max-upload-number">Upload up to 10 images</span>
            <span class="mup-msg">Only image files (PNG, GIF, JPEG, etc.) are allowed for upload.</span>
        </div>
    </div>

    @if ($featuredPostImages->count() > 0)
    <div class="row setting-gallery-container g-3 mb-3">
        @foreach($featuredPostImages as $featuredPostImage)
        <div class="col-6 col-md-3 gallery-setting-image" id="galleryItem{{ $featuredPostImage->id }}">
            <div class="gallery-item">
                <img src="{{ asset('media/'.$featuredPostImage->thumbnail) }}" class="img-fluid rounded" alt="Image">
                <span class="remove-icon" id="removeGalleryItem" data-image-id="{{ $featuredPostImage->id }}">
                    <i class="fas fa-trash-alt"></i>
                </span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <button class="btn submit-btn" type="submit">Save Changes</button>
</form>