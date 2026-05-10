<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Pasien — SIROP</title>
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
                <span class="navbar-text ml-auto">
                    Halo, <strong>{{ auth()->user()->name }}</strong>! 👋
                </span>
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

                {{-- Riwayat Terakhir --}}
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
                                            <th>Dokter</th>
                                            <th>No. Antrian</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($riwayat as $r)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($r->tanggal_kunjungan)->format('d M Y') }}</td>
                                            <td>{{ $r->dokter->nama }}</td>
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
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>
</html>