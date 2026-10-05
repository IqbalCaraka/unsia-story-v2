<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'UNSIA Story - Kuliah Online Universitas Siber Asia')</title>

    <meta name="keywords" content="@yield('keywords', 'kuliah online, universitas siber asia, unsia, kuliah sambil kerja, kuliah online murah, pendaftaran unsia, pmb unsia, kuliah jarak jauh, pjj')">
    <meta name="author" content="UNSIA Story">

    @yield('meta')

    @include('partials.seo')

    {{-- Google Site Verification --}}
    <meta name="google-site-verification" content="xto9eEWnFYcvJT8QGRvLz952sdm668y1R0hHnuF5eEI">

    {{-- Tracking Pixels --}}
    @include('partials.tracking')

    <link rel="shortcut icon" href="{{ asset('assets/images/logo-unsia-story.png') }}" type="image/png">

    {{-- Theme styles --}}
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/webfonts/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/owlcarousel/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-simple-mobilemenu.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    @yield('styles')
</head>
<body>

    @include('partials.navbar')

    @yield('hero')

    </div>
    {{-- END .top_header_banner (dibuka di partials.navbar) --}}

    @yield('content')

    @include('partials.footer')

    @yield('scripts')

</body>
</html>
