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