<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Dokter — SIROP</title>
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
</head>
<body id="page-top">
<div id="wrapper">

    {{-- Sidebar --}}
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('pasien.dashboard') }}">
            <div class="sidebar-brand-icon"><i class="fas fa-hospital"></i></div>
            <div class="sidebar-brand-text mx-3">SIROP</div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item"><a class="nav-link" href="{{ route('pasien.dashboard') }}"><i class="fas fa-fw fa-home"></i><span>Beranda</span></a></li>
        <li class="nav-item active"><a class="nav-link" href="{{ route('pasien.jadwal') }}"><i class="fas fa-fw fa-calendar"></i><span>Jadwal Dokter</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('pendaftaran.create') }}"><i class="fas fa-fw fa-plus-circle"></i><span>Daftar Antrian</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('pendaftaran.riwayat') }}"><i class="fas fa-fw fa-history"></i><span>Riwayat Kunjungan</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('profil.edit') }}"><i class="fas fa-fw fa-user"></i><span>Profil Saya</span></a></li>
        <hr class="sidebar-divider">
        <li class="nav-item">
            <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-fw fa-sign-out-alt"></i><span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
        </li>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                <span class="navbar-text ml-auto">Halo, <strong>{{ auth()->user()->name }}</strong>! 👋</span>
            </nav>

            <div class="container-fluid">
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Jadwal Dokter</h1>
                    <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Daftar Antrian
                    </a>
                </div>

                <div class="row">
                    @forelse($dokter as $d)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card shadow h-100">
                            <div class="card-header bg-primary text-white">
                                <h6 class="m-0 font-weight-bold">{{ $d->nama }}</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td><i class="fas fa-stethoscope text-primary"></i></td>
                                        <td><strong>Spesialisasi</strong></td>
                                        <td>{{ $d->spesialisasi }}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-calendar text-success"></i></td>
                                        <td><strong>Hari Praktik</strong></td>
                                        <td>{{ $d->hari_praktik }}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-clock text-warning"></i></td>
                                        <td><strong>Jam Praktik</strong></td>
                                        <td>{{ $d->jam_praktik }}</td>
                                    </tr>
                                    <tr>
                                        <td><i class="fas fa-users text-info"></i></td>
                                        <td><strong>Kuota/Hari</strong></td>
                                        <td>{{ $d->kuota_per_hari }} Pasien</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('pendaftaran.create') }}?dokter_id={{ $d->id }}"
                                    class="btn btn-success btn-sm btn-block">
                                    <i class="fas fa-plus"></i> Daftar ke Dokter Ini
                                </a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            Belum ada jadwal dokter yang tersedia saat ini.
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>
</html>