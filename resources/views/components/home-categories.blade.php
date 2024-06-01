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
