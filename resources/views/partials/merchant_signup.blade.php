<div class="signup-form">

    <!-- progressbar -->
    <ul id="progressbar">
        <li class="active"><span>Personal <br> Details</span></li>
        <li class=""><span>Business <br> Details</span></li>
        <li class=""><span>Done <br> You are in</span></li>
    </ul>

    <br>
    <div id="personal-details">
        <form id="personalDetailsForm">
            <div class="form-card">

                <div class="row">
                    <label class="form-label">Contact Person's Full Name</label>
                    <div class="col-6">
                        <div class="mb-3">
                            <input type="text" name="merchant_first_name" placeholder="First Name" class="form-control">
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="mb-3">
                            <input type="text" name="merchant_last_name" placeholder="Last Name" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="daySelect" class="form-label">Date of Birth</label>
                    <div class="d-flex merchantBirth">
                        <!-- Day Select -->
                        <select class="form-select me-2" id="daySelect" name="merchant_birth_day">
                            <option value="" selected disabled>Day</option>
                            @for ($i = 1; $i <= 31; $i++) <option value="{{ $i }}">
                                {{ $i }}
                                </option>
                                @endfor
                        </select>

                        <!-- Month Select -->
                        @php
                        $months = [
                        '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June',
                        '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
                        ];
                        @endphp
                        <select class="form-select me-2" id="monthSelect" name="merchant_birth_month">
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
                        <select class="form-select" id="yearSelect" name="merchant_birth_year">
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
                    <label class="form-label" for="merchantGender">Gender</label>
                    <select name="merchant_gender" id="merchantGender" class="form-select">
                        <option value="" selected disabled>Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="businessType" class="form-label">Business Type</label>
                    <select class="form-select" name="business_type">
                        <option value="products_and_services">Products and Services</option>
                        <option value="restaurant">Restaurant</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" name="merchant_email" placeholder="Email Address" class="form-control">
                    <span id="merchant-email-error" class="invalid-feedback text-danger"></span>
                </div>

                <div class="mb-3">
                    <label class="form-label">Phone</label>
                    <div class="input-group phone-input">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                +88
                            </span>
                        </div>
                        <input type="text" name="merchant_phone" placeholder="Phone Number" class="form-control">
                    </div>
                    <span id="merchant-phone-error" class="invalid-feedback text-danger"></span>
                </div>


                <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group password-input">
                <input type="password" name="merchant_password" id="merchant_password" placeholder="At least 8 characters" class="form-control">
                <button type="button" class="btn btn-dark toggle-password"><i class="fas fa-eye-slash"></i></button>
            </div>
            <div id="merchant-password-error"></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Re-type Password</label>
            <div class="input-group password-input">
                <input type="password" name="merchant_password_confirmation" id="merchant_password_confirmation" placeholder="" class="form-control">
                <button type="button" class="btn btn-dark toggle-password"><i class="fas fa-eye-slash"></i></button>
            </div>
            <div id="merchant-confirm-password-error"></div>
        </div>

            </div>
            <button type="button" class="next presonal-next action-button">Next</button>
            <div class="already-member text-cpt-2 pb-3">
                <p>Already a member? <a href="{{ route('auth.loginForm') }}" class="login-text">Log In</a></p>
            </div>
        </form>
    </div>


    <!--2nd fieldsets -->
    <div id="business-details">
        <form id="businessDetailsForm">
            <div class="form-card">

                <!-- Business Name -->
                <div class="mb-4">
                    <label class="form-label">Business Name</label>
                    <input type="text" name="business_name" class="form-control" placeholder="Your business name">
                </div>

                <!-- Facebook URL -->
                <div class="mb-4">
                    <label class="form-label">Facebook URL <i class="fab fa-facebook"></i></label>
                    <input type="text" name="facebook" class="form-control" placeholder="Your Facebook URL">
                </div>

                <!-- Category -->
               <div class="category-part">
                    <div class="accordion mb-3" id="categoryAccordion">
                        <label for="" class="form-label">Category</label>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    Select Category
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#categoryAccordion">
                                <div class="accordion-body">
                                    @if($categories)
                                    @foreach($categories as $category)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category_id[]" value="{{ $category->id }}" id="category{{ $category->id }}Checkbox">
                                        <label class="form-check-label" for="category{{ $category->id }}Checkbox">{{ $category->title }}</label>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <span id="category-error" class="invalid-feedback text-dark">
                    </span>
                </div>

                <!-- Store Type -->
                <div class="row mb-4">
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="store_type[]" value="physical" id="storeTypePhysical" checked>
                            <label class="form-check-label" for="storeTypePhysical">
                                Physical Store
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="store_type[]" value="online" id="storeTypeOnline">
                            <label class="form-check-label" for="storeTypeOnline">
                                Online Store
                            </label>
                        </div>
                    </div>
                </div>
                <span id="store-type-error" class="invalid-feedback text-dark">
                </span>

                <!-- Area -->
                <div class="area-part">
                    <div class="accordion mb-3" id="areaAccordion">
                        <label for="" class="form-label">Business Location</label>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Select Area
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#areaAccordion">
                                <div class="accordion-body">
                                    @foreach($areas as $area)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="area[]" value="{{ $area }}" id="area{{ ucfirst($area) }}Checkbox">
                                        <label class="form-check-label" for="area{{ ucfirst($area) }}Checkbox">{{ ucwords(str_replace('_', ' ', $area)) }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <span id="area-error" class="invalid-feedback text-dark">
                    </span>
                </div>

                <!-- Address Area -->
                <div class="address-part">
                </div>

                <!-- Delivery Area -->
                <div class="delivery-area-part">
                    <div class="accordion mb-3" id="deliveryAreaAccordion">
                        <label for="" class="form-label">Delivery Area</label>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingDeliveryArea">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDeliveryArea" aria-expanded="true" aria-controls="collapseDeliveryArea">
                                    Select Delivery Area
                                </button>
                            </h2>
                            <div id="collapseDeliveryArea" class="accordion-collapse collapse" aria-labelledby="headingDeliveryArea" data-bs-parent="#deliveryAreaAccordion">
                                <div class="accordion-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="delivery_area[]" value="all" id="deliveryAreaAllCheckbox">
                                        <label class="form-check-label" for="deliveryAreaAllCheckbox">All</label>
                                    </div>
                                    @foreach($areas as $area)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="delivery_area[]" value="{{ $area }}" id="deliveryArea{{ ucfirst($area) }}Checkbox">
                                        <label class="form-check-label" for="deliveryArea{{ ucfirst($area) }}Checkbox">{{ ucwords(str_replace('_', ' ', $area)) }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <span id="delivery-area-error" class="invalid-feedback text-dark">
                    </span>
                </div>
            </div>
            <input type="button" name="next" class="next business-details-next action-button" value="Next" />
            <a href="javascript:void(0);" class="previous business-details-previous action-button-previous">Back</a>
            <div class="already-member text-cpt-2 pb-3">
                <p>Already a member? <a href="{{ route('auth.loginForm') }}" class="login-text">Log in</a></p>
            </div>
        </form>
    </div>

    <!--3rd fieldsets -->
    <div id="terms">
        <form id="termsForm">
            <div class="form-card">
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
            <button type="button" class="action-button join-btn">Join</button>
            <a href="javascript:void(0);" class="previous terms-previous action-button-previous">Back</a>
            <div class="already-member text-cpt-2 pb-3">
                <p>Already a member? <a href="{{ route('auth.loginForm') }}" class="login-text">Log in</a></p>
            </div>
        </form>
    </div>
</div>