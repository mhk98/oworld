@extends('layouts.admin.base')
@section('title', 'Edit Category | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Category</li>
    </ol>
</nav>
<form action="{{ route('admin.categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="row g-3">
        <div class="col-md-9">
            <div class="card my-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">Edit Category</h6>
                </div>
                <div class="card-body p-2">
                    <div class="mb-3">
                        <label class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ $category->title }}" placeholder="Title" required>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ $category->slug }}" placeholder="Slug" required>
                        @error('slug')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
 
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_parent" value="yes"
                                id="is-parent-check" {{ $category->is_parent ? 'checked' : '' }}>
                            <label class="form-check-label" for="is-parent-check">
                                Is Parent Category
                            </label>
                        </div>
                    </div>

                    <div class="mb-3" id="parent-category-field">
                        <label class="form-label">Parent Category <span class="text-danger">*</span></label>
                        <select class="form-select @error('parent_id') is-invalid @enderror" name="parent_id"
                            id="parent-category-select">
                            @if(!empty($parentCategories) && count($parentCategories) > 0)
                            @foreach($parentCategories as $parentCategory)
                            <option value="{{ $parentCategory->id }}" {{ $category->parent_id==$parentCategory->id ? 'selected' : '' }}>
                                {{ $parentCategory->title }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        @error('parent_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="active" {{ $category->status=='active' ? 'selected' : ''
                                }}>Active</option>
                            <option value="deactive" {{ $category->status=='deactive' ? 'selected' : '' }}>Deactive
                            </option>
                        </select>
                        @error('status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card my-2">
                <div class="card-body p-2">
                    <div class="image-box mb-1">
                        <label class="form-label">Icon </label>
                        <div class="image-box-preview">
                        <img id="icon_image" src="{{ !empty($category->icon) ? asset('media/'.$category->icon) : asset('static/admin/images/default.jpg') }}" alt="Icon Image">
                        </div>
                        <div class="image-box-select">
                            <input type="file" name="icon" class="image-input @error('icon') is-invalid @enderror" id="icon_file" accept=".png, .jpg, .jpeg">
                            <label for="icon_file">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                                </svg> <span>Change File &hellip;</span></label>
                        </div>
                        @error('icon')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="image-box mb-1">
                        <label class="form-label">Desktop Hero Image </label>
                        <div class="image-box-preview">
                            <img id="desktop_hero_image" src="{{ !empty($category->desktop_hero_image) ? asset('media/'.$category->desktop_hero_image) : asset('static/admin/images/default.jpg') }}" alt="Desktop Hero Image">
                        </div>
                        <div class="image-box-select">
                            <input type="file" name="desktop_hero_image" class="image-input @error('desktop_hero_image') is-invalid @enderror" id="desktop_hero_image_file" accept=".png, .jpg, .jpeg">
                            <label for="desktop_hero_image_file">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                                </svg> <span>Change File &hellip;</span></label>
                        </div>
                        @error('desktop_hero_image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="image-box mb-1">
                        <label class="form-label">Mobile Hero Image </label>
                        <div class="image-box-preview">
                            <img id="mobile_hero_image" src="{{ !empty($category->mobile_hero_image) ? asset('media/'.$category->mobile_hero_image) : asset('static/admin/images/default.jpg') }}" alt="Mobile Hero Image">
                        </div>
                        <div class="image-box-select">
                            <input type="file" name="mobile_hero_image" class="image-input @error('mobile_hero_image') is-invalid @enderror" id="mobile_hero_image_file" accept=".png, .jpg, .jpeg">
                            <label for="mobile_hero_image_file">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                                </svg> <span>Change File &hellip;</span></label>
                        </div>
                        @error('mobile_hero_image')
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
    $(document).ready(function () {
        var is_parent = $('#is-parent-check').is(':checked');
        if (is_parent) {
            $('#parent-category-field').hide();
            $('#parent-category-select').attr('required', false);
        } else {
            $('#parent-category-field').show();
            $('#parent-category-select').attr('required', true);
        }

        $('#is-parent-check').on('change', function () {
            if ($(this).is(':checked')) {
                $('#parent-category-field').hide();
                $('#parent-category-select').attr('required', false);
            } else {
                $('#parent-category-field').show();
                $('#parent-category-select').attr('required', true);
            }
        });
    });
</script>
@endpush