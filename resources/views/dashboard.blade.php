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
            <div class="card-body text-center">
                <h1 class="display-4 font-weight-bold text-primary">A-013</h1>
                <p class="mb-2">Nomor Antrian Saat Ini</p>
                <hr>
                <div class="d-flex justify-content-between px-4">
                    <div>
                        <h5 class="text-success">10</h5>
                        <small>Sudah Dilayani</small>
                    </div>
                    <div>
                        <h5 class="text-danger">5</h5>
                        <small>Menunggu</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('js/demo/statistikkunjungan.js') }}"></script>
@endpush