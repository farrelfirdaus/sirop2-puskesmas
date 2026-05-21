<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center py-4" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon mr-2">
            <i class="fas fa-hospital"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIROP</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Data Pasien -->
    <li class="nav-item {{ request()->routeIs('pasien.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pasien.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Data Pasien</span>
        </a>
    </li>

    <!-- Antrian -->
    <li class="nav-item {{ request()->routeIs('antrian.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('antrian.index') }}">
            <i class="fas fa-fw fa-clipboard-list"></i>
            <span>Antrian</span>
        </a>
    </li>

    <hr class="sidebar-divider">

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

    <!-- Sidebar Toggle -->
    <div class="text-center d-none d-md-inline pb-3">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

<style>
    #accordionSidebar {
        background: linear-gradient(180deg, #2c4ec9 0%, #1a3aad 100%);
        min-height: 100vh;
    }

    #accordionSidebar .sidebar-brand {
        text-decoration: none;
        color: white;
        font-size: 1.2rem;
        font-weight: 700;
        letter-spacing: 1px;
    }

    #accordionSidebar .sidebar-brand-icon i {
        font-size: 1.5rem;
    }

    #accordionSidebar hr.sidebar-divider {
        border-color: rgba(255, 255, 255, 0.15);
        margin: 0 1rem;
    }

    #accordionSidebar .nav-item .nav-link {
        display: flex;
        align-items: center;
        color: rgba(255, 255, 255, 0.75);
        font-size: 0.9rem;
        padding: 0.85rem 1.5rem;
        border-radius: 8px;
        margin: 2px 10px;
        transition: all 0.2s ease;
    }

    #accordionSidebar .nav-item .nav-link i {
        font-size: 1rem;
        margin-right: 0.75rem;
        width: 20px;
        text-align: center;
    }

    #accordionSidebar .nav-item .nav-link:hover {
        color: white;
        background: rgba(255, 255, 255, 0.12);
        text-decoration: none;
    }

    #accordionSidebar .nav-item.active .nav-link {
        color: white !important;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.18);
    }

    /* Collapsed state */
    .sidebar-toggled #accordionSidebar .nav-link span,
    .sidebar-toggled #accordionSidebar .sidebar-brand-text {
        display: none;
    }

    .sidebar-toggled #accordionSidebar .nav-link {
        justify-content: center;
        padding: 0.85rem 0;
        margin: 2px auto;
        width: 42px;
    }

    .sidebar-toggled #accordionSidebar .nav-link i {
        margin-right: 0;
        font-size: 1.1rem;
        width: auto;
    }

    .sidebar-toggled #accordionSidebar .sidebar-brand {
        justify-content: center;
    }

    #accordionSidebar #sidebarToggle {
        display: block;
        margin: 1rem auto 0;
    }
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