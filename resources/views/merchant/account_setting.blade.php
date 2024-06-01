@extends('layouts.base')
@section('content')
<div id="addpost">
    <!-- Upload part Start -->
    <div id="upload-page">
        <div class="back-btn">
            <a href="{{ route('merchant.setting') }}"><i class="fas fa-angle-left"></i></a>
        </div>
        <h6>Account Setting</h6>
        <form action="{{ route('merchant.accountSetting') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <label class="form-label">Full Name</label>
                <div class="col-6">
                    <div class="mb-3">
                        <input type="text" name="merchant_first_name" placeholder="Enter First Name" class="form-control @error('merchant_first_name') is-invalid @enderror" value="{{ old('merchant_first_name', $merchant->first_name) }}" required>
                        @error('merchant_first_name')
                        <span class="invalid-feedback text-dark" role="alert">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="col-6">
                    <div class="mb-3">
                        <input type="text" name="merchant_last_name" placeholder="Enter Last Name" class="form-control @error('merchant_last_name') is-invalid @enderror" value="{{ old('merchant_last_name', $merchant->last_name) }}" required>
                        @error('merchant_last_name')
                        <span class="invalid-feedback text-dark" role="alert">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="daySelect" class="form-label">Date of Birth</label>
                <div class="d-flex">
                    <!-- Day Select -->
                    <select class="form-select me-2 @error('merchant_birth_day') is-invalid @enderror" id="daySelect" name="merchant_birth_day" required>
                        <option value="" selected disabled>Day</option>
                        @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}" {{ $merchant->birth_day == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                    </select>

                    <!-- Month Select -->
                    @php
                    $months = [
                    '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June',
                    '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
                    ];
                    @endphp

                    <select class="form-select me-2 @error('merchant_birth_month') is-invalid @enderror" id="monthSelect" name="merchant_birth_month" required>
                        <option value="" selected disabled>Month</option>
                        @foreach ($months as $monthNumber => $monthName)
                        <option value="{{ $monthNumber }}" {{ $merchant->birth_month == $monthNumber ? 'selected' : '' }}>{{ $monthName }}</option>
                        @endforeach
                    </select>

                    <!-- Year Select -->
                    @php
                    $currentYear = date('Y');
                    $minimumAge = 18;
                    $maximumYear = $currentYear - 80;
                    @endphp
                    <select class="form-select @error('merchant_birth_year') is-invalid @enderror" id="yearSelect" name="merchant_birth_year" required>
                        <option value="" selected disabled>Year</option>
                        @for ($i = $currentYear; $i >= $maximumYear; $i--)
                        @if ($currentYear - $i >= $minimumAge)
                        <option value="{{ $i }}" {{ $merchant->birth_year == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endif
                        @endfor
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label for="businessType" class="form-label">Business Type</label>
                <select class="form-select @error('business_type') is-invalid @enderror" name="business_type" required>
                    <option value="product" {{ $merchant->business_type == 'product' ? 'selected' : '' }}>Product</option>
                    <option value="service" {{ $merchant->business_type == 'service' ? 'selected' : '' }}>Service</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="text" name="merchant_email" placeholder="Enter Email Address" value="{{ old('merchant_email', $merchant->email) }}" class="form-control @error('merchant_email') is-invalid @enderror" required>
                @error('merchant_email')
                <span class="invalid-feedback text-dark" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Phone</label>
                <input type="text" name="merchant_phone" placeholder="Enter Phone Number" value="{{ old('merchant_phone', $merchant->phone) }}" class="form-control @error('merchant_phone') is-invalid @enderror" required>
                @error('merchant_phone')
                <span class="invalid-feedback text-dark" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-text mb-3">
                <p class="fw-semibold">To change your password, fill in the fields below. Leave them blank if you don't want to change your password.</p>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="merchant_password" placeholder="Enter Password" class="form-control @error('merchant_password') is-invalid @enderror">
                @error('merchant_password')
                <span class="invalid-feedback text-dark" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Retype Password</label>
                <input type="password" name="merchant_password_confirmation" placeholder="Retype Password Again" class="form-control @error('merchant_password_confirmation') is-invalid @enderror">
            </div>
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

    @media only screen and (max-width: 768px) {
        #upload-page {
            max-width: 100%;
            padding: 20px !important;
            margin-bottom: 80px;
        }
    }

    @media only screen and (max-width: 600px) {
        #upload-page {
            max-width: 100%;
            padding: 10px !important;
            margin-bottom: 80px;
        }
    }
</style>
@endsection