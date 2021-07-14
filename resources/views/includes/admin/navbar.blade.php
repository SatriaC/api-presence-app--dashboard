<!-- Sidemenu -->
<div class="main-sidebar main-sidebar-sticky side-menu">
    <div class="sidemenu-logo">
        <a class="main-logo" href="index.html">
            <img src="{{ asset('assets/img/logo-1.png') }}" class="header-brand-img desktop-logo" style="width:82%; height:auto;" alt="logo">
            <img src="{{ asset('assets/img/logo-8.png') }}" class="header-brand-img icon-logo" style="width:82%; height:auto;" alt="logo">
            <img src="{{ asset('assets/img/logo-1.png') }}" class="header-brand-img desktop-logo theme-logo"
                 alt="logo">
            <img src="{{ asset('assets/img/logo-2.png') }}" class="header-brand-img icon-logo theme-logo"
                 alt="logo">
        </a>
    </div>
    <div class="main-sidebar-body">
        <ul class="nav">
            {{-- <li class="nav-header"><span class="nav-label">Dashboard</span></li> --}}
            <li class="nav-item">
                <a class="nav-link" href="#"><span class="shape1"></span><span class="shape2"></span><i
                            class="ti-home sidemenu-icon"></i><span class="sidemenu-label">Dashboard</span></a>
            </li>
            <li class="nav-item {{ (request()->is('monitor/karyawan*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('karyawan.index') }}"><span class="shape1"></span><span class="shape2"></span><i
                            class="ti-user sidemenu-icon"></i><span class="sidemenu-label">Monitor Karyawan</span></a>
            </li>
            <li class="nav-item {{ (request()->is('monitor/bagian*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('bagian.index') }}"><span class="shape1"></span><span class="shape2"></span><i
                            class="ti-bag sidemenu-icon"></i><span class="sidemenu-label">Bagian</span></a>
            </li>
            <li class="nav-item {{ (request()->is('monitor/sow*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('sow.index') }}"><span class="shape1"></span><span class="shape2"></span><i
                            class="ti-layers sidemenu-icon"></i><span class="sidemenu-label">Monitor SoW</span></a>
            </li>
            <li class="nav-item {{ (request()->is('monitor/detail-sow*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('detail-sow.index') }}"><span class="shape1"></span><span class="shape2"></span><i
                            class="ti-layers-alt sidemenu-icon"></i><span class="sidemenu-label">Detail SoW</span></a>
            </li>

        </ul>
    </div>
</div>
<!-- End Sidemenu -->
