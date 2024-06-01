@extends('layouts.base')
@section('content')
<!-- Content part start -->
<div class="pt-3 pt-md-4 pt-lg-5"></div>
<div class="auth-logo">
    <a href="{{ route('index') }}">
        <img src="{{ asset('static/images/logo.png') }}" class="img-fluid w-100" alt="Logo">
    </a>
</div>

<div class="pb-3 pb-md-4 pb-lg-5"></div>
<div id="signup-page">
    <div class="sign-up">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link link1 @if(!request('user')) active @endif" id="nav-user-signup-tab" data-bs-toggle="tab" data-bs-target="#nav-user-signup" type="button" role="tab" aria-controls="nav-user-signup" aria-selected="true">User</button>
                <button class="nav-link link2 @if(request('user') == 'merchant') active @endif" id="nav-merchant-signup-tab" data-bs-toggle="tab" data-bs-target="#nav-merchant-signup" type="button" role="tab" aria-controls="nav-merchant-signup" aria-selected="false">Merchant</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <!-- User SignUp Form-->
            <div class="tab-pane fade @if(!request('user')) show active @endif" id="nav-user-signup" role="tabpanel" aria-labelledby="nav-user-signup-tab">
                @include('partials.user_signup')
            </div>
            <!-- Merchant Form-->
            <div class="tab-pane fade @if(request('user') == 'merchant') show active @endif" id="nav-merchant-signup" role="tabpanel" aria-labelledby="nav-merchant-signup-tab">
                @include('partials.merchant_signup')
            </div>
        </div>
    </div>
    <!-- Sign-up part End -->
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="termsAndConModal" tabindex="-1">
    <div class="modal-dialog modal-fullscreen-md-down modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content terms-and-conditions">
            <div class="modal-header">
                <h1 class="modal-title fs-5">O'World Terms and Conditions</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>1. Merchant Policies:</h4>
                <b>a. Business Standards and Ethics:</b>
                <ol>
                    <li>Merchants must provide accurate information to O'World about their products, services, and related business and personal details to ensure transparency and reliability on the platform.</li>
                    <li>Upholding the highest business standards, merchants should conduct all transactions with integrity, honesty, and transparency.</li>
                </ol>

                <b>b. Customer Interaction:</b>
                <ol>
                    <li>Interactions with customers should be characterized by respect, kindness, and professionalism. The use of any form of disrespectful words or behavior is strictly prohibited.</li>
                    <li>Merchants are required to respond promptly to customer queries and concerns, particularly in situations involving changes or issues with orders before delivery.</li>
                </ol>

                <b>c. Product/Service Delivery:</b>
                <ol>
                    <li>Goods or services must be delivered in exact accordance with the marketing representations and promises made to customers.</li>
                    <li>In the event a customer receives a defective or incorrect product, merchants are obligated to initiate an immediate exchange, prioritizing customer satisfaction.</li>
                </ol>

                <b>d. Complaint Handling:</b>
                <ol>
                    <li>A merchant's profile will be temporarily blocked for 2 days if they receive three consecutive complaints, encouraging proactive resolution of customer issues.</li>
                </ol>

                <b>e. Legal Compliance:</b>
                <ol>
                    <li>Merchants are required to adhere to all legal rules, regulations, and standards applicable in Bangladesh.</li>
                    <li>Engagement in any form of illegal activity on the O'World platform, including but not limited to fraud, counterfeiting, or any activities prohibited by law, is strictly forbidden.</li>
                </ol>

                <b>f. Exclusive Registration:</b>
                <ol>
                    <li>Merchants commit to an exclusive association with O'World for a period of 4 years from the date of initial registration.</li>
                    <li>After the initial 4-year period, merchants will be required to review and explicitly agree to the terms and conditions again for continued association with O'World.</li>
                </ol>

                <h4>2. Customer Policies:</h4>
                <b>a. Personal Information:</b>
                <ol>
                    <li>Customers must provide accurate and correct personal information to ensure transparency and facilitate smooth transactions on the O'World platform. All information remains safe.</li>
                </ol>

                <b>b. Rating and Reviews:</b>
                <ol>
                    <li>Customers are expected to give accurate ratings and reviews based on their genuine experiences with the merchants.</li>
                </ol>

                <b>c. Avoiding Personal Vindictiveness:</b>
                <ol>
                    <li>Customers must refrain from trashing merchants based on personal vendettas. Reviews and ratings should be fair, objective, and related to the actual transaction.</li>
                </ol>

                <b>d. Non-Commercial Use:</b>
                <ol>
                    <li>The O'World platform is intended for personal use only. Customers must not exploit the platform for any commercial purposes.</li>
                </ol>

                <b>e. Account Usage:</b>
                <ol>
                    <li>Customers are prohibited from creating multiple accounts or posing as someone else on the O'World platform.</li>
                    <li>Failure to abide by the rules may result in the temporary blocking of customer accounts.</li>
                </ol>

                <b>f. Legal Compliance:</b>
                <ol>
                    <li>Customers must abide by all legal rules, regulations, and standards applicable in Bangladesh.</li>
                </ol>

                <b>g. Respectful Behavior:</b>
                <ol>
                    <li>Customers are expected to behave respectfully towards merchants, fostering a positive and collaborative online marketplace.</li>
                </ol>

                <h4>3. Enforcement Measures:</h4>

                <b>a. O'World reserves the right to enforce these policies through appropriate measures, including but not limited to temporary blocking of merchant and customer accounts.</b>
                <br>
                <b>b. Accounts may be reinstated upon satisfactory resolution of issues and commitment to compliance with the established terms and conditions.</b>

                <p>By utilizing the O'World platform, both merchants and customers explicitly acknowledge and agree to adhere to the comprehensive terms and conditions outlined above. O'World is committed to maintaining a fair, transparent, and reliable online marketplace for the benefit of all users.</p>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function() {

        // Function to display toast
        function showToast(type, message) {
            var toastHTML = '<div class="toast align-items-center text-white bg-' + type + ' border-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">';
            toastHTML += '<div class="d-flex"><div class="toast-body">' + message + '</div>';
            toastHTML += '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div></div>';
            var toastElement = $(toastHTML);
            $('.toast-container').append(toastElement);
            var toast = new bootstrap.Toast(toastElement[0]);
            toast.show();
        }

        // Bangladeshi phone number check
        $.validator.addMethod("phoneBD", function(phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, "");
            return this.optional(element) || (phone_number.length === 11 && /^(\+?88)?01[0-9]{9}$/.test(phone_number));
        }, "Please enter a valid Bangladeshi phone number.");

        // Check if email is already registered
        $.validator.addMethod("checkEmail", function(value, element) {
            var isSuccess = false;
            $.ajax({
                type: "POST",
                url: "{{ route('auth.checkEmailAvailability') }}",
                data: {
                    email: value,
                    _token: '{{ csrf_token() }}'
                },
                async: false,
                success: function(response) {
                    isSuccess = (response == 'available');
                }
            });
            return isSuccess;
        }, "This email is already registered.");

        // Check if phone number is already registered
        $.validator.addMethod("checkPhone", function(value, element) {
            var isSuccess = false;
            $.ajax({
                type: "POST",
                url: "{{ route('auth.checkPhoneAvailability') }}",
                data: {
                    phone: value,
                    _token: '{{ csrf_token() }}'
                },
                async: false,
                success: function(response) {
                    isSuccess = (response == 'available');
                }
            });
            return isSuccess;
        }, "This phone number is already registered.");

        // User signup form validation
        $("#userSignUp").validate({
            rules: {
                first_name: "required",
                last_name: "required",
                birth_day: "required",
                birth_month: "required",
                birth_year: "required",
                gender: "required",
                email: {
                    required: true,
                    email: true,
                    checkEmail: true
                },
                phone: {
                    required: true,
                    phoneBD: true,
                    checkPhone: true
                },
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                }
            },
            messages: {
                first_name: "Please enter your first name.",
                last_name: "Please enter your last name.",
                birth_day: "Please select your birth day.",
                birth_month: "Please select your birth month.",
                birth_year: "Please select your birth year.",
                gender: {
                    required: "Please select your gender."
                },
                email: {
                    required: "Please enter your email address.",
                    email: "Please enter a valid email address.",
                    checkEmail: "This email is already registered."
                },
                phone: {
                    required: "Please enter your phone number.",
                    phoneBD: "Please enter a valid Bangladeshi phone number.",
                    checkPhone: "This phone number is already registered."
                },
                password: {
                    required: "Please enter a password.",
                    minlength: "Your password must be at least 8 characters long."
                },
                password_confirmation: {
                    required: "Please re-enter your password.",
                    equalTo: "Please re-enter your password."
                }
            },
            errorElement: "span",
            errorPlacement: function(error, element) {
                error.addClass("invalid-feedback text-dark");
                if (element.attr("name") == "birth_day" || element.attr("name") == "birth_month" || element.attr("name") == "birth_year") {
                    error.insertAfter($(".userBirth"));
                } else if (element.attr("name") === "email") {
                    error.appendTo($("#email-error"));
                } else if (element.attr("name") === "phone") {
                    error.appendTo($("#phone-error"));
                } else if (element.attr("name") === "password") {
                    error.appendTo($("#password-error"));
                } else if (element.attr("name") === "password_confirmation") {
                    error.appendTo($("#confirm-password-error"));
                } else {
                    error.insertAfter(element);
                }
            }
        });


        // Area Required
        $.validator.addMethod("areaRequired", function(value, element) {
            var physicalStoreSelected = $("input[name='store_type[]'][value='physical']:checked").length > 0;
            if (physicalStoreSelected) {
                return $("input[name='area[]']:checked").length > 0;
            }
            return true;
        }, "Please select at least one area for physical stores.");

        // Delivery Area Required
        $.validator.addMethod("deliveryAreaRequired", function(value, element) {
            var onlineStoreSelected = $("input[name='store_type[]'][value='online']:checked").length > 0;
            if (onlineStoreSelected) {
                return $("input[name='delivery_area[]']:checked").length > 0;
            }
            return true;
        }, "Please select at least one delivery area for online stores.");

        // Initial setup
        $("#personal-details").show();
        $("#business-details").hide();
        $("#terms").hide();
        $("#progressbar li:first").addClass("active");

        // Personal Next
        $(".presonal-next").click(function() {
            var isValid = validateForm("personalDetailsForm");
            if (isValid) {
                $("#personal-details").hide();
                $("#business-details").show();
                $("#terms").hide();
                $("#progressbar li:eq(1)").addClass("active").prev().removeClass("active");
            }
        });

        // Business Details Next
        $(".business-details-next").click(function() {
            var isValid = validateForm("businessDetailsForm");
            if (isValid) {
                $("#personal-details").hide();
                $("#business-details").hide();
                $("#terms").show();
                $("#progressbar li:eq(2)").addClass("active");
            }
        });

        // Business Details Previous
        $(".business-details-previous").click(function() {
            $("#business-details").hide();
            $("#personal-details").show();
            $("#terms").hide();

            $("#progressbar li:eq(0)").addClass("active").next().removeClass("active");
        });

        // Previous button click event for terms
        $(".terms-previous").click(function() {
            $("#terms").hide();
            $("#business-details").show();

            $("#progressbar li:eq(1)").addClass("active").next().removeClass("active");
        });

        // Join Now
        $(".join-btn").click(function() {
            var isValid = validateForm("termsForm");
            if (isValid) {
                var personalDetailsFormData = $("#personalDetailsForm").serialize();
                var businessDetailsFormData = $("#businessDetailsForm").serialize();
                var termsFormData = $("#termsForm").serialize();

                // Combine form data
                var formData = personalDetailsFormData + '&' + businessDetailsFormData + '&' + termsFormData;

                $.ajax({
                    url: "{{ route('auth.signUpMerchant') }}",
                    type: "POST",
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        window.location.href = "{{ route('merchant.storeSetup') }}";
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            var errors = xhr.responseJSON.errors;
                            if (errors) {
                                // Loop through each error and display as toast
                                $.each(errors, function(key, value) {
                                    showToast('danger', value[0]);
                                });
                            }
                        } else {
                            showToast('error', 'An error occurred. Please try again later.');
                        }
                    }
                });
            }
        });

        function validateForm(formId) {
            if (formId === 'personalDetailsForm') {
                return $("#personalDetailsForm").validate({
                    rules: {
                        merchant_first_name: {
                            required: true,
                            minlength: 2
                        },
                        merchant_last_name: {
                            required: true,
                            minlength: 2
                        },
                        merchant_birth_day: {
                            required: true,
                            min: 1,
                            max: 31
                        },
                        merchant_birth_month: {
                            required: true
                        },
                        merchant_birth_year: {
                            required: true
                        },
                        merchant_gender: {
                            required: true
                        },
                        business_type: {
                            required: true
                        },
                        merchant_email: {
                            required: true,
                            email: true,
                            checkEmail: true
                        },
                        merchant_phone: {
                            required: true,
                            phoneBD: true,
                            checkPhone: true
                        },
                        merchant_password: {
                            required: true,
                            minlength: 8
                        },
                        merchant_password_confirmation: {
                            required: true,
                            equalTo: "#merchant_password"
                        }
                    },
                    messages: {
                        merchant_first_name: {
                            required: "Please enter your first name.",
                            minlength: "First name must be at least 2 characters long."
                        },
                        merchant_last_name: {
                            required: "Please enter your last name.",
                            minlength: "Last name must be at least 2 characters long."
                        },
                        merchant_birth_day: {
                            required: "Please select your birth day.",
                            min: "Invalid day. Please enter a value between 1 and 31.",
                            max: "Invalid day. Please enter a value between 1 and 31."
                        },
                        merchant_birth_month: {
                            required: "Please select your birth month."
                        },
                        merchant_birth_year: {
                            required: "Please select your birth year."
                        },
                        business_type: {
                            required: "Please select your business type."
                        },
                        merchant_gender: {
                            required: "Please select your gender."
                        },
                        merchant_email: {
                            required: "Please enter your email address.",
                            email: "Please enter a valid email address.",
                            checkEmail: "This email is already registered."
                        },
                        merchant_phone: {
                            required: "Please enter your phone number.",
                            phoneBD: "Please enter a valid Bangladeshi phone number.",
                            checkPhone: "This phone number is already registered."
                        },
                        merchant_password: {
                            required: "Please enter your password.",
                            minlength: "Password must be at least 8 characters long."
                        },
                        merchant_password_confirmation: {
                            required: "Please confirm your password.",
                            equalTo: "Passwords do not match. Please re-type your password."
                        }
                    },
                    errorElement: "span",
                    errorPlacement: function(error, element) {
                        error.addClass("invalid-feedback text-dark");
                        if (element.attr("name") == "merchant_birth_day" || element.attr("name") == "merchant_birth_month" || element.attr("name") == "merchant_birth_year") {
                            error.insertAfter($(".merchantBirth"));
                        } else if (element.attr("name") === "merchant_email") {
                            error.appendTo($("#merchant-email-error"));
                        } else if (element.attr("name") === "merchant_phone") {
                            error.appendTo($("#merchant-phone-error"));
                        } else if (element.attr("name") === "merchant_password") {
                            error.appendTo($("#merchant-password-error"));
                        } else if (element.attr("name") === "merchant_password_confirmation") {
                            error.appendTo($("#merchant-confirm-password-error"));
                        } else {
                            error.insertAfter(element);
                        }
                    }
                }).form();
            } else if (formId === 'businessDetailsForm') {
                return $("#businessDetailsForm").validate({
                    ignore: [],
                    rules: {
                        business_name: {
                            required: true
                        },
                        facebook: {
                            required: true
                        },
                        'category_id[]': {
                            required: true
                        },
                        'store_type[]': {
                            required: true
                        },
                        'area[]': {
                            areaRequired: true
                        },
                        'delivery_area[]': {
                            deliveryAreaRequired: true
                        }
                    },
                    messages: {
                        business_name: {
                            required: "Please enter your business name."
                        },
                        facebook: {
                            required: "Please enter your Facebook URL."
                        },
                        'category_id[]': {
                            required: "Please select at least one category."
                        },
                        'store_type[]': {
                            required: "Please select at least one store type."
                        },
                        'area[]': {
                            areaRequired: "Please select at least one area."
                        },
                        'delivery_area[]': {
                            deliveryAreaRequired: "Please select at least one delivery area."
                        }
                    },
                    errorElement: "span",
                    errorPlacement: function(error, element) {
                        error.addClass("invalid-feedback text-danger");
                        if (element.attr("name") === "category_id[]") {
                            error.appendTo($("#category-error"));
                        } else if (element.attr("name") === "store_type[]") {
                            error.appendTo($("#store-type-error"));
                        } else if (element.attr("name") === "area[]") {
                            error.appendTo($("#area-error"));
                        } else if (element.attr("name") === "delivery_area[]") {
                            error.appendTo($("#delivery-area-error"));
                        } else {
                            error.insertAfter(element);
                        }
                    }
                }).form();

            } else if (formId === 'termsForm') {
                return $("#termsForm").validate({
                    rules: {
                        accept_terms_and_conditions: {
                            required: true
                        }
                    },
                    messages: {
                        accept_terms_and_conditions: {
                            required: "Please accept the terms and conditions to proceed."
                        }
                    },
                    errorElement: "span",
                    errorPlacement: function(error, element) {
                        error.addClass("invalid-feedback text-dark");
                        error.insertAfter(element.parent());
                    }
                }).form();
            }
        }

        // Toggle Parts Visibility
        function togglePartsVisibility() {
            var physicalChecked = $('#storeTypePhysical').is(':checked');
            var onlineChecked = $('#storeTypeOnline').is(':checked');

            $('.area-part, .address-part, .delivery-area-part').hide();

            if (physicalChecked && onlineChecked) {
                $('.area-part, .address-part, .delivery-area-part').show();
            } else if (physicalChecked) {
                $('.area-part, .address-part').show();
            } else if (onlineChecked) {
                $('.delivery-area-part').show();
            }
        }

        togglePartsVisibility();

        $('#storeTypePhysical, #storeTypeOnline').change(function() {
            togglePartsVisibility();
        });

        // Address Dynamic
        $('input[name^="area"]').change(function() {
            var areaValue = $(this).val();

            if ($(this).is(':checked')) {
                var capitalizedAreaValue = areaValue.replace(/_/g, ' ').replace(/\b\w/g, function(char) {
                    return char.toUpperCase();
                });

                var addressInput = '<div class="mb-3 address' + areaValue + '">' +
                    '<label class="form-label">' + capitalizedAreaValue + ' Address</label>' +
                    '<textarea name="address[' + areaValue + ']" class="form-control" placeholder="Enter your address" required></textarea>' +
                    '</div>';

                $('.address-part').append(addressInput);
            } else {
                $('.address-part .address' + areaValue).remove();
            }
        }).change();

        // Delivery Area All Check 
        $('#deliveryAreaAllCheckbox').click(function() {
            $('input[name="delivery_area[]"]').prop('checked', $(this).prop('checked'));
        });

        $('input[name="delivery_area[]"]').click(function() {
            if (!$(this).prop('checked')) {
                $('#deliveryAreaAllCheckbox').prop('checked', false);
            } else {
                if ($('input[name="delivery_area[]"]:checked').length === $('input[name="delivery_area[]"]').length) {
                    $('#deliveryAreaAllCheckbox').prop('checked', true);
                }
            }
        });

        // Function to handle checking/unchecking checkbox based on business type
        function handleBusinessType() {
            if ($('select[name="business_type"]').val() === 'restaurant') {
                $('#category13Checkbox').prop('checked', true);
            } else {
                $('#category13Checkbox').prop('checked', false);
            }
        }

        // Call the function on page load
        handleBusinessType();

        // Call the function when select element changes
        $('select[name="business_type"]').change(function() {
            handleBusinessType();
        });


        $(document).on('click', '.toggle-password', function() {
            var passwordField = $(this).closest('.input-group').find('input');
            var fieldType = passwordField.attr('type');
            if (fieldType === 'password') {
                passwordField.attr('type', 'text');
                $(this).html('<i class="fas fa-eye"></i>');
            } else {
                passwordField.attr('type', 'password');
                $(this).html('<i class="fas fa-eye-slash"></i>');
            }
        });

    });
</script>
@endpush