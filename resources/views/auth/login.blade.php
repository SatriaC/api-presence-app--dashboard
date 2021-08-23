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
    <div class="page main-signin-wrapper" id="page-login" style="">

        {{-- @if (session('sukses'))
            <div class="alert alert-success" role="alert">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ session('sukses') }} &nbsp; <a href="{{ route('kirim.index') }}">Klik Disini untuk ke Menu Terkirim
                    &nbsp;</a>
            </div>
        @endif --}}

        @if ($errors->any())
            <div class="alert alert-danger mg-b-0" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- Row -->
        <div class="row signpages text-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="row row-sm">
                        {{-- <div class="col-lg-6 col-xl-5 d-none d-lg-block text-center bg-primary details">
                            <div class="mt-5 pt-4 p-2 pos-absolute">
                                <div class="clearfix"></div>

                                <img src="{{ asset('assets/img/logo-6.png') }}"
                                    style="width:130%; height:auto; margin-top=-20px" class="ht-100 mb-0" alt="user">
                            </div>
                        </div> --}}
                        <div class="col-lg-12 col-xl-12 col-xs-12 col-sm-12 login_form ">
                            <div class="container-fluid">
                                <div class="row row-sm">
                                    <div class="card-body mt-2 mb-2">
                                        @if (session('error'))
                                            <div class="alert alert-danger" role="alert">
                                                <button aria-label="Close" class="close" data-dismiss="alert"
                                                    type="button">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                {{ session('error') }}
                                            </div>
                                        @elseif (session('success'))
                                            <div class="alert alert-success" role="alert">
                                                <button aria-label="Close" class="close" data-dismiss="alert"
                                                    type="button">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                                {{ session('success') }}
                                            </div>
                                        @endif
                                        {{-- <img src="{{ asset('assets/img/brand/logo.png') }}"
                                            class=" d-lg-none header-brand-img text-left float-left mb-4" alt="logo"> --}}
                                        <div class="clearfix"></div>
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                                            {{-- <h3 class="text-center mb-2">Kinarya Respati</h3> --}}
                                            {{-- <p class="mb-4 text-muted tx-13 ml-0 text-center">Signin with Marissa</p> --}}
                                            <div class="form-group text-left">
                                                <label for="email">{{ __('E-Mail Address') }}</label>
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
                                        <div class="text-left mt-5 ml-0">

                                            <div class="mb-1"><a target="_blank"
                                                    href="#">Download Manual Book</a>
                                            </div>
                                            @if (Route::has('password.request'))
                                                <div class="mb-1"><a
                                                        href="{{ route('password.request') }}">{{ __('Lupa Password?') }}</a>
                                                </div>
                                            @endif
                                            {{-- <div>Don't have an account? <a
                                                    href="/regi">Register Here</a></div> --}}
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
