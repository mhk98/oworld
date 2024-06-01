@extends('layouts.base')
@section('content')

@if($highlightCategories->isNotEmpty())
<div class="highlight-categories owl-carousel owl-theme">
  @foreach($highlightCategories as $highlightCategory)
    @if($highlightCategory->highlights->isNotEmpty())
    <div class="highlight-category">
    <div class="highlight-gradient {{ $highlightCategory->allViewed() ? 'not-active' : '' }}">
      <div class="first-highlight" data-bs-toggle="modal" data-bs-target="#highlightModal{{ $highlightCategory->id }}">
        <img src="{{ asset('media/'.$highlightCategory->highlights->first()->thumbnail) }}" alt="{{ $highlightCategory->title }}">
      </div>
    </div>
      <h5>{{ $highlightCategory->title == 'Events and Entertainment' ? 'Events' : $highlightCategory->title }}</h5>
    </div>
    @endif
  @endforeach
</div>
@endif

@if($billboards && $billboards->count() > 0)
<div class="mt-2 mt-md-3 mt-lg-4 mt-xl-4">
  <div class="billboard-wrapper">
    <div class="billboard-carousel owl-carousel owl-theme">
      @foreach($billboards as $billboard)
      <div class="billboard-item">
        <img src="{{ asset('media/'.$billboard->image) }}" alt="Billboard">
      </div>
      @endforeach
    </div>
    <div class="carousel-navigation">
      <a href="javascript:void(0);" class="prev" id="billboard-carousel-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left"><polyline points="15 18 9 12 15 6"></polyline></svg>
      </a>
      <a href="javascript:void(0);" class="next" id="billboard-carousel-next">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
      </a>
    </div>
  </div>
</div>
@endif

@if($homeCategories->isNotEmpty())
<div class="home-category pb-3">
  <div class="row">
    <div class="col-md-12">
      <div class="title">
        <h4 class="m-0">Categories</h4>
      </div>
      <div class="row mt-2 mt-md-3 mt-lg-5 mt-xl-5 g-3 g-md-3 g-lg-3 g-xl-3">
        @foreach($homeCategories as $homeCategory)
        <div class="col-md-2 col-4">
          <div class="category-item text-center">
            <div class="category-image">
              @if($homeCategory->title == 'Food')
              <a href="{{ route('food') }}">
                <img src="{{ asset('media/'.$homeCategory->icon) }}" class="img-fluid w-100" alt="{{ $homeCategory->title }}">
              </a>
              @else
              <a href="{{ route('category', $homeCategory->slug) }}">
                <img src="{{ asset('media/'.$homeCategory->icon) }}" class="img-fluid w-100" alt="{{ $homeCategory->title }}">
              </a>
              @endif
            </div>
            <p>
              <a href="{{ $homeCategory->title == 'Food' ? route('food') : route('category', $homeCategory->slug) }}">
                {{ $homeCategory->title }}
              </a>
            </p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endif


@if(!empty($featuredSections))
    @foreach($featuredSections as $featuredSection)
        @if($featuredSection->featuredPosts->count() > 0 || $featuredSection->featuredOffers->count() > 0 || $featuredSection->featuredStores->count() > 0)
            <div class="featured pb-4 pb-md-4 pb-lg-5 mb-5 mb-md-4 mb-lg-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="title">
                            <h4>{{ $featuredSection->title }}</h4>
                        </div>
                    </div>
                    @if($featuredSection->content_type == 'Posts' && $featuredSection->featuredPosts->count() > 0)
                        <div class="mt-4 mt-md-4 mt-lg-5 mt-xl-5">
                            <div class="row g-3">
                                @foreach($featuredSection->featuredPosts as $featuredPost)
                                    <div class="col-6 col-md-4">
                                        <div class="post-list-item">
                                            <div class="text-center">
                                                <img src="{{ asset('media/'.$featuredPost->thumbnail) }}" class="img-fluid rounded" alt="{{ $featuredPost->title }}" data-bs-toggle="modal" data-bs-target="#featuredPostModal{{ $featuredPost->featured_content_id  }}">
                                                <p><a href="{{ route('store', $featuredPost->store->slug) }}" class="store-name">{{ $featuredPost->store->business_name }}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    @push('modal')
                                        <x-featured-post :featuredPost="$featuredPost" />
                                    @endpush
                                @endforeach
                            </div>
                        </div>
                    @elseif($featuredSection->content_type == 'Offers' && $featuredSection->featuredOffers->count() > 0)
                        <div class="mt-4 mt-md-4 mt-lg-5 mt-xl-5">
                            <div class="row g-3">
                                @foreach($featuredSection->featuredOffers as $featuredOffer)
                                    <div class="col-6 col-md-4">
                                        <div class="offer-list-item">
                                            <div class="text-center">
                                                <img src="{{ asset('media/'.$featuredOffer->thumbnail) }}" class="img-fluid rounded" alt="{{ $featuredOffer->title }}" data-bs-toggle="modal" data-bs-target="#featuredOfferModal{{ $featuredOffer->featured_content_id  }}">
                                                <p><a href="{{ route('store', $featuredOffer->store->slug) }}" class="store-name">{{ $featuredOffer->store->business_name }}</a></p>
                                            </div>
                                        </div>
                                    </div>
                                    @push('modal')
                                        <x-featured-offer :featuredOffer="$featuredOffer" />
                                    @endpush
                                @endforeach
                            </div>
                        </div>
                    @elseif($featuredSection->content_type == 'Stores')
                        <div class="store-items row mt-4 mt-md-4 mt-lg-5 mt-xl-5">
                            @forelse($featuredSection->featuredStores as $featuredStore)
                                <div class="col-lg-3 col-6 col-sm-4">
                                    <x-store-item :store="$featuredStore->store" />
                                </div>
                            @empty
                                <div class="col-12">
                                    <p>No stores found.</p>
                                </div>
                            @endforelse
                        </div>
                    @endif
                </div>
            </div>
        @endif
    @endforeach
@endif

@endsection

@push('modal')
@foreach($highlightCategories as $highlightCategory)
    @if($highlightCategory->highlights->isNotEmpty())
        <div class="modal fade highlight-modal" id="highlightModal{{ $highlightCategory->id }}" tabindex="-1">
            <div class="modal-dialog modal-fullscreen mx-auto">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="story-wrapper">
                            <div class="owl-carousel owl-theme dot-style story-slider">
                                @foreach($highlightCategory->highlights()->orderBy('slot', 'asc')->get() as $highlight)
                                    <div class="story-item">
                                        <div class="story-card">
                                            <div class="story-header">
                                                <h2 class="story-title">{{ $highlightCategory->title }}</h2>
                                                <a href="javascript:void(0);" class="close-btn" data-bs-dismiss="modal"><i class="fas fa-times"></i></a>
                                            </div>
                                            <div class="story-image-container">
                                                <img src="{{ asset('media/'.$highlight->image) }}" alt="image" />
                                            </div>
                                            <div class="story-footer">
                                                <div class="store-info">
                                                    <div class="store-logo">
                                                        <img src="{{ asset('media/'.$highlight->store->profile_picture) }}" alt="{{ $highlight->store->business_name }}">
                                                    </div>
                                                    <h3 class="store-name">
                                                      <a href="{{ route('store', $highlight->store->slug) }}">
                                                      {{ $highlight->store->business_name }}
                                                      </a>
                                                    </h3>
                                                </div>
                                                <div class="story-caption">
                                                    <p>{{ $highlight->description }}</p>
                                                </div>
                                                <div class="story-actions">
                                                    <a href="javascript:void(0);" id="likeContent" data-id="{{ $highlight->id }}" data-type="highlight" class="like-btn">
                                                        <i class="{{ $highlight->isLike() ? 'fas' : 'far' }} fa-heart"></i>
                                                        <span class="likes-count">{{ $highlight->likes()->count() }}</span>
                                                    </a>
                                                    <a href="javascript:void(0);" class="share-btn" id="shareContent" data-url="{{ route('shareHighlight', $highlightCategory->id) }}">
                                                        <i class="fas fa-share-alt"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="carousel-navigation">
                                <a style="margin-left:27px" href="javascript:void(0);" class="prev" id="story-carousel-prev">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left">
                                        <polyline points="15 18 9 12 15 6"></polyline>
                                    </svg>
                                </a>
                                <a style="margin-right:27px" href="javascript:void(0);" class="next" id="story-carousel-next">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                        <polyline points="9 18 15 12 9 6"></polyline>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endpush

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    @if(!empty($openFeaturedPost))
    var myModal = new bootstrap.Modal(document.getElementById('featuredPostModal{{ $openFeaturedPost->featured_content_id }}'));
    myModal.show();
    @endif

    @if(!empty($openFeaturedOffer))
    var myModal = new bootstrap.Modal(document.getElementById('featuredOfferModal{{ $openFeaturedOffer->featured_content_id }}'));
    myModal.show();
    @endif

    @if(!empty($openHighlightCategory))
    var myModal = new bootstrap.Modal(document.getElementById('highlightModal{{ $openHighlightCategory->id }}'));
    myModal.show();
    @endif

    // Story image click event
    document.querySelectorAll('.story-slider .item img').forEach(function(img) {
      img.addEventListener('click', function() {
        var imgSrc = img.getAttribute('src');
        document.getElementById('modalStoryImage').setAttribute('src', imgSrc);
        var storyImageModal = new bootstrap.Modal(document.getElementById('storyImageModal'));
        storyImageModal.show();
      });
    });
  });

  $(document).ready(function() {
    var storyitems = $(".story-slider");
    storyitems.owlCarousel({
      items: 1,
      margin: 0,
      nav: true,
      loop: true,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplayHoverPause: true,
      dots: true
    });

    // Custom navigation
    $("#story-carousel-prev").click(function() {
      storyitems.trigger('prev.owl.carousel');
    });

    $("#story-carousel-next").click(function() {
      storyitems.trigger('next.owl.carousel');
    });

    var billboardItems = $(".billboard-carousel");
    billboardItems.owlCarousel({
      items: 1,
      margin: 0,
      nav: true,
      loop: true,
      autoplay: true,
      autoplayTimeout: 4000,
      autoplayHoverPause: true,
      dots: true
    });

    // Custom navigation
    $("#billboard-carousel-prev").click(function() {
      billboardItems.trigger('prev.owl.carousel');
    });

    $("#billboard-carousel-next").click(function() {
      billboardItems.trigger('next.owl.carousel');
    });
  });
</script>

@endpush