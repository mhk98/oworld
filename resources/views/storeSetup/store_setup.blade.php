@extends('layouts.base')
@section('content')

<!-- Profile Setup part Start -->
<div class="setup-body">
    <div class="setup-content">
        <div class="profile-setup">

            @if(request('step') == 'category' || request('step') == 'external_links' || request('step') == 'filters' || request('step') == 'filters')
            <div class="title">
                <h6>Store Details</h6>
            </div>
            @endif

            <div class="part-3">

                @if(empty(request('step')) || request('step') == 'picture')
                <form action="{{ route('merchant.storeSetup') }}" method="post" enctype="multipart/form-data" class="uploadForm" id="pictureForm">
                    @csrf
                    <input type="hidden" name="step" value="picture">
                    <div class="uplode-part">
                        <h6 class="title3">Profile picture</h6>
                        <div class="box1">
                            <div class="upload-box">
                                <input type="file" id="file-input" name="profile_picture" accept="image/*">
                                <label for="file-input">
                                    <img id="preview-image" src="{{ asset('static/images/placeholder.jpg') }}" alt="Upload Image">
                                </label>
                            </div>
                        </div>
                        <div id="profile-picture-error" class="invalid-feedback text-center text-danger"></div>

                        <h6 class="title3">Cover picture</h6>
                        <div class="box2">
                            <div class="upload-box2">
                                <input type="file" id="file-input2" name="cover_picture" accept="image/*">
                                <label for="file-input2">
                                    <img id="preview-image2" src="{{ asset('static/images/placeholder.jpg') }}" alt="Upload Image">
                                </label>
                            </div>
                        </div>
                        <div id="cover-picture-error" class="invalid-feedback text-start text-danger"></div>
                    </div>
                    <div class="btns pt-4 d-flex justify-content-end">
                        <button type="submit" class="n-page">Next</button>
                    </div>
                </form>

                @elseif(request('step') == 'category')
                <form action="{{ route('merchant.storeSetup') }}" method="post" enctype="multipart/form-data" class="categoryPart" id="categoryForm">
                    @csrf
                    <input type="hidden" name="step" value="category">
                    <div class="px-1">


                        <div class="category-part mb-3">
                            <h3 class="title3 p-0 pb-2 text-start">Category</h6>

                                <!-- Category -->
                                <h6 class="main-categories text-start mb-3">
                                    @if($store->mainCategories->isNotEmpty())
                                    {{ $store->mainCategories->pluck('title')->implode(', ') }}
                                    @endif
                                </h6>

                                <h3 class="title3 p-0 pb-2 text-start">Sub-category</h6>

                                    <!-- Sub Category -->
                                    <div class="sub-category-part mb-3">
                                        <div class="accordion" id="categoryAccordion">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingSubCategory">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSubCategory" aria-expanded="true" aria-controls="collapseSubCategory">
                                                        Select Sub-category
                                                    </button>
                                                </h2>
                                                <div id="collapseSubCategory" class="accordion-collapse collapse" aria-labelledby="headingSubCategory" data-bs-parent="#categoryAccordion">
                                                    <div class="accordion-body" id="subCategories">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="sub-category-error" class="invalid-feedback text-center text-danger">
                                        </div>
                                    </div>

                                    <div class="products-part mb-3">
                                        <h3 class="title3 p-0 pb-2 text-start">Products</h3>
                                        <input type="text" name="products" class="form-control mb-4" value="{{ old('products') }}" data-role="tagsinput">
                                        <small class="form-text text-muted">Enter product names separated by commas (e.g., Product1, Product2).</small>
                                    </div>

                                    <div class="services-part mb-3">
                                        <h3 class="title3 p-0 pb-2 text-start">Services</h3>
                                        <input type="text" name="services" class="form-control mb-3" value="{{ old('services') }}" data-role="tagsinput">
                                        <small class="form-text text-muted">Enter service names separated by commas (e.g., Service1, Service2).</small>
                                    </div>

                        </div>


                        <div class="btns part-c4 mt-5 d-flex justify-content-between px-3">
                            <a href="{{ url()->current() }}?step=picture" class="p-page">Back</a>
                            <button type="submit" class="n-page">Next</button>
                        </div>

                </form>
                @elseif(request('step') == 'external_links')
                <form action="{{ route('merchant.storeSetup') }}" method="post" enctype="multipart/form-data" id="linksForm">
                    @csrf
                    <input type="hidden" name="step" value="external_links">
                    <div class="px-5 slid-content part-url5">
                        <h6 class="title3 p-0 pb-4 text-start">External Links <span>(optional)</span></h6>
                        <h6 class="title4 d-flex"><img src="{{ asset('static/images/fb2.jpg') }}" alt="Facebook"> {{ ucfirst(Helper::socialMediaUsername($store->facebook, 'facebook')) }}</h6>

                        <!-- Twitter URL -->
                        <div class="mb-4">
                            <label class="form-label">Twitter URL <i class="fab fa-twitter"></i></label>
                            <input type="url" name="twitter" class="form-control" placeholder="Your Twitter URL">
                        </div>

                        <!-- Instagram URL -->
                        <div class="mb-4">
                            <label class="form-label">Instagram URL <i class="fab fa-instagram"></i></label>
                            <input type="url" name="instagram" class="form-control" placeholder="Your Instagram URL">
                        </div>

                        <!-- LinkedIn URL -->
                        <div class="mb-4">
                            <label class="form-label">LinkedIn URL <i class="fab fa-linkedin"></i></label>
                            <input type="url" name="linkedin" class="form-control" placeholder="Your LinkedIn URL">
                        </div>

                        <!-- Website URL -->
                        <div class="mb-4">
                            <label class="form-label">Website URL <i class="fas fa-globe"></i></label>
                            <input type="url" name="website" class="form-control" placeholder="Your Website URL">
                        </div>
                    </div>


                    <div class="btns part-url5 d-flex justify-content-between px-3">
                        <a href="{{ url()->current() }}?step=picture" class="p-page">Back</a>
                        <button type="submit" class="n-page">Next</button>
                    </div>
                </form>
                @elseif(request('step') == 'filters')
                <form action="{{ route('merchant.storeSetup') }}" method="post" enctype="multipart/form-data" id="filters">
                    @csrf
                    <input type="hidden" name="step" value="filters">
                    
                    <div class="px-5 slid-content part-check6">
                        <h6 class="title3 p-0 pb-4 text-start">Additional Filters <span>(optional)</span></h6>

                        <div class="check-part">
                            
                        @if(count(array_intersect([1, 2, 3, 6, 8, 9, 10, 11, 12], $store->mainCategories->pluck('id')->toArray())) > 0)
    <div class="row black-border-bottom mb-3 pb-2">
        <div class="col">
            <label class="check-container">Pre-order
                <input type="checkbox" name="pre_order" value="yes" checked="checked">
                <span class="checkmark"></span>
            </label>
        </div>

        <div class="col">
            <label class="check-container">In Stock
                <input type="checkbox" name="in_stock" value="yes" checked="checked">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
@endif

    <div class="row black-border-bottom mb-3 pb-2">
    @if(in_array(8, $store->mainCategories->pluck('id')->toArray()))
            <div class="col">
            <label class="check-container">Organic
                <input type="checkbox" name="organic" value="yes" checked="checked">
                <span class="checkmark"></span>
            </label>
        </div>
    @endif

    @if(!in_array(4, $store->mainCategories->pluck('id')->toArray()) && !in_array(12, $store->mainCategories->pluck('id')->toArray()))
        <div class="col">
            <label class="check-container">Home delivery
                <input type="checkbox" name="home_delivery" value="yes" checked="checked">
                <span class="checkmark"></span>
            </label>
        </div>
    @endif

    </div>

    @if(count(array_intersect([1, 2, 5, 7], $store->mainCategories->pluck('id')->toArray())) > 0)
    <div class="row black-border-bottom mb-3 pb-2">
        <div class="col">
            <label class="check-container">Men
                <input type="checkbox" name="men" value="yes" checked="checked">
                <span class="checkmark"></span>
            </label>
        </div>

        <div class="col">
            <label class="check-container">Women
                <input type="checkbox" name="women" value="yes" checked="checked">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
    @endif

    @if(count(array_intersect([1,2,3,6,7,8,9,11], $store->mainCategories->pluck('id')->toArray())) > 0)
    <div class="row black-border-bottom mb-3 pb-2">
        <div class="col">
            <label class="check-container">Imported
                <input type="checkbox" name="imported" value="yes" checked="checked">
                <span class="checkmark"></span>
            </label>
        </div>

        <div class="col">
            <label class="check-container">Local
                <input type="checkbox" name="local" value="yes" checked="checked">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>  
    @endif

    @if(in_array(13, $store->mainCategories->pluck('id')->toArray()))
    <div class="row black-border-bottom mb-3 pb-2">
        <div class="col">
            <label class="check-container">Cuisine
                <input type="checkbox" name="cuisine" value="yes" checked="checked">
                <span class="checkmark"></span>
            </label>
        </div>

        <div class="col">
            <label class="check-container">Indoor
                <input type="checkbox" name="indoor" value="yes" checked="checked">
                <span class="checkmark"></span>
            </label>
        </div>
    </div> 

    <div class="row black-border-bottom mb-3 pb-2">
        <div class="col">
            <label class="check-container">Outdoor
                <input type="checkbox" name="outdoor" value="yes" checked="checked">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
    @endif

</div>
                    </div>

                    <div class="btns d-flex justify-content-between p-3">
                        <a href="{{ url()->current() }}?step=external_links" class="p-page">Back</a>
                        <button type="submit" class="n-page lg-btn">Go to your store</button>
                    </div>
                </form>
                @endif

                <ul class="page-dots text-center">
                    @foreach(['picture', 'category', 'external_links', 'filters'] as $step)
                    <li class="{{ request()->is('merchant/store-setup*') && request()->input('step') == $step ? 'active' : '' }}">
                        <a href="javascript:void(0):">
                            <i class="{{ request()->is('merchant/store-setup*') && request()->input('step') == $step ? 'far' : 'fas' }} fa-circle"></i>
                        </a>
                    </li>
                    @endforeach
                </ul>

            </div>
        </div>
    </div>
</div>
<!-- Profile Setup part End -->
@endsection
@push('js')
<script src="{{ asset('static/vendors/tagsinput/bootstrap-tagsinput.js') }}"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {

        // Clear file inputs
        $("#file-input, #file-input2").val('');

        // Picture Form
        $("#pictureForm").submit(function(event) {
            event.preventDefault();

            // Validate profile picture
            var profilePicture = $("#file-input").get(0).files[0];
            if (!profilePicture) {
                $("#profile-picture-error").text("Please upload a profile picture.");
                return false;
            } else if (!profilePicture.type.match('image.*')) {
                $("#profile-picture-error").text("Please upload an image file.");
                return false;
            } else {
                $("#profile-picture-error").text("");
            }

            // Validate cover picture
            var coverPicture = $("#file-input2").get(0).files[0];
            if (!coverPicture) {
                $("#cover-picture-error").text("Please upload a cover picture.");
                return false;
            } else if (!coverPicture.type.match('image.*')) {
                $("#cover-picture-error").text("Please upload an image file.");
                return false;
            } else {
                $("#cover-picture-error").text("");
            }

            // If all validations pass, submit the form
            this.submit();
        });


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

        // upload box
        $('#file-input2').change(function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#preview-image2').attr('src', event.target.result);
                };
                reader.readAsDataURL(file);
            }
        });

        @php
        $mainCategoryIds = $store->mainCategories->isNotEmpty() ? $store->mainCategories->pluck('id')->toArray() : [];
        @endphp



        // Function to update sub-categories
        var mainCategories = @json($mainCategoryIds);

        // Function to update sub-categories
        function updateSubcategories() {
            if (mainCategories.length > 0) {
                $.ajax({
                    url: '{{ route("merchant.getSubcategories") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        mainCategories: mainCategories
                    },
                    success: function(data) {
                        $('#subCategories').html(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            } else {
                $('#subCategories').empty();
            }
        }

        // Update sub-categories when main categories change
        $(document).ready(function() {
            updateSubcategories();
        });

        // Initial update of sub-categories
        updateSubcategories();
    });
</script>
@endpush