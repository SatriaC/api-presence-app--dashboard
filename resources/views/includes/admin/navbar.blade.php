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
            <li class="nav-item {{ (request()->is('/')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}"><span class="shape1"></span><span class="shape2"></span><i
                            class="ti-home sidemenu-icon"></i><span class="sidemenu-label">Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i
                        class="ti-desktop sidemenu-icon"></i><span class="sidemenu-label">Master Data</span></a>
                <ul class="nav-sub">
                    @if (Auth::user()->privilege == 1)
                    <li class="nav-sub-item">
                        <a class="nav-sub-link" href="{{ route('karyawan.index') }}">Karyawan</a>
                    </li>
                    <li class="nav-sub-item">
                        <a class="nav-sub-link" href="{{ route('bagian.index') }}">Bagian</a>
                    </li>
                    @endif
                    <li class="nav-sub-item">
                        <a class="nav-sub-link" href="{{ route('sow.index') }}">SoW</a>
                    </li>
                    <li class="nav-sub-item">
                        <a class="nav-sub-link" href="{{ route('kategori-sow.index') }}">Kategori SoW</a>
                    </li>
                    <li class="nav-sub-item">
                        <a class="nav-sub-link" href="{{ route('detail-sow.index') }}">Detail SoW</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link with-sub" href="#"><span class="shape1"></span><span class="shape2"></span><i
                        class="ti-clipboard sidemenu-icon"></i><span class="sidemenu-label">Reporting</span></a>
                <ul class="nav-sub">
                    <li class="nav-sub-item">
                        <a class="nav-sub-link" href="{{ route('pekerjaan.index') }}">Pekerjaan</a>
                    </li>
                    <li class="nav-sub-item">
                        <a class="nav-sub-link" href="{{ route('kehadiran.index') }}">Kehadiran</a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</div>
<!-- End Sidemenu -->
