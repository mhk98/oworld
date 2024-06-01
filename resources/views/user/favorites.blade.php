@extends('layouts.base')
@section('content')
<div id="post-page">

   {{--- @if($favorites->count() > 0)
    @foreach($favorites as $favorite)
    @php
    $offer = \App\Models\Offer::where('id', $favorite->content_id)->first();
    @endphp
    @if($offer )
    <!-- Post Preview part Start -->
    <div class="post mb-3">
        <div class="post-head d-flex justify-content-between">
            <div class="d-flex">
                <img src="{{ asset('media/'.$offer->store->profile_picture) }}" alt="">
                <a href="{{ route('store',$offer->store->store_id) }}"><h4>{{ $offer->store->business_name }}</h4></a>
            </div>
            <p><i class="fas fa-circle"></i><span>{{ \Carbon\Carbon::parse($offer->created_at)->diffForHumans() }}</span></p>
            <a href="#"><i class="fas fa-ellipsis-h"></i></a>
        </div>

        <img src="{{ asset('media/'.$offer->image) }}" class="img-fluid w-100" alt="Offer">

        <div class="post-description">
            <p>{{ $offer->description }} <a href="#">View More</a></p>
        </div>
        <div class="post-footer d-flex justify-content-between">
            <div class="d-flex">
            <a href="javascript:void(0);" id="removeFavorite" data-id="{{ $favorite->id }}">
                    <i class="fas fa-heart text-danger"></i>
                </a>
                <i class="fas fa-comment"></i>
            </div>
            <i class="fas fa-share"></i>
        </div>
    </div>
    <!-- Post Preview part End -->
    @endif
    @endforeach
    @else ---}}

    <div class="alert alert-info" role="alert">
        No favorites found.
    </div>

    {{---
@endif ---}}

</div>
@endsection