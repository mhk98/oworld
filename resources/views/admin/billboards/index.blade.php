@extends('layouts.admin.base')
@section('title', 'All Billboards | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.billboards.index') }}">Billboards</a></li>
        <li class="breadcrumb-item active" aria-current="page">All Billboards</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-header px-0 d-flex justify-content-between align-items-center">
                    <h6 class="card-title">All Billboards</h6>
                    <a class="btn btn-primary" href="{{ route('admin.billboards.create') }}" role="button">Add
                        New Billboard</a>
                </div>
                <div class="filter">
                    <form action="{{ route('admin.billboards.index') }}" class="filter-form row g-3">
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
    <th style="width: 5%;">#</th>
    <th style="width: 25%;">Image</th>
    <th style="width: 20%;">Store</th>
    <th style="width: 20%;">Status</th>
    <th style="width: 20%;">Date</th>
    <th style="width: 10%;">Action</th>
</tr>
                        </thead>
                        <tbody>
                            @if(!empty($billboards) && $billboards->count() > 0)
                            @foreach($billboards as $key => $billboard)
                            <tr>
                                <td>{{ $billboards->currentpage() * $billboards->perpage() - $billboards->perpage() + ++$key }}</td>
                                <td>
                                    <img src="{{ !empty($billboard->image) ? asset('media/'.$billboard->image) : asset('static/admin/images/default.jpg') }}" alt="Billboard Image">
                                </td>
                                <td>
                                    {{ !empty($billboard->store) ? $billboard->store->business_name : 'N/A' }}
                                </td>
                                <td>
                                    @if($billboard->status == 'pending')
                                    <span class="badge bg-warning text-dark text-capitalize">{{ $billboard->status }}</span>
                                    @elseif($billboard->status == 'private')
                                    <span class="badge bg-secondary text-capitalize">{{ $billboard->status }}</span>
                                    @elseif($billboard->status == 'published')
                                    <span class="badge bg-success text-capitalize">{{ $billboard->status }}</span>
                                    @else
                                    <span class="badge bg-light text-dark">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $billboard->created_at->format('Y-m-d h:i:s A') }}</td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <div class="edit-btn">
                                            <a class="btn btn-sm btn-primary" href="{{ route('admin.billboards.edit', $billboard->id) }}" role="button">Edit</a>
                                        </div>
                                        <div class="delete-btn ms-2">
                                            <form action="{{ route('admin.billboards.destroy', $billboard->id) }}" method="post">
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
                        {{ $billboards->appends(request()->query())->links('layouts.admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection