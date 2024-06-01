@extends('layouts.admin.base')
@section('title', 'Add New Highlight | '.env('APP_NAME'))
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.highlights.index') }}">Highlights</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add New Highlight</li>
    </ol>
</nav>
<form action="{{ route('admin.highlights.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="row g-3">
        <div class="col-md-9">
            <div class="card my-2">
                <div class="card-head p-2 border-bottom">
                    <h6 class="card-title my-1">Add New Highlight</h6>
                </div>
                <div class="card-body p-2">
                    <div class="image-box mb-1">
                        <label class="form-label">Image </label>
                        <div class="image-box-preview">
                            <img id="highlight_image" src="{{ asset('static/admin/images/default.jpg') }}" alt="Highlight Image">
                        </div>
                        <div class="image-box-select">
                            <input type="file" name="image" class="image-input @error('image') is-invalid @enderror" id="highlight_image_file" accept=".png, .jpg, .jpeg">
                            <label for="highlight_image_file">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                    <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                                </svg> <span>Change File &hellip;</span></label>
                        </div>
                        @error('highlight_image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" id="category" required>
                            @if($categories->count() > 0)
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        @error('category_id')
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


                    <div class="mb-3 mt-4">
                        <label class="form-label">Description</label>
                        <textarea name="description" cols="10" rows="3" class="form-control">{{ old('description') }}</textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Select Slot</label>
                        <input type="date" class="form-control @error('published_date') is-invalid @enderror" name="published_date" value="{{ old('published_date') }}" required>
                        @error('published_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="slot-radio" id="all-slots">

                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>
                                Published
                            </option>
                            <option value="private" {{ old('status') == 'private' ? 'selected' : '' }}>
                                Private
                            </option>
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

        // Set the value of published_date input to empty
        $('input[name="published_date"]').val('');

        // Fetch Slots
        function fetchSlots() {
            var categoryId = $('select[name="category_id"]').val();
            var slotDate = $('input[name="published_date"]').val();

            // Send AJAX request
            $.ajax({
                url: "{{ route('admin.getHighlightSlots') }}",
                method: 'POST',
                data: {
                    category_id: categoryId,
                    published_date: slotDate,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#all-slots').html(response);
                }
            });
        }

        // Call fetchSlots() when category or published date changes and both are not empty
        $('select[name="category_id"], input[name="published_date"]').change(function() {
            var categoryId = $('select[name="category_id"]').val();
            var publishedDate = $('input[name="published_date"]').val();

            if (categoryId && publishedDate) {
                fetchSlots();
            }
        });
    });
</script>
@endpush