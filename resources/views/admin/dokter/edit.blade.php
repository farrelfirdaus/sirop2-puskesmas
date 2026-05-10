@extends('layouts.app')

@section('title', 'Edit Dokter')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Dokter</h1>
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
        <form method="POST" action="{{ route('dokter.update', $dokter->id) }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nama Dokter</label>
                        <input type="text" name="nama" class="form-control"
                            value="{{ old('nama', $dokter->nama) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Spesialisasi / Poli</label>
                        <input type="text" name="spesialisasi" class="form-control"
                            value="{{ old('spesialisasi', $dokter->spesialisasi) }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Hari Praktik</label>
                        <input type="text" name="hari_praktik" class="form-control"
                            value="{{ old('hari_praktik', $dokter->hari_praktik) }}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jam Praktik</label>
                        <input type="text" name="jam_praktik" class="form-control"
                            value="{{ old('jam_praktik', $dokter->jam_praktik) }}" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kuota Per Hari</label>
                        <input type="number" name="kuota_per_hari" class="form-control"
                            value="{{ old('kuota_per_hari', $dokter->kuota_per_hari) }}" min="1" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="aktif" {{ old('status', $dokter->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak aktif" {{ old('status', $dokter->status) == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update
            </button>
        </form>
    </div>
</div>
@endsection