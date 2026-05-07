@extends('layouts.app')

@section('title', 'Edit Pasien')

@section('content')

<h1 class="h3 mb-4 text-gray-800">Edit Data Pasien</h1>

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
        <h6 class="m-0 font-weight-bold text-primary">Form Edit Pasien</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('pasien.update', $pasien->nik) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">NIK</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" value="{{ $pasien->nik }}" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Nama</label>
                <div class="col-sm-9">
                    <input type="text" name="nama" class="form-control" value="{{ $pasien->nama }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tempat Lahir</label>
                <div class="col-sm-9">
                    <input type="text" name="tempat_lahir" class="form-control" value="{{ $pasien->tempat_lahir }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tanggal Lahir</label>
                <div class="col-sm-9">
                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ $pasien->tanggal_lahir }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Alamat</label>
                <div class="col-sm-9">
                    <textarea name="alamat" class="form-control" rows="3" required>{{ $pasien->alamat }}</textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">No. HP</label>
                <div class="col-sm-9">
                    <input type="text" name="no_hp" class="form-control" value="{{ $pasien->no_hp }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Agama</label>
                <div class="col-sm-9">
                    <select name="agama" class="form-control" required>
                        @foreach(['Islam','Kristen','Katolik','Hindu','Budha','Konghucu'] as $agama)
                            <option value="{{ $agama }}" {{ $pasien->agama == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Pendidikan Terakhir</label>
                <div class="col-sm-9">
                    <select name="pendidikan_terakhir" class="form-control" required>
                        @foreach(['SD','SMP','SMA','D3','S1','S2','S3'] as $pendidikan)
                            <option value="{{ $pendidikan }}" {{ $pasien->pendidikan_terakhir == $pendidikan ? 'selected' : '' }}>{{ $pendidikan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Pekerjaan</label>
                <div class="col-sm-9">
                    <input type="text" name="pekerjaan" class="form-control" value="{{ $pasien->pekerjaan }}" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Golongan Darah</label>
                <div class="col-sm-9">
                    <select name="golongan_darah" class="form-control" required>
                        @foreach(['A','B','AB','O'] as $gol)
                            <option value="{{ $gol }}" {{ $pasien->golongan_darah == $gol ? 'selected' : '' }}>{{ $gol }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-9 offset-sm-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('pasien.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection