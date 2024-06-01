@extends('layouts.admin.base')
@section('title', 'Add New Billboard | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.billboards.index') }}">Billboards</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add New Billboard</li>
    </ol>
</nav>
<form action="{{ route('admin.billboards.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row g-3">
        <div class="col-md-9">
            <div class="card my-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">Add New Billboard</h6>
                </div>
                <div class="card-body p-2">
                    <div class="image-box mb-1">
                        <label class="form-label">Image </label>
                        <div class="image-box-preview">
                            <img id="billboard_image" src="{{ asset('static/admin/images/default.jpg') }}" alt="Billboard Image">
                        </div>
                        <div class="image-box-select">
                            <input type="file" name="image" class="image-input @error('image') is-invalid @enderror" id="billboard_image_file" accept=".png, .jpg, .jpeg">
                            <label for="billboard_image_file">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                                </svg> <span>Change File &hellip;</span></label>
                        </div>
                        @error('billboard_image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Store <span class="text-danger">*</span></label>
                        <select class="form-select @error('store_id') is-invalid @enderror" name="store_id" id="store" required>
                            @if($stores->count() > 0)
                            @foreach($stores as $store)
                            <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
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
                <label class="form-label">Published Date</label>
                <input type="date" class="form-control @error('published_date') is-invalid @enderror" name="published_date" value="{{ old('published_date') }}" required>
                @error('published_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

                    <div class="mb-3">
                        <label class="form-label">Serial <span class="text-danger">*</span></label>
                        <select class="form-select @error('serial') is-invalid @enderror" name="serial" id="serial" required>
                            @for($i = 1; $i <= 10; $i++) 
                            <option value="{{ $i }}" {{ old('serial') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                            @endfor
                        </select>
                        @error('serial')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="private" {{ old('status', 'private') == 'private' ? 'selected' : '' }}>Private</option>
                            <option value="published" {{ old('status', 'published') == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#store').select2();
    });
</script>
@endpush