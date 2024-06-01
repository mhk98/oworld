
   <!-- Top part start -->
    <div class="top-bar align-items-center d-lg-flex d-none">
                            <div class="search-form d-flex justify-content-end">
                                <form action="{{ route('search') }}" method="get">
                                    <div class="serch">
                                        <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search">
                                        <button><i class="fas fa-search"></i></button>
                                    </div>
                                </form>
                            </div>

                            @guest
                            <div class="login-part header-btn d-flex align-items-center justify-content-end">
                                <a href="{{ route('auth.signUpForm') }}">Sign Up</a>
                                <a class="btn btn-default btn-login" href="{{ route('auth.loginForm') }}">Log in</a>
                            </div>
                            @endguest

                            @auth
                            <div class="user-dropdown-part d-flex align-items-center justify-content-end">
                                <div class="dropdown header-dropdown">

                                    @if(auth()->user()->is_merchant)
                                    <a class="btn" href="javascript:void(0);" role="button" id="userDropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-store"></i> {{ $store->business_name ?? 'N/A' }}
                                    </a>
                                    @elseif(!auth()->user()->is_merchant && !auth()->user()->is_admin)
                                    <a class="btn" href="javascript:void(0);" role="button" id="userDropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user-cog"></i>
                                        {{ auth()->user()->first_name }}
                                    </a>
                                    @else
                                    <a class="btn" href="{{ route('admin.dashboard') }}" role="button" aria-expanded="false">
                                        <i class="fas fa-user-cog"></i>
                                        Admin
                                    </a>
                                    @endif

                                    <ul class="dropdown-menu" aria-labelledby="userDropdownMenu">
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

                                </div>
                            </div>
                            @endauth
                        </div>
                        <!-- Top part end -->