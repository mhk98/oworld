<!-- Basic settings content goes here -->
<form action="{{ route('merchant.storeSetting') }}" id="storeSetting" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="step" value="basic">

    <!-- Business Name -->
    <div class="mb-4">
        <label class="form-label">Business Name</label>
        <input type="text" name="business_name" class="form-control" value="{{ old('business_name', $store->business_name) }}" disabled>
        @error('business_name')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="image-box mb-2">
        <label class="form-label">Profile Picture</label>
        <div class="image-box-preview">
            <img id="profile_image" src="{{ !empty($store->profile_picture) ? asset('media/'.$store->profile_picture) : asset('static/admin/images/default.jpg') }}" alt="Profile Image">
        </div>
        <div class="image-box-select">
            <input type="file" name="profile_picture" class="image-input @error('profile_picture') is-invalid @enderror" id="profile_file" accept=".png, .jpg, .jpeg">
            <label for="profile_file">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                </svg> <span>Change Logo &hellip;</span>
            </label>
        </div>
        @error('profile_picture')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <div class="image-box mb-1">
        <label class="form-label">Cover Picture</label>
        <div class="image-box-preview">
            <img id="cover_image" src="{{ !empty($store->cover_picture) ? asset('media/'.$store->cover_picture) : asset('static/admin/images/default.jpg') }}" alt="Cover Image">
        </div>
        <div class="image-box-select">
            <input type="file" name="cover_picture" class="image-input @error('cover_picture') is-invalid @enderror" id="cover_file" accept=".png, .jpg, .jpeg">
            <label for="cover_file">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                </svg> <span>Change Cover &hellip;</span>
            </label>
        </div>
        @error('cover_picture')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>


    <!-- Store Type -->
    <label class="form-label">Store Type <span class="text-danger">*</span></label>
    <div class="row">
        <div class="col-6">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="store_type[]" value="online" id="storeTypeOnline" {{ in_array('online', $store->store_type) ? 'checked' : '' }}>
                <label class="form-check-label" for="storeTypeOnline">
                    Online Store
                </label>
            </div>
        </div>
        <div class="col-6">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="store_type[]" value="physical" id="storeTypePhysical" {{ in_array('physical', $store->store_type) ? 'checked' : '' }}>
                <label class="form-check-label" for="storeTypePhysical">
                    Physical Store
                </label>
            </div>
        </div>
    </div>

    @error('store_type')
    <div class="invalid-feedback text-danger mt-1" role="alert">
        <strong>{{ $message }}</strong>
    </div>
    @enderror

    <!-- Category -->
    <div class="category-part category-accordion p-0 mt-4 mb-3">
        <div class="accordion" id="categoryAccordion">
            <label for="" class="form-label">Category <span class="text-danger">*</span></label>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        Select Category
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#categoryAccordion">
                    <div class="accordion-body">
                        @if($categories)
                        @foreach($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="category_id[]" value="{{ $category->id }}" id="category{{ $category->id }}Checkbox" {{ !empty($store->mainCategories) && in_array($category->id, $store->mainCategories->pluck('id')->toArray()) ? 'checked' : '' }}>
                            <label class="form-check-label" for="category{{ $category->id }}Checkbox">{{ $category->title }}</label>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @error('category_id')
        <div class="invalid-feedback text-danger mt-1" role="alert">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
    </div>


    <!-- Sub Category -->
    <div class="sub-category-part category-accordion p-0 mb-3">
        <div class="accordion" id="subCategoryAccordion">
            <label for="" class="form-label">Sub Category <span class="text-danger">*</span></label>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingSubCategory">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSubCategory" aria-expanded="true" aria-controls="collapseSubCategory">
                        Select Sub-category
                    </button>
                </h2>
                <div id="collapseSubCategory" class="accordion-collapse collapse" aria-labelledby="headingSubCategory" data-bs-parent="#subCategoryAccordion">
                    <div class="accordion-body" id="subCategories">

                    </div>
                </div>
            </div>
        </div>
        @error('sub_category_id')
        <div class="invalid-feedback text-danger mt-1" role="alert">
            <strong>{{ $message }}</strong>
        </div>
        @enderror
    </div>


    <div class="products-part mb-3">
    <label class="form-label p-0 pb-2">Products </label>
                                    <input type="text" name="products" class="form-control mb-4" value="{{ old('products', $store->products->pluck('product')->implode(',')) }}" data-role="tagsinput">
                                    <small class="form-text text-muted">Enter product names separated by commas (e.g., Product1, Product2).</small>
                                </div>

                                <div class="services-part mb-3">
                                <label class="form-label p-0 pb-2">Services </label>
                                    <input type="text" name="services" class="form-control mb-3" value="{{ old('services', $store->services->pluck('service')->implode(',')) }}" data-role="tagsinput">
                                    <small class="form-text text-muted">Enter service names separated by commas (e.g., Service1, Service2).</small>
                                </div>

                                <!-- Tags -->
                                <div class="tags mb-3">
<label class="form-label">Tiles Tags <span class="text-danger">*</span></label>

@if(count(array_intersect([1, 2, 3, 6, 8, 9, 10, 11, 12], $store->mainCategories->pluck('id')->toArray())) > 0)
<!-- Pre-order -->
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="tags[]" value="pre_order" id="tagPreOrder" {{ !empty($store->tags) && in_array('pre_order', $store->tags) ? 'checked' : '' }}>
    <label class="form-check-label" for="tagPreOrder">Pre-order</label>
</div>

<!-- In Stock -->
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="tags[]" value="in_stock" id="tagInStock" {{ !empty($store->tags) && in_array('in_stock', $store->tags) ? 'checked' : '' }}>
    <label class="form-check-label" for="tagInStock">In Stock</label>
</div>
@endif

@if(count(array_intersect([1, 2, 5, 7], $store->mainCategories->pluck('id')->toArray())) > 0)
<!-- Men -->
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="tags[]" value="men" id="tagMen" {{ !empty($store->tags) && in_array('men', $store->tags) ? 'checked' : '' }}>
    <label class="form-check-label" for="tagMen">Men</label>
</div>

<!-- Women -->
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="tags[]" value="women" id="tagWomen" {{ !empty($store->tags) && in_array('women', $store->tags) ? 'checked' : '' }}>
    <label class="form-check-label" for="tagWomen">Women</label>
</div>
@endif

@if(count(array_intersect([1,2,3,6,7,8,9,11], $store->mainCategories->pluck('id')->toArray())) > 0)
<!-- Imported -->
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="tags[]" value="imported" id="tagImported" {{ !empty($store->tags) && in_array('imported', $store->tags) ? 'checked' : '' }}>
    <label class="form-check-label" for="tagImported">Imported</label>
</div>

<!-- Local -->
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="tags[]" value="local" id="tagLocal" {{ !empty($store->tags) && in_array('local', $store->tags) ? 'checked' : '' }}>
    <label class="form-check-label" for="tagLocal">Local</label>
</div>
@endif

@if(in_array(8, $store->mainCategories->pluck('id')->toArray()))
<!-- Organic -->
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="tags[]" value="organic" id="tagOrganic" {{ !empty($store->tags) && in_array('organic', $store->tags) ? 'checked' : '' }}>
    <label class="form-check-label" for="tagOrganic">Organic</label>
</div>
@endif

@if(!in_array(4, $store->mainCategories->pluck('id')->toArray()) && !in_array(12, $store->mainCategories->pluck('id')->toArray()))
<!-- Home Delivery -->
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="tags[]" value="home_delivery" id="tagHomeDelivery" {{ !empty($store->tags) && in_array('home_delivery', $store->tags) ? 'checked' : '' }}>
    <label class="form-check-label" for="tagHomeDelivery">Home Delivery</label>
</div>
@endif

@if(in_array(13, $store->mainCategories->pluck('id')->toArray()))
<!-- Cuisine -->
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="tags[]" value="cuisine" id="tagCuisine" {{ !empty($store->tags) && in_array('cuisine', $store->tags) ? 'checked' : '' }}>
    <label class="form-check-label" for="tagCuisine">Cuisine</label>
</div>

<!-- Indoor -->
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="tags[]" value="indoor" id="tagIndoor" {{ !empty($store->tags) && in_array('indoor', $store->tags) ? 'checked' : '' }}> 
    <label class="form-check-label" for="tagIndoor">Indoor</label>
</div>

<!-- Outdoor -->
<div class="form-check">
    <input class="form-check-input" type="checkbox" name="tags[]" value="outdoor" id="tagOutdoor" {{ !empty($store->tags) && in_array('outdoor', $store->tags) ? 'checked' : '' }}>
    <label class="form-check-label" for="tagOutdoor">Outdoor</label>
</div>
@endif

@error('tags')
<div class="invalid-feedback text-danger mt-1" role="alert">
    <strong>{{ $message }}</strong>
</div>
@enderror

<div class="form-text text-danger tags-error"></div>
                                </div>


    <!-- Email -->
    <div class="mb-4">
        <label class="form-label">Email <span class="text-danger">*</span></label>
        <input type="email" name="email" class="form-control" value="{{ $store->email }}" required>
        @error('email')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <!-- Phone -->
    <div class="mb-4">
        <label class="form-label">Phone <span class="text-danger">*</span></label>
        <input type="tel" name="phone" class="form-control" value="{{ old('phone', $store->phone) }}" required>
        @error('phone')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <!-- Established Since -->
    <div class="mb-4">
        <label class="form-label">Established Since <span class="text-danger">*</span></label>
        <input type="text" name="established_since" class="form-control" value="{{ old('established_since', $store->established_since) }}" required>
        @error('established_since')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <!-- Intro -->
    <div class="mb-4">
        <label class="form-label">Intro <span class="text-danger">*</span></label>
        <textarea name="intro" class="form-control" rows="4" required>{{ old('intro', $store->intro) }}</textarea>
        @error('intro')
        <span class="invalid-feedback text-danger" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>

    <button class="btn submit-btn" type="submit">Save Changes</button>
</form>

@push('js')
<script>
$(document).ready(function(){
    var maxChecked = 3;
    $('input[name="tags[]"]').change(function(){
        var checked = $('input[name="tags[]"]:checked').length;
        if(checked > maxChecked){
            $(this).prop('checked', false);
            $('.tags-error').text('You can only select up to ' + maxChecked + ' tags.');
        } else {
            $('.tags-error').text('');
        }
    });
});
</script>
@endpush