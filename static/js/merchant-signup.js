$(document).ready(function () {

    // Bangladeshi phone number check
    $.validator.addMethod("phoneBD", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return this.optional(element) || (phone_number.length === 11 && /^(\+?88)?01[0-9]{9}$/.test(phone_number));
    }, "Please enter a valid Bangladeshi phone number.");

    // Check if email is already registered
    $.validator.addMethod("checkEmail", function (value, element) {
        var isSuccess = false;
        $.ajax({
            type: "POST",
            url: "{{ route('auth.checkEmailAvailability') }}",
            data: {
                email: value,
                _token: '{{ csrf_token() }}'
            },
            async: false,
            success: function (response) {
                isSuccess = (response == 'available');
            }
        });
        return isSuccess;
    }, "This email is already registered.");

    // Check if phone number is already registered
    $.validator.addMethod("checkPhone", function (value, element) {
        var isSuccess = false;
        $.ajax({
            type: "POST",
            url: "{{ route('auth.checkPhoneAvailability') }}",
            data: {
                phone: value,
                _token: '{{ csrf_token() }}'
            },
            async: false,
            success: function (response) {
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
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback text-dark");
            if (element.attr("name") == "birth_day" || element.attr("name") == "birth_month" || element.attr("name") == "birth_year") {
                error.insertAfter($(".userBirth"));
            } else if (element.attr("name") === "email") {
                error.appendTo($("#email-error"));
            } else if (element.attr("name") === "phone") {
                error.appendTo($("#phone-error"));
            } else {
                error.insertAfter(element);
            }
        }
    });


    // Area Required
    $.validator.addMethod("areaRequired", function (value, element) {
        var physicalStoreSelected = $("input[name='store_type[]'][value='physical']:checked").length > 0;
        if (physicalStoreSelected) {
            return $("input[name='area[]']:checked").length > 0;
        }
        return true;
    }, "Please select at least one area for physical stores.");

    // Delivery Area Required
    $.validator.addMethod("deliveryAreaRequired", function (value, element) {
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
    $(".presonal-next").click(function () {
        var isValid = validateForm("personalDetailsForm");
        if (isValid) {
            $("#personal-details").hide();
            $("#business-details").show();
            $("#terms").hide();
            $("#progressbar li:eq(1)").addClass("active").prev().removeClass("active");
        }
    });

    // Business Details Next
    $(".business-details-next").click(function () {
        var isValid = validateForm("businessDetailsForm");
        if (isValid) {
            $("#personal-details").hide();
            $("#business-details").hide();
            $("#terms").show();
            $("#progressbar li:eq(2)").addClass("active");
        }
    });

    // Business Details Previous
    $(".business-details-previous").click(function () {
        $("#business-details").hide();
        $("#personal-details").show();
        $("#terms").hide();

        $("#progressbar li:eq(0)").addClass("active").next().removeClass("active");
    });

    // Previous button click event for terms
    $(".terms-previous").click(function () {
        $("#terms").hide();
        $("#business-details").show();

        $("#progressbar li:eq(1)").addClass("active").next().removeClass("active");
    });

    // Join Now
    $(".join-btn").click(function () {
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
                success: function (response) {
                    window.location.href = "{{ url('store') }}/" + response.store_id;
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
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
                errorPlacement: function (error, element) {
                    error.addClass("invalid-feedback text-dark");
                    if (element.attr("name") == "merchant_birth_day" || element.attr("name") == "merchant_birth_month" || element.attr("name") == "merchant_birth_year") {
                        error.insertAfter($(".merchantBirth"));
                    } else if (element.attr("name") === "merchant_email") {
                        error.appendTo($("#merchant-email-error"));
                    } else if (element.attr("name") === "merchant_phone") {
                        error.appendTo($("#merchant-phone-error"));
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
                errorPlacement: function (error, element) {
                    error.addClass("invalid-feedback text-dark");
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
                errorPlacement: function (error, element) {
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

    $('#storeTypePhysical, #storeTypeOnline').change(function () {
        togglePartsVisibility();
    });

    // Address Dynamic
    $('input[name^="area"]').change(function () {
        var areaValue = $(this).val();

        if ($(this).is(':checked')) {
            var capitalizedAreaValue = areaValue.replace(/_/g, ' ').replace(/\b\w/g, function (char) {
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
    $('#deliveryAreaAllCheckbox').click(function () {
        $('input[name="delivery_area[]"]').prop('checked', $(this).prop('checked'));
    });

    $('input[name="delivery_area[]"]').click(function () {
        if (!$(this).prop('checked')) {
            $('#deliveryAreaAllCheckbox').prop('checked', false);
        } else {
            if ($('input[name="delivery_area[]"]:checked').length === $('input[name="delivery_area[]"]').length) {
                $('#deliveryAreaAllCheckbox').prop('checked', true);
            }
        }
    });
});