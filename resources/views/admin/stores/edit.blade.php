@extends('layouts.admin.base')
@section('title', 'Edit Store | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.stores.index') }}">Categories</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Store</li>
    </ol>
</nav>
<form action="{{ route('admin.stores.update', $store->id) }}" method="post" enctype="multipart/form-data" id="editStoreForm">
    @csrf
    @method('put')
    <div class="row g-3">
        <div class="col-md-9">
            <div class="card my-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">Edit Store</h6>
                </div>
                <div class="card-body p-2">

                    <div class="mb-3">
                        <label class="form-label">Business Name <span class="text-danger">*</span></label>
                        <input type="text" name="business_name" class="form-control @error('business_name') is-invalid @enderror" id="business_name" value="{{ old('business_name', $store->business_name) }}" placeholder="Enter Business Name" disabled>
                        @error('business_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Merchant <span class="text-danger">*</span></label>
                        <select class="form-select @error('merchant_id') is-invalid @enderror" id="merchant" name="merchant_id" required>
                            @if($merchants->count() > 0)
                            @foreach($merchants as $merchant)
                            <option value="{{ $merchant->id }}" {{ $store->merchant_id==$merchant->id ? 'selected' : ''}}>{{ $merchant->first_name . ' ' . $merchant->last_name }}</option>
                            @endforeach
                            @endif
                        </select>
                        @error('merchant_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Business Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('business_type') is-invalid @enderror" name="business_type" required>
                            <option value="products_and_services" {{ $store->business_type=='products_and_services' ? 'selected' : '' }}>Products and Services</option>
                            <option value="restaurant" {{ $store->business_type=='restaurant' ? 'selected' : '' }}>Restaurant</option>
                        </select>
                        @error('business_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Store Type <span class="text-danger">*</span></label>

                        <div class="row mb-4">
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="store_type[]" value="physical" id="storeTypePhysical" {{ in_array('physical', $store->store_type) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="storeTypePhysical">
                                        Physical Store
                                    </label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="store_type[]" value="online" id="storeTypeOnline" {{ in_array('online', $store->store_type) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="storeTypeOnline">
                                        Online Store
                                    </label>
                                </div>
                            </div>
                        </div>

                        @error('store_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <!-- Category -->
                    <div class="category-part">
                        <div class="accordion mb-3" id="categoryAccordion">
                            <label for="" class="form-label">Category <span class="text-danger">*</span></label>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                        Select Category
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#categoryAccordion">
                                    <div class="accordion-body">
                                        @if($allCategories)
                                        @foreach($allCategories as $category)
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
                        <span id="category-error" class="invalid-feedback text-dark">
                        </span>
                    </div>


                    <!-- Sub Category -->
                    <div class="sub-category-part category-accordion mb-3">
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

                    <!-- Products -->
                    <div class="mb-4">
                        <label class="form-label">Products</label>
                        <input type="text" name="products" class="form-control" value="{{ old('products', $store->products->pluck('product')->implode(',')) }}" data-role="tagsinput">
                        <small class="form-text text-muted">Enter product names separated by commas (e.g., Product1, Product2).</small>
                        @error('products')
                        <span class="invalid-feedback text-dark" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Services -->
                    <div class="mb-4">
                        <label class="form-label">Services</label>
                        <input type="text" name="services" class="form-control" value="{{ old('services', $store->services->pluck('service')->implode(',')) }}" data-role="tagsinput">
                        <small class="form-text text-muted">Enter service names separated by commas (e.g., Service1, Service2).</small>
                        @error('services')
                        <span class="invalid-feedback text-dark" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

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
                                            <input class="form-check-input" type="checkbox" name="area[]" value="{{ $area }}" id="area{{ ucfirst($area) }}Checkbox" {{ !empty($store->areas) && in_array($area, $store->areas->pluck('area')->toArray()) ? 'checked' : '' }}>
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
     <div class="address-part mb-3">
         @if($store->areas->count() > 0)
         @foreach($store->areas as $storeArea)
         @php
         $areaValue = $storeArea->area;
         $capitalizedAreaValue = ucwords(str_replace('_', ' ', $areaValue));
         @endphp
         <div class="mb-3 address-{{ $areaValue }}">
             <label class="form-label">{{ $capitalizedAreaValue }} Address <span class="text-danger">*</span></label>
             <textarea name="address[{{ $areaValue }}]" class="form-control" placeholder="Enter your address" required>{{ $storeArea->address }}</textarea>
         </div>
         @endforeach
         @endif

         @error('address')
        <div class="invalid-feedback text-danger mt-1" role="alert">
            <strong>{{ $message }}</strong>
        </div>
        @enderror

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
                                            <input class="form-check-input" type="checkbox" name="delivery_area[]" value="{{ $area }}" id="deliveryArea{{ ucfirst($area) }}Checkbox" {{ !empty($store->deliveryAreas) && in_array($area, $store->deliveryAreas->pluck('area')->toArray()) ? 'checked' : '' }}>
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


                    <div class="mb-3">
                        <label class="form-label">Intro</label>
                        <textarea class="form-control @error('intro') is-invalid @enderror" name="intro" rows="4">{{ $store->intro }}</textarea>
                        @error('intro')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" id="phone" value="{{ $store->phone }}" placeholder="Enter Phone Number" required>
                        @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ $store->email }}" placeholder="Enter Email Address" required>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Established Since</label>
                        <input type="text" name="established_since" class="form-control @error('established_since') is-invalid @enderror" id="established_since" value="{{ $store->established_since }}" placeholder="Enter Establishment Year">
                        @error('established_since')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="card mb-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">Extra Links</h6>
                </div>
                <div class="card-body p-2">

                    <!-- Facebook -->
                    <div class="mb-3">
                        <label class="form-label">Facebook <span class="text-danger">*</span></label>
                        <input type="text" name="facebook" class="form-control @error('facebook') is-invalid @enderror" id="facebook" value="{{ $store->facebook }}" placeholder="Enter Facebook URL" required>
                        @error('facebook')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Twitter -->
                    <div class="mb-3">
                        <label class="form-label">Twitter</label>
                        <input type="text" name="twitter" class="form-control @error('twitter') is-invalid @enderror" id="twitter" value="{{ $store->twitter }}" placeholder="Enter Twitter URL">
                        @error('twitter')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Instagram -->
                    <div class="mb-3">
                        <label class="form-label">Instagram</label>
                        <input type="text" name="instagram" class="form-control @error('instagram') is-invalid @enderror" id="instagram" value="{{ $store->instagram }}" placeholder="Enter Instagram URL">
                        @error('instagram')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- LinkedIn -->
                    <div class="mb-3">
                        <label class="form-label">LinkedIn</label>
                        <input type="text" name="linkedin" class="form-control @error('linkedin') is-invalid @enderror" id="linkedin" value="{{ $store->linkedin }}" placeholder="Enter LinkedIn URL">
                        @error('linkedin')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Website -->
                    <div class="mb-3">
                        <label class="form-label">Website</label>
                        <input type="text" name="website" class="form-control @error('website') is-invalid @enderror" id="website" value="{{ $store->website }}" placeholder="Enter Website URL">
                        @error('website')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <!-- Map URL -->
                    <div class="mb-3">
                        <label class="form-label">Map URL</label>
                        <input type="text" name="map_url" class="form-control @error('map_url') is-invalid @enderror" id="map_url" value="{{ $store->map_url }}" placeholder="Enter Map URL">
                        @error('map_url')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>


            <div class="card mb-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">Interior</h6>
                </div>
                <div class="card-body p-2">
                    <div class="multiple-uploader" id="interiorUploader">
                        <div class="mup-msg">
                            <span class="mup-main-msg">click to upload images.</span>
                            <span class="mup-msg" id="max-upload-number">Upload up to 10 images</span>
                            <span class="mup-msg">Only image files (PNG, GIF, JPEG, etc.) are allowed for upload.</span>
                        </div>
                    </div>


                    @if ($interiorImages->count() > 0)
    <div class="row setting-gallery-container g-3 mb-3">
        @foreach($interiorImages as $interiorImage)
        <div class="col-6 col-md-3 gallery-setting-image" id="galleryItem{{ $interiorImage->id }}">
            <div class="gallery-item">
                <img src="{{ asset('media/'.$interiorImage->thumbnail) }}" class="img-fluid rounded" alt="Image">
                <span class="remove-icon" id="removeGalleryItem" data-image-id="{{ $interiorImage->id }}">
                    <i class="fas fa-trash-alt"></i>
                </span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

                </div>
            </div>

            <div class="card mb-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">Featured Post</h6>
                </div>
                <div class="card-body p-2">

                    <div class="mb-3">
                        <select name="featured_post_type" class="form-select w-50">
                            <option value="menu" {{ $store->featured_post_type == 'menu' ? 'selected' : '' }}>Menu</option>
                            <option value="products_and_services" {{ $store->featured_post_type == 'products_and_services' ? 'selected' : '' }}>Products and Services</option>
                            <option value="packages" {{ $store->featured_post_type == 'packages' ? 'selected' : '' }}>Packages</option>
                        </select>
                        @error('featured_post_type')
                        <span class="invalid-feedback text-dark" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="multiple-uploader" id="featuredPostUploader">
                        <div class="mup-msg">
                            <span class="mup-main-msg">click to upload images.</span>
                            <span class="mup-msg" id="max-upload-number">Upload up to 10 images</span>
                            <span class="mup-msg">Only image files (PNG, GIF, JPEG, etc.) are allowed for upload.</span>
                        </div>
                    </div>

                    @if ($featuredPostImages->count() > 0)
    <div class="row setting-gallery-container g-3 mb-3">
        @foreach($featuredPostImages as $featuredPostImage)
        <div class="col-6 col-md-3 gallery-setting-image" id="galleryItem{{ $featuredPostImage->id }}">
            <div class="gallery-item">
                <img src="{{ asset('media/'.$featuredPostImage->thumbnail) }}" class="img-fluid rounded" alt="Image">
                <span class="remove-icon" id="removeGalleryItem" data-image-id="{{ $featuredPostImage->id }}">
                    <i class="fas fa-trash-alt"></i>
                </span>
            </div>
        </div>
        @endforeach
    </div>
    @endif
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">Store Open Hours</h6>
                </div>
                <div class="card-body p-2">

                @php
                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            @endphp

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th class="text-nowrap">Day</th>
                            <th class="text-nowrap">Opening</th>
                            <th class="text-nowrap">Closing</th>
                            <th class="text-nowrap">Open 24 Hours</th>
                            <th class="text-nowrap">Closed</th>
                        </tr>
                    </thead>

                    @foreach ($days as $day)
                        @php
                            $openingHour = $store->openingHours()->where('day', $day)->first();
                        @endphp
                        <tr>
                            <th class="text-nowrap">{{ $day }}</th>
                            <td class="text-nowrap">
                                <select class="form-select" name="{{ strtolower($day) }}_opening">
                                    @for ($i = 0; $i < 24; $i++)
                                        @php
                                            $hour = sprintf('%02d:00:00', $i);
                                        @endphp
                                        <option value="{{ $hour }}" {{ $openingHour && $openingHour->opening == $hour ? 'selected' : '' }}>
                                            {{ date('h:i A', strtotime($hour)) }}
                                        </option>
                                    @endfor
                                </select>
                            </td>
                            <td class="text-nowrap">
                                <select class="form-select" name="{{ strtolower($day) }}_closing">
                                    @for ($i = 0; $i < 24; $i++)
                                        @php
                                            $hour = sprintf('%02d:00:00', $i);
                                        @endphp
                                        <option value="{{ $hour }}" {{ $openingHour && $openingHour->closing == $hour ? 'selected' : '' }}>
                                            {{ date('h:i A', strtotime($hour)) }}
                                        </option>
                                    @endfor
                                </select>
                            </td>
                            <td class="text-nowrap">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="{{ strtolower($day) }}TwentyFourHours" name="{{ strtolower($day) }}_24h" {{ $openingHour && $openingHour->open_24h ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ strtolower($day) }}TwentyFourHours">Open 24 Hours</label>
                                </div>
                            </td>
                            <td class="text-nowrap">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="{{ strtolower($day) }}Closed" name="{{ strtolower($day) }}_closed" {{ $openingHour && $openingHour->closed ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ strtolower($day) }}Closed">Closed</label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

                </div>
            </div>

        </div>
        <div class="col-md-3">
            <div class="card my-2">
                <div class="card-body p-2">
                    <div class="image-box mb-1">
                        <label class="form-label">Profile Picture</label>
                        <div class="image-box-preview">
                            <img id="profile_image" src="{{ !empty($store->profile_picture) ? asset('media/'.$store->profile_picture) : asset('static/admin/images/default.jpg') }}" alt="Profile Image">
                        </div>
                        <div class="image-box-select">
                            <input type="file" name="profile_picture" class="image-input @error('profile_picture') is-invalid @enderror" id="profile_file" accept=".png, .jpg, .jpeg">
                            <label for="profile_file">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                                </svg> <span>Change File &hellip;</span>
                            </label>
                        </div>
                        @error('profile_picture')
                        <span class="invalid-feedback" role="alert">
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
                                </svg> <span>Change File &hellip;</span>
                            </label>
                        </div>
                        @error('cover_picture')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="pending" {{ $store->status=='pending' ? 'selected' : '' }}>Pending</option>
                            <option value="active" {{ $store->status=='active' ? 'selected' : '' }}>Active</option>
                            <option value="suspend" {{ $store->status=='suspend' ? 'selected' : '' }}>Suspend</option>
                            <option value="deactive" {{ $store->status=='deactive' ? 'selected' : '' }}>Deactive</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<style>
    .bootstrap-tagsinput {
        width: 100%;
        padding: 5px 5px;
        border-radius: 0.25rem !important;
    }

    .bootstrap-tagsinput .tag {
        width: 100% !important;
        max-width: 100% !important;
        color: white !important;
        background-color: #0d6efd;
        padding: 0.2rem;
    }

    /* Style for remove icon */
    .gallery-item {
        position: relative;
    }

    /* Style for remove icon */
    .remove-icon {
        position: absolute;
        top: 5px;
        right: 5px;
        cursor: pointer;
        background-color: rgba(255, 255, 255, 0.7);
        padding: 6.5px;
        border-radius: 50%;
        font-size: 13px;
        color: #000;
        z-index: 2;
        width: 24px;
        height: 24px;
        line-height: 1;
    }

    /* Hover effect for remove icon */
    .remove-icon:hover {
        background-color: #ff0000;
        color: #fff;
    }
</style>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#merchant').select2();

        // Image Change With Preview
        function preview_image(input, image_id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(image_id).attr("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#profile_file").change(function() {
            preview_image(this, "#profile_image");
        });

        $("#cover_file").change(function() {
            preview_image(this, "#cover_image");
        });

        // interior uploader
        let interiorUploader = new MultipleUploader('#interiorUploader').init({
            maxUpload: 10,
            maxSize: 5,
            filesInpName: 'interiorImages',
            formSelector: '#editStoreForm',
        });


        // featured posts
        let productUploader = new MultipleUploader('#featuredPostUploader').init({
            maxUpload: 10,
            maxSize: 5,
            filesInpName: 'featuredPosts',
            formSelector: '#editStoreForm',
        });

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
    var addressInputExists = $('.address-part .address-' + areaValue).length > 0;

    if ($(this).is(':checked') && !addressInputExists) {
        var capitalizedAreaValue = areaValue.replace(/_/g, ' ').replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });

        var addressInput = '<div class="mb-3 address-' + areaValue + '">' +
            '<label class="form-label">' + capitalizedAreaValue + ' Address <span class="text-danger">*</span></label>' +
            '<textarea name="address[' + areaValue + ']" class="form-control" placeholder="Enter your address" required></textarea>' +
            '</div>';

        $('.address-part').append(addressInput);
    } else if (!$(this).is(':checked') && addressInputExists) {
        $('.address-part .address-' + areaValue).remove();
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

        // Update sub-categories when page loads
        updateSubcategories();

        // Function to update sub-categories
        function updateSubcategories() {
            var mainCategories = $('[name="category_id[]"]:checked').map(function() {
                return $(this).val();
            }).get();

            if (mainCategories.length > 0) {
                $.ajax({
                    url: '{{ route("admin.getSubcategories") }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        mainCategories: mainCategories,
                        store_id: '{{ $store->id }}',
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
        $('[name="category_id[]"]').on('change', function() {
            updateSubcategories();
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


        $(document).on('click', '#removeGalleryItem', function(event) {
            var imageId = $(this).data('image-id');
            var confirmation = confirm("Are you sure you want to delete this image?");

            if (confirmation) {
                $.ajax({
                    url: '{{ url("admin/remove-gallery-item") }}/' + imageId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        imageId: imageId
                    },
                    success: function(response) {
                        $('#galleryItem' + imageId).remove();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert("An error occurred while deleting the image.");
                    }
                });
            }
        });

    });
</script>
@endpush