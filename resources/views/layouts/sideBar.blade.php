  <!-- Sidebar part start -->
  <div class="sidebar d-none d-lg-block">
            <div class="sidebar-logo">
                <a href="{{ route('index') }}">
                    <img src="{{ asset('static/images/logo.png') }}" alt="Logo">
                </a>
            </div>
            <ul>
                <li class="sidebar-item home-menu-item {{ request()->is('/') ? 'active' : '' }}">
                    <a href="{{ route('index') }}">
                        <img class="brand-img" src="{{ asset('static/images/icons/home.png') }}" alt="Home">
                        <img class="white-img" src="{{ asset('static/images/icons/home-white.png') }}" alt="Home">
                        <span>Home</span>
                    </a>
                </li>

                <li class="sidebar-item categories-menu-item {{ request()->is('categories') ? 'active' : '' }}">
                    <a href="{{ route('categories') }}">
                        <img class="brand-img" src="{{ asset('static/images/icons/categories.png') }}" alt="Categories">
                        <img class="white-img" src="{{ asset('static/images/icons/categories-white.png') }}" alt="Categories">
                        <span>Categories</span>
                    </a>
                </li>

                <li class="sidebar-item food-menu-item {{ request()->is('food') ? 'active' : '' }}">
                    <a href="{{ route('food') }}">
                        <img class="brand-img" src="{{ asset('static/images/icons/food.png') }}" alt="Food">
                        <img class="white-img" src="{{ asset('static/images/icons/food-white.png') }}" alt="Food">
                        <span>Food</span></a>
                </li>

                <li class="sidebar-item offers-menu-item {{ request()->is('offers') ? 'active' : '' }}">
                    <a href="{{ route('offers') }}">
                        <img class="brand-img" src="{{ asset('static/images/icons/offers.png') }}" alt="Offers">
                        <img class="white-img" src="{{ asset('static/images/icons/offers-white.png') }}" alt="Offers">
                        <span>Offers</span>
                    </a>
                </li>

                <li class="sidebar-item bday-menu-item {{ request()->is('bday-bash') ? 'active' : '' }}">
                    <a href="{{ route('bday_bash') }}">
                        <img class="brand-img" src="{{ asset('static/images/icons/birthday.png') }}" alt="B'day Bash">
                        <img class="white-img" src="{{ asset('static/images/icons/birthday-white.png') }}" alt="B'day Bash">
                        <span>B'day Bash</span>
                    </a>
                </li>

                <li class="sidebar-item influencer-menu-item {{ request()->is('influencer') ? 'active' : '' }}">
                    <a href="{{ route('influencer') }}">
                        <img class="brand-img" src="{{ asset('static/images/icons/influencers.png') }}" alt="Influencer">
                        <img class="white-img" src="{{ asset('static/images/icons/influencers-white.png') }}" alt="Influencer">
                        <span>Influencer</span>
                    </a>
                </li>

                <li class="sidebar-item favorites-menu-item {{ request()->is('account/favorites') ? 'active' : '' }}">
                    <a href="{{ route('user.dashboard') }}">
                        <img class="brand-img" src="{{ asset('static/images/icons/favorites.png') }}" alt="Favorites">
                        <img class="white-img" src="{{ asset('static/images/icons/favorites-white.png') }}" alt="Favorites">
                        <span>Favorites</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar part end -->