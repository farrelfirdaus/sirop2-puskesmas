<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya — SIROP</title>
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
        <li class="nav-item"><a class="nav-link" href="{{ route('pendaftaran.riwayat') }}"><i class="fas fa-fw fa-history"></i><span>Riwayat Kunjungan</span></a></li>
        <li class="nav-item active"><a class="nav-link" href="{{ route('profil.edit') }}"><i class="fas fa-fw fa-user"></i><span>Profil Saya</span></a></li>
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
                    <h1 class="h3 mb-0 text-gray-800">Profil Saya</h1>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Diri</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('profil.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama Lengkap</label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->name }}" disabled>
                                        <small class="text-muted">Nama tidak bisa diubah</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" class="form-control"
                                            value="{{ $user->email }}" disabled>
                                        <small class="text-muted">Email tidak bisa diubah</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input type="text" name="nik" class="form-control"
                                            value="{{ old('nik', $user->nik) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>No. HP</label>
                                        <input type="text" name="no_hp" class="form-control"
                                            value="{{ old('no_hp', $user->no_hp) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" class="form-control"
                                            value="{{ old('tempat_lahir', $user->tempat_lahir) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir" class="form-control"
                                            value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Alamat Lengkap</label>
                                <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $user->alamat) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Agama</label>
                                        <select name="agama" class="form-control" required>
                                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                                                <option value="{{ $agama }}"
                                                    {{ old('agama', $user->agama) == $agama ? 'selected' : '' }}>
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
                                            @foreach(['A','B','AB','O'] as $gd)
                                                <option value="{{ $gd }}"
                                                    {{ old('golongan_darah', $user->golongan_darah) == $gd ? 'selected' : '' }}>
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
                                            @foreach(['SD','SMP','SMA/SMK','D3','S1','S2','S3','Lainnya'] as $p)
                                                <option value="{{ $p }}"
                                                    {{ old('pendidikan_terakhir', $user->pendidikan_terakhir) == $p ? 'selected' : '' }}>
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
                                            value="{{ old('pekerjaan', $user->pekerjaan) }}" required>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</body>
</html>