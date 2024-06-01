<form action="{{ route('merchant.storeSetting') }}" method="post" id="interiorForm" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="step" value="interior">

    <div class="multiple-uploader" id="interiorUploader">
        <div class="mup-msg">
            <span class="mup-main-msg">click to upload images.</span>
            <span class="mup-msg" id="max-upload-number">Upload up to 10 images</span>
            <span class="mup-msg">Only image files (PNG, GIF, JPEG, etc.) are allowed for upload.</span>
        </div>
    </div>

    @if ($interiorImages->count() > 0)
    <div class="row setting-gallery-container g-3 mb-3">
        @foreach($interiorImages as $interiorImage)
        <div class="col-6 col-md-3 gallery-setting-image" id="galleryItem{{ $interiorImage->id }}">
            <div class="gallery-item">
                <img src="{{ asset('media/'.$interiorImage->thumbnail) }}" class="img-fluid rounded" alt="Image">
                <span class="remove-icon" id="removeGalleryItem" data-image-id="{{ $interiorImage->id }}">
                    <i class="fas fa-trash-alt"></i>
                </span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <button class="btn submit-btn" type="submit">Save Changes</button>
</form>