@extends('layouts.admin.base')
@section('title', 'Featured Offers | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.featured-offers.index') }}">Featured Offers</a></li>
        <li class="breadcrumb-item active" aria-current="page">All Featured Offers</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-header px-0 d-flex justify-content-between align-items-center">
                    <h6 class="card-title">All Featured Offers</h6>
                    <a class="btn btn-primary" href="{{ route('admin.featured-offers.create') }}" role="button">Add New</a>
                </div>
                <div class="filter mt-3">
                    <form action="{{ route('admin.featured-offers.index') }}" class="filter-form row g-3">
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
                <div class="table-responsive pt-3">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 20%;">Thumbnail</th>
                                <th style="width: 20%;">Title</th>
                                <th style="width: 20%;">Section</th>
                                <th style="width: 15%;">Status</th>
                                <th style="width: 15%;">Date</th>
                                <th style="width: 5%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($featuredOffers) && $featuredOffers->count() > 0)
                            @foreach($featuredOffers as $key => $featuredOffer)
                            <tr>
                                <td>{{ $featuredOffers->currentpage() * $featuredOffers->perpage() - $featuredOffers->perpage() + ++$key }}</td>
                                <td>
                                    <img src="{{ !empty($featuredOffer->thumbnail) ? asset('media/'.$featuredOffer->thumbnail) : asset('static/admin/images/default.jpg') }}" alt="Thumbnail">
                                </td>
                                <td>
                                    {{ $featuredOffer->title }}
                                </td>
                                <td>
                                    {{ $featuredOffer->featuredSection ? $featuredOffer->featuredSection->title : '' }}
                                </td>
                                <td>
                                    @if($featuredOffer->status == 'active')
                                    <span class="badge rounded-pill bg-success">Active</span>
                                    @elseif($featuredOffer->status == 'deactive')
                                    <span class="badge rounded-pill bg-warning text-dark">Deactive</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $featuredOffer->created_at->format('Y-m-d h:i A') }}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <div class="edit-btn">
                                            <a class="btn btn-sm btn-primary" href="{{ route('admin.featured-offers.edit', $featuredOffer->id) }}" role="button">Edit</a>
                                        </div>
                                        <div class="delete-btn ms-2">
                                            <form action="{{ route('admin.featured-offers.destroy', $featuredOffer->id) }}" method="post">
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
                        {{ $featuredOffers->appends(request()->query())->links('layouts.admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection