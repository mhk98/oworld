@extends('layouts.admin.base')
@section('title', 'All Featured Sections | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.featured-sections.index') }}">Featured Sections</a></li>
        <li class="breadcrumb-item active" aria-current="page">All Featured Sections</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="card-header px-0 d-flex justify-content-between align-items-center">
                    <h6 class="card-title">All Featured Sections</h6>
                    <a class="btn btn-primary" href="{{ route('admin.featured-sections.create') }}" role="button">Add New</a>
                </div>
                <div class="table-responsive pt-3">
                    <table class="table table-sm table-striped table-hover">
                        <thead class="table-secondary">
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 30%;">Section</th>
                                <th style="width: 20%;">Content Type</th>
                                <th style="width: 20%;">Status</th>
                                <th style="width: 20%;">Date</th>
                                <th style="width: 15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($featuredSections) && $featuredSections->count() > 0)
                            @foreach($featuredSections as $key => $featuredSection)
                            <tr>
                                <td>{{ $featuredSections->currentpage() * $featuredSections->perpage() - $featuredSections->perpage() + ++$key }}</td>
                                <td>
                                    {{ $featuredSection->title }}
                                </td>
                                <td>
                                    {{ $featuredSection->content_type }}
                                </td>
                                <td>
                                    @if($featuredSection->status == 'active')
                                    <span class="badge rounded-pill bg-info">Active</span>
                                    @elseif($featuredSection->status == 'inactive')
                                    <span class="badge rounded-pill bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $featuredSection->created_at->format('Y-m-d h:i A') }}
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start">
                                        <div class="edit-btn">
                                            <a class="btn btn-sm btn-primary" href="{{ route('admin.featured-sections.edit', $featuredSection->id) }}" role="button">Edit</a>
                                        </div>
                                        <div class="delete-btn ms-2">
                                            <form action="{{ route('admin.featured-sections.destroy', $featuredSection->id) }}" method="post">
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
                        {{ $featuredSections->appends(request()->query())->links('layouts.admin.pagination') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection