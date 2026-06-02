@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <span class="text-muted small">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
</div>

{{-- ── Summary Cards ── --}}
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Antrian Hari Ini</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalHariIni }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-calendar-day fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Menunggu</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalMenunggu }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-hourglass-half fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Sedang Dipanggil</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDipanggil }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-bell fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai Dilayani</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalSelesai }}</div>
                    </div>
                    <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Baris 2: Grafik per poli + Pie status ── --}}
<div class="row">
    {{-- Grafik 7 hari breakdown per poli --}}
    <div class="col-xl-8 col-lg-7 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Kunjungan 7 Hari Terakhir (per Poli)</h6>
            </div>
            <div class="card-body">
                <canvas id="grafikPerPoli" height="100"></canvas>
            </div>
        </div>
    </div>

    {{-- Pie chart status hari ini --}}
    <div class="col-xl-4 col-lg-5 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Status Antrian Hari Ini</h6>
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <canvas id="pieStatus" style="max-height:200px"></canvas>
                <div class="mt-3 w-100">
                    <div class="d-flex justify-content-between small mb-1">
                        <span><span class="badge" style="background:#f6c23e">&nbsp;</span> Menunggu</span>
                        <strong>{{ $statusHariIni['menunggu'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between small mb-1">
                        <span><span class="badge" style="background:#36b9cc">&nbsp;</span> Dipanggil</span>
                        <strong>{{ $statusHariIni['dipanggil'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between small mb-1">
                        <span><span class="badge" style="background:#1cc88a">&nbsp;</span> Selesai</span>
                        <strong>{{ $statusHariIni['selesai'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between small">
                        <span><span class="badge" style="background:#e74a3b">&nbsp;</span> Batal</span>
                        <strong>{{ $statusHariIni['batal'] }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ── Baris 3: Antrian per poli + Dokter hari ini ── --}}
<div class="row">
    {{-- Antrian per poli --}}
    <div class="col-xl-5 col-lg-5 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Antrian Aktif Per Poli</h6>
            </div>
            <div class="card-body">
                @foreach(['Poli Umum' => 'primary', 'Poli Gigi' => 'info', 'Poli KIA' => 'success'] as $poli => $warna)
                @php $ap = $antrianPerPoli[$poli]; @endphp
                <div class="d-flex align-items-center justify-content-between mb-3 p-3 rounded"
                     style="background:#f8f9fc; border-left:4px solid var(--bs-{{ $warna }}, #4e73df)">
                    <div>
                        <div class="font-weight-bold text-gray-800 mb-1">{{ $poli }}</div>
                        <div class="small text-muted">
                            @if($ap['nomor_dipanggil'])
                                <span class="text-info font-weight-bold">🔔 No. {{ str_pad($ap['nomor_dipanggil'], 3, '0', STR_PAD_LEFT) }} dipanggil</span>
                            @else
                                <span>Belum ada dipanggil</span>
                            @endif
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="small">
                            <span class="text-warning font-weight-bold">{{ $ap['menunggu'] }}</span>
                            <span class="text-muted"> menunggu</span>
                        </div>
                        <div class="small">
                            <span class="text-success font-weight-bold">{{ $ap['selesai'] }}</span>
                            <span class="text-muted"> selesai</span>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="text-center mt-2">
                    <a href="{{ route('antrian.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-tasks mr-1"></i> Kelola Antrian
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Dokter aktif hari ini --}}
    <div class="col-xl-7 col-lg-7 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    Dokter Bertugas Hari Ini
                    <span class="badge badge-primary ml-1">{{ $dokterHariIni->count() }}</span>
                </h6>
                <a href="{{ route('dokter.index') }}" class="btn btn-sm btn-outline-primary">Kelola Dokter</a>
            </div>
            <div class="card-body p-0">
                @if($dokterHariIni->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-user-md fa-3x mb-3 text-gray-300"></i>
                        <p>Tidak ada dokter terjadwal hari ini.</p>
                    </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th class="small">Dokter</th>
                                <th class="small">Poli</th>
                                <th class="small">Jam</th>
                                <th class="small text-center">Pasien</th>
                                <th class="small text-center">Kuota</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dokterHariIni as $dok)
                            @php
                                $persen = $dok->kuota_per_hari > 0
                                    ? round(($dok->pasien_hari_ini / $dok->kuota_per_hari) * 100)
                                    : 0;
                                $barWarna = $persen >= 90 ? 'danger' : ($persen >= 60 ? 'warning' : 'success');
                            @endphp
                            <tr>
                                <td class="align-middle">
                                    <div class="font-weight-bold text-gray-800 small">{{ $dok->nama }}</div>
                                </td>
                                <td class="align-middle small text-muted">{{ $dok->spesialisasi }}</td>
                                <td class="align-middle small text-muted">{{ $dok->jam_praktik }}</td>
                                <td class="align-middle text-center">
                                    <span class="font-weight-bold text-gray-800">{{ $dok->pasien_hari_ini }}</span>
                                </td>
                                <td class="align-middle" style="min-width:100px">
                                    <div class="d-flex align-items-center">
                                        <div class="progress flex-grow-1 mr-2" style="height:8px">
                                            <div class="progress-bar bg-{{ $barWarna }}"
                                                 style="width:{{ min($persen,100) }}%"></div>
                                        </div>
                                        <small class="text-muted" style="white-space:nowrap">
                                            {{ $dok->pasien_hari_ini }}/{{ $dok->kuota_per_hari }}
                                        </small>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// ── Grafik per poli ──────────────────────────────────────────
const labels = {!! json_encode($labels) !!};
new Chart(document.getElementById('grafikPerPoli'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Poli Umum',
                data: {!! json_encode($grafikPerPoli['Poli Umum']) !!},
                backgroundColor: 'rgba(78,115,223,0.7)',
                borderColor: 'rgba(78,115,223,1)',
                borderWidth: 1,
                borderRadius: 4,
            },
            {
                label: 'Poli Gigi',
                data: {!! json_encode($grafikPerPoli['Poli Gigi']) !!},
                backgroundColor: 'rgba(54,185,204,0.7)',
                borderColor: 'rgba(54,185,204,1)',
                borderWidth: 1,
                borderRadius: 4,
            },
            {
                label: 'Poli KIA',
                data: {!! json_encode($grafikPerPoli['Poli KIA']) !!},
                backgroundColor: 'rgba(28,200,138,0.7)',
                borderColor: 'rgba(28,200,138,1)',
                borderWidth: 1,
                borderRadius: 4,
            },
        ]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'top' } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } },
            x: { stacked: false }
        }
    }
});

// ── Pie status hari ini ──────────────────────────────────────
new Chart(document.getElementById('pieStatus'), {
    type: 'doughnut',
    data: {
        labels: ['Menunggu', 'Dipanggil', 'Selesai', 'Batal'],
        datasets: [{
            data: [
                {{ $statusHariIni['menunggu'] }},
                {{ $statusHariIni['dipanggil'] }},
                {{ $statusHariIni['selesai'] }},
                {{ $statusHariIni['batal'] }}
            ],
            backgroundColor: ['#f6c23e','#36b9cc','#1cc88a','#e74a3b'],
            borderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        cutout: '65%',
        plugins: { legend: { display: false } }
    }
});
</script>
@endpush

@endsection