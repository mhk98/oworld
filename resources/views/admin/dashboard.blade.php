@extends('layouts.admin.base')
@section('title', 'Dashboard | O\'World')
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="row flex-grow-1">
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card mb-2">
                    <div class="card-body">
                        <h6 class="card-title mb-0">Total Users</h6>
                        <h3 class="mb-0">
                            {{ $totalUsers }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card mb-2">
                    <div class="card-body">
                        <h6 class="card-title mb-0">Total Merchants</h6>
                        <h3 class="mb-0">
                        {{ $totalMerchants }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card mb-2">
                    <div class="card-body">
                        <h6 class="card-title mb-0">Total Stores</h6>
                        <h3 class="mb-0">
                        {{ $totalStores }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card mb-2">
                    <div class="card-body">
                        <h6 class="card-title mb-0">Total Posts</h6>
                        <h3 class="mb-0">
                        {{ $totalPosts }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card mb-2">
                    <div class="card-body">
                        <h6 class="card-title mb-0">Total Offers</h6>
                        <h3 class="mb-0">
                        {{ $totalOffers }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card mb-2">
                    <div class="card-body">
                        <h6 class="card-title mb-0">Total Highlights</h6>
                        <h3 class="mb-0">
                        {{ $totalHighlights }}
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 grid-margin stretch-card">
                <div class="card mb-2">
                    <div class="card-body">
                        <h6 class="card-title mb-0">Total Billboards</h6>
                        <h3 class="mb-0">
                        {{ $totalBillboards }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{---
<div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title mb-0">Monthly Orders</h6>
                <div style="height: 400px;">
                    <canvas id="monthly-orders-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 col-xl-12 col-md-12">
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="card-title mb-0">Weekly Orders</h6>
                <div style="height: 400px;">
                    <canvas id="weekly-orders-chart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>---}}
@endsection