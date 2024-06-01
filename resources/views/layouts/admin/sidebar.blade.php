<nav class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('index') }}" target="_blank" class="sidebar-brand">
            O'World
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item {{ request()->is('admin/categories*','admin/category-serial*') ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#categories" role="button" aria-expanded="false" aria-controls="categories">
                    <i class="link-icon" data-feather="folder"></i>
                    <span class="link-title">Categories</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('admin/categories*') ? 'show' : '' }}" id="categories">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.create') }}" class="nav-link">Add New</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}" class="nav-link">All Categories</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.category_serial.index') }}" class="nav-link">Category Serial</a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- Stores -->
            <li class="nav-item {{ request()->is('admin/stores*') ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#stores" role="button" aria-expanded="false" aria-controls="stores">
                    <i class="link-icon" data-feather="shopping-bag"></i>
                    <span class="link-title">Stores</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('admin/stores*') ? 'show' : '' }}" id="stores">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.stores.create') }}" class="nav-link">Add New</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.stores.index') }}" class="nav-link">All Stores</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Billboards -->
            <li class="nav-item {{ request()->is('admin/billboards*') ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#billboards" role="button" aria-expanded="false" aria-controls="billboards">
                    <i class="link-icon" data-feather="monitor"></i>
                    <span class="link-title">Billboards</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('admin/billboards*') ? 'show' : '' }}" id="billboards">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.billboards.create') }}" class="nav-link">Add New</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.billboards.index') }}" class="nav-link">All Billboards</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Highlights -->
            <li class="nav-item {{ request()->is('admin/highlights*') ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#highlights" role="button" aria-expanded="false" aria-controls="highlights">
                    <i class="link-icon" data-feather="star"></i>
                    <span class="link-title">Highlights</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('admin/highlights*') ? 'show' : '' }}" id="highlights">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.highlights.create') }}" class="nav-link">Add New</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.highlights.index') }}" class="nav-link">All Highlights</a>
                        </li>
                    </ul>
                </div>
            </li>


            <!-- Offers -->
            <li class="nav-item {{ request()->is('admin/offers*') ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#offers" role="button" aria-expanded="false" aria-controls="offers">
                    <i class="link-icon" data-feather="gift"></i>
                    <span class="link-title">Offers</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('admin/offers*') ? 'show' : '' }}" id="offers">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.offers.create') }}" class="nav-link">Add New</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.offers.index') }}" class="nav-link">All Offers</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Posts -->
            <li class="nav-item {{ request()->is('admin/posts*') ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#posts" role="button" aria-expanded="false" aria-controls="posts">
                    <i class="link-icon" data-feather="file-text"></i>
                    <span class="link-title">Posts</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('admin/posts*') ? 'show' : '' }}" id="posts">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.posts.create') }}" class="nav-link">Add New</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.posts.index') }}" class="nav-link">All Posts</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#users" role="button" aria-expanded="false" aria-controls="users">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="link-title">Users</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('admin/users*') ? 'show' : '' }}" id="users">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.users.create') }}" class="nav-link">Add New</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}" class="nav-link">All Users</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Featured Sections -->
            <li class="nav-item {{ request()->is('admin/featured-sections*','admin/featured-posts*','admin/featured-offers*','admin/featured-stores*') ? 'active' : '' }}">
                <a class="nav-link" data-bs-toggle="collapse" href="#featured-sections" role="button" aria-expanded="false" aria-controls="featured-sections">
                    <i class="link-icon" data-feather="star"></i>
                    <span class="link-title">Featured Sections</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse {{ request()->is('admin/featured-sections*','admin/featured-posts*','admin/featured-offers*','admin/featured-stores*') ? 'show' : '' }}" id="featured-sections">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('admin.featured-posts.index') }}" class="nav-link">Posts</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.featured-offers.index') }}" class="nav-link">Offers</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.featured-stores.index') }}" class="nav-link">Stores</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.featured-sections.index') }}" class="nav-link">Sections</a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Products -->
<li class="nav-item {{ request()->is('admin/products-services*') ? 'active' : '' }}">
    <a href="{{ route('admin.products_services') }}" class="nav-link">
        <i class="link-icon" data-feather="shopping-bag"></i>
        <span class="link-title">Products and Services</span>
    </a>
</li>

            <li class="nav-item">
                <a href="{{ route('admin.logout') }}" class="nav-link">
                    <i class="link-icon" data-feather="log-out"></i>
                    <span class="link-title">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</nav>