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