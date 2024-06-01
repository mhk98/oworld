    <!-- Mobile Search Modal -->
    <div class="modal fade mobile-search" id="mobileSearchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Search</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('search') }}" method="get">
                        <div class="input-group my-3">
                            <input type="text" class="form-control mobile-search-input" name="search" placeholder="Search" aria-label="Search" aria-describedby="search-mobile-button">
                            <button class="btn btn-default mobile-search-icon" type="submit" id="search-mobile-button"><i class="fas fa-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>