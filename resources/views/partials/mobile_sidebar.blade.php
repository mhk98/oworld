    <!-- Mobile Sidebar -->
    <div class="mobile-sidebar offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            @if($allCategories)
            <ul class="mobile-header-menu list-unstyled">
                @foreach($allCategories as $categoryItem)
                <li class="nav-item"><a class="nav-link text-start" href="{{ route('category', $categoryItem->slug) }}">
                        {{ $categoryItem->title }}
                    </a></li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>