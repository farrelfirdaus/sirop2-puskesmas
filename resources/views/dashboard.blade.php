@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Kunjungan (Hari)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kunjunganHariIni }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-notes-medical fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Pasien Terdaftar</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalPasien }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pasien Baru (Hari)</div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $totalKunjungan }}</div>
                            </div>
                            <div class="col">
                                <div class="progress progress-sm mr-2">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 40%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Antrian Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $kunjunganBulanIni }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Kunjungan Mingguan</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Antrian Saat Ini</h6>
            </div>
           <div class="card-body">
    {{-- Tab Poli --}}
    <div style="display:flex; gap:8px; margin-bottom:20px">
        <button onclick="gantiTabAdmin('Poli Umum', this)" id="admin-tab-poli-umum"
            style="flex:1; padding:8px; border:none; border-radius:8px;
            background:#4e73df; color:white; cursor:pointer; font-weight:bold; font-size:0.75rem">
            Poli Umum
        </button>
        <button onclick="gantiTabAdmin('Poli Gigi', this)" id="admin-tab-poli-gigi"
            style="flex:1; padding:8px; border:none; border-radius:8px;
            background:#e0e0e0; color:#666; cursor:pointer; font-weight:bold; font-size:0.75rem">
            Poli Gigi
        </button>
        <button onclick="gantiTabAdmin('Poli KIA', this)" id="admin-tab-poli-kia"
            style="flex:1; padding:8px; border:none; border-radius:8px;
            background:#e0e0e0; color:#666; cursor:pointer; font-weight:bold; font-size:0.75rem">
            Poli KIA
        </button>
    </div>
    <div class="text-center">
        <h1 class="display-4 font-weight-bold text-primary">
            No. <span id="admin-angka-antrian">{{ $antrianPerPoli['Poli Umum']['sedang'] ?: '-' }}</span>
        </h1>
        <p class="text-muted" id="admin-label-poli">Poli Umum — {{ now()->format('d M Y') }}</p>
        <hr>
        <div style="display:flex; justify-content:space-around; padding:0 20px">
            <div>
                <h5 class="text-success" id="admin-sudah-dilayani">
                    {{ $antrianPerPoli['Poli Umum']['sedang'] }}
                </h5>
                <small>Sudah Dilayani</small>
            </div>
            <div>
                <h5 class="text-danger" id="admin-menunggu-count">
                    {{ $antrianPerPoli['Poli Umum']['menunggu'] }}
                </h5>
                <small>Menunggu</small>
            </div>
        </div>
    </div>
</div>
</div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('myAreaChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($grafik, 'hari')) !!},
            datasets: [{
                label: 'Kunjungan',
                data: {!! json_encode(array_column($grafik, 'jumlah')) !!},
                backgroundColor: 'rgba(78, 115, 223, 0.7)',
                borderColor: 'rgba(78, 115, 223, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
</script>
<script>
// Antrian per poli admin
let adminPoliAktif = 'Poli Umum';
let adminAntrianData = {
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

function gantiTabAdmin(poli, btn) {
    adminPoliAktif = poli;
    document.querySelectorAll('[id^="admin-tab-"]').forEach(b => {
        b.style.background = '#e0e0e0';
        b.style.color = '#666';
    });
    btn.style.background = '#4e73df';
    btn.style.color = 'white';

    const data = adminAntrianData[poli];
    document.getElementById('admin-angka-antrian').innerText = data.sedang > 0 ? data.sedang : '-';
    document.getElementById('admin-label-poli').innerText = poli + ' — {{ now()->format("d M Y") }}';
    document.getElementById('admin-sudah-dilayani').innerText = data.sedang;
    document.getElementById('admin-menunggu-count').innerText = data.menunggu;
}

function refreshAdminAntrian() {
    fetch('/api/antrian-realtime')
        .then(r => r.json())
        .then(data => {
            adminAntrianData = data;
            const d = data[adminPoliAktif];
            document.getElementById('admin-angka-antrian').innerText = d.sedang > 0 ? d.sedang : '-';
            document.getElementById('admin-sudah-dilayani').innerText = d.sedang;
            document.getElementById('admin-menunggu-count').innerText = d.menunggu;
        });
}

setInterval(refreshAdminAntrian, 10000);
</script>
@endpush

@endsection

@push('scripts')
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('js/demo/statistikkunjungan.js') }}"></script>
@endpush