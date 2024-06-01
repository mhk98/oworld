@extends('layouts.base')
@section('content')
<div class="row justify-content-center align-items-center">
    <div class="col-md-9">
<div class="setting-accordion">
    <div class="accordion" id="settingAccordion">

           <!-- Basic -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="basicHeading">
            <button class="accordion-button{{ request()->get('sec') === 'basic' ? '' : ' collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#basicCollapse" aria-expanded="{{ request()->get('sec') === 'basic' ? 'true' : 'false' }}" aria-controls="basicCollapse">
                Basic
            </button>
        </h2>
        <div id="basicCollapse" class="accordion-collapse collapse{{ request()->get('sec') === 'basic' ? ' show' : '' }}" aria-labelledby="basicHeading" data-bs-parent="#settingAccordion">
            <div class="accordion-body">
                @include('merchant.forms.store_basic')
            </div>
        </div>
    </div>

    <!-- Area -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="areaHeading">
            <button class="accordion-button{{ request()->get('sec') === 'area' ? '' : ' collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#areaCollapse" aria-expanded="{{ request()->get('sec') === 'area' ? 'true' : 'false' }}" aria-controls="areaCollapse">
                Area
            </button>
        </h2>
        <div id="areaCollapse" class="accordion-collapse collapse{{ request()->get('sec') === 'area' ? ' show' : '' }}" aria-labelledby="areaHeading" data-bs-parent="#settingAccordion">
            <div class="accordion-body">
                @include('merchant.forms.store_area')
            </div>
        </div>
    </div>

    <!-- External Links -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="externalLinksHeading">
            <button class="accordion-button{{ request()->get('sec') === 'external_links' ? '' : ' collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#externalLinksCollapse" aria-expanded="{{ request()->get('sec') === 'external_links' ? 'true' : 'false' }}" aria-controls="externalLinksCollapse">
                External Links
            </button>
        </h2>
        <div id="externalLinksCollapse" class="accordion-collapse collapse{{ request()->get('sec') === 'external_links' ? ' show' : '' }}" aria-labelledby="externalLinksHeading" data-bs-parent="#settingAccordion">
            <div class="accordion-body">
                @include('merchant.forms.store_external_links')
            </div>
        </div>
    </div>


    <!-- Interior -->
    <div class="accordion-item">
        <h2 class="accordion-header" id="interiorHeading">
            <button class="accordion-button{{ request()->get('sec') === 'interior' ? '' : ' collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#interiorCollapse" aria-expanded="{{ request()->get('sec') === 'interior' ? 'true' : 'false' }}" aria-controls="interiorCollapse">
                Interior
            </button>
        </h2>
        <div id="interiorCollapse" class="accordion-collapse collapse{{ request()->get('sec') === 'interior' ? ' show' : '' }}" aria-labelledby="interiorHeading" data-bs-parent="#settingAccordion">
            <div class="accordion-body">
                @include('merchant.forms.store_interior')
            </div>
        </div>
    </div>

 <!-- Featured Post -->
 <div class="accordion-item">
        <h2 class="accordion-header" id="featuredPostHeading">
            <button class="accordion-button{{ request()->get('sec') === 'featured_post' ? '' : ' collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#featuredPostCollapse" aria-expanded="{{ request()->get('sec') === 'featured_post' ? 'true' : 'false' }}" aria-controls="featuredPostCollapse">
                Featured Post
            </button>
        </h2>
        <div id="featuredPostCollapse" class="accordion-collapse collapse{{ request()->get('sec') === 'featured_post' ? ' show' : '' }}" aria-labelledby="featuredPostHeading" data-bs-parent="#settingAccordion">
            <div class="accordion-body">
                @include('merchant.forms.store_featured_post')
            </div>
        </div>
    </div>


 <!-- Opening Hours -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="openingHoursHeading">
                <button class="accordion-button {{ request()->get('sec') === 'opening_hours' ? '' : ' collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#openingHoursCollapse" aria-expanded="false" aria-controls="openingHoursCollapse">
                    Opening Hours
                </button>
            </h2>
            <div id="openingHoursCollapse" class="accordion-collapse collapse {{ request()->get('sec') === 'opening_hours' ? ' show' : '' }}" aria-labelledby="openingHoursHeading" data-bs-parent="#settingAccordion">
                <div class="accordion-body">
                    @include('merchant.forms.store_opening_hours')
                </div>
            </div>
        </div>


    </div>
</div>
</div>
</div>
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

        // interior uploader
        let interiorUploader = new MultipleUploader('#interiorUploader').init({
            maxUpload: 10,
            maxSize: 5,
            filesInpName: 'interiorImages',
            formSelector: '#interiorForm',
        });


        // featured posts
        let productUploader = new MultipleUploader('#featuredPostUploader').init({
            maxUpload: 10,
            maxSize: 5,
            filesInpName: 'featuredPosts',
            formSelector: '#featuredPostForm',
        });

       // Update sub-categories when page loads
    updateSubcategories();

    // Function to update sub-categories
    function updateSubcategories() {
        var mainCategories = $('[name="category_id[]"]:checked').map(function() {
            return $(this).val();
        }).get();

        if (mainCategories.length > 0) {
            $.ajax({
                url: '{{ route("merchant.getSubcategories") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    mainCategories: mainCategories
                },
                success: function(data) {
                    $('#subCategories').html(data);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        } else {
            $('#subCategories').empty();
        }
    }

    // Update sub-categories when main categories change
    $('[name="category_id[]"]').on('change', function() {
        updateSubcategories();
    });

        $(document).on('click', '#removeGalleryItem', function(event) {
            var imageId = $(this).data('image-id');
            var confirmation = confirm("Are you sure you want to delete this image?");

            if (confirmation) {
                $.ajax({
                    url: '{{ url("merchant/remove-gallery-item") }}/' + imageId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}',
                        imageId: imageId
                    },
                    success: function(response) {
                        $('#galleryItem' + imageId).remove();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        alert("An error occurred while deleting the image.");
                    }
                });
            }
        });

         // Address Dynamic
         $('input[name^="area"]').change(function() {
    var areaValue = $(this).val();
    var addressInputExists = $('.address-part .address-' + areaValue).length > 0;

    if ($(this).is(':checked') && !addressInputExists) {
        var capitalizedAreaValue = areaValue.replace(/_/g, ' ').replace(/\b\w/g, function(char) {
            return char.toUpperCase();
        });

        var addressInput = '<div class="mb-3 address-' + areaValue + '">' +
            '<label class="form-label">' + capitalizedAreaValue + ' Address <span class="text-danger">*</span></label>' +
            '<textarea name="address[' + areaValue + ']" class="form-control" placeholder="Enter your address" required></textarea>' +
            '</div>';

        $('.address-part').append(addressInput);
    } else if (!$(this).is(':checked') && addressInputExists) {
        $('.address-part .address-' + areaValue).remove();
    }
}).change();

        // Delivery Area All Check 
        $('#deliveryAreaAllCheckbox').click(function() {
            $('input[name="delivery_area[]"]').prop('checked', $(this).prop('checked'));
        });

        $('input[name="delivery_area[]"]').click(function() {
            if (!$(this).prop('checked')) {
                $('#deliveryAreaAllCheckbox').prop('checked', false);
            } else {
                if ($('input[name="delivery_area[]"]:checked').length === $('input[name="delivery_area[]"]').length) {
                    $('#deliveryAreaAllCheckbox').prop('checked', true);
                }
            }
        });

    });
</script>
@endpush