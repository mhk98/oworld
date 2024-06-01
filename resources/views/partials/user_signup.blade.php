<form action="{{ route('auth.signUpUser') }}" class="signup-form" id="userSignUp" method="post">
    @csrf
    <div class="form-card">
        <div class="row">
            <label class="form-label">Full Name</label>
            <div class="col-6">
                <div class="mb-3">
                    <input type="text" name="first_name" placeholder="First Name" class="form-control" value="">
                </div>
            </div>
            <div class="col-6">
                <div class="mb-3">
                    <input type="text" name="last_name" placeholder="Last Name" class="form-control" value="">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="daySelect" class="form-label">Date of Birth</label>
            <div class="d-flex userBirth">
                <!-- Day Select -->
                <select class="form-select me-2" id="daySelect" name="birth_day">
                    <option value="" selected disabled>Day</option>
                    @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                </select>

                <!-- Month Select -->
                @php
                $months = [
                '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June',
                '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
                ];
                @endphp
                <select class="form-select me-2" id="monthSelect" name="birth_month">
                    <option value="" selected disabled>Month</option>
                    @foreach ($months as $monthNumber => $monthName)
                    <option value="{{ $monthNumber }}">{{ $monthName }}</option>
                    @endforeach
                </select>

                <!-- Year Select -->
                @php
                $currentYear = date('Y');
                $minimumAge = 18;
                $maximumYear = $currentYear - 80;
                @endphp
                <select class="form-select" id="yearSelect" name="birth_year">
                    <option value="" selected disabled>Year</option>
                    @for ($i = $currentYear; $i >= $maximumYear; $i--)
                    @if ($currentYear - $i >= $minimumAge)
                    <option value="{{ $i }}">{{ $i }}</option>
                    @endif
                    @endfor
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label" for="gender">Gender</label>
            <select name="gender" id="gender" class="form-select">
                <option value="" selected>Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>
        </div>


        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="text" name="email" placeholder="Email Address" class="form-control" id="email" value="">
            <div id="email-error"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <div class="input-group phone-input">
                <div class="input-group-prepend">
                    <span class="input-group-text">+88</span>
                </div>
                <input type="text" name="phone" placeholder="Phone Number" class="form-control" id="phone" value="">
            </div>
            <div id="phone-error"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group password-input">
                <input type="password" name="password" id="password" placeholder="At least 8 characters" class="form-control">
                <button type="button" class="btn btn-dark toggle-password"><i class="fas fa-eye-slash"></i></button>
            </div>
            <div id="password-error"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Re-type Password</label>
            <div class="input-group password-input">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="" class="form-control">
                <button type="button" class="btn btn-dark toggle-password"><i class="fas fa-eye-slash"></i></button>
            </div>
            <div id="confirm-password-error"></div>
        </div>


        <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="accept_terms_and_conditions" value="agree" id="termsCheck">
                    <label class="form-check-label" for="termsCheck">
                        I accept the <a href="javascript:void(0);" class="accept-terms-and-conditions" data-bs-toggle="modal" data-bs-target="#termsAndConModal">terms and conditions</a> of O'World.
                    </label>
                </div>
                @error('accept_terms_and_conditions')
                <span class="invalid-feedback text-dark" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

    </div>

    <button type="submit" class="action-button text-center">Sign Up</button>

    <div class="already-member text-center pt-2 pb-3">
        <p>Already a member? <a href="{{ route('auth.loginForm') }}" class="login-text">Log in</a></p>
    </div>
</form>