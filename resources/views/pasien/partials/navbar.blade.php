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

        <!-- Notifikasi Bell — manual dropdown tanpa Bootstrap -->
        <li class="nav-item mx-1" style="position:relative;">
            <a class="nav-link position-relative" href="#"
               id="notifBellBtn"
               style="color: #aaa;"
               onclick="toggleNotifDropdown(event)">
                <i class="fas fa-bell" style="font-size: 1.1rem;"></i>
                <span id="notif-badge"
                      style="display:none; position:absolute; top:4px; right:4px;
                             background:#e74a3b; color:white; border-radius:50%;
                             width:17px; height:17px; font-size:0.65rem;
                             font-weight:700; line-height:17px; text-align:center;">
                    0
                </span>
            </a>

            <!-- Dropdown manual -->
            <div id="notifDropdownMenu"
                 style="display:none; position:fixed; top:60px; right:20px;
                        width:340px; background:white; border-radius:12px;
                        box-shadow:0 8px 32px rgba(0,0,0,0.15);
                        overflow:hidden; z-index:9999;">
                <div style="background:#4e73df; padding:12px 16px; display:flex; align-items:center; justify-content:space-between;">
                    <span style="color:white; font-weight:600; font-size:0.9rem;">
                        <i class="fas fa-bell mr-2"></i>Notifikasi
                    </span>
                    <span onclick="tutupNotifDropdown()"
                          style="color:rgba(255,255,255,0.8); cursor:pointer; font-size:1.1rem;">&times;</span>
                </div>
                <div id="notif-list" style="max-height:320px; overflow-y:auto;">
                    <div class="text-center text-muted py-4" style="font-size:0.85rem;">
                        <i class="fas fa-bell-slash fa-2x mb-2 d-block" style="color:#ddd;"></i>
                        Memuat...
                    </div>
                </div>
                <div style="border-top:1px solid #f0f0f0; padding:10px 16px; text-align:center;">
                    <a href="{{ route('notifikasi.index') }}"
                       style="font-size:0.82rem; color:#4e73df; text-decoration:none;">
                        Lihat semua notifikasi
                    </a>
                </div>
            </div>
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

            <div class="dropdown-menu dropdown-menu-right shadow"
                style="border: none; border-radius: 10px; padding: 0.5rem 0;"
                aria-labelledby="userDropdown">
                <a class="dropdown-item py-2 px-4" href="{{ route('profil.edit') }}" style="font-size: 0.88rem; color: #555;">
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

<script>
// URL disimpan di window supaya bisa diakses dari script lain
window._notifUrlJumlah = '{{ route("notifikasi.jumlah") }}';
window._notifUrlIndex  = '{{ route("notifikasi.index") }}';

function toggleNotifDropdown(event) {
    event.preventDefault();
    event.stopPropagation();
    const menu = document.getElementById('notifDropdownMenu');
    const isOpen = menu.style.display === 'block';
    if (isOpen) {
        menu.style.display = 'none';
    } else {
        menu.style.display = 'block';
        muatIsiNotifikasi();
    }
}

function tutupNotifDropdown() {
    document.getElementById('notifDropdownMenu').style.display = 'none';
}

function muatIsiNotifikasi() {
    fetch(window._notifUrlIndex, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(list => {
        const container = document.getElementById('notif-list');
        if (!list || list.length === 0) {
            container.innerHTML = `
                <div class="text-center text-muted py-4" style="font-size:0.85rem;">
                    <i class="fas fa-bell-slash fa-2x mb-2 d-block" style="color:#ddd;"></i>
                    Tidak ada notifikasi
                </div>`;
            return;
        }

        const icons = {
            dipanggil:       { icon: 'fa-bullhorn',     color: '#4e73df' },
            jadwal_hari_ini: { icon: 'fa-calendar-day', color: '#1cc88a' },
            jadwal_h1:       { icon: 'fa-calendar-alt', color: '#f6c23e' },
            status_berubah:  { icon: 'fa-info-circle',  color: '#36b9cc' },
        };

        container.innerHTML = list.slice(0, 10).map(n => {
            const ic = icons[n.tipe] || { icon: 'fa-bell', color: '#aaa' };
            const belum = !n.dibaca;
            return `
                <div style="display:flex; align-items:flex-start; padding:12px 16px;
                            border-bottom:1px solid #f5f5f5;
                            background:${belum ? '#f8f9ff' : 'white'};">
                    <div style="width:34px; height:34px; border-radius:50%;
                                background:${ic.color}20; display:flex;
                                align-items:center; justify-content:center;
                                flex-shrink:0; margin-right:12px;">
                        <i class="fas ${ic.icon}" style="color:${ic.color}; font-size:0.85rem;"></i>
                    </div>
                    <div style="flex:1; min-width:0;">
                        <div style="font-weight:${belum ? '700' : '500'}; font-size:0.82rem; color:#333; margin-bottom:2px;">
                            ${n.judul}
                        </div>
                        <div style="font-size:0.78rem; color:#777; line-height:1.4;">
                            ${n.pesan}
                        </div>
                    </div>
                    ${belum ? '<span style="width:8px;height:8px;border-radius:50%;background:#4e73df;flex-shrink:0;margin-top:4px;"></span>' : ''}
                </div>`;
        }).join('');

        // Reset badge
        const badge = document.getElementById('notif-badge');
        if (badge) badge.style.display = 'none';
    })
    .catch(err => {
        document.getElementById('notif-list').innerHTML =
            '<div class="text-center text-danger py-3" style="font-size:0.85rem;">Gagal memuat notifikasi</div>';
    });
}

// Klik di luar dropdown → tutup
document.addEventListener('click', function(e) {
    const menu = document.getElementById('notifDropdownMenu');
    const btn  = document.getElementById('notifBellBtn');
    if (menu && btn && !menu.contains(e.target) && !btn.contains(e.target)) {
        menu.style.display = 'none';
    }
});
</script>

<!-- End Topbar -->