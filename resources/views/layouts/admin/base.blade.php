<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>O'World </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('static/admin/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('static/admin/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('static/admin/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link href="{{ asset('static/admin/vendors/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('static/admin/vendors/tagsinput/bootstrap-tagsinput.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/admin/vendors/multipleUploader/css/main.css') }}"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('static/admin/css/style.css') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('static/admin/images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('static/admin/images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('static/admin/images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('static/admin/images/favicon/site.webmanifest') }}">
</head>

<body>

<div class="loader" id="loader"></div>

<style>
    .loader {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    border: 8px solid #f3f3f3; /* Light grey */
    border-top: 8px solid #3498db; /* Blue */
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite; /* Rotate animation */
    z-index: 9999; /* Ensure it's on top of everything */
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

    @if(!request()->is('admin-auth*'))
    <div class="main-wrapper">
        @include('layouts.admin.sidebar')
        <div class="page-wrapper">
            @include('layouts.admin.navbar')
            <div class="page-content">
                <div class="row justify-content-start align-items-center">
                    <div class="col-12 col-md-8">
                        <div class="flash">
                            @include('layouts.admin.flash')
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>
            @include('layouts.admin.footer')
        </div>
    </div>
    @else
    <div class="main-wrapper">
        <div class="page-wrapper full-page">
            @yield('content')
        </div>
    </div>
    @endif


    <script src="{{ asset('static/admin/vendors/core/core.js') }}" type="text/javascript"></script>
    <script src="{{ asset('static/admin/vendors/chartjs/Chart.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('static/admin/vendors/jquery.flot/jquery.flot.js') }}" type="text/javascript"></script>
    <script src="{{ asset('static/admin/vendors/jquery.flot/jquery.flot.resize.js') }}" type="text/javascript"></script>
    <script src="{{ asset('static/admin/vendors/feather-icons/feather.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('static/admin/js/template.js') }}" type="text/javascript"></script>
    <script src="{{ asset('static/admin/js/masonry.pkgd.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('static/admin/vendors/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('static/admin/vendors/multi-image-picker/spartan-multi-image-picker-min.js') }}"
        type="text/javascript"></script>
    <script src="{{ asset('static/admin/vendors/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('static/admin/vendors/tagsinput/bootstrap-tagsinput.js') }}"></script>

    <script src="{{ asset('static/admin/vendors/multipleUploader/js/multiple-uploader.js') }}"></script>
    <script src="{{ asset('static/admin/vendors/multipleUploader/js/util.js') }}"></script>

    <script src="{{ asset('static/admin/vendors/jquery-sortable-js/Sortable.js') }}"></script>

    {{---- <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script> -----}}


    <script src="{{ asset('static/admin/js/custom.js') }}"></script>
    <script type="text/javascript">
        if ($("#editor").length > 0) {
            CKEDITOR.replace('editor');
        }

        $(window).on("load", function() {
        $("#loader").fadeOut("slow");
    });
    </script>
    @stack('js')
</body>

</html>