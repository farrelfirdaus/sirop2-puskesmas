@extends('layouts.app')

@section('title', 'Tambah Pasien')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Tambah Data Pasien</h1>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Tambah Pasien</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pasien.store') }}" method="POST">
            @csrf
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">NIK</label>
                <div class="col-sm-9">
                    <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tempat Lahir</label>
                <div class="col-sm-9">
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-9">
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Alamat</label>
                <div class="col-sm-9">
                    <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">No. HP</label>
                <div class="col-sm-9">
                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Agama</label>
                <div class="col-sm-9">
                    <select name="agama" class="form-control" required>
                        <option value="">-- Pilih Agama --</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Budha">Budha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                <div class="col-sm-9">
                    <select name="pendidikan_terakhir" class="form-control" required>
                        <option value="">-- Pilih Pendidikan --</option>
                        <option value="SD">SD</option>
                        <option value="SMP">SMP</option>
                        <option value="SMA">SMA</option>
                        <option value="D3">D3</option>
                        <option value="S1">S1</option>
                        <option value="S2">S2</option>
                        <option value="S3">S3</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Pekerjaan</label>
                <div class="col-sm-9">
                    <input type="text" name="pekerjaan" class="form-control" value="{{ old('pekerjaan') }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Golongan Darah</label>
                <div class="col-sm-9">
                    <select name="golongan_darah" class="form-control" required>
                        <option value="">-- Pilih Golongan Darah --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('pasien.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection