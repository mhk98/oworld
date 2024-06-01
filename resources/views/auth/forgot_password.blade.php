<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>O'World</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('static/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('static/vendors/tagsinput/bootstrap-tagsinput.css') }}" />
    <link rel="stylesheet" href="{{ asset('static/vendors/select2/css/select2.min.css') }}" />

    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

    <link rel="stylesheet" href="{{ asset('static/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('static/css/responsive.css') }}">
</head>

<body>

    <div class="main">
        <!-- Content part start -->

        <div class="pt-3 pt-md-4 pt-lg-5"></div>
        <div class="logo-2">
            <a href="{{ route('index') }}">
                <img src="{{ asset('static/images/logo.png') }}" class="img-fluid w-100" alt="">
            </a>
        </div>
        <div class="pb-3 pb-md-4 pb-lg-5"></div>

        <div id="login-page">
            <div class="login">
                <form action="{{ route('auth.login') }}" method="POST" class="login-form">
                    @csrf

                    <div class="login-title">
                        <h6>The biggest Plartform in bangladesh.</h6>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Email</label>
                        <input type="text" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                        @error('email')
                        <span class="invalid-feedback text-dark" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('layouts.flash')
    <script src="{{ asset('static/js/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('static/js/slick.min.js') }}"></script>
    <script src="{{ asset('static/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('static/vendors/tagsinput/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('static/vendors/select2/js/select2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
    <script src="{{ asset('static/js/custom.js') }}"></script>
    <script>
        var btn = document.getElementById('fav-btn');

        function Toggle() {
            if (btn.classList.contains("far")) {
                btn.classList.remove("far");
                btn.classList.add("fas");
            }
        }
    </script>
</body>

</html>