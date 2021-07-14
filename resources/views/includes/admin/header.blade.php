<!-- Main Header-->
<div class="main-header side-header sticky">
    <div class="container-fluid">
        <div class="main-header-left">
            <a class="main-header-menu-icon" href="#" id="mainSidebarToggle"><span></span></a>
        </div>
        <div class="main-header-center">
            <div class="responsive-logo">
                <a href="index.html"><img src="{{ asset('assets/img/logo-1.png') }}" class="mobile-logo"
                        style="height: 50px" alt="logo"></a>
                <a href="index.html"><img src="{{ asset('assets/img/logo-1.png') }}" class="mobile-logo-dark"
                        alt="logo"></a>
            </div>
        </div>
        <div class="main-header-right">
            <div class="dropdown main-profile-menu">
                <a class="d-flex" href="">
                    <span class="main-img-user"><img alt="avatar" src="../../assets/img/blank.png"></span>
                </a>
                <div class="dropdown-menu">
                    <div class="header-navheading">
                        <h6 class="main-notification-title">ADMIN</h6>
                        <p class="main-notification-text">ADMIN</p>
                    </div>
                    <a class="dropdown-item" href="#">
                        <i class="fe fe-settings"></i> Change Password
                    </a>
                    {{-- <a class="dropdown-item" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fe fe-power"></i> Sign Out
                    </a> --}}
                    <a class="dropdown-item" href="#">
                        <i class="fe fe-power"></i> Sign Out
                    </a>
                    {{-- <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form> --}}
                </div>
            </div>
            <!-- Navresponsive closed -->
        </div>
    </div>
</div>
<!-- End Main Header-->
