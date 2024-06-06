@extends('layouts.base')
@section('content')
<div id="store">
    @if(!request('content_type'))
    <!-- Add Post part Start -->
    <div id="add-post-page" class="mb-5">
         @php
        $store = \App\Models\Store::where('id', session('current_store'))->first();
    @endphp

    @if($store)
        <div class="back-btn">
            <a href="{{ route('store', $store->slug) }}"><i class="fas fa-angle-left"></i></a>
        </div>
        @endif
        
        <h2>Chose your option</h2>
        <div class="form-check">
            <label class="form-check-label" for="contentTypePost">
                <input class="form-check-input" type="radio" name="content_type" value="post" id="contentTypePost">
                <p>Post</p>
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label" for="contentTypeOffer">
                <input class="form-check-input" type="radio" name="content_type" value="offer" id="contentTypeOffer">
                <p>Offer</p>
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label" for="contentTypeHighlight">
                <input class="form-check-input" type="radio" name="content_type" value="highlight" id="contentTypeHighlight">
                <p>Highlight</p>
            </label>
        </div>
        <div class="form-check">
            <label class="form-check-label" for="contentTypeBilboard">
                <input class="form-check-input" type="radio" name="content_type" value="bilboard" id="contentTypeBilboard">
                <p>Bilboard</p>
            </label>
        </div>
    </div>
    <!-- Add Post part End -->
    @elseif(request('content_type') == 'post')
    <div id="upload-page">
        <div class="back-btn">
            <a href="{{ route('merchant.storeContentForm') }}"><i class="fas fa-angle-left"></i></a>
        </div>
        <h6>Upload Post</h6>

        <form action="{{ route('merchant.storePost') }}" method="post" enctype="multipart/form-data" id="postContent">
            @csrf

            <div class="img-upload-here">
                <div class="multiple-uploader" id="postUploader">
                    <div class="mup-msg">
                        <span class="mup-main-msg">click to upload images.</span>
                        <span class="mup-msg" id="max-upload-number">Upload up to 10 images</span>
                        <span class="mup-msg">Only image files (PNG, GIF, JPEG, etc.) are allowed for upload.</span>
                    </div>
                </div>

                @error('post_image')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3 mt-4">
                <label class="form-label">Add Description</label>
                <textarea name="description" cols="10" rows="3" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="pinCheckbox" name="pin_post" value="true">
                <label class="form-check-label" for="pinCheckbox">Pin Post</label>
            </div>

            <button class="btn" type="submit">Upload</button>
        </form>

        <form method="POST" class="needs-validation" novalidate>
                <label class="form-label">Please pay payment</label>
                <button class="btn btn-primary btn-lg btn-block" id="sslczPayBtn"
                        token="if you have any token validation"
                        postdata="your javascript arrays or objects which requires in backend"
                        order="If you already have the transaction generated for current order"
                        endpoint="{{ url('/pay-via-ajax') }}"> Pay Now
                </button>
            </form>
    </div>
    @elseif(request('content_type') == 'offer')
    <div id="upload-page">
        <div class="back-btn">
            <a href="{{ route('merchant.storeContentForm') }}"><i class="fas fa-angle-left"></i></a>
        </div>
        <h6>Upload Offer</h6>

        <form action="{{ route('merchant.storeOffer') }}" method="post" enctype="multipart/form-data" id="offerContent">
            @csrf

            <div class="img-upload-here">
                <div class="multiple-uploader" id="offerUploader">
                    <div class="mup-msg">
                        <span class="mup-main-msg">click to upload images.</span>
                        <span class="mup-msg" id="max-upload-number">Upload up to 10 images</span>
                        <span class="mup-msg">Only image files (PNG, GIF, JPEG, etc.) are allowed for upload.</span>
                    </div>
                </div>
                @error('offer_image')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select class="form-select w-100" name="category_id" required>
                    @if($allCategories)
                    @foreach($allCategories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                    @endforeach
                    @endif
                </select>
                @error('category_id')
                <span class="invalid-feedback text-dark" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Offer Expiration Date</label>
                <input type="date" class="form-control @error('offer_expiration') is-invalid @enderror" name="offer_expiration" value="{{ old('offer_expiration') }}" required>
                @error('offer_expiration')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3 mt-4">
                <label class="form-label">Add Description</label>
                <textarea name="description" cols="10" rows="3" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button class="btn" type="submit">Upload</button>
        </form>

        <form method="POST" class="needs-validation" novalidate>
                <label class="form-label">Please pay payment</label>
                <button class="btn btn-primary btn-lg btn-block" id="sslczPayBtn"
                        token="if you have any token validation"
                        postdata="your javascript arrays or objects which requires in backend"
                        order="If you already have the transaction generated for current order"
                        endpoint="{{ url('/pay-via-ajax') }}"> Pay Now
                </button>
            </form>
    </div>
    @elseif(request('content_type') == 'highlight')
    <div id="upload-page">
        <div class="back-btn">
            <a href="{{ route('merchant.storeContentForm') }}"><i class="fas fa-angle-left"></i></a>
        </div>
        <h6>Upload Highlight</h6>

        <form action="{{ route('merchant.storeHighlight') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="single-image-upload">
                <img src="{{ asset('static/images/icons/img-upload.jpg') }}" id="post-image" class="img-fluid w-100" alt="">
                <label for="input-file">Browse gallery</label>
                <input type="file" name="highlight_image" accept="image/jpeg, image/jpg, image/png" id="input-file">
                @error('highlight_image')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Category -->
            <div class="mb-3">
                <label class="form-label">Category</label>
                <select class="form-select w-100" name="category_id" required>
                    @if($allCategories)
                    @foreach($allCategories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->title }}
                    </option>
                    @endforeach
                    @endif
                </select>
                @error('category_id')
                <span class="invalid-feedback text-dark" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="mb-3 mt-4">
                <label class="form-label">Add Description</label>
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

            <<button class="btn" type="submit">Upload</button>
        </form>

        <form method="POST" class="needs-validation" novalidate>
                <label class="form-label">Please pay payment</label>
                <button class="btn btn-primary btn-lg btn-block" id="sslczPayBtn"
                        token="if you have any token validation"
                        postdata="your javascript arrays or objects which requires in backend"
                        order="If you already have the transaction generated for current order"
                        endpoint="{{ url('/pay-via-ajax') }}"> Pay Now
                </button>
            </form>
    </div>
    @elseif(request('content_type') == 'bilboard')
    <div id="upload-page">
        <div class="back-btn">
            <a href="{{ route('merchant.storeContentForm') }}"><i class="fas fa-angle-left"></i></a>
        </div>
        <h6>Upload Billboard</h6>

        <form action="{{ route('merchant.storeBillboard') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="single-image-upload">
                <img src="{{ asset('static/images/icons/img-upload.jpg') }}" id="post-image" class="img-fluid w-100" alt="">
                <label for="input-file">Browse gallery</label>
                <input type="file" name="billboard_image" accept="image/jpeg, image/jpg, image/png" id="input-file">
                @error('billboard_image')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3 mt-4">
                <label class="form-label">Add Description</label>
                <textarea name="description" cols="10" rows="3" class="form-control">{{ old('description') }}</textarea>
                @error('description')
                <span class="text-danger">{{ $message }}</span>
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

            <button class="btn" type="submit">Upload</button>
        </form>

        <form method="POST" class="needs-validation" novalidate>
                <label class="form-label">Please pay payment</label>
                <button class="btn btn-primary btn-lg btn-block" id="sslczPayBtn"
                        token="if you have any token validation"
                        postdata="your javascript arrays or objects which requires in backend"
                        order="If you already have the transaction generated for current order"
                        endpoint="{{ url('/pay-via-ajax') }}"> Pay Now
                </button>
            </form>
    </div>
    @endif
</div>

<style>
    .multiple-uploader {
        min-height: 150px;
        margin: 10px auto;
        width: 100%;
    }

    .single-image-upload label {
        display: block;
        width: 100%;
        background: #fff;
        color: #000;
        padding: 8px;
        margin: 10px auto;
        border-radius: 25px;
        cursor: pointer;
        text-align: center;
        box-shadow: 0 2px 6px 3px rgba(221, 221, 221, 0.7);
    }

    .single-image-upload input {
        display: none;
    }

    .single-image-upload img {
        border: 1px solid #000;
        border-radius: 5px;
        margin-bottom: 10px;
        width: 100%;
        height: auto;
    }
</style>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('input[name="content_type"]').change(function() {
            var contentType = $(this).val();
            window.location.href = window.location.href.split('?')[0] + '?content_type=' + contentType;
        });


        // post photo uploader
        if ($('#postUploader').length) {
            let postPhotoUploader = new MultipleUploader('#postUploader').init({
                maxUpload: 10,
                maxSize: 5,
                filesInpName: 'postImages',
                formSelector: '#postContent'
            });
        }

        // offer photo uploader
        if ($('#offerUploader').length) {
            let offerPhotoUploader = new MultipleUploader('#offerUploader').init({
                maxUpload: 10,
                maxSize: 5,
                filesInpName: 'offerImages',
                formSelector: '#offerContent'
            });
        }

        // input file preview
        if ($('#input-file').length) {
            $("#input-file").change(function() {
                $("#post-image").attr("src", URL.createObjectURL(this.files[0]));
            });
        }

        // Set the value of published_date input to empty
        $('input[name="published_date"]').val('');

        // Fetch Slots
        function fetchSlots() {
            var categoryId = $('select[name="category_id"]').val();
            var slotDate = $('input[name="published_date"]').val();

            // Send AJAX request
            $.ajax({
                url: "{{ route('merchant.getSlots') }}",
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


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>


<!-- If you want to use the popup integration, -->
<script>
    var obj = {};
    obj.cus_name = $('#customer_name').val();
    obj.cus_phone = $('#mobile').val();
    obj.cus_email = $('#email').val();
    obj.cus_addr1 = $('#address').val();
    obj.amount = $('#total_amount').val();

    $('#sslczPayBtn').prop('postdata', obj);

    (function (window, document) {
        var loader = function () {
            var script = document.createElement("script"), tag = document.getElementsByTagName("script")[0];
            // script.src = "https://seamless-epay.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR LIVE
            script.src = "https://sandbox.sslcommerz.com/embed.min.js?" + Math.random().toString(36).substring(7); // USE THIS FOR SANDBOX
            tag.parentNode.insertBefore(script, tag);
        };

        window.addEventListener ? window.addEventListener("load", loader, false) : window.attachEvent("onload", loader);
    })(window, document);
</script>
@endpush