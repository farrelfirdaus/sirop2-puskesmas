<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('pasien.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-hospital"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIROP</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->routeIs('pasien.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pasien.dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Beranda</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('pendaftaran.create') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pendaftaran.create') }}">
            <i class="fas fa-fw fa-plus-circle"></i>
            <span>Daftar Antrian</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('pendaftaran.riwayat') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pendaftaran.riwayat') }}">
            <i class="fas fa-fw fa-history"></i>
            <span>Riwayat Kunjungan</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('profil.edit') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('profil.edit') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Profil Saya</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link" href="#" onclick="confirmLogout(event)">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </li>
</ul>