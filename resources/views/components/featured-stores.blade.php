<div class="featured pb-4 pb-md-4 pb-lg-5 mb-5 mb-md-4 mb-lg-0" id="category">
    <div class="row">
        <div class="col-lg-12">
            <div class="title">
                <h4>Featured Stores</h4>
            </div>
        </div>
        <div class="store-items row mt-4 mt-md-4 mt-lg-5 mt-xl-5">
            @forelse($featuredStores as $featuredStore)
                <div class="col-lg-3 col-6 col-sm-4">
                    <x-store-item :store="$featuredStore" />
                </div>
            @empty
                <div class="col-12">
                    <p>No stores found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>