<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="{{ asset('assets/logo/logo-icon.png') }}">
    <!-- Title -->
    <title> @yield('view_title') | Quin Ecommerce - Admin </title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico" />

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS Implementing Plugins -->
    <link rel="stylesheet" href="{{ asset('assets\css\vendor.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets\vendor\icon-set\style.css') }}" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- CSS Front Template -->
    <link rel="stylesheet" href="{{ asset('assets\css\theme.min.css?v=1.0') }}" />
    @stack('css')
    @stack('js1')

</head>

<body class="footer-offset">
    @yield('root')
    @stack('js2')
</body>

</html>
