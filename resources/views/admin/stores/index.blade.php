@extends('layouts.admin.base')
@section('title', 'All Stores | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.stores.index') }}">Stores</a></li>
        <li class="breadcrumb-item active" aria-current="page">All Stores</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-header px-0 d-flex justify-content-between align-items-center">
                    <h6 class="card-title">All Stores</h6>
                    <a class="btn btn-primary" href="{{ route('admin.stores.create') }}" role="button">Add
                        Store</a>
                </div>
                <div class="filter">
                    <form action="{{ route('admin.stores.index') }}" class="filter-form row g-3">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="business_name" value="{{ request()->get('business_name') ? request()->get('business_name') : '' }}" placeholder="Enter Business Name" />
                            <select class="form-select" name="status">
                                <option value="All" {{ request()->get('status') == 'All' ? 'selected' : '' }}>
                                    Select Status
                                </option>
                                <option value="active" {{ request()->get('status') == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>
                                <option value="suspend" {{ request()->get('status') == 'suspend' ? 'selected' : '' }}>
                                    Suspend
                                </option>
                                <option value="deactive" {{ request()->get('status') == 'deactive' ? 'selected' : '' }}>
                                    Deactive
                                </option>
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
                                <th style="width: 25%;">Title</th>
                                <th style="width: 15%;">Profile Photo</th>
                                <th style="width: 20%;">Merchant</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($stores) && $stores->count() > 0)
                            @foreach($stores as $key => $store)
                            <tr>
                                <td>{{ $stores->currentpage() * $stores->perpage() - $stores->perpage() + ++$key }}</td>
                                <td>
                                    <a href="{{ route('store', $store->slug) }}" target="_blank">{{ $store->business_name }}</a>
                                </td>
                                <td>
                                    <img src="{{ !empty($store->profile_picture) ? asset('media/'.$store->profile_picture) : asset('static/admin/images/default.jpg') }}" alt="{{ $store->title }}">
                                </td>
                                <td>
                                    {{ !empty($store->merchant) ? $store->merchant->first_name . ' ' . $store->merchant->last_name : 'N/A' }}
                                </td>
                                <td>
                                    @if($store->status == 'active')
                                    <span class="badge rounded-pill bg-primary">Active</span>
                                    @elseif($store->status == 'suspend')
                                    <span class="badge rounded-pill bg-danger">Suspend</span>
                                    @else
                                    <span class="badge rounded-pill bg-secondary">Deactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <div class="edit-btn">
                                            <a class="btn btn-sm btn-primary" href="{{ route('admin.stores.edit', $store->id) }}" role="button">Edit</a>
                                        </div>
                                        <div class="delete-btn ms-2">
                                            <form action="{{ route('admin.categories.destroy', $store->id) }}" method="post">
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
                                <td colspan="6">No Result Found!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="pagination mt-2">
                    <div class="d-flex justify-content-center">
                        {{ $stores->appends(request()->query())->links('layouts.admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection