@extends('layouts.app')

@section('title', 'Kelola Dokter')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Kelola Dokter</h1>
    <a href="{{ route('dokter.create') }}" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Dokter
    </a>
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
                        <th>Nama Dokter</th>
                        <th>Spesialisasi</th>
                        <th>Hari Praktik</th>
                        <th>Jam Praktik</th>
                        <th>Kuota/Hari</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dokter as $i => $d)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->spesialisasi }}</td>
                        <td>{{ $d->hari_praktik }}</td>
                        <td>{{ $d->jam_praktik }}</td>
                        <td>{{ $d->kuota_per_hari }} pasien</td>
                        <td>
                            @if($d->status == 'aktif')
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('dokter.edit', $d->id) }}"
                                class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('dokter.destroy', $d->id) }}"
                                method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin hapus dokter ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Belum ada data dokter.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection