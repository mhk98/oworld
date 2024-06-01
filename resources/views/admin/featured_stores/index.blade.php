@extends('layouts.admin.base')
@section('title', 'Featured Stores | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.featured-posts.index') }}">Featured Stores</a></li>
        <li class="breadcrumb-item active" aria-current="page">All Featured Stores</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-header px-0 d-flex justify-content-between align-items-center">
                    <h6 class="card-title">Featured Stores</h6>
                    <a class="btn btn-primary" href="{{ route('admin.featured-stores.create') }}" role="button">Add New</a>
                </div>
                <div class="filter mt-3">
                    <form action="{{ route('admin.featured-stores.index') }}" class="row g-3">
                        <div class="col-md-6">
                            <select class="form-select" name="section">
                                <option value="All" {{ request()->get('section') == 'All' ? 'selected' : '' }}>
                                    Select Featured Section
                                </option>
                                @if($featuredSections->count() > 0)
                                @foreach($featuredSections as $featuredSection)
                                <option value="{{ $featuredSection->id }}" {{ request()->get('section') == $featuredSection->id ? 'selected' : '' }}>
                                    {{ $featuredSection->title }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-outline-primary" type="submit">Search</button>
                        </div>
                    </form>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 20%;">Store</th>
                                <th style="width: 20%;">Section</th>
                                <th style="width: 15%;">Date</th>
                                <th style="width: 5%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($featuredStores) && $featuredStores->count() > 0)
                            @foreach($featuredStores as $key => $featuredStore)
                            <tr>
                                <td>{{ $featuredStores->currentpage() * $featuredStores->perpage() - $featuredStores->perpage() + ++$key }}</td>
                                <td>{{ !empty($featuredStore->store->business_name) ? $featuredStore->store->business_name : 'N/A' }}</td>
                                <td>{{ $featuredStore->featuredSection ? $featuredStore->featuredSection->title : '' }}</td>
                                <td>{{ $featuredStore->created_at->format('Y-m-d h:i A') }}</td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <div class="edit-btn me-2">
                                            <a class="btn btn-sm btn-primary" href="{{ route('admin.featured-stores.edit', $featuredStore->id) }}" role="button">Edit</a>
                                        </div>
                                        <div class="delete-btn">
                                            <form action="{{ route('admin.featured-stores.destroy', $featuredStore->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete?');">
                                                @method('delete')
                                                @csrf
                                                <button class="btn btn-sm btn-danger" type="submit" role="button">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr class="text-center">
                                <td colspan="5">No Result Found!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="pagination mt-2">
                    <div class="d-flex justify-content-center">
                        {{ $featuredStores->appends(request()->query())->links('layouts.admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection