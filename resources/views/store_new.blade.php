@extends('layouts.base')
@section('content')
<div class="store-profile">
    <div class="store-top d-flex justify-content-between">
        <div class="store-business-name">
            <h2>{{ $store->business_name }}</h2>
            @if(in_array('online', $store->store_type))
            <h6>
                <i class="far fa-clock"></i>
                <a href="javascript:void(0);">
                    <span class="text-success px-1">Online Store</span>
                </a>
            </h6>
            @elseif(in_array('physical', $store->store_type) && $openingHoursStatus != 'not_found')
            <h6>
                <i class="far fa-clock"></i>
                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#openingHours">
                    <span class="px-1 @if($openingHoursStatus == 'open_now') text-success @else text-warning @endif">
                        @if($openingHoursStatus == 'open_now')
                        Open Now
                        @elseif (is_numeric($hoursUntilNextOpening))
                        Opens in {{ $hoursUntilNextOpening }} hours
                        @else
                        {{ $hoursUntilNextOpening }}
                        @endif
                    </span>
                    <i class="fa-solid fa-chevron-down text-dark"></i>
                </a>
            </h6>
            @endif
        </div>
        <div class="count-followers text-center">
            <i class="@if($store->isFollowing) fas fa-heart followed @else far fa-heart not-followed @endif" id="followStore" data-id="{{ $store->id }}"></i>
            <p><span id="followCounts">{{ $store->followers_count }}</span> <span>Followers</span></p>
        </div>
    </div>

    <div class="store-images">
        <div class="store-cover">
            @if($store->cover_picture)
            <img src="{{ asset('media/'.$store->cover_picture) }}" class="img-fluid w-100" alt="Cover Photo">
            @else
            <img src="{{ asset('static/images/sample_cover_picture.jpg') }}" class="img-fluid w-100" alt="Cover Photo Placeholder">
            @endif

            <!-- Ratings -->
            <div class="store-ratings">
                @php
                $averageRating = $store->averageRating;
                $totalStars = 5;
                $filledStars = floor($averageRating);
                $emptyStars = $totalStars - $filledStars;
                @endphp
                @for ($i = 0; $i < $filledStars; $i++) <i class="fas fa-star points"></i>
                    @endfor
                    @for ($i = 0; $i < $emptyStars; $i++) <i class="fas fa-star"></i>
                        @endfor
            </div>
        </div>

        <!-- Logo -->
        <div class="store-logo">
            @if($store->profile_picture)
            <img src="{{ asset('media/'.$store->profile_picture) }}" data-bs-toggle="modal" data-bs-target="#logoModal" alt="Profile Picture">
            @else
            <img src="{{ asset('static/images/sample_profile_picture.jpg') }}" alt="Profile Picture Placeholder">
            @endif
        </div>
    </div>

    <div class="mb-4"></div>

    <div class="store-details d-flex justify-content-between">
        <div class="store-social">
            @if($store->facebook)
            <a href="{{ $store->facebook }}" target="__blank">
                <img src="{{ asset('static/images/icons/facebook.jpg') }}" alt="Facebook">
            </a>
            @endif

            @if($store->instagram)
            <a href="{{ $store->instagram }}" target="__blank">
                <img src="{{ asset('static/images/icons/instagram.jpg') }}" alt="Instagram">
            </a>
            @endif

            @if($store->website)
            <a href="{{ $store->website }}" target="__blank">
                <img src="{{ asset('static/images/icons/website.jpg') }}" alt="Website">
            </a>
            @endif

            @if($store->map_url)
            <a href="{{ $store->map_url }}" target="__blank">
                <img src="{{ asset('static/images/icons/location.jpg') }}" alt="Address">
            </a>
            @endif
        </div>

        @if($store->isMerchant)
        <div class="store-add-content">
            <a href="{{ route('merchant.storeContentForm') }}"><i class="fas fa-plus-circle"></i></a>
        </div>
        @endif

        <div class="store-contact-info">
            <div class="d-flex align-items-center justify-content-end mb-2">
                <h6>
                    {{ $store->areas->isNotEmpty() ? $store->areas->first()->address : '' }}
                    @if($store->areas()->count() > 1)
                    <br>
                    <a class="me-1 view-all-address" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addressModal">View All</a>
                    @endif
                </h6>
                <i class="fas fa-location-arrow"></i>
            </div>

            <div class="d-flex align-items-center justify-content-end">
                <h6 class="phone-number">{{ $store->phone }}</h6>
                <i class="fas fa-phone-volume mb-0"></i>
            </div>
        </div>


    </div>

    {{--- <div class="store-mobile-changes">
        <div class="d-md-none">
            @if($store->isMerchant)
            <div class="add-option2">
                <a href="{{ route('merchant.storeContentForm') }}"><i class="fas fa-plus-circle pe-1"></i> Add</a>
</div>
@endif
</div>
</div> ----}}

<div class="mb-5"></div>

<div class="store-tabs">
    <nav>
        <div class="nav nav-tabs justify-content-evenly" id="nav-tab" role="tablist">
            <button class="nav-link" id="nav-description-tab" data-bs-toggle="tab" data-bs-target="#nav-description" type="button" role="tab" aria-controls="nav-description" aria-selected="true">
                <img src="{{ asset('static/images/icons/description.png') }}" alt="Description"> Description
            </button>
            <button class="nav-link active" id="nav-posts-tab" data-bs-toggle="tab" data-bs-target="#nav-posts" type="button" role="tab" aria-controls="nav-posts" aria-selected="false">
                <img src="{{ asset('static/images/icons/posts.jpg') }}" alt="Posts"> Posts
            </button>
            <button class="nav-link" id="nav-reviews-tab" data-bs-toggle="tab" data-bs-target="#nav-reviews" type="button" role="tab" aria-controls="nav-reviews" aria-selected="false">
                <img src="{{ asset('static/images/icons/reviews.jpg') }}" alt="Reviews"> Reviews
            </button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade store-description" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">
            <div class="py-4">
                @if($store->isMerchant)
                <a href="{{ route('merchant.storeSettingForm') }}" class="edit-store">
                    <i class="fas fa-edit"></i> Edit Store
                </a>
                @endif

                @if($store->intro)
                <h6 class="store-description-title pt-3">Intro</h6>
                <p class="store-intro">{{ $store->intro }}</p>
                @endif

                @if($store->mainCategories()->count() > 0)
                <h6 class="store-description-title pt-3">Category</h6>
                <div class="store-description-tag pt-2">
                    <ul>
                        @foreach($store->mainCategories as $mainCategory)
                        <li><span>{{ $mainCategory->title }}</span></li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if($store->subCategories()->count() > 0)
                <h6 class="store-description-title pt-3">Sub Category</h6>
                <div class="store-description-tag pt-2">
                    <ul>
                        @foreach($store->subCategories as $subCategory)
                        <li><span>{{ $subCategory->title }}</span></li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if ($store->products->count() > 0)
                <h6 class="store-description-title pt-3">Products</h6>
                <div class="store-description-tag pt-2">
                    <ul>
                        @foreach ($store->products as $product)
                        <li><span>{{ $product->product }}</span></li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if ($store->services->count() > 0)
                <h6 class="store-description-title pt-3">Services</h6>
                <ul class="store-services list-unstyled pt-1">
                    @foreach ($store->services as $service)
                    <li>{{ $service->service }}</li>
                    @endforeach
                </ul>
                @endif

                @if ($store->featuredPosts->count() > 0)
                <h6 class="store-description-title pt-3 pb-2">
                    @if($store->featured_post_type == 'menu')
                    Menu
                    @elseif($store->featured_post_type == 'products_and_services')
                    Products and Services
                    @elseif($store->featured_post_type == 'packages')
                    Packages
                    @endif
                </h6>

                <div class="row g-3">
                    @foreach ($store->featuredPosts as $featuredPost)
                    <div class="col-6 col-md-2 gallery-image">
                        <img src="{{ asset('media/'.$featuredPost->thumbnail) }}" class="img-fluid rounded" alt="Image" data-bs-toggle="modal" data-bs-target="#featured_postModal">
                    </div>
                    @endforeach
                </div>
                @endif

                @if ($store->interiorPosts->count() > 0)
                <h6 class="store-description-title pt-3 pb-2">Interior</h6>
                <div class="row g-3">
                    @foreach ($store->interiorPosts as $interiorPost)
                    <div class="col-6 col-md-2 gallery-image">
                        <img src="{{ asset('media/'.$interiorPost->thumbnail) }}" class="img-fluid rounded" alt="Image" data-bs-toggle="modal" data-bs-target="#interiorModal">
                    </div>
                    @endforeach
                </div>
                @endif

                <h6 class="store-description-title pt-3 pb-2">Contact</h6>
                <div class="store-contact-list">
                    <ul class="list-unstyled">
                        @if($store->phone)
                        <li><a href="tel:{{ $store->phone }}" target="_blank"><i class="fas fa-phone-volume"></i> {{ $store->phone }}</a></li>
                        @endif
                        @if($store->email)
                        <li><a href="mailto:{{ $store->email }}" target="_blank"><i class="fas fa-envelope"></i> {{ $store->email }}</a></li>
                        @endif
                        @if($store->facebook)
                        <li><a href="{{ $store->facebook }}" target="_blank"><i class="fab fa-facebook"></i> {{ Helper::socialMediaUsername($store->facebook, 'facebook') }}</a></li>
                        @endif
                        @if($store->twitter)
                        <li><a href="{{ $store->twitter }}" target="_blank"><i class="fab fa-twitter"></i> {{ Helper::socialMediaUsername($store->twitter, 'twitter') }}</a></li>
                        @endif
                        @if($store->instagram)
                        <li><a href="{{ $store->instagram }}" target="_blank"><i class="fab fa-instagram"></i> {{ Helper::socialMediaUsername($store->instagram, 'instagram') }}</a></li>
                        @endif
                        @if($store->linkedin)
                        <li><a href="{{ $store->linkedin }}" target="_blank"><i class="fab fa-linkedin"></i> {{ Helper::socialMediaUsername($store->linkedin, 'linkedin') }}</a></li>
                        @endif
                        @if($store->website)
                        <li><a href="{{ $store->website }}" target="_blank"><i class="fas fa-globe"></i> {{ Helper::extractDomain($store->website) }}</a></li>
                        @endif
                        @if($store->map_url)
                        <li><a href="{{ $store->map_url }}" target="_blank"><i class="fas fa-map-marker-alt"></i> Google Map</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        <div class="tab-pane fade show active s-tab2" id="nav-posts" role="tabpanel" aria-labelledby="nav-posts-tab">
            <div class="py-4">
                <div class="row g-3">
                    @if ($store->featuredPosts->count() > 0)
                    <div class="col-6 col-md-4">
                        <div class="post-item featured-post text-center" data-bs-toggle="modal" data-bs-target="#featured_postModal">
                            <img src="{{ asset('media/'.$store->featuredPosts->first()->thumbnail) }}" class="img-fluid rounded" alt="Feature Post">
                            <p>
                                @if($store->featured_post_type == 'menu')
                                <i class="fas fa-list-alt"></i> Menu
                                @elseif($store->featured_post_type == 'products_and_services')
                                <i class="fas fa-shopping-basket"></i> Products and Services
                                @elseif($store->featured_post_type == 'packages')
                                <i class="fas fa-box"></i> Packages
                                @endif
                            </p>
                        </div>
                    </div>
                    @endif

                    @foreach($store->posts()->where('status', 'published')->get() as $post)
                    <div class="col-6 col-md-4">
                        <div class="post-item {{ $post->pin_post ? 'pin-post' : '' }} text-center" data-bs-toggle="modal" data-bs-target="#postModal{{ $post->post_id }}">
                            <img src="{{ asset('media/'.$post->thumbnail) }}" class="img-fluid rounded" alt="">
                            @if($post->pin_post)
                            <div class="pin-icon">
                                <i class="far fa-bookmark"></i>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="tab-pane fade s-tab2" id="nav-reviews" role="tabpanel" aria-labelledby="nav-reviews-tab">
            <div class="pt-4">
                <p>Coming Soon</p>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function() {

        // Follow / Unfollow
        $(document).on('click', '#followStore', function(event) {
            event.preventDefault();
            var storeId = $(this).data('id');
            var isFollowing = $(this).hasClass('followed');
            var token = '{{ csrf_token() }}';
            var url = '{{ route("user.followStore") }}';

            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    store_id: storeId,
                    _token: token
                },
                success: function(response) {
                    if (response.subscribed) {
                        $('#followCounts').text(parseInt($('#followCounts').text()) + 1);
                        $('#followStore').removeClass('not-followed').addClass('followed').removeClass('far').addClass('fas');
                    } else if (response.unsubscribed) {
                        $('#followCounts').text(parseInt($('#followCounts').text()) - 1);
                        $('#followStore').removeClass('followed').addClass('not-followed').removeClass('fas').addClass('far');
                    }
                },
                error: function(error) {
                    console.error('Error:', error);
                }
            });
        });

    });
</script>
@endpush

@push('modal')

@include('partials.opening_hours_modal', [
'openingHoursStatus' => $openingHoursStatus,
'hoursUntilNextOpening' => $hoursUntilNextOpening,
'openingHoursData' => $openingHoursData,
'currentDay' => $currentDay
])

@if($store->posts()->where('status', 'published')->count() > 0)
@foreach($store->posts->where('status', 'published') as $post)
<x-post :post="$post" />
@endforeach
@endif

@if($store->interiorPosts->count() > 0)
<x-store-gallery :store="$store" galleryType="interior" />
@endif

@if($store->featuredPosts->count() > 0)
<x-store-gallery :store="$store" galleryType="featured_post" />
@endif

@if($store->profile_picture)
<x-logo-view :store="$store" />
@endif

@if($store->areas()->count() >= 1)
<!------ Start Address Modal ------->
<div class="address-modal modal fade" id="addressModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-start">
                <ul class="list-group list-group-flush">
                    @foreach($store->areas as $storeArea)
                    <li class="list-group-item"><i class="fas fa-map-marker-alt"></i> {{ $storeArea->address }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
<!------- End Address Modal -------->
@endif
@endpush

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if(!empty($openPost))
        var myModal = new bootstrap.Modal(document.getElementById('postModal{{ $openPost->post_id }}'));
        myModal.show();
        @endif
    });
</script>
@endpush