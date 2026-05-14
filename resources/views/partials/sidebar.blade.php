<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar"
    style="background: linear-gradient(180deg, #2c4ec9 0%, #1a3aad 100%); min-height: 100vh;">

    <!-- Sidebar Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center py-4" href="{{ route('dashboard') }}"
        style="text-decoration: none; color: white;">
        <div class="sidebar-brand-icon mr-2">
            <i class="fas fa-hospital" style="font-size: 1.5rem;"></i>
        </div>
        <div class="sidebar-brand-text font-weight-bold" style="font-size: 1.3rem; letter-spacing: 1px;">SIROP</div>
    </a>

    <hr class="sidebar-divider my-0" style="border-color: rgba(255,255,255,0.2);">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3 px-4" href="{{ route('dashboard') }}"
            style="color: rgba(255,255,255,0.85); font-size: 0.9rem;">
            <i class="fas fa-fw fa-home mr-3" style="font-size: 1rem;"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Data Pasien -->
    <li class="nav-item {{ request()->routeIs('pasien.*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3 px-4" href="{{ route('pasien.index') }}"
            style="color: rgba(255,255,255,0.85); font-size: 0.9rem;">
            <i class="fas fa-fw fa-user mr-3" style="font-size: 1rem;"></i>
            <span>Data Pasien</span>
        </a>
    </li>

    <!-- Antrian -->
    <li class="nav-item {{ request()->routeIs('antrian.*') ? 'active' : '' }}">
        <a class="nav-link d-flex align-items-center py-3 px-4" href="{{ route('antrian.index') }}"
            style="color: rgba(255,255,255,0.85); font-size: 0.9rem;">
            <i class="fas fa-fw fa-clipboard-list mr-3" style="font-size: 1rem;"></i>
            <span>Antrian</span>
        </a>
    </li>

    <!-- Logout -->
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center py-3 px-4" href="#" onclick="confirmLogout()"
            style="color: rgba(255,255,255,0.85); font-size: 0.9rem; cursor: pointer;">
            <i class="fas fa-fw fa-sign-out-alt mr-3" style="font-size: 1rem;"></i>
            <span>Logout</span>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </li>

    <hr class="sidebar-divider" style="border-color: rgba(255,255,255,0.2);">

    <!-- Sidebar Toggle Button -->
    <div class="text-center d-none d-md-inline pb-3">
        <button class="rounded-circle border-0" id="sidebarToggle"
            style="width: 28px; height: 28px; background: rgba(255,255,255,0.2); color: white; cursor: pointer;">
            <i class="fas fa-chevron-left" style="font-size: 0.7rem;"></i>
        </button>
    </div>

</ul>

<style>
    #accordionSidebar .nav-item.active .nav-link {
        color: white !important;
        font-weight: 600 !important;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        margin: 0 12px;
        padding-left: 12px !important;
    }
    #accordionSidebar .nav-link:hover {
        color: white !important;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        margin: 0 12px;
        padding-left: 12px !important;
        transition: all 0.2s ease;
    }
    .sidebar { transition: width 0.3s ease; }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Yakin mau logout?',
            text: 'Kamu akan keluar dari aplikasi.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#2c4ec9',
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