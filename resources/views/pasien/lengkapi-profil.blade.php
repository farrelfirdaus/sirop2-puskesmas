<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Profil — SIROP</title>
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-gradient-primary">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center mb-4">
                            <h1 class="h4 text-gray-900 font-weight-bold">Lengkapi Data Diri</h1>
                            <p class="text-muted">Harap lengkapi data diri kamu sebelum menggunakan layanan</p>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profil.simpan') }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input type="text" name="nik" class="form-control"
                                            value="{{ old('nik') }}" placeholder="16 digit NIK" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No. HP</label>
                                        <input type="text" name="no_hp" class="form-control"
                                            value="{{ old('no_hp') }}" placeholder="No. HP aktif" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" class="form-control"
                                            value="{{ old('tempat_lahir') }}" placeholder="Tempat lahir" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control"
                                            value="{{ old('tanggal_lahir') }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="3"
                                    placeholder="Alamat lengkap" required>{{ old('alamat') }}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Agama</label>
                                        <select name="agama" class="form-control" required>
                                            <option value="">-- Pilih Agama --</option>
                                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                                                <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>
                                                    {{ $agama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Golongan Darah</label>
                                        <select name="golongan_darah" class="form-control" required>
                                            <option value="">-- Pilih --</option>
                                            @foreach(['A','B','AB','O'] as $gd)
                                                <option value="{{ $gd }}" {{ old('golongan_darah') == $gd ? 'selected' : '' }}>
                                                    {{ $gd }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pendidikan Terakhir</label>
                                        <select name="pendidikan_terakhir" class="form-control" required>
                                            <option value="">-- Pilih --</option>
                                            @foreach(['SD','SMP','SMA/SMK','D3','S1','S2','S3','Lainnya'] as $p)
                                                <option value="{{ $p }}" {{ old('pendidikan_terakhir') == $p ? 'selected' : '' }}>
                                                    {{ $p }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pekerjaan</label>
                                        <input type="text" name="pekerjaan" class="form-control"
                                            value="{{ old('pekerjaan') }}" placeholder="Pekerjaan" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">
                                Simpan & Lanjutkan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>