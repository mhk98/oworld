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
            <img src="{{ asset('static/images/sample_cover_picture.jpg') }}" class="img-fluid w-100" alt="Cover Photo">
            @endif


            <div class="store-ratings">
                @php
                $averageRating = $store->averageRating;
                $totalStars = 5;
                $filledStars = floor($averageRating);
                $emptyStars = $totalStars - $filledStars;
                for ($i = 0; $i < $filledStars; $i++) { echo '<i class="fas fa-star points"></i>' ; } for ($i=0; $i < $emptyStars; $i++) { echo '<i class="fas fa-star"></i>' ; } @endphp </div>
            </div>

            <div class="store-logo">

                @if($store->profile_picture)
                <img src="{{ asset('media/'.$store->profile_picture) }}" data-bs-toggle="modal" data-bs-target="#logoModal" alt="Profile Picture">
                @else
                <img src="{{ asset('static/images/sample_profile_picture.jpg') }}" alt="Profile Picture">
                @endif

            </div>
        </div>

        <div class="mb-4"></div>
        <div class="store-mobile-changes">
            <div class="store-dtls d-flex justify-content-between">
                <div class="social">
                    @if($store->facebook)
                    <a href="{{ $store->facebook }}" target="__blank"><img src="{{ asset('static/images/icons/fb.jpg') }}" alt="Facebook"></a>
                    @endif

                    @if($store->instagram)
                    <a href="{{ $store->instagram }}" target="__blank"><img src="{{ asset('static/images/icons/inista.jpg') }}" alt="Instagram"></a>
                    @endif

                    @if($store->website)
                    <a href="{{ $store->website }}" target="__blank"><img src="{{ asset('static/images/icons/web.jpg') }}" alt="Website"></a>
                    @endif

                    @if($store->address)
                    <a href="https://www.google.com/maps/place/{{ urlencode($store->address) }}" target="__blank"><img src="{{ asset('static/images/icons/location.jpg') }}" alt="Address"></a>
                    @endif
                </div>

                @if($store->isMerchant)
                <div class="add-option">
                    <a href="{{ route('merchant.storeContentForm') }}"><i class="fas fa-plus-circle"></i></a>
                </div>
                @endif

                <div class="contact-info">
                    <div class="d-flex align-items-center justify-content-end mb-2">
                        <h6>
                            {{ $store->areas->isNotEmpty() ? $store->areas->first()->address : '' }}
                            @if($store->areas()->count() > 1)
                            <br>
                            <a class="me-1 view-all-address" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addressModal">View All</a>
                            @endif
                        </h6>
                        <p><i class="fas fa-location-arrow"></i></p>
                    </div>

                    <div class="d-flex align-items-center justify-content-end">
                        <h6 class="c-number">{{ $store->phone }}</h6>
                        <p><i class="fas fa-phone-volume mb-0"></i></p>
                    </div>
                </div>
            </div>

            <div class="d-md-none">
                @if($store->isMerchant)
                <div class="add-option2">
                    <a href="{{ route('merchant.storeContentForm') }}"><i class="fas fa-plus-circle pe-1"></i> Add</a>
                </div>
                @endif
            </div>
        </div>
        <div class="mb-5"></div>

        <div class="store-tabs">
            <nav>
                <div class="nav nav-tabs justify-content-evenly" id="nav-tab" role="tablist">
                    <button class="nav-link" id="nav-description-tab" data-bs-toggle="tab" data-bs-target="#nav-description" type="button" role="tab" aria-controls="nav-description" aria-selected="true">
                        <img src="{{ asset('static/images/icons/review.jpg') }}" alt="Description"> Description
                    </button>
                    <button class="nav-link active" id="nav-posts-tab" data-bs-toggle="tab" data-bs-target="#nav-posts" type="button" role="tab" aria-controls="nav-posts" aria-selected="false">
                        <img src="{{ asset('static/images/icons/pic.jpg') }}" alt="Posts"> Posts
                    </button>
                    <button class="nav-link" id="nav-reviews-tab" data-bs-toggle="tab" data-bs-target="#nav-reviews" type="button" role="tab" aria-controls="nav-reviews" aria-selected="false">
                        <img src="{{ asset('static/images/icons/review.jpg') }}" alt="Reviews"> Reviews
                    </button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade store-dtls" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">
                    @if($store->isMerchant)
                    <a href="{{ route('merchant.storeSettingForm') }}?sec=basic" class="edit-link">
                        <i class="fas fa-edit"></i> Edit Store
                    </a>
                    @endif

                    @if($store->intro)
                    <h6 class="m-title pt-3">Intro</h6>
                    <p>{{ $store->intro }}</p>
                    @else
                    @if($store->isMerchant)
                    <h6 class="m-title pt-3">Intro</h6>
                    <p class="empty-message">Please add intro <a href="{{ route('merchant.storeSettingForm') }}?sec=basic">here</a>.</p>
                    @endif
                    @endif

                    <h6 class="m-title pt-3">Category</h6>
                    @if($store->mainCategories()->count() > 0)
                    <div class="c-tag pt-2">
                        @foreach($store->mainCategories as $mainCategory)
                        <span>{{ $mainCategory->title }}</span>
                        @endforeach
                    </div>
                    @endif

                    @if($store->subCategories()->count() > 0)
                    <h6 class="m-title pt-3">Sub Category</h6>
                    <div class="c-tag pt-2">
                        @foreach($store->subCategories as $subCategory)
                        <span>{{ $subCategory->title }}</span>
                        @endforeach
                    </div>
                    @endif

                    @if ($store->products->count() > 0)
    <h6 class="m-title pt-3">Products</h6>
    <div class="c-tag p-tag pt-2">
        <p>
            @foreach ($store->products as $product)
                <span>{{ $product->product }}</span>
            @endforeach
        </p>
    </div>
@endif

@if ($store->services->count() > 0)
    <h6 class="m-title pt-3">Services</h6>
    @foreach ($store->services as $service)
        <p>{{ $service->service }}</p>
    @endforeach
@endif
                    @if ($store->featuredPosts->count() > 0)
                    <h6 class="m-title pt-3">
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
                    <h6 class="m-title pt-3">Interior</h6>
                    <div class="row g-3">
                        @foreach ($store->interiorPosts as $interiorPost)
                        <div class="col-6 col-md-2 gallery-image">
                            <img src="{{ asset('media/'.$interiorPost->thumbnail) }}" class="img-fluid rounded" alt="Image" data-bs-toggle="modal" data-bs-target="#interiorModal">
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <h6 class="m-title pt-3">Contact</h6>
                    @if($store->phone)
                    <p><a href="tel:{{ $store->phone }}" target="_blank"><i class="fas fa-phone-volume"></i> {{ $store->phone }}</a></p>
                    @endif
                    @if($store->email)
                    <p><a href="mailto:{{ $store->email }}" target="_blank"><i class="fas fa-envelope"></i> {{ $store->email }}</a></p>
                    @endif
                    @if($store->facebook)
                    <p><a href="{{ $store->facebook }}" target="_blank"><i class="fab fa-facebook"></i> {{ Helper::socialMediaUsername($store->facebook, 'facebook') }}</a></p>
                    @endif
                    @if($store->twitter)
                    <p><a href="{{ $store->twitter }}" target="_blank"><i class="fab fa-twitter"></i> {{ Helper::socialMediaUsername($store->twitter, 'twitter') }}</a></p>
                    @endif
                    @if($store->instagram)
                    <p><a href="{{ $store->instagram }}" target="_blank"><i class="fab fa-instagram"></i> {{ Helper::socialMediaUsername($store->instagram, 'instagram') }}</a></p>
                    @endif
                    @if($store->linkedin)
                    <p><a href="{{ $store->linkedin }}" target="_blank"><i class="fab fa-linkedin"></i> {{ Helper::socialMediaUsername($store->linkedin, 'linkedin') }}</a></p>
                    @endif
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

    <style>
        .count-followers i {
            cursor: pointer;
        }

        .view-all-address {
            color: #ED217C;
            font-weight: 500;
        }

        .view-all-address:hover {
            color: #ED217CC9 !important;
        }

        .address-modal .modal-dialog {
            max-width: 800px;
        }

        .address-modal .list-group-item {
            padding: 1.5rem 1rem;
        }

        .address-modal ul {
            max-height: 220px;
            overflow-y: auto;
        }
    </style>
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

            @if(!empty($openInterior))
                var myModal = new bootstrap.Modal(document.getElementById('interiorModal'));
                myModal.show();
            @endif 

            @if(!empty($openFeatured))
                var myModal = new bootstrap.Modal(document.getElementById('featured_postModal'));
                myModal.show();
            @endif 

            @if(!empty($openLogo))
                var myModal = new bootstrap.Modal(document.getElementById('logoModal'));
                myModal.show();
            @endif 
            

        });
    </script>
@endpush