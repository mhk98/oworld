@extends('layouts.admin.base')
@section('title', 'Edit Store | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.featured-stores.index') }}">Featured Stores</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Store</li>
    </ol>
</nav>
<form action="{{ route('admin.featured-stores.update', $featuredStore->id) }}" method="post" enctype="multipart/form-data" id="updateStore">
    @csrf
    @method('PUT')
    <div class="row g-3">
        <div class="col-md-9">
            <div class="card my-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">Edit Store</h6>
                </div>
                <div class="card-body p-2">

                    <div class="mb-3">
                        <label class="form-label">Section <span class="text-danger">*</span></label>
                        <select class="form-select @error('featured_section_id') is-invalid @enderror" name="featured_section_id">
                            @if($featuredSections->count() > 0)
                            @foreach($featuredSections as $featuredSection)
                            <option value="{{ $featuredSection->id }}" {{ $featuredStore->featured_section_id == $featuredSection->id ? 'selected' : '' }}>
                                {{ $featuredSection->title }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        @error('featured_section_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stores <span class="text-danger">*</span></label>
                        <select class="form-select @error('store_id') is-invalid @enderror" id="stores-select" name="store_id">
                            @if($stores->count() > 0)
                            @foreach($stores as $store)
                            <option value="{{ $store->id }}" {{ $store->id == $featuredStore->store_id ? 'selected' : '' }}>
                                {{ $store->business_name }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        @error('store_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Serial <span class="text-danger">*</span></label>
                        <select class="form-select @error('serial') is-invalid @enderror" name="serial" required>
                            @for ($i = 1; $i <= 20; $i++)
                                <option value="{{ $i }}" {{ $featuredStore->serial == $i ? 'selected' : '' }}>{{ $i }}</option>
                            @endfor
                        </select>
                        @error('serial')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <button class="btn btn-primary px-5" type="submit">Update</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#stores-select').select2();
    });
</script>
@endpush