@extends('layouts.admin.base')
@section('title', 'Add User | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add New User</li>
    </ol>
</nav>
<form action="{{ route('admin.users.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row g-3">
        <div class="col-md-8">
            <div class="card my-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">Add New User</h6>
                </div>
                <div class="card-body p-2">
                    <div class="row mb-3">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <div class="col-6">
                            <div class="mb-1">
                                <input type="text" name="first_name" placeholder="Enter First Name" value="{{ old('first_name') }}" class="form-control @error('first_name') is-invalid @enderror" required>
                                @error('first_name')
                                <span class="invalid-feedback text-warning" role="alert">
                                    <strong>{{ $errors->first('first_name') }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="mb-1">
                                <input type="text" name="last_name" placeholder="Enter Last Name" value="{{ old('last_name') }}" class="form-control @error('last_name') is-invalid @enderror" required>
                                @error('last_name')
                                <span class="invalid-feedback text-warning" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email Address" required>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="Phone" required>
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Date of Birth <span class="text-danger">*</span></label>
                        <div class="d-flex">
                            <!-- Day Select -->
                            <select class="form-select me-2 @error('birth_day') is-invalid @enderror" id="daySelect" name="birth_day" required>
                                <option value="" selected disabled>Day</option>
                                @for ($i = 1; $i <= 31; $i++)
                                <option value="{{ $i }}" {{ old('birth_day') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>

                            <!-- Month Select -->
                            <select class="form-select me-2 @error('birth_month') is-invalid @enderror" id="monthSelect" name="birth_month" required>
                                <option value="" selected disabled>Month</option>
                                @php
                                $months = [
                                '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June',
                                '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
                                ];
                                @endphp

                                @foreach ($months as $monthNumber => $monthName)
                                <option value="{{ $monthNumber }}" {{ old('birth_month') == $monthNumber ? 'selected' : '' }}>{{ $monthName }}</option>
                                @endforeach
                            </select>

                            <!-- Year Select -->
                            <select class="form-select @error('birth_year') is-invalid @enderror" id="yearSelect" name="birth_year" required>
                                <option value="" selected disabled>Year</option>
                                @php
                                $currentYear = date('Y');
                                $minimumAge = 18;
                                $maximumYear = $currentYear - 80;
                                @endphp

                                @for ($i = $currentYear; $i >= $maximumYear; $i--)
                                @if ($currentYear - $i >= $minimumAge)
                                <option value="{{ $i }}" {{ old('birth_year') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endif
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Business Type </label>
                        <select class="form-select @error('business_type') is-invalid @enderror" name="business_type">
                            <option value="" selected disabled>Select Business Type</option>
                            <option value="product" {{ empty(old('business_type')) || old('business_type')=='product' ? 'selected' : '' }}>
                                Product
                            </option>
                            <option value="service" {{ old('business_type')=='service' ? 'selected' : '' }}>
                                Service
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                            <option value="user" {{ empty(old('role')) || old('role')=='user' ? 'selected' : '' }}>
                                User
                            </option>
                            <option value="merchant" {{ old('role')=='merchant' ? 'selected' : '' }}>
                                Merchant
                            </option>
                            <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                        </select>
                        @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="active" {{ empty(old('status')) || old('status') == 'active' ? 'selected' : '' }}>
                                Active
                            </option>
                            <option value="suspend" {{ old('status') == 'suspend' ? 'selected' : '' }}>
                                Suspend
                            </option>
                            <option value="deactive" {{ old('status') == 'deactive' ? 'selected' : '' }}>
                                Deactive
                            </option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card my-2">
                <div class="card-body p-2">
                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" placeholder="Password" required>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" value="{{ old('password_confirmation') }}" placeholder="Confirm Password" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection