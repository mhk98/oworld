@extends('layouts.admin.base')
@section('title', 'All Highlights | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.highlights.index') }}">Highlights</a></li>
        <li class="breadcrumb-item active" aria-current="page">All Highlights</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-header px-0 d-flex justify-content-between align-items-center">
                    <h6 class="card-title">All Highlights</h6>
                    <a class="btn btn-primary" href="{{ route('admin.highlights.create') }}" role="button">Add New Highlight</a>
                </div>
                <div class="filter">
                    <form action="{{ route('admin.highlights.index') }}" class="filter-form row g-3">
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
                                <th style="width: 25%;">Store</th>
                                <th style="width: 25%;">Status</th>
                                <th style="width: 25%;">Date</th>
                                <th style="width: 15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($highlights) && $highlights->count() > 0)
                            @foreach($highlights as $key => $highlight)
                            <tr>
                                <td>{{ $highlights->currentpage() * $highlights->perpage() - $highlights->perpage() + ++$key }}</td>
                                <td>
                                    <img src="{{ !empty($highlight->thumbnail) ? asset('media/'.$highlight->thumbnail) : asset('static/admin/images/default.jpg') }}" alt="Highlight Image">
                                </td>
                                <td>
                                    {{ !empty($highlight->store) ? $highlight->store->business_name : 'N/A' }}
                                </td>
                                <td>
                                {{ $highlight->created_at->format('Y-m-d H:i:s') }}
                                </td>
                                <td>
                                    @if($highlight->status == 'pending')
                                    <span class="badge rounded-pill bg-info">Pending</span>
                                    @elseif($highlight->status == 'private')
                                    <span class="badge rounded-pill bg-danger">Pending</span>
                                    @else
                                    <span class="badge rounded-pill bg-primary">Published</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <div class="edit-btn">
                                            <a class="btn btn-sm btn-primary" href="{{ route('admin.highlights.edit', $highlight->id) }}" role="button">Edit</a>
                                        </div>
                                        <div class="delete-btn ms-2">
                                            <form action="{{ route('admin.highlights.destroy', $highlight->id) }}" method="post">
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
                                <td colspan="4">No Result Found!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="pagination mt-2">
                    <div class="d-flex justify-content-center">
                        {{ $highlights->appends(request()->query())->links('layouts.admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection