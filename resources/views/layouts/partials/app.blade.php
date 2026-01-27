<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keyword" content="">
    <meta name="author" content="WRAPCODERS">

    <title>@yield('title', 'Duralux || Proposal')</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/dataTables.bs5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/tagify.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/tagify-data.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/quill.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/select2-theme.min.css') }}">

    <!-- Custom Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">

    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>


<body>
    <div class="main-wrapper">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <div class="content-wrapper">
            <!-- Header -->
            @include('layouts.partials.header')

            <!-- Main Content -->
            <div class="content p-4">
                @yield('content')
            </div>

            <!-- Footer -->
            @include('layouts.partials.footer')
        </div>
    </div>

    <!-- Scripts -->
    <!--! BEGIN: Vendors JS -->
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/circle-progress.min.js') }}"></script>
    <!--! END: Vendors JS -->

    <!--! BEGIN: Apps Init -->
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard-init.min.js') }}"></script>
    <!--! END: Apps Init -->

    <!--! BEGIN: Theme Customizer -->
    <script src="{{ asset('assets/js/theme-customizer-init.min.js') }}"></script>
    <!--! END: Theme Customizer -->

    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/dataTables.bs5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/select2-active.min.js') }}"></script>
    <script src="{{ asset('assets/js/common-init.min.js') }}"></script>
    <script src="{{ asset('assets/js/leads-init.min.js') }}"></script>

</body>

</html>
