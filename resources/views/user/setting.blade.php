@extends('layouts.base')
@section('content')
<div class="account-setting ps-5">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-5">Account Settings</h2>
            <form action="{{ route('user.updateSetting') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3 align-items-center">
    <label for="profile_picture" class="col-md-2 col-form-label">Profile Picture:</label>

    <div class="col-md-4">
        <div class="upload-box">
            <input type="file" id="file-input" name="profile_picture" accept="image/*">
            <label for="file-input">
                @if($user->profile_picture)
                <img id="preview-image" src="{{ asset('media/'.$user->profile_picture) }}" alt="Change Image">
                @else
                <img id="preview-image" src="{{ asset('static/images/placeholder.jpg') }}" alt="Upload Image">
                @endif
            </label>
        </div>
        @error('profile_picture')
        <div class="invalid-feedback text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

                <div class="row mb-3">
                    <label for="first_name" class="col-md-2 col-form-label">First Name:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="Enter first name" required>
                        @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="last_name" class="col-md-2 col-form-label">Last Name:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Enter last name" required>
                        @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="email" class="col-md-2 col-form-label">Email Address:</label>
                    <div class="col-md-4">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Enter email address" autocomplete="off" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        @if(empty($user->email_verified_at))
                        <div class="form-text text-danger">Verify your email, <a href="{{ route('auth.resendVerificationEmail') }}" class="link-primary">resend email</a></div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="phone" class="col-md-2 col-form-label">Phone Number:</label>
                    <div class="col-md-4">
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Enter phone number" required>
                        @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-2"></div>
                    <div class="col-md-10">
                        <button type="submit" class="btn btn-primary">Update Settings</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .upload-box {
  width: 150px;
  height: 150px;
}

#preview-image {
  height: 150px;
}

    .form-group label {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .form-group input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }


    .btn-primary {
        font-size: 20px;
        font-weight: 450;
        background-color: #D81A8F;
        color: #fff;
        border: 1px solid #D81A8F;
        border-radius: 5px;
        padding: 10px 15px;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #e80e94;
        border-color: #e80e94;
    }

    .btn-primary:active,
    .btn-primary:focus {
        background-color: #e80e94;
        border-color: #e80e94;
    }
</style>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        // upload box
        $('#file-input').change(function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#preview-image').attr('src', event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
@endpush