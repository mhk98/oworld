<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasFilter" aria-labelledby="offcanvasFilter">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasFilter">Filters</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <form action="{{ url()->current() }}" method="get">

    @if(request()->filled('store_type'))
        <input type="hidden" name="store_type" value="{{ request()->query('store_type') }}">
      @endif

      @if(request()->filled('area'))
      <input type="hidden" name="area" value="{{ request()->query('area') }}">
      @endif

      @if(request()->is('categories','search'))
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="pre_order" id="flexCheckPreorder" @if(request()->has('pre_order')) checked @endif>
        <label class="form-check-label" for="flexCheckPreorder">
          Pre-order
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="in_stock" id="flexCheckInstock" @if(request()->has('in_stock')) checked @endif>
        <label class="form-check-label" for="flexCheckInstock">
          In Stock
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="men" id="flexCheckMen" @if(request()->has('men')) checked @endif>
        <label class="form-check-label" for="flexCheckMen">
          Men
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="women" id="flexCheckWomen" @if(request()->has('women')) checked @endif>
        <label class="form-check-label" for="flexCheckWomen">
          Women
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="imported" id="flexCheckImported" @if(request()->has('imported')) checked @endif>
        <label class="form-check-label" for="flexCheckImported">
          Imported
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="local" id="flexCheckLocal" @if(request()->has('local')) checked @endif>
        <label class="form-check-label" for="flexCheckLocal">
          Local
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="organic" id="flexCheckOrganic" @if(request()->has('organic')) checked @endif>
        <label class="form-check-label" for="flexCheckOrganic">
          Organic
        </label>
      </div>


      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="cuisine" id="flexCheckCuisine" @if(request()->has('cuisine')) checked @endif>
        <label class="form-check-label" for="flexCheckCuisine">
          Cuisine
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="home_delivery" id="flexCheckHomedelivery" @if(request()->has('home_delivery')) checked @endif>
        <label class="form-check-label" for="flexCheckHomedelivery">
          Home Delivery
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="indoor" id="flexCheckIndoor" @if(request()->has('indoor')) checked @endif>
        <label class="form-check-label" for="flexCheckIndoor">
          Indoor
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="outdoor" id="flexCheckOutdoor" @if(request()->has('outdoor')) checked @endif>
        <label class="form-check-label" for="flexCheckOutdoor">
          Outdoor
        </label>
      </div>

      @elseif(request()->is('food*'))
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="cuisine" id="flexCheckCuisine" @if(request()->has('cuisine')) checked @endif>
        <label class="form-check-label" for="flexCheckCuisine">
          Cuisine
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="home_delivery" id="flexCheckHomedelivery" @if(request()->has('home_delivery')) checked @endif>
        <label class="form-check-label" for="flexCheckHomedelivery">
          Home Delivery
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="indoor" id="flexCheckIndoor" @if(request()->has('indoor')) checked @endif>
        <label class="form-check-label" for="flexCheckIndoor">
          Indoor
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="outdoor" id="flexCheckOutdoor" @if(request()->has('outdoor')) checked @endif>
        <label class="form-check-label" for="flexCheckOutdoor">
          Outdoor
        </label>
      </div>
      @elseif(request()->is('category/fashion'))
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="pre_order" id="flexCheckPreorder" @if(request()->has('pre_order')) checked @endif>
        <label class="form-check-label" for="flexCheckPreorder">
          Pre-order
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="in_stock" id="flexCheckInstock" @if(request()->has('in_stock')) checked @endif>
        <label class="form-check-label" for="flexCheckInstock">
          In Stock
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="men" id="flexCheckMen" @if(request()->has('men')) checked @endif>
        <label class="form-check-label" for="flexCheckMen">
          Men
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="women" id="flexCheckWomen" @if(request()->has('women')) checked @endif>
        <label class="form-check-label" for="flexCheckWomen">
          Women
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="imported" id="flexCheckImported" @if(request()->has('imported')) checked @endif>
        <label class="form-check-label" for="flexCheckImported">
          Imported
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="local" id="flexCheckLocal" @if(request()->has('local')) checked @endif>
        <label class="form-check-label" for="flexCheckLocal">
          Local
        </label>
      </div>


      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="home_delivery" id="flexCheckHomedelivery" @if(request()->has('home_delivery')) checked @endif>
        <label class="form-check-label" for="flexCheckHomedelivery">
          Home Delivery
        </label>
      </div>


      @elseif(request()->is('category/beauty'))
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="pre_order" id="flexCheckPreorder" @if(request()->has('pre_order')) checked @endif>
        <label class="form-check-label" for="flexCheckPreorder">
          Pre-order
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="in_stock" id="flexCheckInstock" @if(request()->has('in_stock')) checked @endif>
        <label class="form-check-label" for="flexCheckInstock">
          In Stock
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="men" id="flexCheckMen" @if(request()->has('men')) checked @endif>
        <label class="form-check-label" for="flexCheckMen">
          Men
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="women" id="flexCheckWomen" @if(request()->has('women')) checked @endif>
        <label class="form-check-label" for="flexCheckWomen">
          Women
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="imported" id="flexCheckImported" @if(request()->has('imported')) checked @endif>
        <label class="form-check-label" for="flexCheckImported">
          Imported
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="local" id="flexCheckLocal" @if(request()->has('local')) checked @endif>
        <label class="form-check-label" for="flexCheckLocal">
          Local
        </label>
      </div>


      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="home_delivery" id="flexCheckHomedelivery" @if(request()->has('home_delivery')) checked @endif>
        <label class="form-check-label" for="flexCheckHomedelivery">
          Home Delivery
        </label>
      </div>

      @elseif(request()->is('category/home-and-living'))
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="pre_order" id="flexCheckPreorder" @if(request()->has('pre_order')) checked @endif>
        <label class="form-check-label" for="flexCheckPreorder">
          Pre-order
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="in_stock" id="flexCheckInstock" @if(request()->has('in_stock')) checked @endif>
        <label class="form-check-label" for="flexCheckInstock">
          In Stock
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="imported" id="flexCheckImported" @if(request()->has('imported')) checked @endif>
        <label class="form-check-label" for="flexCheckImported">
          Imported
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="local" id="flexCheckLocal" @if(request()->has('local')) checked @endif>
        <label class="form-check-label" for="flexCheckLocal">
          Local
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="home_delivery" id="flexCheckHomedelivery" @if(request()->has('home_delivery')) checked @endif>
        <label class="form-check-label" for="flexCheckHomedelivery">
          Home Delivery
        </label>
      </div>
      @elseif(request()->is('category/events-and-entertainment'))
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="men" id="flexCheckMen" @if(request()->has('men')) checked @endif>
        <label class="form-check-label" for="flexCheckMen">
          Men
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="women" id="flexCheckWomen" @if(request()->has('women')) checked @endif>
        <label class="form-check-label" for="flexCheckWomen">
          Women
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="home_delivery" id="flexCheckHomedelivery" @if(request()->has('home_delivery')) checked @endif>
        <label class="form-check-label" for="flexCheckHomedelivery">
          Home Delivery
        </label>
      </div>
      @elseif(request()->is('category/tech-and-electronics'))
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="pre_order" id="flexCheckPreorder" @if(request()->has('pre_order')) checked @endif>
        <label class="form-check-label" for="flexCheckPreorder">
          Pre-order
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="in_stock" id="flexCheckInstock" @if(request()->has('in_stock')) checked @endif>
        <label class="form-check-label" for="flexCheckInstock">
          In Stock
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="imported" id="flexCheckImported" @if(request()->has('imported')) checked @endif>
        <label class="form-check-label" for="flexCheckImported">
          Imported
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="local" id="flexCheckLocal" @if(request()->has('local')) checked @endif>
        <label class="form-check-label" for="flexCheckLocal">
          Local
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="home_delivery" id="flexCheckHomedelivery" @if(request()->has('home_delivery')) checked @endif>
        <label class="form-check-label" for="flexCheckHomedelivery">
          Home Delivery
        </label>
      </div>
      @elseif(request()->is('category/health-and-wellness'))
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="men" id="flexCheckMen" @if(request()->has('men')) checked @endif>
        <label class="form-check-label" for="flexCheckMen">
          Men
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="women" id="flexCheckWomen" @if(request()->has('women')) checked @endif>
        <label class="form-check-label" for="flexCheckWomen">
          Women
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="imported" id="flexCheckImported" @if(request()->has('imported')) checked @endif>
        <label class="form-check-label" for="flexCheckImported">
          Imported
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="local" id="flexCheckLocal" @if(request()->has('local')) checked @endif>
        <label class="form-check-label" for="flexCheckLocal">
          Local
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="home_delivery" id="flexCheckHomedelivery" @if(request()->has('home_delivery')) checked @endif>
        <label class="form-check-label" for="flexCheckHomedelivery">
          Home Delivery
        </label>
      </div>
      @elseif(request()->is('category/groceries'))
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="pre_order" id="flexCheckPreorder" @if(request()->has('pre_order')) checked @endif>
        <label class="form-check-label" for="flexCheckPreorder">
          Pre-order
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="in_stock" id="flexCheckInstock" @if(request()->has('in_stock')) checked @endif>
        <label class="form-check-label" for="flexCheckInstock">
          In Stock
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="imported" id="flexCheckImported" @if(request()->has('imported')) checked @endif>
        <label class="form-check-label" for="flexCheckImported">
          Imported
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="local" id="flexCheckLocal" @if(request()->has('local')) checked @endif>
        <label class="form-check-label" for="flexCheckLocal">
          Local
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="organic" id="flexCheckOrganic" @if(request()->has('organic')) checked @endif>
        <label class="form-check-label" for="flexCheckOrganic">
          Organic
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="home_delivery" id="flexCheckHomedelivery" @if(request()->has('home_delivery')) checked @endif>
        <label class="form-check-label" for="flexCheckHomedelivery">
          Home Delivery
        </label>
      </div>
      @elseif(request()->is('category/education-and-work'))
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="pre_order" id="flexCheckPreorder" @if(request()->has('pre_order')) checked @endif>
        <label class="form-check-label" for="flexCheckPreorder">
          Pre-order
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="in_stock" id="flexCheckInstock" @if(request()->has('in_stock')) checked @endif>
        <label class="form-check-label" for="flexCheckInstock">
          In Stock
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="imported" id="flexCheckImported" @if(request()->has('imported')) checked @endif>
        <label class="form-check-label" for="flexCheckImported">
          Imported
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="local" id="flexCheckLocal" @if(request()->has('local')) checked @endif>
        <label class="form-check-label" for="flexCheckLocal">
          Local
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="home_delivery" id="flexCheckHomedelivery" @if(request()->has('home_delivery')) checked @endif>
        <label class="form-check-label" for="flexCheckHomedelivery">
          Home Delivery
        </label>
      </div>
      @elseif(request()->is('category/business-services'))
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="pre_order" id="flexCheckPreorder" @if(request()->has('pre_order')) checked @endif>
        <label class="form-check-label" for="flexCheckPreorder">
          Pre-order
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="in_stock" id="flexCheckInstock" @if(request()->has('in_stock')) checked @endif>
        <label class="form-check-label" for="flexCheckInstock">
          In Stock
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="home_delivery" id="flexCheckHomedelivery" @if(request()->has('home_delivery')) checked @endif>
        <label class="form-check-label" for="flexCheckHomedelivery">
          Home Delivery
        </label>
      </div>
      @elseif(request()->is('category/automotive'))
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="pre_order" id="flexCheckPreorder" @if(request()->has('pre_order')) checked @endif>
        <label class="form-check-label" for="flexCheckPreorder">
          Pre-order
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="in_stock" id="flexCheckInstock" @if(request()->has('in_stock')) checked @endif>
        <label class="form-check-label" for="flexCheckInstock">
          In Stock
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="imported" id="flexCheckImported" @if(request()->has('imported')) checked @endif>
        <label class="form-check-label" for="flexCheckImported">
          Imported
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="local" id="flexCheckLocal" @if(request()->has('local')) checked @endif>
        <label class="form-check-label" for="flexCheckLocal">
          Local
        </label>
      </div>

      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="home_delivery" id="flexCheckHomedelivery" @if(request()->has('home_delivery')) checked @endif>
        <label class="form-check-label" for="flexCheckHomedelivery">
          Home Delivery
        </label>
      </div>
      @endif

      <button type="submit" class="btn btn-primary mt-3 w-100">Filter</button>

    </form>
  </div>
</div>