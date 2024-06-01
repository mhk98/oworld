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
        <div class="store-setup-picture">
            <form action="{{ route('merchant.picture') }}" method="post" enctype="multipart/form-data" id="pictureForm">
                @csrf

                <h3 class="profile-picture-title">Profile picture</h3>
                <div class="profile-picture-wrapper">
                    <div class="profile-picture-box">
                        <input type="file" id="file-input-profile" name="profile_picture" accept="image/*">
                        <label for="file-input-profile">
                            @if($store->profile_picture)
                            <img id="preview-profile-image" class="preview-profile-image"
                             src="{{ asset('media/'.$store->profile_picture) }}" alt="Upload Image">
                             <input type="hidden" id="existing-profile-picture" value="true">
                             @else
                            <img id="preview-profile-image" class="preview-profile-image"
                             src="{{ asset('static/images/placeholder.jpg') }}" alt="Upload Image">
                             @endif
                        </label>
                    </div>
                </div>
                <div id="profile-picture-error" class="invalid-feedback text-center text-danger">
                    @error('profile_picture')
                    {{ $message }}
                    @enderror
                </div>

                <h3 class="cover-picture-title">Cover picture</h3>
                <div class="cover-picture-wrapper">
                    <div class="cover-picture-box">
                        <input type="file" id="file-input-cover" name="cover_picture" accept="image/*">
                        <label for="file-input-cover">
                        @if($store->cover_picture)
                            <img id="preview-cover-image" class="preview-cover-image"
                             src="{{ asset('media/'.$store->cover_picture) }}" alt="Upload Image">
                             <input type="hidden" id="existing-cover-picture" value="true">
                        @else
                        <img id="preview-cover-image" class="preview-cover-image"
                             src="{{ asset('static/images/placeholder.jpg') }}" alt="Upload Image">
                        @endif
                            
                        </label>
                    </div>
                </div>
                <div id="cover-picture-error" class="invalid-feedback text-start text-danger">
                    @error('cover_picture')
                    {{ $message }}
                    @enderror
                </div>

                <div class="store-setup-btns pt-4 d-flex justify-content-end">
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
            <li>
                <a href="javascript:void(0);">
                    <i class="far fa-circle"></i>
                </a>
            </li>
            <li>
                <a href="javascript:void(0);">
                    <i class="far fa-circle"></i>
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
@push('js')
<script>
    $(document).ready(function() {
 // Clear file inputs
 $("#file-input-profile, #file-input-cover").val('');

// Picture Form
$("#pictureForm").submit(function(event) {
    event.preventDefault();

    var maxFileSize = 5 * 1024 * 1024;

    // Validate profile picture
    var profilePicture = $("#file-input-profile").get(0).files[0];
    var existingProfilePicture = $("#existing-profile-picture").length > 0;

    if (!profilePicture && !existingProfilePicture) {
        $("#profile-picture-error").text("Please upload a profile picture.");
        return false;
    } else if (profilePicture && !profilePicture.type.match('image.*')) {
        $("#profile-picture-error").text("Please upload an image file.");
        return false;
    } else if (profilePicture && profilePicture.size > maxFileSize) {
        $("#profile-picture-error").text("Profile picture must be less than 5MB.");
        return false;
    } else {
        $("#profile-picture-error").text("");
    }

    // Validate cover picture
    var coverPicture = $("#file-input-cover").get(0).files[0];
    var existingCoverPicture = $("#existing-cover-picture").length > 0;

    if (!coverPicture && !existingCoverPicture) {
        $("#cover-picture-error").text("Please upload a cover picture.");
        return false;
    } else if (coverPicture && !coverPicture.type.match('image.*')) {
        $("#cover-picture-error").text("Please upload an image file.");
        return false;
    } else if (coverPicture && coverPicture.size > maxFileSize) {
        $("#cover-picture-error").text("Cover picture must be less than 5MB.");
        return false;
    } else {
        $("#cover-picture-error").text("");
    }

    this.submit();
});
        // Profile Picture
        $('#file-input-profile').change(function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#preview-profile-image').attr('src', event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        // Cover Picture
        $('#file-input-cover').change(function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#preview-cover-image').attr('src', event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush