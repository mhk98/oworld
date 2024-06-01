@extends('layouts.admin.base')
@section('title', 'All Posts | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Posts</a></li>
        <li class="breadcrumb-item active" aria-current="page">All Posts</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-header px-0 d-flex justify-content-between align-items-center">
                    <h6 class="card-title">All Posts</h6>
                    <a class="btn btn-primary" href="{{ route('admin.posts.create') }}" role="button">Add New Post</a>
                </div>
                <div class="filter">
                    <form action="{{ route('admin.posts.index') }}" class="filter-form row g-3">
                        <div class="input-group mb-3">
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
                                <th style="width: 10%;">#</th>
                                <th style="width: 20%;">Thumbnail</th>
                                <th style="width: 20%;">Store</th>
                                <th style="width: 20%;">Status</th>
                                <th style="width: 20%;">Date</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($posts) && $posts->count() > 0)
                            @foreach($posts as $key => $post)
                            <tr>
                                <td>{{ $posts->currentpage() * $posts->perpage() - $posts->perpage() + ++$key }}</td>
                                <td>
                                    <img src="{{ !empty($post->thumbnail) ? asset('media/'.$post->thumbnail) : asset('static/admin/images/default.jpg') }}" alt="Post Image">
                                </td>
                                <td>
                                    {{ !empty($post->store) ? $post->store->business_name : 'N/A' }}
                                </td>
                                <td>
                                    @if($post->status == 'pending')
                                    <span class="badge bg-warning text-dark text-capitalize">{{ $post->status }}</span>
                                    @elseif($post->status == 'private')
                                    <span class="badge bg-secondary text-capitalize">{{ $post->status }}</span>
                                    @elseif($post->status == 'published')
                                    <span class="badge bg-success text-capitalize">{{ $post->status }}</span>
                                    @else
                                    <span class="badge bg-light text-dark">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $post->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <div class="edit-btn">
                                            <a class="btn btn-sm btn-primary" href="{{ route('admin.posts.edit', $post->id) }}" role="button">Edit</a>
                                        </div>
                                        <div class="delete-btn ms-2">
                                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="post">
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
                        {{ $posts->appends(request()->query())->links('layouts.admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection