@extends('layouts.base')
@section('content')
<!-- Category banner part Start -->
<div class="category-banner">
    @if($mainCategory->desktop_hero_image)
    <img src="{{ asset('media/'.$mainCategory->desktop_hero_image) }}" class="img-fluid w-100 d-none d-md-block" alt="">
    @endif

    @if($mainCategory->mobile_hero_image)
    <img src="{{ asset('media/'.$mainCategory->mobile_hero_image) }}" class="img-fluid w-100 d-block d-md-none" alt="">
    @endif
</div>
<!-- Category banner part End -->


<!----- Start Categories Part ----->
<div class="categories d-flex align-items-start mt-3">
    <a href="{{ route('categories') }}" class="{{ request()->is('categories') ? 'active' : '' }} text-center">
        <img src="{{ asset('static/images/category.png') }}" alt="All Categories">
        <p>All</p>
    </a>

    @if($allCategories)
    @foreach($allCategories as $categoryItem)
    @if($categoryItem->title != 'Food')
    <a href="{{ route('category', $categoryItem->slug) }}" class="text-center {{ (request()->is('category/' . $categoryItem->slug) || (request()->is('category/' . $categoryItem->slug . '/*'))) ? 'active' : '' }}">
        <img src="{{ asset('media/'.$categoryItem->icon) }}" alt="{{ $categoryItem->title }}">
        <p>
            @switch($categoryItem->title)
            @case('Education & Work')
            Education <br> & Work
            @break
            @case('Home & Living')
            Home <br> & Living
            @break
            @default
            {!! str_replace("&", "& <br>", $categoryItem->title) !!}
            @endswitch
        </p>
    </a>
    @endif
    @endforeach
    @endif
</div>
<!----- End Categories Part ----->

<!------ Start Sub Categories Part ------>
@if($subCategories->count() > 0)
<div class="sub-categories">
    <ul>
        <li><a href="{{ route('category', $mainCategory->slug) }}" class="{{ request()->is('category/' . $mainCategory->slug) ? 'active' : '' }}">All</a></li>
        @foreach($subCategories as $subCategory)
        <li><a href="{{ route('subCategory', ['mainCategory' => $subCategory->parentCategory->slug, 'subCategory' => $subCategory->slug]) }}"
         class="{{ request()->is('category/' . $mainCategory->slug . '/' . $subCategory->slug) ? 'active' : '' }}">
        {{ $subCategory->title }}
        </a></li>
        @endforeach

        @if($mainCategory->id == '7' || $mainCategory->id == '8')
        <li><a href="{{ route('subCategory', ['mainCategory' => $mainCategory->slug, 'subCategory' => 'nutrition']) }}" 
        class="{{ request()->is('category/' . $mainCategory->slug . '/nutrition') ? 'active' : '' }}">Nutrition</a></li>
        @endif
    </ul>
</div>
@endif
<!------ End Sub Categories Part ------>


<!----- Start Filters Part ----->
<div class="filters d-flex justify-content-start align-items-center mt-3">
  <div class="filter-btn">
    <a data-bs-toggle="offcanvas" href="#offcanvasFilter" role="button" aria-controls="offcanvasFilter">
      <img src="{{ asset('static/images/icons/filter-from-google.jpg') }}" alt=""> Filter
    </a>
  </div>

  <div class="filter-item">
    <form action="{{ url()->current() }}" id="filterForm">
      <div class="d-flex">

        <div class="d-flex align-items-center">
          <label for="storeType" class="form-label text-nowrap mb-0 me-2">Store type</label>
          <select class="form-select store-type-select" name="store_type" id="storeType" aria-label="Store Type">
            <option value="all" {{ request('store_type') == 'all' ? 'selected' : '' }}>All</option>
            <option value="online" {{ request('store_type') == 'online' ? 'selected' : '' }}>Online</option>
            <option value="physical" {{ request('store_type') == 'physical' ? 'selected' : '' }}>Physical</option>
          </select>
        </div>

        <div class="d-flex align-items-center area-check-container ms-3">
          <label for="areaAccordion" class="form-label text-nowrap mb-0 me-2">Select Area</label>
          <div class="accordion" id="areaAccordion">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Select Area
                </button>
              </h2>
              <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#areaAccordion">
                <div class="accordion-body">
                  @foreach(['badda', 'banani', 'cantonment', 'dhanmondi', 'gulshan', 'uttara', 'kafrul', 'kalabagan', 'khilgaon', 'khilkhet', 'mirpur', 'mohammadpur', 'motijheel', 'new-market', 'paltan', 'ramna', 'rampura', 'shahbag', 'tejgaon'] as $area)
                  @php
                  $checked = in_array($area, explode(',', request('area', '')));
                  @endphp
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="area[]" value="{{ $area }}" id="area{{ ucfirst($area) }}Checkbox" {{ $checked ? 'checked' : '' }}>
                    <label class="form-check-label" for="area{{ ucfirst($area) }}Checkbox">{{ ucfirst($area) }}</label>
                  </div>
                  @endforeach
                  <button type="button" class="btn btn-primary mt-3 w-100" id="filterButton">Filter</button>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </form>
  </div>
</div>
<!----- End Filters Part ----->

@if(request()->query())
<!-- Start Filters Items -->
<div class="filters-items mt-3">
  @foreach(request()->query() as $key => $value)
    @if($key == 'area')
      @php $areaValues = explode(',', $value); @endphp
      @if(count($areaValues) > 1)
        @foreach($areaValues as $area)
          <a class="btn btn-default filters-item-btn" href="javascript:void(0);" data-request="{{ $key }}={{ $area }}" role="button">{{ ucfirst($area) }} <i class="fas fa-times"></i></a>
        @endforeach
      @endif
    @elseif(in_array($key, ['pre_order', 'in_stock', 'men', 'women', 'imported', 'local', 'organic', 'cuisine', 'indoor', 'outdoor', 'home_delivery']))
      <a class="btn btn-default filters-item-btn" href="javascript:void(0);" data-request="{{ $key }}={{ $value }}" role="button">{{ ucfirst($key == 'pre_order' ? 'Pre-order' : str_replace('_', ' ', $key)) }} <i class="fas fa-times"></i></a>
    @else
      <a class="btn btn-default filters-item-btn" href="javascript:void(0);" data-request="{{ $key }}={{ $value }}" role="button">{{ ucfirst($value) }} <i class="fas fa-times"></i></a>
    @endif
  @endforeach
  <a href="{{ url()->current() }}" class="btn btn-link" id="clear-all">Clear All</a>
</div>
@endif
<!----- End Filters Items ------>

<!---- Start Stores Part ------>
<div class="store-items mt-5 p-0">
  <div class="row">
    @if($stores && $stores->count() > 0)
    @foreach($stores as $store)
    <div class="col-lg-3 col-6 col-sm-4">
      <x-store-item :store="$store" />
    </div>
    @endforeach
    @else
    <div class="col-12">
      <p>No stores found.</p>
    </div>
    @endif
  </div>
</div>
<!---- End Stores Part ------>

@include('partials.filters_sidebar')

@endsection
@push('js')
<script>
  $(document).ready(function() {
    // Search Sort By Change
    $("#storeType").change(function() {
      var storeType = $("#storeType").val();

      // Get the current URL
      var currentUrl = new URL(window.location.href);
      var searchParams = new URLSearchParams(currentUrl.search);

      if (storeType) {
        searchParams.set("store_type", storeType);
      } else {
        searchParams.delete("store_type");
      }

      // Set the new URL with the updated parameters
      currentUrl.search = searchParams.toString();
      var newUrl = currentUrl.toString();

      window.location.href = newUrl;
    });

    // Filter Button Click
    $("#filterButton").click(function() {
      var selectedAreas = [];

      // Get all checked checkboxes
      $("input[type='checkbox'][name='area[]']:checked").each(function() {
        selectedAreas.push($(this).val());
      });

      // Get the current URL
      var currentUrl = new URL(window.location.href);
      var searchParams = new URLSearchParams(currentUrl.search);
      if (selectedAreas.length > 0) {
        searchParams.set("area", selectedAreas.join(','));
      } else {
        searchParams.delete("area");
      }

      currentUrl.search = searchParams.toString();
      var newUrl = currentUrl.toString();
      window.location.href = newUrl;
    });

    // Filter Item Btn
    $('.filters-item-btn').on('click', function(event) {
      event.preventDefault();
      var clickedQuery = $(this).data('request');
      var queryParams = new URLSearchParams(window.location.search);

      var [key, value] = clickedQuery.split('=');

      if (key === 'area') {
        var currentAreaValues = queryParams.get(key).split(',');
        var updatedAreaValues = currentAreaValues.filter(area => area !== value);
        queryParams.set(key, updatedAreaValues.join(','));
      } else {
        queryParams.delete(key);
      }

      var newUrl = window.location.pathname + '?' + queryParams.toString();
      window.location.href = newUrl;
    });

     // Function to scroll to the active sub-category item
     function scrollToActiveSubCategory() {
        var activeSubCategory = $('.sub-categories a.active');

        if (activeSubCategory.length > 0) {
            var container = $('.sub-categories ul');
            var containerLeft = container.offset().left;
            var activeSubCategoryLeft = activeSubCategory.offset().left;
            var scrollDistance = activeSubCategoryLeft - containerLeft;
            container.scrollLeft(container.scrollLeft() + scrollDistance);
        }
    }

    scrollToActiveSubCategory();
    
    $(window).resize(function() {
        scrollToActiveSubCategory();
    });

  });
</script>
@endpush