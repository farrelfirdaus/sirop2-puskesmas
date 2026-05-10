@extends('layouts.app')

@section('title', 'Tambah Dokter')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Dokter</h1>
    <a href="{{ route('dokter.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-body">
        <form method="POST" action="{{ route('dokter.store') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Dokter</label>
                        <input type="text" name="nama" class="form-control"
                            value="{{ old('nama') }}" placeholder="contoh: dr. Siti Aminah" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Spesialisasi / Poli</label>
                        <input type="text" name="spesialisasi" class="form-control"
                            value="{{ old('spesialisasi') }}" placeholder="contoh: Poli Umum" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Hari Praktik</label>
                        <input type="text" name="hari_praktik" class="form-control"
                            value="{{ old('hari_praktik') }}"
                            placeholder="contoh: Senin, Rabu, Jumat" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jam Praktik</label>
                        <input type="text" name="jam_praktik" class="form-control"
                            value="{{ old('jam_praktik') }}"
                            placeholder="contoh: 08:00 - 12:00" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kuota Per Hari</label>
                        <input type="number" name="kuota_per_hari" class="form-control"
                            value="{{ old('kuota_per_hari', 20) }}" min="1" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak aktif" {{ old('status') == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan
            </button>
        </form>
    </div>
</div>
@endsection