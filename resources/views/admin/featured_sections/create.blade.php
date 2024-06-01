@extends('layouts.admin.base')
@section('title', 'New Featured Section | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.featured-sections.index') }}">Featured Sections</a></li>
        <li class="breadcrumb-item active" aria-current="page">New Featured Section</li>
    </ol>
</nav>
<form action="{{ route('admin.featured-sections.store') }}" method="post" enctype="multipart/form-data" id="postContent">
    @csrf
    <div class="row g-3">
        <div class="col-md-8">
            <div class="card my-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">New Featured Section</h6>
                </div>
                <div class="card-body p-2">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}">
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Serial</label>
                        <select class="form-select @error('serial') is-invalid @enderror" name="serial">
                            <option value="">Select Serial</option>
                            @for ($i = 1; $i <= 10; $i++) <option value="{{ $i }}" @if(old('serial')==$i) selected @endif>{{ $i }}</option>
                                @endfor
                        </select>
                        @error('serial')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content Type <span class="text-danger">*</span></label>
                        <select class="form-select @error('content_type') is-invalid @enderror" name="content_type" required>
                            <option value="Stores" {{ old('content_type') == 'Stores' ? 'selected' : '' }}>Stores</option>
                            <option value="Posts" {{ old('content_type') == 'Posts' ? 'selected' : '' }}>Posts</option>
                            <option value="Offers" {{ old('content_type') == 'Offers' ? 'selected' : '' }}>Offers</option>
                        </select>
                        @error('content_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <button class="btn btn-primary px-5" type="submit">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection