<!doctype HTML>
<html>
</head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

	<!-- All Css Files -->
	<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

	<!-- Custom Css -->
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/custom.css') }}" rel="stylesheet">
    <!-- <link rel="stylesheet" href="http://webeetest.com/s&t/admin/css/style.css">
	<link rel="stylesheet" href="http://webeetest.com/s&t/admin/css/custom.css"> -->
	<!-- Google Fonts -->
    <link href="{{ asset('assets/css/snackbar.css') }}" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,600&display=swap" rel="stylesheet">
    @yield('link')
</head>
<body>

    <div id="snackbar"></div>
    @include('admin.layout.sidenav')
    @yield('body')
    @include('admin.layout.footer')
    <!-- All Js Files -->
	<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script> -->
	<script src="{{ asset('assets/js/aos.js') }}"></script>
    <script src="{{ asset('assets/js/slick.min.js') }}"></script>
	<script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <!-- Custom Js -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/common.js') }}"></script>

    <script src="{{ asset('assets/admin/js/global.min.js') }}"></script>
	<script src="{{ asset('assets/admin/js/deznav-init.js') }}"></script>
    <script src="{{ asset('assets/admin/js/custom.min.js') }}"></script>
    @yield('script')
</body>
</html>