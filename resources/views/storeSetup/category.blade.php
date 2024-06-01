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
    <div class="store-details-title">
        <h2>Store Details</h2>
    </div>

    <div class="setup-category">
        <form action="{{ route('merchant.category') }}" method="post" enctype="multipart/form-data" id="categoryForm">
            @csrf
            <div class="category-part mb-3">
                <h3 class="category-title text-start">Category</h6>

                    <!-- Category -->
                    <h6 class="main-categories text-start mb-3">
                        @if($store->mainCategories->isNotEmpty())
                        {{ $store->mainCategories->pluck('title')->implode(', ') }}
                        @endif
                    </h6>

                    <h3 class="sub-category-title text-start">Sub-category</h6>

                        <!-- Sub Category -->
                        <div class="sub-category-part mb-3">
                            <div class="accordion" id="subCategoryAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingSubCategory">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSubCategory" aria-expanded="true" aria-controls="collapseSubCategory">
                                            Select Sub-category
                                        </button>
                                    </h2>
                                    <div id="collapseSubCategory" class="accordion-collapse collapse" aria-labelledby="headingSubCategory" data-bs-parent="#subCategoryAccordion">
                                        <div class="accordion-body">
                                            <div id="subCategories"></div>

                                            <!-- Error message -->
                                            <div id="sub-category-error" class="invalid-feedback text-danger" style="display: none;">
                                                Please select at least one sub-category.
                                            </div>

                                            <!-- Apply button -->
                                            <button type="button" class="btn btn-default btn-apply mt-3" id="applyButton">Apply</button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="sub-category-error" class="invalid-feedback text-center text-danger">
                            </div>
                        </div>

                        <div class="products-part mb-3">
                            <h3 class="products-title text-start">Products</h3>
                            <input type="text" name="products" class="form-control mb-4" value="{{ old('products', $store->products->pluck('product')->implode(',')) }}" data-role="tagsinput">
                            <small class="form-text text-muted">Enter product names separated by commas (e.g., Product1, Product2).</small>
                        </div>

                        <div class="services-part mb-3">
                            <h3 class="services-title text-start">Services</h3>
                            <input type="text" name="services" class="form-control mb-3" value="{{ old('services', $store->services->pluck('service')->implode(',')) }}" data-role="tagsinput">
                            <small class="form-text text-muted">Enter service names separated by commas (e.g., Service1, Service2).</small>
                        </div>

            </div>

            <div class="store-setup-btns pt-4 d-flex justify-content-between">
                <a href="{{ route('merchant.pictureForm') }}" class="btn btn-default btn-back">Back</a>
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
    </ul>
</div>
<!-- Store setup part end -->
@endsection
@push('js')
<script>
    $(document).ready(function() {

        $('#applyButton').on('click', function() {
            var isChecked = $('input[name="sub_category_id[]"]:checked').length > 0;

            if (!isChecked) {
                $('#sub-category-error').show();
            } else {
                $('#sub-category-error').hide();
                $('#collapseSubCategory').collapse('hide');
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