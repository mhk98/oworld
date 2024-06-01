@extends('layouts.admin.base')
@section('title', 'All Categories | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
        <li class="breadcrumb-item active" aria-current="page">All Categories</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-header px-0 d-flex justify-content-between align-items-center">
                    <h6 class="card-title">All Categories</h6>
                    <a class="btn btn-primary" href="{{ route('admin.categories.create') }}" role="button">Add Category</a>
                </div>
                <div class="filter">
                    <form action="{{ route('admin.categories.index') }}" class="filter-form row g-3">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="title" value="{{ request()->get('title') ? request()->get('title') : '' }}" placeholder="Title" />
                            <select class="form-select" name="status">
                                <option value="All" {{ request()->get('status') == 'All' ? 'selected' : '' }}>All</option>
                                <option value="active" {{ request()->get('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ request()->get('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive pt-3">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th style="width: 30%;">Title</th>
                                <th style="width: 15%;">Icon</th>
                                <th style="width: 25%;">Url</th>
                                <th style="width: 10%;">Status</th>
                                <th style="width: 20%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($parentCategories) && $parentCategories->count() > 0)
                                @foreach($parentCategories as $key => $parentCategory)
                                    <tr>
                                        <td>{{ $parentCategory->title }}</td>
                                        <td>
                                            <img src="{{ !empty($parentCategory->icon) ? asset('media/'.$parentCategory->icon) : asset('static/admin/images/default.jpg') }}" alt="{{ $parentCategory->title }}">
                                        </td>
                                        <td>
                                            <a href="{{ route('category',$parentCategory->slug) }}" target="_blank">{{ $parentCategory->slug }}</a>
                                        </td>
                                        <td>
                                            @if($parentCategory->status == 'active')
                                                <span class="badge rounded-pill bg-primary">Active</span>
                                            @else
                                                <span class="badge rounded-pill bg-secondary">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-start">
                                                <div class="edit-btn">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.categories.edit', $parentCategory->id) }}" role="button">Edit</a>
                                                </div>
                                                <div class="delete-btn ms-2">
                                                    <form action="{{ route('admin.categories.destroy', $parentCategory->id) }}" method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete?');" role="button">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @if (isset($parentCategory->subCategories) && $parentCategory->subCategories->count() > 0)
                                        @foreach ($parentCategory->subCategories as $subCategory)
                                            <tr>
                                                <td>-- {{ $subCategory->title }}</td>
                                                <td>
                                            <img src="{{ !empty($subCategory->icon) ? asset('media/'.$subCategory->icon) : asset('static/admin/images/default.jpg') }}" alt="{{ $subCategory->title }}">
                                        </td>
                                                <td>
                                                    <a href="{{ route('category',$subCategory->slug) }}" target="_blank">{{ $subCategory->slug }}</a>
                                                </td>
                                                <td>
                                                    @if($subCategory->status == 'active')
                                                        <span class="badge rounded-pill bg-primary">Active</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-secondary">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>
                                                <div class="d-flex justify-content-start">
                                                <div class="edit-btn">
                                                    <a class="btn btn-sm btn-primary" href="{{ route('admin.categories.edit', $subCategory->id) }}" role="button">Edit</a>
                                                </div>
                                                <div class="delete-btn ms-2">
                                                    <form action="{{ route('admin.categories.destroy', $subCategory->id) }}" method="post">
                                                        @method('delete')
                                                        @csrf
                                                        <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure you want to delete?');" role="button">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
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
                        {{ $parentCategories->appends(request()->query())->links('layouts.admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection