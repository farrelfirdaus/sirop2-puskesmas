<!DOCTYPE html>
<html lang="id">
<head>
    <title>Beranda Pasien — SIROP</title>
    @include('pasien.partials.head')
</head>
<body id="page-top">
<div id="wrapper">

    @include('pasien.partials.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('pasien.partials.navbar')

            {{-- konten dashboard tetap sama --}}
</head>
<body id="page-top">
<div id="wrapper">
    {{-- Content Wrapper --}}
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
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
                    <div class="col-xl-6 col-md-6 mb-4">
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

                    <div class="col-xl-6 col-md-6 mb-4">
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
                {{-- Nomor yang sedang dipanggil --}}
                <div id="box-dipanggil">
                    <p class="text-muted mb-1" style="font-size:0.78rem;">SEDANG DIPANGGIL</p>
                    <h1 class="display-4 font-weight-bold text-primary mb-0">
                        <span id="angka-antrian">-</span>
                    </h1>
                    <p class="text-muted mb-0" id="nama-dipanggil" style="font-size:0.85rem;"></p>
                </div>
                <p class="text-muted mt-1" id="label-poli">Poli Umum — {{ now()->format('d M Y') }}</p>

                {{-- Box posisi antrian pasien --}}
                <div id="box-posisi-saya" style="display:none; margin: 10px 16px 4px; border-radius:10px;
                     padding:10px 16px; background:#f0f4ff; border:1.5px solid #c7d7ff;">
                    <div style="display:flex; align-items:center; gap:10px;">
                        <div style="width:36px; height:36px; border-radius:50%; background:#4e73df;
                                    display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="fas fa-user" style="color:white; font-size:0.85rem;"></i>
                        </div>
                        <div style="text-align:left; flex:1;">
                            <div style="font-size:0.75rem; color:#4e73df; font-weight:700; text-transform:uppercase;">
                                Antrian Kamu Hari Ini
                            </div>
                            <div id="posisi-saya-teks" style="font-size:0.85rem; color:#333; font-weight:500;">
                                —
                            </div>
                        </div>
                        <div id="posisi-saya-badge" style="display:none; background:#4e73df; color:white;
                             border-radius:8px; padding:4px 10px; font-size:0.8rem; font-weight:700;">
                            No. <span id="posisi-saya-nomor">-</span>
                        </div>
                    </div>
                </div>

                <hr>
                <div style="display:flex; justify-content:space-around; padding:0 20px">
                    <div>
                        <h4 class="text-success font-weight-bold" id="sudah-dilayani">-</h4>
                        <small>Sudah Dilayani</small>
                    </div>
                    <div>
                        <h4 class="text-danger font-weight-bold" id="menunggu-count">-</h4>
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
                                            <span class="badge badge-warning">Menunggu Dipanggil</span>
                                        @elseif($r->status == 'dipanggil')
                                            <span class="badge badge-primary">Sedang Dipanggil</span>
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
// Polling badge notifikasi — jalan setelah jQuery load
function cekBadgeNotifikasi() {
    if (!window._notifUrlJumlah) return;
    fetch(window._notifUrlJumlah, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        const badge = document.getElementById('notif-badge');
        if (!badge) return;
        if (data.jumlah > 0) {
            badge.style.display = 'block';
            badge.textContent = data.jumlah > 9 ? '9+' : data.jumlah;
        } else {
            badge.style.display = 'none';
        }
    })
    .catch(() => {});
}
cekBadgeNotifikasi();
setInterval(cekBadgeNotifikasi, 5000);
</script>
<script>
let poliAktif = 'Poli Umum';

function updateTampilanAntrian(data) {
    const d = data[poliAktif];
    const nomorEl = document.getElementById('angka-antrian');
    const namaEl  = document.getElementById('nama-dipanggil');

    if (d.nomor_dipanggil) {
        nomorEl.innerText = String(d.nomor_dipanggil).padStart(3, '0');
        namaEl.innerText  = d.nama_dipanggil ?? '';
        nomorEl.closest('h1').classList.remove('text-muted');
        nomorEl.closest('h1').classList.add('text-primary');
    } else {
        nomorEl.innerText = '-';
        namaEl.innerText  = 'Belum ada antrian dipanggil';
        nomorEl.closest('h1').classList.remove('text-primary');
        nomorEl.closest('h1').classList.add('text-muted');
    }

    document.getElementById('sudah-dilayani').innerText = d.sudah_dilayani ?? 0;
    document.getElementById('menunggu-count').innerText = d.menunggu ?? 0;
}

function gantiTab(poli, btn) {
    poliAktif = poli;
    document.querySelectorAll('[id^="tab-"]').forEach(b => {
        b.style.background = '#e0e0e0';
        b.style.color = '#666';
    });
    btn.style.background = '#4e73df';
    btn.style.color = 'white';

    document.getElementById('label-poli').innerText = poli + ' — {{ now()->format("d M Y") }}';

    // Langsung fetch saat ganti tab
    refreshAntrianRealtime();
    refreshPosisiSaya();
}

// Realtime: update setiap 5 detik
function refreshAntrianRealtime() {
    fetch('/api/antrian-realtime')
        .then(r => r.json())
        .then(data => {
            updateTampilanAntrian(data);
        })
        .catch(() => {});
}

// Fetch posisi antrian pasien yang login
function refreshPosisiSaya() {
    fetch('/api/posisi-antrian-saya')
        .then(r => r.json())
        .then(data => {
            const box   = document.getElementById('box-posisi-saya');
            const teks  = document.getElementById('posisi-saya-teks');
            const badge = document.getElementById('posisi-saya-badge');
            const nomor = document.getElementById('posisi-saya-nomor');

            // Hanya tampilkan kalau poli yang aktif = poli antrian pasien
            if (!data.ada || data.poli !== poliAktif) {
                box.style.display = 'none';
                return;
            }

            box.style.display = 'block';
            nomor.textContent = String(data.nomor_antrian).padStart(3, '0');
            badge.style.display = 'block';

            if (data.status === 'dipanggil') {
                teks.innerHTML = '<span style="color:#4e73df; font-weight:700;">🔔 Nomor kamu sedang dipanggil! Segera ke ruang pemeriksaan.</span>';
                box.style.background = '#e8f0ff';
                box.style.borderColor = '#4e73df';
            } else if (data.status === 'menunggu') {
                if (data.posisi === 0) {
                    teks.textContent = 'Kamu adalah antrian berikutnya!';
                } else {
                    teks.textContent = 'Masih ' + data.posisi + ' orang di depan kamu.';
                }
                box.style.background = '#f0f4ff';
                box.style.borderColor = '#c7d7ff';
            } else if (data.status === 'selesai') {
                teks.textContent = 'Antrian kamu sudah selesai dilayani.';
                box.style.background = '#f0fff4';
                box.style.borderColor = '#b2f5c8';
            }
        })
        .catch(() => {});
}

// ============================================================
// POP-UP TOAST saat notifikasi 'dipanggil' masuk
// ============================================================
let sudahMunculNotifIds = JSON.parse(sessionStorage.getItem('notifMuncul') || '[]');

function cekNotifikasiDipanggil() {
    fetch('{{ route("notifikasi.index") }}', {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(list => {
        if (!list || list.length === 0) return;

        // Cari notifikasi tipe 'dipanggil' yang belum dibaca dan belum pernah pop-up
        const baru = list.filter(n =>
            n.tipe === 'dipanggil' &&
            !n.dibaca &&
            !sudahMunculNotifIds.includes(n.id)
        );

        baru.forEach(n => {
            tampilToast(n.judul, n.pesan);
            sudahMunculNotifIds.push(n.id);
        });

        // Simpan ke sessionStorage supaya tidak muncul lagi setelah refresh
        sessionStorage.setItem('notifMuncul', JSON.stringify(sudahMunculNotifIds));
    })
    .catch(() => {});
}

function tampilToast(judul, pesan) {
    // Buat container toast kalau belum ada
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.style.cssText = `
            position: fixed; bottom: 24px; right: 24px;
            z-index: 9999; display: flex; flex-direction: column; gap: 10px;
        `;
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.style.cssText = `
        background: white; border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        padding: 0; overflow: hidden; min-width: 300px; max-width: 360px;
        animation: slideInToast 0.4s ease;
        border-left: 5px solid #4e73df;
    `;
    toast.innerHTML = `
        <div style="background:#4e73df; padding:10px 16px; display:flex; align-items:center; gap:10px;">
            <i class="fas fa-bullhorn" style="color:white; font-size:1rem;"></i>
            <span style="color:white; font-weight:700; font-size:0.9rem; flex:1;">${judul}</span>
            <span onclick="this.closest('[data-toast]').remove()"
                  style="color:rgba(255,255,255,0.7); cursor:pointer; font-size:1.1rem; line-height:1;">&times;</span>
        </div>
        <div style="padding:12px 16px;">
            <p style="margin:0; font-size:0.85rem; color:#444; line-height:1.5;">${pesan}</p>
            <div style="margin-top:10px; display:flex; gap:8px;">
                <button onclick="this.closest('[data-toast]').remove()"
                        style="flex:1; padding:6px; border:1.5px solid #4e73df; border-radius:8px;
                               background:white; color:#4e73df; font-size:0.8rem; cursor:pointer; font-weight:600;">
                    Tutup
                </button>
            </div>
        </div>
    `;
    toast.setAttribute('data-toast', '1');
    container.appendChild(toast);

    // Auto close setelah 10 detik
    setTimeout(() => {
        toast.style.animation = 'fadeOutToast 0.4s ease forwards';
        setTimeout(() => toast.remove(), 400);
    }, 10000);
}

// CSS animasi toast
if (!document.getElementById('toast-style')) {
    const style = document.createElement('style');
    style.id = 'toast-style';
    style.textContent = `
        @keyframes slideInToast {
            from { opacity:0; transform: translateX(60px); }
            to   { opacity:1; transform: translateX(0); }
        }
        @keyframes fadeOutToast {
            from { opacity:1; transform: translateX(0); }
            to   { opacity:0; transform: translateX(60px); }
        }
    `;
    document.head.appendChild(style);
}

// Load pertama kali saat halaman dibuka
refreshAntrianRealtime();
refreshPosisiSaya();
cekNotifikasiDipanggil();

// Polling gabungan setiap 5 detik
setInterval(() => {
    refreshAntrianRealtime();
    refreshPosisiSaya();
    cekNotifikasiDipanggil();
}, 5000);
</script>
<script>
    function confirmLogout(event) {
        event.preventDefault();
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
</body>
</body>
</html>