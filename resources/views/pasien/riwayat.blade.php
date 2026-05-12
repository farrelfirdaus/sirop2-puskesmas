<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Kunjungan — SIROP</title>
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
        <li class="nav-item"><a class="nav-link" href="{{ route('pasien.jadwal') }}"><i class="fas fa-fw fa-calendar"></i><span>Jadwal Dokter</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('pendaftaran.create') }}"><i class="fas fa-fw fa-plus-circle"></i><span>Daftar Antrian</span></a></li>
        <li class="nav-item active"><a class="nav-link" href="{{ route('pendaftaran.riwayat') }}"><i class="fas fa-fw fa-history"></i><span>Riwayat Kunjungan</span></a></li>
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
                    <h1 class="h3 mb-0 text-gray-800">Riwayat Kunjungan</h1>
                    <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Daftar Antrian Baru
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card shadow mb-4">
                    <div class="card-body">
                        @if($riwayat->isEmpty())
                            <div class="text-center py-5">
                                <i class="fas fa-history fa-3x text-gray-300 mb-3"></i>
                                <p class="text-muted">Belum ada riwayat kunjungan.</p>
                                <a href="{{ route('pendaftaran.create') }}" class="btn btn-primary">
                                    Daftar Antrian Sekarang
                                </a>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Kunjungan</th>
                                            <th>Nama Pasien</th>
                                         
                                            <th>Spesialisasi</th>
                                            <th>No. Antrian</th>
                                            <th>Keluhan</th>
                                            <th>Untuk</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($riwayat as $i => $r)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($r->tanggal_kunjungan)->format('d M Y') }}</td>
                                            <td>{{ $r->nama_pasien }}</td>
                                            <td>{{ $r->poli }}</td>
                                            <td>
                                                <span class="badge badge-primary" style="font-size:1em">
                                                    No. {{ $r->nomor_antrian }}
                                                </span>
                                            </td>
                                            <td>{{ Str::limit($r->keluhan, 50) }}</td>
                                            <td>
                                                @if($r->untuk == 'diri_sendiri')
                                                    <span class="badge badge-info">Diri Sendiri</span>
                                                @else
                                                    <span class="badge badge-secondary">Orang Lain</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($r->status == 'menunggu')
                                                    <span class="badge badge-warning">Menunggu</span>
                                                @elseif($r->status == 'selesai')
                                                    <span class="badge badge-success">Selesai</span>
                                                @else
                                                    <span class="badge badge-danger">Batal</span>
                                                @endif
                                            </td>
                                            <td>
    @if($r->status == 'menunggu' && $r->tanggal_kunjungan > now()->toDateString())
        <form action="{{ route('pendaftaran.batal', $r->id) }}" 
            method="POST" class="d-inline"
            onsubmit="return confirm('Yakin mau batalkan antrian ini?')">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fas fa-times"></i> Batalkan
            </button>
        </form>
    @elseif($r->status == 'menunggu' && $r->tanggal_kunjungan <= now()->toDateString())
        <span class="text-muted small">Tidak bisa dibatalkan</span>
    @else
        <span class="text-muted small">-</span>
    @endif

    {{-- Tombol Google Calendar --}}
    @if($r->status != 'batal')
        @php
            $tglMulai = \Carbon\Carbon::parse($r->tanggal_kunjungan)->format('Ymd');
            $tglSelesai = \Carbon\Carbon::parse($r->tanggal_kunjungan)->addDay()->format('Ymd');
            $judul = urlencode('Kunjungan ' . $r->poli . ' - SIROP Puskesmas');
            $detail = urlencode('No. Antrian: ' . $r->nomor_antrian . '\nKeluhan: ' . $r->keluhan);
            $gcalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$judul}&dates={$tglMulai}/{$tglSelesai}&details={$detail}";
        @endphp
        <a href="{{ $gcalUrl }}" target="_blank" class="btn btn-success btn-sm mt-1">
            <i class="fas fa-calendar-plus"></i> Google Calendar
        </a>
    @endif
    {{-- Tombol Cetak PDF --}}
@if($r->status != 'batal')
    <a href="{{ route('pendaftaran.cetak', $r->id) }}" 
        target="_blank" class="btn btn-primary btn-sm mt-1">
        <i class="fas fa-print"></i> Cetak
    </a>
@endif
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
    </div>
</div>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>
</html>