@extends('layouts.base')
@section('content')
<div class="offers">

    <!----- Start Offer Categories Part ----->
    <div class="categories d-flex align-items-start">
        <a href="{{ route('offers') }}" class="{{ request()->is('offers') && empty(request('category')) ? 'active' : '' }} text-center">
            <img src="{{ asset('static/images/category.png') }}" alt="All Categories">
            <p>All</p>
        </a>

        @if($categories)
        @foreach($categories as $category)
        <a href="{{ route('offers') . '?' . http_build_query(['category' => $category->slug]) }}" class="{{ request('category') == $category->slug ? 'active' : '' }} text-center">
            <img src="{{ asset('media/'.$category->icon) }}" alt="{{ $category->title }}">
            @if($category->title == 'Education & Work')
            <p>Education <br> & Work</p>
            @elseif($category->title == 'Home & Living')
            <p>Home <br> & Living</p>
            @elseif(strpos($category->title, "&") !== false)
            @php
            $title = str_replace("&", "& <br>", $category->title);
            @endphp
            <p>{!! $title !!}</p>
            @else
            <p>{{ $category->title }}</p>
            @endif
        </a>
        @endforeach
        @endif

    </div>
    <!----- End Offer Categories Part ----->

    <!----- Start Offer Items Part ----->
    @if($offers->count() > 0)
    <div class="row g-3 mt-3">
        @foreach($offers as $offer)
            <!-- Post Preview part Start -->
            <div class="col-6 col-md-4">
                <div class="offer-item">
                    <div class="text-center">
                        <img src="{{ asset('media/'.$offer->thumbnail) }}" class="img-fluid rounded" alt="Offer" data-bs-toggle="modal" data-bs-target="#offerModal{{ $offer->offer_id }}">
                        <p><a href="{{ route('store', $offer->store->slug) }}" class="store-name">{{ $offer->store->business_name }}</a></p>
                    </div>
                </div>
            </div>
            <!-- Post Preview part End -->
        @endforeach
    </div>
@else
    <p class="p-3">No offers available at the moment.</p>
@endif

    <!----- End Offer Items Part ----->

</div>
@endsection

@push('modal')
@if($offers->count() > 0)
@foreach($offers as $offer)
<x-offer :offer="$offer" />
@endforeach
@endif
@endpush

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(!empty($openOffer))
                var myModal = new bootstrap.Modal(document.getElementById('offerModal{{ $openOffer->offer_id }}'));
                myModal.show();
            @endif 
        });
    </script>
@endpush