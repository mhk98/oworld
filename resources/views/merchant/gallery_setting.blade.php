@extends('layouts.base')
@section('content')
<div id="addpost">
    <!-- Upload part Start -->
    <div id="upload-page">
        <div class="back-btn">
            <a href="{{ route('merchant.setting') }}"><i class="fas fa-angle-left"></i></a>
        </div>
        <h6>Store Photo Gallery</h6>
        <form action="{{ route('merchant.gallerySetting') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="image-box mb-2">
                <label class="form-label">Profile Picture</label>
                <div class="image-box-preview">
                    <img id="profile_image" src="{{ !empty($store->profile_picture) ? asset('media/'.$store->profile_picture) : asset('static/admin/images/default.jpg') }}" alt="Profile Image">
                </div>
                <div class="image-box-select">
                    <input type="file" name="profile_picture" class="image-input @error('profile_picture') is-invalid @enderror" id="profile_file" accept=".png, .jpg, .jpeg">
                    <label for="profile_file">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                        </svg> <span>Change File &hellip;</span>
                    </label>
                </div>
                @error('profile_picture')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="image-box mb-1">
                <label class="form-label">Cover Picture</label>
                <div class="image-box-preview">
                    <img id="cover_image" src="{{ !empty($store->cover_picture) ? asset('media/'.$store->cover_picture) : asset('static/admin/images/default.jpg') }}" alt="Cover Image">
                </div>
                <div class="image-box-select">
                    <input type="file" name="cover_picture" class="image-input @error('cover_picture') is-invalid @enderror" id="cover_file" accept=".png, .jpg, .jpeg">
                    <label for="cover_file">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
                        </svg> <span>Change File &hellip;</span>
                    </label>
                </div>
                @error('cover_picture')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <p class="fw-semibold mb-3">Interior</p>

            <div id="upload-container" class="form__container text-center">
                <label for="upload-files" class="mb-0">Choose or Drag & Drop Files</label>
                <input id="upload-files" class="form__file" type="file" name="files[]" accept="image/*" multiple>
            </div>
            <div id="files-list-container" class="form__files-container"></div>

            <button class="btn" type="submit">Save Changes</button>
        </form>
    </div>
    <!-- Upload part End -->
</div>
<style>
    #upload-page {
        max-width: 700px !important;
        margin-bottom: 20px;
    }


    .image-box-preview {
        padding: 10px 0;
    }

    .image-box-preview img {
        max-width: 100%;
        max-height: 250px;
        border-radius: 5px;
    }

    .image-box-select input[type="file"] {
        display: none;
    }

    .image-box-select label {
        max-width: 80%;
        font-size: 19px;
        font-weight: 550px;
        text-overflow: ellipsis;
        white-space: nowrap;
        cursor: pointer;
        display: inline-block;
        overflow: hidden;
        padding: 2px 5px;
        border-radius: 20px;
        color: #fff;
        background-color: #1a0457;
    }

    .image-box-select:focus label,
    .image-box-select.has-focus label,
    .image-box-select label:hover {
        background-color: #0d022c;
    }

    .image-box-select:focus label,
    .image-box-select.has-focus label {
        outline: 1px dotted #000;
        outline: -webkit-focus-ring-color auto 5px;
    }

    .image-box-select label svg {
        width: 1em;
        height: 1em;
        vertical-align: middle;
        fill: currentColor;
        margin-top: -0.25em;
        margin-right: 0.25em;
    }


    .image-select .input-group {
        position: relative;
        display: inline-block;
    }

    .image-select .file-label {
        display: inline-block;
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 0;
        padding: 5px;
        cursor: pointer;
    }

    .image-select .file-button {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .image-select .file-input {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
</style>
<style>
    .form__container {
        position: relative;
        width: 100%;
        height: 200px;
        border: 2px dashed silver;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 18px;
        color: silver;
        margin-bottom: 5px;
    }

    .form__container.active {
        background-color: rgba(silver, 0.2);
    }

    .form__file {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        cursor: pointer;
        opacity: 0;
    }

    .form__files-container {
        display: block;
        width: 100%;
        font-size: 0;
        margin-top: 20px;
    }

    .form__image-container {
        display: inline-block;
        width: 33.333%;
        height: 200px;
        margin-bottom: 10px;
        position: relative;
    }

    .form__image-container:not(:nth-child(2n)) {
      /***  margin-right: 2%; */
    }

    .form__image-container:after {
        content: "✕";
        position: absolute;
        line-height: 200px;
        font-size: 30px;
        margin: auto;
        top: 0;
        right: 0;
        left: 0;
        text-align: center;
        font-weight: bold;
        color: #fff;
        background-color: rgba(0, 0, 0, 0.4);
        opacity: 0;
        transition: opacity 0.2s ease-in-out;
    }

    .form__image-container:hover:after {
        opacity: 1;
        cursor: pointer;
    }

    .form__image {
        object-fit: contain;
        width: 100%;
        height: 100%;
    }
</style>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        // Image Change With Preview
        function preview_image(input, image_id) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $(image_id).attr("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#profile_file").change(function() {
            preview_image(this, "#profile_image");
        });

        $("#cover_file").change(function() {
            preview_image(this, "#cover_image");
        });

        var inputFile = $('#upload-files');
        var inputContainer = $('#upload-container');
        var filesListContainer = $('#files-list-container');
        var fileList = [];

        function previewImages() {
            filesListContainer.empty();
            if (fileList.length > 0) {
                $.each(fileList, function(index, addedFile) {
                    var content = `
                            <div class="form__image-container js-remove-image" data-index="${index}">
                                <img class="form__image" src="${addedFile.url}" alt="${addedFile.name}">
                            </div>
                        `;
                    filesListContainer.append(content);
                });
            } else {
                console.log('empty');
                inputFile.val('');
            }
        }

        function fileUpload() {
            inputFile.on('click dragstart dragover', function() {
                inputContainer.addClass('active');
            });

            inputFile.on('dragleave dragend drop change blur', function() {
                inputContainer.removeClass('active');
            });

            inputFile.on('change', function() {
                var files = Array.from(inputFile[0].files);
                console.log("changed");
                $.each(files, function(_, file) {
                    var fileURL = URL.createObjectURL(file);
                    var fileName = file.name;
                    if (!file.type.match("image/")) {
                        alert(fileName + " is not an image");
                        console.log(file.type);
                    } else {
                        var uploadedFile = {
                            name: fileName,
                            url: fileURL,
                        };
                        fileList.push(uploadedFile);
                    }
                });

                console.log(fileList); //final list of uploaded files
                previewImages();
            });
        }

        function removeFile() {
            filesListContainer.on('click', '.js-remove-image', function() {
                var fileIndex = $(this).data('index');
                fileList.splice(fileIndex, 1);
                previewImages();
            });
        }

        fileUpload();
        removeFile();
    });
</script>
@endpush