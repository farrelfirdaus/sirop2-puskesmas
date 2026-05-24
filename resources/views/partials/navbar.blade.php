<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top"
    style="box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 0 1.5rem;">

    <!-- Sidebar Toggle Mobile -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars" style="color: #555;"></i>
    </button>

    <!-- Custom Navbar Content (per halaman) -->
<div class="d-none d-sm-flex align-items-center" style="flex: 1; max-width: 600px;">
    @yield('navbar_content')
</div>

    <!-- Right Side Icons -->
    <ul class="navbar-nav ml-auto align-items-center">

        <!-- Notifikasi -->
        <li class="nav-item mx-1">
            <a class="nav-link" href="#" style="color: #aaa;">
                <i class="fas fa-bell" style="font-size: 1.1rem;"></i>
            </a>
        </li>

        <!-- Pesan -->
        <li class="nav-item mx-1">
            <a class="nav-link" href="#" style="color: #aaa;">
                <i class="fas fa-envelope" style="font-size: 1.1rem;"></i>
            </a>
        </li>

        <div class="topbar-divider" style="width: 1px; height: 30px; background: #e3e6f0; margin: 0 1rem;"></div>

        <!-- User Info -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline font-weight-500"
                    style="color: #555; font-size: 0.9rem;">
                    {{ Auth::user()->name }}
                </span>
                <div class="rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 36px; height: 36px; background: #2c4ec9; color: white; font-size: 1rem;">
                    <i class="fas fa-user"></i>
                </div>
            </a>

            <!-- Dropdown -->
            <div class="dropdown-menu dropdown-menu-right shadow"
                style="border: none; border-radius: 10px; padding: 0.5rem 0;"
                aria-labelledby="userDropdown">
                <a class="dropdown-item py-2 px-4" href="#" style="font-size: 0.88rem; color: #555;">
                    <i class="fas fa-user fa-sm mr-2 text-muted"></i> Profil
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item py-2 px-4" href="#"
                    style="font-size: 0.88rem; color: #e74a3b;"
                    onclick="event.preventDefault(); confirmLogout();">
                    <i class="fas fa-sign-out-alt fa-sm mr-2"></i> Logout
                </a>
                <form id="logout-form-top" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>

    </ul>
</nav>
<!-- End Topbar -->