<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O'World</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Noto+Sans+Bengali:wght@100..900&display=swap" rel="stylesheet">
    <link href="{{ asset('static/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('static/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('static/vendors/tagsinput/bootstrap-tagsinput.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/vendors/select2/css/select2.min.css') }}" />
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('static/vendors/multipleUploader/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('static/vendors/croppie/croppie.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/style.css') }}?v=1.05.21.01">
    {{---- <link rel="stylesheet" href="{{ asset('static/css/responsive.css') }}"> ----}}
    @stack('css')
</head>

<body class="{{ request()->is('merchant/store-setup*') ? 'store-setup' : (request()->is('auth*') ? 'auth' : '') }}">

    @if(!request()->is('merchant/store-setup*') && !request()->is('auth*'))
    <div class="main">
        @include('layouts.sideBar')

        <!-- Main content part start -->
        <div class="main-content">
            @php
            $store = auth()->check() && auth()->user()->is_merchant ? \App\Models\Store::find(session('current_store')) : null;
            @endphp

            @include('layouts.topBar')
            @include('layouts.mobileHeader')

            @yield('content')
        </div>
        <!-- Main content part end -->
    </div>
    @include('layouts.mobileBottom')

    <!--- WhatsApp Floating --->
    <div class="whatsapp-floating">
        <a href="https://wa.me/880172088106" class="whatsapp-link" target="_blank">
            <i class="fab fa-whatsapp"></i>
        </a>
    </div>

    @include('partials.mobile_sidebar')
    @include('partials.mobile_search')
    @include('partials.share_modal')
    @include('partials.delete_modal')

    @stack('modal')
    @include('layouts.flash')

    @else

    @yield('content')

    @endif

    <script src="{{ asset('static/js/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('static/js/slick.min.js') }}"></script>
    <script src="{{ asset('static/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('static/vendors/tagsinput/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('static/vendors/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('static/vendors/multipleUploader/js/multiple-uploader.js') }}"></script>
    <script src="{{ asset('static/vendors/multipleUploader/js/util.js') }}"></script>
    <script src="{{ asset('static/vendors/croppie/croppie.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <!-- Include jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

    <script src="{{ asset('static/js/custom.js') }}"></script>

    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
    <script>
        var btn = document.getElementById('fav-btn');

        function Toggle() {
            if (btn.classList.contains("far")) {
                btn.classList.remove("far");
                btn.classList.add("fas");
            }
        }
    </script>
    <script>
        $('.click').click(function() {
            $('.sidebar').toggleClass('sidebar2');
            $('.click').toggleClass('fa-bars');
        });
    </script>
    <script>
        $(document).ready(function() {

            $('.highlight-categories').owlCarousel({
                loop: false,
                margin: 10,
                nav: false,
                dots: false,
                autoplay: false,
                autoplayTimeout: 1500,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 3
                    },
                    600: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    },
                    1200: {
                        items: 8
                    }
                }
            });

            // Share
            function openShareModal(url) {
                $('#shareModal input').val(url);

                // Update social share links
                $('#shareModal .facebook').attr('href', 'https://www.facebook.com/sharer/sharer.php?u=' + url);
                $('#shareModal .twitter').attr('href', 'https://twitter.com/intent/tweet?url=' + url);
                $('#shareModal .instagram').attr('href', 'https://www.instagram.com/?url=' + url);
                $('#shareModal .whatsapp').attr('href', 'https://wa.me/?text=' + url);
                $('#shareModal .telegram').attr('href', 'https://t.me/share/url?url=' + url);

                // Show the modal
                $('#shareModal').modal('show');
            }

            $(document).on('click', '#shareContent', function() {
                var url = $(this).data('url');
                openShareModal(url);
            });

            $('#copyUrl').click(function() {
                var input = $(this).closest('.modal').find('input');
                input.select();
                document.execCommand("copy");
                $(this).text("Copied");
                setTimeout(function() {
                    $('#copyUrl').text("Copy");
                }, 2000);
            });

            // Like Content
            $(document).on('click', '#likeContent', function(event) {
                //console.log("Like");

                event.preventDefault();

                // Check authentication before performing action
                if (!checkAuthentication()) {
                    redirectToLoginForm();
                    return;
                }

                var contentId = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var url = '{{ route("user.likeContent") }}';
                var content_type = $(this).data('type');
                var likeIcon = $(this).find('i');
                var likeCount = $(this).find('span');

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        content_id: contentId,
                        content_type: content_type,
                        _token: token
                    },
                    success: function(response) {
                        if (response.like) {
                            likeCount.text(parseInt(likeCount.text()) + 1);
                            likeIcon.removeClass('far').addClass('fas');
                        } else if (response.unlike) {
                            var newLikeCount = parseInt(likeCount.text()) - 1;
                            likeCount.text(newLikeCount >= 0 ? newLikeCount : 0);
                            likeIcon.removeClass('fas').addClass('far');
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });

            $(document).on('click', '.edit-description-btn', function(e) {
                e.preventDefault();
                var contentId = $(this).data('content-id');
                $('#content-description-' + contentId).toggle();
                $('#edit-description-form-' + contentId).toggle();
            });

            $(document).on('click', '.save-description', function(e) {
                e.preventDefault();
                var contentId = $(this).data('content-id');
                var contentType = $(this).data('content-type');
                var newDescription = $('#description-edit-box-' + contentId).val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route("merchant.updateContent") }}',
                    data: {
                        content_type: contentType,
                        content_id: contentId,
                        description: newDescription,
                        _token: '{{ csrf_token() }}',
                    },
                    success: function(response) {
                        $('#content-description-' + contentId + ' p').text(newDescription);
                        $('#content-description-' + contentId).show();
                        $('#edit-description-form-' + contentId).hide();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });


            // Save Offer
            $(document).on('click', '#saveOffer', function(event) {
                event.preventDefault();

                // Check authentication before performing action
                if (!checkAuthentication()) {
                    redirectToLoginForm();
                    return;
                }

                var offerId = $(this).data('id');
                var contentType = $(this).data('type');
                var token = '{{ csrf_token() }}';
                var url = '{{ route("user.saveOffer") }}';
                var saveIcon = $(this).find('i');

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        offer_id: offerId,
                        content_type: contentType,
                        _token: token
                    },
                    success: function(response) {
                        // Toggle save/unsave icon
                        if (response.save) {
                            saveIcon.removeClass('far').addClass('fas');
                        } else if (response.unsave) {
                            saveIcon.removeClass('fas').addClass('far');
                        }
                    },
                    error: function(error) {
                        console.error('Error:', error);
                    }
                });
            });

            // Submit Comment
            $(document).on('click', '.submit-comment', function(e) {
                e.preventDefault();

                // Check authentication before performing action
                if (!checkAuthentication()) {
                    redirectToLoginForm();
                    return;
                }

                var currentForm = $(this).closest('.comment-form');
                var contentId = currentForm.data('content');
                var comment = currentForm.find('textarea').val();
                var contentType = currentForm.data('type');
                var content_id = contentId;

                $.ajax({
                    url: '{{ route("user.submitComment") }}',
                    type: 'POST',
                    data: {
                        comment: comment,
                        content_type: contentType,
                        content_id: content_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            var newComment = `
            <div class="comment-item mt-2" id="comment-${response.comment_id}">
                <div class="d-flex flex-row align-items-center py-2">
                    <div class="w-100">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>{{ auth()->check() ? auth()->user()->first_name : '' }}</span>
                            <div>
                                <small>Just now</small>
                                <button class="btn btn-sm btn-danger delete-comment" data-comment-id="${response.comment_id}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-default edit-comment" data-comment-id="${response.comment_id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-default save-comment" data-comment-id="${response.comment_id}" style="display: none;">
                                    <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text-justify comment-text mb-0">
                            ${comment}
                        </p>
                        <textarea class="form-control comment-edit-box" style="display: none;"></textarea>
                    </div>
                </div>
            </div>
        `;
                            // Append new comment to the correct comment list based on content-id
                            $('#comments-list-' + contentId).append(newComment);
                            currentForm.find('textarea').val('');
                        } else {
                            console.log('Comment submission failed');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // Edit comment
            $(document).on('click', '.edit-comment', function() {
                var commentId = $(this).data('comment-id');
                var commentText = $('#comment-' + commentId + ' .comment-text').text().trim();
                $('#comment-' + commentId + ' .comment-text').hide();
                $('#comment-' + commentId + ' .comment-edit-box').val(commentText).show();
                $(this).hide();
                $('#comment-' + commentId + ' .save-comment').show();
            });

            // Save edited comment
            $(document).on('click', '.save-comment', function() {
                var commentId = $(this).data('comment-id');
                var editedComment = $('#comment-' + commentId + ' .comment-edit-box').val().trim();

                $.ajax({
                    url: '{{ route("user.editComment") }}',
                    method: 'POST',
                    data: {
                        comment_id: commentId,
                        comment: editedComment,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            $('#comment-' + commentId + ' .comment-text').text(editedComment).show();
                            $('#comment-' + commentId + ' .comment-edit-box').hide();
                            $('#comment-' + commentId + ' .edit-comment').show();
                            $('#comment-' + commentId + ' .save-comment').hide();
                        } else {
                            console.error('Failed to edit comment.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to edit comment:', error);
                    }
                });
            });

            // Delete Comment
            $(document).on('click', '.delete-comment', function(e) {
                e.preventDefault();

                var commentId = $(this).data('comment-id');

                // Show confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '{{ route("user.deleteComment") }}',
                            type: 'POST',
                            data: {
                                comment_id: commentId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#comment-' + commentId).remove();
                                    Swal.fire(
                                        'Deleted!',
                                        'Your comment has been deleted.',
                                        'success'
                                    );
                                } else {
                                    console.log('Failed to delete comment');
                                    Swal.fire(
                                        'Oops!',
                                        'Failed to delete the comment.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                                Swal.fire(
                                    'Oops!',
                                    'Failed to delete the comment. Please try again later.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });

            /***** $('#search').keyup(function() {
                 var query = $(this).val();

                 if (query.length > 2) {
                     $.ajax({
                         url: '{{ route("autocomplete") }}',
                         method: 'GET',
                         data: { query: query },
                         dataType: 'json',
                         success: function(data) {
                             var suggestions = data.map(function(store) {
                                 return '<li>' + store.business_name + '</li>';
                             });
                             $('#autocomplete-results').html(suggestions.join(''));
                         }
                     });
                 } else {
                     $('#autocomplete-results').empty();
                 }
             }); */


            // Authentication
            function checkAuthentication() {
                return {{ Auth::check() ? 'true' : 'false' }};
            }

            // Function to redirect to login form
            function redirectToLoginForm() {
                window.location.href = '{{ route("auth.loginForm") }}';
            }

            // Delete Content
            $(document).on('click', '#deleteContent', function(e) {
                var contentType = $(this).data('type');
                var contentId = $(this).data('id');

                $('#deleteModal #content_type').val(contentType);
                $('#deleteModal #content_id').val(contentId);

                $('#deleteModal').modal('show');
            });

        });
    </script>
    @stack('js')
</body>

</html>