@extends('layouts.app')

@section('title', 'Kelola Pendaftaran')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Pendaftaran Pasien</h1>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Nama Pasien</th>
                        <th>NIK</th>
                        <th>Dokter</th>
                        <th>No. Antrian</th>
                        <th>Keluhan</th>
                        <th>Untuk</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendaftaran as $i => $p)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_kunjungan)->format('d M Y') }}</td>
                        <td>{{ $p->nama_pasien }}</td>
                        <td>{{ $p->nik_pasien }}</td>
                        <td>{{ $p->poli }}</td>
                        <td>
                            <span class="badge badge-primary" style="font-size:1em">
                                No. {{ $p->nomor_antrian }}
                            </span>
                        </td>
                        <td>{{ Str::limit($p->keluhan, 40) }}</td>
                        <td>
                            @if($p->untuk == 'diri_sendiri')
                                <span class="badge badge-info">Diri Sendiri</span>
                            @else
                                <span class="badge badge-secondary">Orang Lain</span>
                            @endif
                        </td>
                        <td>
                            @if($p->status == 'menunggu')
                                <span class="badge badge-warning">Menunggu</span>
                            @elseif($p->status == 'selesai')
                                <span class="badge badge-success">Selesai</span>
                            @else
                                <span class="badge badge-danger">Batal</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('pendaftaran.updateStatus', $p->id) }}"
                                method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-control form-control-sm d-inline"
                                    style="width:auto"
                                    onchange="this.form.submit()">
                                    <option value="menunggu" {{ $p->status == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="selesai" {{ $p->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="batal" {{ $p->status == 'batal' ? 'selected' : '' }}>Batal</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-muted">
                            Belum ada data pendaftaran.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script>
// Auto refresh halaman setiap 30 detik
setInterval(function() {
    fetch(window.location.href)
        .then(r => r.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const tabelBaru = doc.querySelector('tbody');
            const tabelLama = document.querySelector('tbody');
            if (tabelBaru && tabelLama) {
                tabelLama.innerHTML = tabelBaru.innerHTML;
            }
        });
}, 10000); // setiap 10 detik
</script>
@endpush
@endsection