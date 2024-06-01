@extends('layouts.admin.base')
@section('title', 'All Offers | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.offers.index') }}">Offers</a></li>
        <li class="breadcrumb-item active" aria-current="page">All Offers</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-header px-0 d-flex justify-content-between align-items-center">
                    <h6 class="card-title">All Offers</h6>
                    <a class="btn btn-primary" href="{{ route('admin.offers.create') }}" role="button">Add New Offer</a>
                </div>
                <div class="filter">
                    <form action="{{ route('admin.offers.index') }}" class="filter-form row g-3">
                        <div class="input-group mb-3">
                            <select class="form-select" name="category">
                                <option value="All" {{ request()->get('store') == 'All' ? 'selected' : '' }}>
                                    Select Category
                                </option>
                                @if($categories->count() > 0)
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request()->get('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            <select class="form-select" name="store">
                                <option value="All" {{ request()->get('store') == 'All' ? 'selected' : '' }}>
                                    Select Store
                                </option>
                                @if($stores->count() > 0)
                                @foreach($stores as $store)
                                <option value="{{ $store->id }}" {{ request()->get('store') == $store->id ? 'selected' : '' }}>
                                    {{ $store->business_name }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive pt-3">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="table-secondary">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 30%;">Image</th>
                            <th style="width: 15%;">Category</th>
                            <th style="width: 20%;">Store</th>
                            <th style="width: 15%;">Status</th>
                            <th style="width: 15%;">Date</th>
                            <th style="width: 20%;">Action</th>
                         </tr>
                        </thead>
                        <tbody>
                            @if(!empty($offers) && $offers->count() > 0)
                            @foreach($offers as $key => $offer)
                            <tr>
                                <td>{{ $offers->currentpage() * $offers->perpage() - $offers->perpage() + ++$key }}</td>
                                <td>
                                    <img src="{{ !empty($offer->thumbnail) ? asset('media/'.$offer->thumbnail) : asset('static/admin/images/default.jpg') }}" alt="Offer Image">
                                </td>
                                <td>
                                    {{ !empty($offer->category) ? $offer->category->title : 'N/A' }}
                                </td>
                                <td>
                                    {{ !empty($offer->store) ? $offer->store->business_name : 'N/A' }}
                                </td>
                                <td>
                                    @if($offer->status == 'pending')
                                    <span class="badge bg-warning text-dark text-capitalize">{{ $offer->status }}</span>
                                    @elseif($offer->status == 'private')
                                    <span class="badge bg-secondary text-capitalize">{{ $offer->status }}</span>
                                    @elseif($offer->status == 'published')
                                    <span class="badge bg-success text-capitalize">{{ $offer->status }}</span>
                                    @else
                                    <span class="badge bg-light text-dark">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $offer->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <div class="edit-btn">
                                            <a class="btn btn-sm btn-primary" href="{{ route('admin.offers.edit', $offer->id) }}" role="button">Edit</a>
                                        </div>
                                        <div class="delete-btn ms-2">
                                            <form action="{{ route('admin.offers.destroy', $offer->id) }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete?');" role="button">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr class="text-center">
                                <td colspan="7">No Result Found!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="pagination mt-2">
                    <div class="d-flex justify-content-center">
                        {{ $offers->appends(request()->query())->links('layouts.admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection