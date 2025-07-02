<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <!-- meta -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Created by Mr Quynh (quynh232000@gmail.com)" />
    <meta name="keywords" content="Created by Mr Quynh (quynh232000@gmail.com)" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title"
        content="Admin - Manage admin created by Mr. Quynh" />
    <meta property="og:url" content="https://mr-quynh.site" />
    <meta property="og:site_name" content="Manage Admin created by Mr. Quynh" />
    <link rel="canonical" href="https://mr-quynh.site" />
    <link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css?t=' . time()) }}" rel="stylesheet"
        type="text/css" />



    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="icon" type="image/png" href="{{ asset('assets/media/logos/logo-icon.png') }}">
    <!-- Title -->
    <title> @yield('title') | Quin </title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico" />

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />



    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- CSS Front Template -->
    @stack('css')
    @stack('js1')
    <style>
        img {
            object-fit: cover
        }
    </style>
    <link href="{{ asset('assets/plugins/global/plugins.bundle.css?t=' . time()) }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/style.bundle.css?t=' . time()) }}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/js/admin/admin-function.js?t=' . time()) }}"></script>
</head>


<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->

    @yield('root')

    <!--end::Root-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "{{ asset('assets/') }}";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used for this page only)-->

    @stack('js2')

</body>



</html>
