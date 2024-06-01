@extends('layouts.base')
@section('content')
<div class="settings">
    <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-6">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <!-- New tab for Favorites -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-favorites-tab" data-bs-toggle="pill" data-bs-target="#pills-favorites" type="button" role="tab" aria-controls="pills-favorites" aria-selected="false">Favorites</button>
                </li>

                <!-- New tab for Saved Offers -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-offers-tab" data-bs-toggle="pill" data-bs-target="#pills-offers" type="button" role="tab" aria-controls="pills-offers" aria-selected="false">Saved Offers</button>
                </li>
            </ul>
        </div>
        <div class="col-md-12">
            <div class="tab-content" id="pills-tabContent">

                <!-- New content pane for Favorites -->
                <div class="tab-pane fade show active" id="pills-favorites" role="tabpanel" aria-labelledby="pills-favorites-tab">
                    <div class="mt-5 p-0 p-md-0 p-lg-0" id="category">
                        <div class="store-items mt-5 p-0">
                            <div class="row">
                                @if($followedStores && $followedStores->count() > 0)
                                @foreach($followedStores as $followedStore)
                                <div class="col-lg-3 col-6 col-sm-4">
                                    <x-store-item :store="$followedStore->store" />
                                </div>
                                @endforeach
                                @else
                                <div class="col-12">
                                    <p>No stores found.</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- New content pane for Saved Offers -->
                <div class="tab-pane fade" id="pills-offers" role="tabpanel" aria-labelledby="pills-offers-tab">
                    @if($savedOffers->count() > 0)
                    <div class="row g-3">
                        @foreach($savedOffers as $savedOffer)
                        @if($savedOffer->is_featured)
                        <!-- Post Preview part Start -->
                        <div class="col-6 col-md-4">
                            <div class="post rounded">
                                <div class="text-center">
                                    <img src="{{ asset('media/'.$savedOffer->featuredOffer->thumbnail) }}" class="img-fluid rounded" alt="Offer" data-bs-toggle="modal" data-bs-target="#featuredOfferModal{{ $savedOffer->featuredOffer->featured_content_id }}">
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <p><a href="{{ route('store', $savedOffer->featuredOffer->store->slug) }}" class="store-name">{{ $savedOffer->featuredOffer->store->business_name }}</a></p>
                            </div>
                        </div>
                        <!-- Post Preview part End -->
                        @else
                        <!-- Post Preview part Start -->
                        <div class="col-6 col-md-4">
                            <div class="post rounded">
                                <div class="text-center">
                                    <img src="{{ asset('media/'.$savedOffer->offer->thumbnail) }}" class="img-fluid rounded" alt="Offer" data-bs-toggle="modal" data-bs-target="#offerModal{{ $savedOffer->offer->offer_id }}">
                                </div>
                            </div>
                            <div class="text-center mt-2">
                                <p><a href="{{ route('store', $savedOffer->offer->store->slug) }}" class="store-name">{{ $savedOffer->offer->store->business_name }}</a></p>
                            </div>
                        </div>
                        <!-- Post Preview part End -->
                        @endif
                        @endforeach
                    </div>
                    @else
                    <p>No offer saved.</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.settings .nav-pills .nav-item {
  width: 50%;
}

</style>
@endsection

@push('modal')
@if($savedOffers->count() > 0)
@foreach($savedOffers as $savedOffer)
@if($savedOffer->is_featured)
<x-featured-offer :featuredOffer="$savedOffer->featuredOffer" />
@else
<x-offer :offer="$savedOffer->offer" />
@endif
@endforeach
@endif
@endpush