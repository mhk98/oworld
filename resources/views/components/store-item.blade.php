<div class="store-item">
    <a href="{{ route('store', $store->slug) }}">
        <div class="store-logo">
            @if($store->profile_picture)
                <img src="{{ asset('media/'.$store->profile_picture) }}" alt="{{ $store->business_name }}">
            @else
                <img src="{{ asset('static/images/sample_profile_picture.jpg') }}" alt="{{ $store->business_name }}">
            @endif
        </div>
    </a>
    <a href="{{ route('store', $store->slug) }}">
        <div class="store-cover">
            @if($store->cover_picture)
                <img src="{{ asset('media/'.$store->cover_picture) }}" alt="{{ $store->business_name }}">
            @else
                <img src="{{ asset('static/images/sample_cover_picture.jpg') }}" alt="{{ $store->business_name }}">
            @endif
        </div>
    </a>
    <p class="store-name">
        <a href="{{ route('store', $store->slug) }}">{{ $store->business_name }}</a>
    </p>
    @if(!empty($store->tags))
        <p class="store-tags">
            @foreach($store->tags as $key => $storeTag)
                @php
                    $tagNames = [
                        'pre_order' => 'Pre-order',
                        'in_stock' => 'In Stock',
                        'organic' => 'Organic',
                        'home_delivery' => 'Home Delivery',
                        'men' => 'Men',
                        'women' => 'Women',
                        'imported' => 'Imported',
                        'local' => 'Local',
                        'cuisine' => 'Cuisine',
                        'indoor' => 'Indoor',
                        'outdoor' => 'Outdoor'
                    ];
                @endphp
                {{ $tagNames[$storeTag] ?? $storeTag }}
                @if (!$loop->last)
                    .
                @endif
            @endforeach
        </p>
    @endif
</div>