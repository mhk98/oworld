@extends('layouts.admin.base')
@section('title', 'All Products and Services | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
        <li class="breadcrumb-item active" aria-current="page">All Products and Services</li>
    </ol>
</nav>

<div class="row g-3">
    <div class="col-md-12">
        <div class="card my-2">
            <div class="card-body p-2">

                @if($products->isNotEmpty())
                <h2 class="fs-4 fw-bold mb-3">Products</h2>
                <ul class="list-inline product-list">
    @foreach($products as $product)
        <li class="list-inline-item">
            <a href="{{ route('admin.similar_word', $product->product) }}">{{ $product->product }}</a>
        </li>
    @endforeach
</ul>
                <div class="pagination mt-2">
                    <div class="d-flex justify-content-center">
                        {{ $products->appends(request()->query())->links('layouts.admin.pagination') }}
                    </div>
                </div>
                <hr>
                @endif

                @if($services->isNotEmpty())
                <h2 class="fs-4 fw-bold mb-3">Services</h2>
                <ul class="list-inline service-list">
                    @foreach($services as $service)
                    <li class="list-inline-item">
                        <a href="{{ route('admin.similar_word', $service->service) }}">{{ $service->service }}</a>
                    </li>
                    @endforeach
                </ul>
                <div class="pagination mt-2">
                    <div class="d-flex justify-content-center">
                        {{ $services->appends(request()->query())->links('layouts.admin.pagination') }}
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</div>
<style>
.product-list a, .service-list a {
    font-size: 16px;
    color: #333;
 transition: color 0.3s ease;
}

.product-list a:hover, .service-list a:hover {
    color: #007bff;
}
</style>
@endsection