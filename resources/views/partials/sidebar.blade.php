<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-hospital"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIROP</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <div class="sidebar-heading">Data</div>

    <!-- Data Pasien -->
    <li class="nav-item {{ request()->routeIs('pasien.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pasien.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Pasien</span>
        </a>
    </li>
<!-- Nav Item - Laporan -->
<li class="nav-item">
    <a class="nav-link" href="#">
        <i class="fas fa-fw fa-notes-medical"></i>
        <span>Laporan</span>
    </a>
</li>
    <hr class="sidebar-divider">

    <div class="sidebar-heading">Akun</div>

    <!-- Logout -->
<li class="nav-item">
    <a class="nav-link" href="#" onclick="confirmLogout()">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Logout</span>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
</li>

    <hr class="sidebar-divider d-none d-md-block">

    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Yakin mau logout?',
            text: 'Kamu akan keluar dari aplikasi.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>