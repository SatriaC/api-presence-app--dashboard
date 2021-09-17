<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="description" content="Respati">
    <meta name="author" content="Kiselgroup">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/img/logo-2.png') }}" type="image/x-icon" />

    <!-- Title -->
    <title>Login</title>

    <!-- Bootstrap css-->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- Icons css-->
    <link href="{{ asset('assets/plugins/web-fonts/icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/web-fonts/font-awesome/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/web-fonts/plugin.css') }}" rel="stylesheet" />

    <!-- Style css-->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/skins.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/dark-style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/colors/default.css') }}" rel="stylesheet">

    <!-- Color css-->
    <link id="theme" rel="stylesheet" type="text/css" media="all" href="{{ asset('assets/css/colors/color.css') }}">

</head>

<body class="main-body leftmenu">

    <!-- Loader -->
    <div id="global-loader">
        <img src="{{ asset('assets/img/loader.svg') }}" class="loader-img" alt="Loader">
    </div>
    <!-- End Loader -->

    <!-- Page -->
    <div class="page main-signin-wrapper" style="">

        {{-- @if (session('sukses'))
            <div class="alert alert-success" role="alert">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ session('sukses') }} &nbsp; <a href="{{ route('kirim.index') }}">Klik Disini untuk ke Menu Terkirim
                    &nbsp;</a>
            </div>
        @endif --}}

        <!-- Row -->
        <div class="row signpages text-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="row row-sm">
                        <div class="col-lg-6 col-xl-5 d-none d-lg-block text-center" style="background: #cae3fc; border-radius: 10px 0px 0px 10px">
                            <div class="mt-5 pt-4 p-2 pos-absolute" >
                                {{-- <img src="{{ asset('assets/img/marisa.png') }}" class="header-brand-img mb-4"
                                style="display: block;
                                    margin-left: auto;
                                    margin-right: auto;
                                    margin-top: -25px;
                                    margin-bottom: auto;"
                                    alt="logo" width="30" height="30"> --}}
                                <img src="{{ asset('assets/img/Design Login.png') }}" class="header-brand-img mb-4"
                                style="    display: block;
                                width: 74%;
                                margin-left: 26px;
                                height: auto;
                                object-fit: cover;"

                                    alt="logo" width="400" height="300">
                                <div class="clearfix"></div>
                                {{-- <img src="{{ asset('assets/img/svgs/user.svg') }}" class="ht-100 mb-0" alt="user">
                                <h5 class="mt-4 text-white">Create Your Account</h5>
                                <span class="tx-white-6 tx-13 mb-5 mt-xl-0">Signup to create, discover and connect with the
                                    global community</span> --}}
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-7 col-xs-12 col-sm-12">
                            <div class="container-fluid">
                                <div class="row row-sm">
                                    <div class="card-body mt-2 mb-2">
                                        <div class="clearfix"></div>
                                        <form action="{{ route('login') }}" method="post">
                                            @csrf
                                            <img src="{{ asset('assets/img/logo-1.png') }}" style="width: 50%; margin-bottom: 10px" alt="">
                                            <h5 class="text-left mt-2">Signin</h5>

                                            <br>
                                            <br>
                                            {{-- <p class="mb-4 text-muted tx-13 ml-0 text-left">Signin to create, discover and
                                                connect with the global community</p> --}}

                                            @if (session('error'))
                                                <div class="alert alert-danger alert-block">
                                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                    <strong>{{ session('error') }}</strong>
                                                </div>
                                            @endif
                                            <div class="form-group text-left">
                                                <label for="email">{{ __('Email Address') }}</label>
                                                <input id="email" type="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    name="email" value="{{ old('email') }}" required
                                                    autocomplete="email" autofocus>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group text-left">
                                                <label for="password">{{ __('Password') }}</label>
                                                <input id="password" type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    name="password" required autocomplete="current-password">
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <button class="btn ripple btn-block"
                                                style="background-color:#3195F1;color: white;">Sign In</button>
                                        </form>
                                        <div class="text-left ml-0 mt-5">
                                            <div class="mb-1"><a href="{{ route('password.request') }}" style="color: #3195F1">Lupa password?</a></div>
                                            {{-- @if ($manual_book) --}}
                                                <div>
                                                    <a target="_blank" href="{{ route('manual-book') }}" style="color: #3195F1">Download Manual Book
                                                    </a>
                                                </div>
                                            {{-- @endif --}}
                                            {{-- <div>Don't have an account? <a href="#">Register Here</a></div> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Row -->

    </div>
    <!-- End Page -->

    <!-- Jquery js-->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

    <!-- Bootstrap js-->
    <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

    <!-- Select2 js-->
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>

    <!-- Custom js -->
    <script src="{{ asset('assets/js/custom.js') }}"></script>


</body>

</html>
