

                        <!-- Mobile-Header part start -->
                        <div class="mobile-header d-lg-none d-flex align-items-center justify-content-between">
                            <div class="mobile-menu-toggle">
                                <button class="btn btn-default hamburger-btn" data-bs-toggle="offcanvas" href="#mobileSidebar" role="button" aria-controls="mobileSidebar">
                                    <i class="fas fa-bars"></i>
                                </button>
                            </div>

                            <div class="mobile-logo text-center">
                                <a href="{{ route('index') }}">
                                    <img src="{{ asset('static/images/logo.png') }}" class="img-fluid w-100" alt="Logo">
                                </a>
                            </div>

                            <div class="mobile-header-right d-flex align-items-center justify-content-end">
                                <a href="javascript:void(0);" class="btn btn-default mobile-search-btn" data-bs-toggle="modal" data-bs-target="#mobileSearchModal">
                                    <i class="fas fa-search"></i>
                                </a>

                                @auth
                                @if(auth()->user()->is_merchant)
                                <a href="javascript:void(0);" class="btn btn-default mobile-user-btn" id="dropdownUserMobileMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-store"></i> <br> <span>
                                    {{ $store->business_name ?? 'N/A' }}
                                    </span>
                                </a>
                                @elseif(!auth()->user()->is_merchant && !auth()->user()->is_admin)
                                <a href="javascript:void(0);" class="btn btn-default mobile-user-btn" id="dropdownUserMobileMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-store"></i> <br> <span>{{ auth()->user()->first_name }}</span>
                                </a>
                                @elseif(auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-default mobile-user-btn">
                                    <i class="fas fa-user-cog"></i> <br> <span>Admin</span>
                                </a>
                                @endif
                                @else
                                <a href="{{ route('auth.loginForm') }}" class="btn btn-default mobile-user-btn">
                                    <i class="fas fa-user"></i> <br> <span>Login</span>
                                </a>
                                @endauth

                                @auth
                                <ul class="dropdown-menu mobile-dropdown" aria-labelledby="dropdownUserMobileMenu">
                                    @if(auth()->user()->is_merchant)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('store', $store->slug) }}">
                                            <i class="fas fa-store"></i><span>Go to Store</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('merchant.setting') }}">
                                            <i class="fas fa-cog"></i><span>Settings</span></a>
                                    </li>
                                    @elseif(!auth()->user()->is_merchant && !auth()->user()->is_admin)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('user.settingForm') }}">
                                            <i class="fas fa-cog"></i><span>Settings</span></a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                            <i class="fas fa-plus-square"></i><span>Favorites</span></a>
                                    </li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="{{ route('auth.logout') }}">
                                            <i class="fas fa-sign-out-alt"></i><span>Log Out</span></a>
                                    </li>
                                </ul>
                                @endauth
                            </div>
                        </div>
                        <!-- Mobile-Header part end -->