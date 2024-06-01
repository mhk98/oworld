 <!-- Mobile bottom part Start -->
 <div class="mobile-bottom d-flex d-lg-none">
        <div class="mobile-bottom-item category-bottom-item {{ request()->is('categories') ? 'active' : '' }}">
            <a href="{{ route('categories') }}">
                <img class="brand-img" src="{{ asset('static/images/icons/categories.png') }}" alt="Categories">
                <img class="white-img" src="{{ asset('static/images/icons/categories-white.png') }}" alt="Categories">
                <span>Categories</span>
            </a>
        </div>

        <div class="mobile-bottom-item food-bottom-item {{ request()->is('food') ? 'active' : '' }}">
            <a href="{{ route('food') }}">
                <img class="brand-img" src="{{ asset('static/images/icons/food.png') }}" alt="Foods">
                <img class="white-img" src="{{ asset('static/images/icons/food-white.png') }}" alt="Foods">
                <span>Food</span>
            </a>
        </div>

        <div class="mobile-bottom-item offers-bottom-item {{ request()->is('offers') ? 'active' : '' }}">
            <a href="{{ route('offers') }}">
                <img class="brand-img" src="{{ asset('static/images/icons/offers.png') }}" alt="Offers">
                <img class="white-img" src="{{ asset('static/images/icons/offers-white.png') }}" alt="Offers">
                <span>Offers</span>
            </a>
        </div>

        <div class="mobile-bottom-item bday-bottom-item {{ request()->is('bday-bash') ? 'active' : '' }}">
            <a href="{{ route('bday_bash') }}">
                <img class="brand-img" src="{{ asset('static/images/icons/birthday.png') }}" alt="B'day Bash">
                <img class="white-img" src="{{ asset('static/images/icons/birthday-white.png') }}" alt="B'day Bash">
                <span>B'day Bash</span>
            </a>
        </div>

        <div class="mobile-bottom-item favorites-bottom-item {{ request()->is('account/favorites') ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}">
                <img class="brand-img" src="{{ asset('static/images/icons/favorites.png') }}" alt="Favorites">
                <img class="white-img" src="{{ asset('static/images/icons/favorites-white.png') }}" alt="Favorites">
                <span>Favorites</span>
            </a>
        </div>
    </div>
    <!-- Mobile bottom part End -->
