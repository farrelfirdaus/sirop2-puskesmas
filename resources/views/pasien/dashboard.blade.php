<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Pasien — SIROP</title>
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    /* Full screen wrapper */
    html, body, #wrapper {
        height: 100%;
        width: 100%;
    }

    #wrapper {
        display: flex !important;
        overflow: hidden;
    }

    /* Sidebar fixed height */
    .sidebar {
        min-height: 100vh;
        height: 100%;
    }

    /* Content wrapper fill sisa layar */
    #content-wrapper {
        flex: 1 !important;
        min-width: 0;
        overflow-y: auto;
        height: 100vh;
    }

    /* Responsive mobile */
    @media (max-width: 768px) {
        #wrapper {
            flex-direction: column !important;
        }

        .sidebar {
            width: 100% !important;
            min-height: auto !important;
            height: auto !important;
        }

        #content-wrapper {
            height: auto !important;
        }

        .container-fluid {
            padding: 12px !important;
        }

        .col-xl-4 {
            margin-bottom: 12px;
        }
    }
</style>
</head>
<body id="page-top">
<div id="wrapper">

    {{-- Sidebar --}}
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
        <li class="nav-item {{ request()->routeIs('pasien.jadwal') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('pasien.jadwal') }}">
                <i class="fas fa-fw fa-calendar"></i>
                <span>Jadwal Dokter</span>
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
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>

    {{-- Content Wrapper --}}
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">

            {{-- Topbar --}}
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item mx-1" style="position:relative">
            <a href="#" id="alertsDropdown" onclick="toggleNotif(event)">
                <i class="fas fa-bell fa-fw" style="font-size:1.2rem"></i>
                <span class="badge badge-danger" id="notif-count" 
                    style="display:none; position:absolute; top:-5px; right:-5px; 
                    border-radius:50%; padding:2px 6px; font-size:0.7rem">0</span>
            </a>
            <div id="notif-dropdown" 
                style="display:none; position:absolute; right:0; top:30px; 
                width:350px; max-height:400px; overflow-y:auto; 
                background:white; border-radius:8px; 
                box-shadow:0 4px 15px rgba(0,0,0,0.15); z-index:9999">
                <div style="padding:10px 15px; font-weight:bold; 
                    border-bottom:1px solid #eee; color:#4e73df">
                    🔔 Notifikasi
                </div>
                <div id="notif-items">
                    <div class="text-center p-3 text-muted">Memuat...</div>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <span class="navbar-text mx-3">
                Halo, <strong>{{ auth()->user()->name }}</strong>! 👋
            </span>
        </li>
    </ul>
</nav>

            {{-- Main Content --}}
            <div class="container-fluid">

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Beranda Pasien</h1>
                </div>

                {{-- Cards --}}
                <div class="row">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Dokter Aktif Tersedia
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $dokterAktif }} Dokter
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-user-md fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Total Kunjungan Saya
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            {{ $riwayat->count() }} Kunjungan
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-history fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Daftar Antrian Sekarang
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <a href="{{ route('pendaftaran.create') }}" class="btn btn-info btn-sm">
                                                Daftar Sekarang
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-plus-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
    {{-- Antrian Aktif --}}
{{-- Antrian Aktif --}}
<div class="col-xl-4 col-lg-5 mb-4">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Antrian Saat Ini</h6>
        </div>
        <div class="card-body">
            {{-- Tab Poli --}}
            <div style="display:flex; gap:8px; margin-bottom:20px">
                <button onclick="gantiTab('Poli Umum', this)" id="tab-poli-umum"
                    style="flex:1; padding:8px; border:none; border-radius:8px;
                    background:#4e73df; color:white; cursor:pointer; font-weight:bold; font-size:0.75rem">
                    Poli Umum
                </button>
                <button onclick="gantiTab('Poli Gigi', this)" id="tab-poli-gigi"
                    style="flex:1; padding:8px; border:none; border-radius:8px;
                    background:#e0e0e0; color:#666; cursor:pointer; font-weight:bold; font-size:0.75rem">
                    Poli Gigi
                </button>
                <button onclick="gantiTab('Poli KIA', this)" id="tab-poli-kia"
                    style="flex:1; padding:8px; border:none; border-radius:8px;
                    background:#e0e0e0; color:#666; cursor:pointer; font-weight:bold; font-size:0.75rem">
                    Poli KIA
                </button>
            </div>

            {{-- Konten Antrian --}}
            <div class="text-center">
                <h1 class="display-4 font-weight-bold text-primary">
                    No. <span id="angka-antrian">{{ $antrianPerPoli['Poli Umum']['sedang'] ?: '-' }}</span>
                </h1>
                <p class="text-muted" id="label-poli">Poli Umum — {{ now()->format('d M Y') }}</p>
                <hr>
                <div style="display:flex; justify-content:space-around; padding:0 20px">
                    <div>
                        <h4 class="text-success font-weight-bold" id="sudah-dilayani">
                            {{ $antrianPerPoli['Poli Umum']['sedang'] }}
                        </h4>
                        <small>Sudah Dilayani</small>
                    </div>
                    <div>
                        <h4 class="text-danger font-weight-bold" id="menunggu-count">
                            {{ $antrianPerPoli['Poli Umum']['menunggu'] }}
                        </h4>
                        <small>Menunggu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    {{-- Riwayat Terakhir --}}
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Riwayat Kunjungan Terakhir</h6>
            </div>
            <div class="card-body">
                @if($riwayat->isEmpty())
                    <p class="text-center text-muted">Belum ada riwayat kunjungan.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Poli</th>
                                    <th>No. Antrian</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($riwayat as $r)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($r->tanggal_kunjungan)->format('d M Y') }}</td>
                                    <td>{{ $r->poli }}</td>
                                    <td>{{ $r->nomor_antrian }}</td>
                                    <td>
                                        @if($r->status == 'menunggu')
                                            <span class="badge badge-warning">Menunggu</span>
                                        @elseif($r->status == 'selesai')
                                            <span class="badge badge-success">Selesai</span>
                                        @else
                                            <span class="badge badge-danger">Batal</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <a href="{{ route('pendaftaran.riwayat') }}" class="btn btn-primary btn-sm">
                    Lihat Semua Riwayat
                </a>
            </div>
        </div>
    </div>
</div>

            </div>
        </div>
    </div>
</div>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function loadNotifikasi() {
    fetch('/notifikasi/jumlah')
        .then(r => r.json())
        .then(data => {
            const badge = document.getElementById('notif-count');
            if (data.jumlah > 0) {
                badge.style.display = 'inline';
                badge.innerText = data.jumlah;
            } else {
                badge.style.display = 'none';
            }
        });
}

function toggleNotif(e) {
    e.preventDefault();
    const dropdown = document.getElementById('notif-dropdown');
    if (dropdown.style.display === 'none') {
        dropdown.style.display = 'block';
        // Load notifikasi
        fetch('/notifikasi')
            .then(r => r.json())
            .then(data => {
                const container = document.getElementById('notif-items');
                if (data.length === 0) {
                    container.innerHTML = '<div class="text-center p-3 text-muted">Tidak ada notifikasi</div>';
                    return;
                }
                container.innerHTML = data.map(n => `
                    <a href="#" onclick="bacaNotif(${n.id}, this)" 
                        style="display:flex; align-items:flex-start; padding:12px 15px; 
                        border-bottom:1px solid #eee; text-decoration:none; color:#333;
                        background:${n.dibaca ? 'white' : '#f8f9fc'}">
                        <div style="margin-right:10px; margin-top:3px">
                            <span style="width:35px; height:35px; border-radius:50%; 
                                display:flex; align-items:center; justify-content:center;
                                background:${n.tipe === 'jadwal_hari_ini' ? '#1cc88a' : n.tipe === 'jadwal_h1' ? '#f6c23e' : '#36b9cc'}">
                                <i class="fas ${n.tipe === 'status_berubah' ? 'fa-check' : 'fa-calendar'}" 
                                    style="color:white; font-size:0.8rem"></i>
                            </span>
                        </div>
                        <div>
                            <div style="font-size:0.75rem; color:#999">${new Date(n.created_at).toLocaleDateString('id-ID')}</div>
                            <div style="font-weight:bold; font-size:0.85rem">${n.judul}</div>
                            <div style="font-size:0.8rem; color:#666">${n.pesan}</div>
                        </div>
                    </a>
                `).join('');
                document.getElementById('notif-count').style.display = 'none';
            });
    } else {
        dropdown.style.display = 'none';
    }
}

// Tutup dropdown kalau klik di luar
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('notif-dropdown');
    const bell = document.getElementById('alertsDropdown');
    if (!bell.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.style.display = 'none';
    }
});
let poliAktif = 'Poli Umum';

let antrianData = {
    'Poli Umum': {
        sedang: {{ $antrianPerPoli['Poli Umum']['sedang'] }},
        menunggu: {{ $antrianPerPoli['Poli Umum']['menunggu'] }}
    },
    'Poli Gigi': {
        sedang: {{ $antrianPerPoli['Poli Gigi']['sedang'] }},
        menunggu: {{ $antrianPerPoli['Poli Gigi']['menunggu'] }}
    },
    'Poli KIA': {
        sedang: {{ $antrianPerPoli['Poli KIA']['sedang'] }},
        menunggu: {{ $antrianPerPoli['Poli KIA']['menunggu'] }}
    }
};

function gantiTab(poli, btn) {
    poliAktif = poli;
    document.querySelectorAll('[id^="tab-"]').forEach(b => {
        b.style.background = '#e0e0e0';
        b.style.color = '#666';
    });
    btn.style.background = '#4e73df';
    btn.style.color = 'white';

    const data = antrianData[poli];
    document.getElementById('angka-antrian').innerText = data.sedang > 0 ? data.sedang : '-';
    document.getElementById('label-poli').innerText = poli + ' — {{ now()->format("d M Y") }}';
    document.getElementById('sudah-dilayani').innerText = data.sedang;
    document.getElementById('menunggu-count').innerText = data.menunggu;
}

// Realtime: update setiap 10 detik
function refreshAntrianRealtime() {
    fetch('/api/antrian-realtime')
        .then(r => r.json())
        .then(data => {
            antrianData = data;
            const d = data[poliAktif];
            document.getElementById('angka-antrian').innerText = d.sedang > 0 ? d.sedang : '-';
            document.getElementById('sudah-dilayani').innerText = d.sedang;
            document.getElementById('menunggu-count').innerText = d.menunggu;
        });
}

setInterval(refreshAntrianRealtime, 10000); // setiap 10 detik
</script>
</body>
</html>