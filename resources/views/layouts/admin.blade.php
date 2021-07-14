<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="description" content="Building Management">
    <meta name="author" content="Kiselgroup">

    <!-- Title -->
    <title>@yield('title')</title>

    @include('includes.admin.style')
    @stack('custom-style')
</head>

<body class="main-body leftmenu">

    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- End Loader -->


    <!-- Page -->
    <div class="page">
        {{-- Sidebar --}}
        @include('includes.admin.navbar')
        {{-- Header --}}
        @include('includes.admin.header')

        <!-- Main Content-->
        <div class="main-content side-content pt-0">

            <div class="container-fluid">
                <div class="inner-body">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- End Main Content-->

        {{-- Footer --}}
        @include('includes.admin.footer')

    </div>
    <!-- End Page -->

    <!-- Back-to-top -->
    <a href="#top" id="back-to-top"><i class="fe fe-arrow-up"></i></a>

    {{-- Script --}}
    @include('includes.admin.script')
    @stack('custom-script')
</body>

</html>
