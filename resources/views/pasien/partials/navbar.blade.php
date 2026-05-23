<style>
@media (max-width: 768px) {
    /* Sidebar lebih kecil di mobile */
    .sidebar {
        width: 80px !important;
        min-width: 80px !important;
    }

    /* Sembunyikan teks sidebar, tampilkan icon saja */
    .sidebar .nav-item .nav-link span {
        display: none !important;
    }

    .sidebar-brand-text {
        display: none !important;
    }

    /* Konten utama ambil sisa ruang */
    #content-wrapper {
        width: calc(100% - 80px) !important;
    }

    /* Tabel bisa scroll horizontal */
    .table-responsive {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
    }

    /* Form input full width */
    .form-control {
        width: 100% !important;
    }

    /* Card full width */
    .col-xl-4, .col-xl-8, .col-md-6 {
        width: 100% !important;
        max-width: 100% !important;
        flex: 0 0 100% !important;
    }

    /* Navbar info tanggal sembunyi di mobile */
    .d-none.d-sm-inline-block {
        display: none !important;
    }

    /* Font lebih kecil */
    h1 { font-size: 1.5rem !important; }
    h3 { font-size: 1.2rem !important; }
}
</style>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    {{-- Info Tanggal & Antrian Aktif --}}
    <div class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0">
        @php
            $tanggal = \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY');
            $jam = \Carbon\Carbon::now()->format('H:i');
            $antrianAktif = \App\Models\Pendaftaran::where('user_id', auth()->id())
                ->where('status', 'menunggu')
                ->whereDate('tanggal_kunjungan', today())
                ->first();
        @endphp
        <span class="text-gray-600" style="font-size:0.85rem">
            📅 {{ $tanggal }} | {{ $jam }}
            @if($antrianAktif)
                &nbsp;|&nbsp; 🎫 Antrian aktif: {{ $antrianAktif->poli }} No. {{ $antrianAktif->nomor_antrian }}
            @endif
        </span>
    </div>

    {{-- Kanan: Lonceng & Nama --}}
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

function bacaNotif(id, el) {
    fetch(`/notifikasi/${id}/baca`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    });
    el.classList.remove('bg-light');
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('notif-dropdown');
    const bell = document.getElementById('alertsDropdown');
    if (dropdown && bell && !bell.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.style.display = 'none';
    }
});

loadNotifikasi();
</script>