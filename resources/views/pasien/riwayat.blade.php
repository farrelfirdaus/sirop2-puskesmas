<!DOCTYPE html>
<html lang="id">
<head>
    <title>Riwayat Kunjungan — SIROP</title>
    @include('pasien.partials.head')
</head>
<body id="page-top">
<div id="wrapper">

    @include('pasien.partials.sidebar')

    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            @include('pasien.partials.navbar')

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

                        <div class="mb-3" style="max-width: 420px;">
                            <div style="display:flex; border: 1.5px solid #dee2e6; border-radius: 10px; overflow:hidden; background:white;">
                                <input type="text" id="searchInput"
                                    style="flex:1; border:none; outline:none; padding: 10px 16px; font-size:0.95rem; color:#6c757d; background:transparent;"
                                    placeholder="Search for...">
                                <button style="background:#4e73df; border:none; padding: 10px 18px; cursor:pointer;">
                                    <i class="fas fa-search" style="color:white; font-size:0.9rem"></i>
                                </button>
                            </div>
                        </div>

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
                                            <th>Tanggal</th>
                                            <th>Nama Pasien</th>
                                            <th>Poli</th>
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
                                            <td>{{ Str::limit($r->keluhan, 30) }}</td>
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
                                                    <span class="badge badge-danger">Dibatalkan</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($r->status == 'menunggu' && $r->tanggal_kunjungan > now()->toDateString())
                                                <form action="{{ route('pendaftaran.batal', $r->id) }}"
                                                     method="POST"
                                                        onsubmit="return confirm('Yakin mau batalkan antrian ini?')">
                                                 @csrf
                                                @method('PATCH')
                                                    <button type="submit" class="btn btn-danger btn-sm btn-block mb-1">
                                                    <i class="fas fa-times"></i> Batalkan
                                                    </button>
                                                </form>
                                                @elseif($r->status == 'menunggu' && $r->tanggal_kunjungan <= now()->toDateString())
                                                    <span class="text-muted small">Tidak bisa dibatalkan</span>
                                                @else
                                                    <span class="text-muted small">-</span>
                                                @endif

                                                @if($r->status != 'batal')
                                                @php
                                                    $tglMulai = \Carbon\Carbon::parse($r->tanggal_kunjungan)->format('Ymd');
                                                    $tglSelesai = \Carbon\Carbon::parse($r->tanggal_kunjungan)->addDay()->format('Ymd');
                                                    $judul = urlencode('Kunjungan ' . $r->poli . ' - SIROP Puskesmas');
                                                    $detail = urlencode('No. Antrian: ' . $r->nomor_antrian . '\nKeluhan: ' . $r->keluhan);
                                                    $gcalUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text={$judul}&dates={$tglMulai}/{$tglSelesai}&details={$detail}";
                                                @endphp
                                                    <a href="{{ $gcalUrl }}" target="_blank" 
                                                        class="btn btn-success btn-sm btn-block mb-1">
                                                    <i class="fas fa-calendar-plus"></i> Google Calendar
                                                    </a>
                                                    <a href="{{ route('pendaftaran.cetak', $r->id) }}"
                                                        target="_blank" 
                                                        class="btn btn-secondary btn-sm btn-block">
                                                    <i class="fas fa-print"></i> Cetak Antrian
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

<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
        });
    });

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
</html>