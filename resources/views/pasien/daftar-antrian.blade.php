<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Antrian — SIROP</title>
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
        <li class="nav-item active"><a class="nav-link" href="{{ route('pendaftaran.create') }}"><i class="fas fa-fw fa-plus-circle"></i><span>Daftar Antrian</span></a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('pendaftaran.riwayat') }}"><i class="fas fa-fw fa-history"></i><span>Riwayat Kunjungan</span></a></li>
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
                    <h1 class="h3 mb-0 text-gray-800">Daftar Antrian</h1>
                </div>

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
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
                        <h6 class="m-0 font-weight-bold text-primary">Form Pendaftaran Antrian</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pendaftaran.store') }}">
                            @csrf

                            {{-- Untuk siapa --}}
                            <div class="form-group">
                                <label class="font-weight-bold">Pendaftaran Untuk:</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="untuk"
                                            id="diri_sendiri" value="diri_sendiri"
                                            {{ old('untuk', 'diri_sendiri') == 'diri_sendiri' ? 'checked' : '' }}
                                            onchange="toggleForm(this.value)">
                                        <label class="form-check-label" for="diri_sendiri">Diri Sendiri</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="untuk"
                                            id="orang_lain" value="orang_lain"
                                            {{ old('untuk') == 'orang_lain' ? 'checked' : '' }}
                                            onchange="toggleForm(this.value)">
                                        <label class="form-check-label" for="orang_lain">Orang Lain</label>
                                    </div>
                                </div>
                            </div>

                            {{-- Data Pasien --}}
                            <div class="card mb-4" id="card-data-pasien">
                                <div class="card-header bg-light">
                                    <h6 class="m-0 font-weight-bold text-secondary" id="label-data-pasien">
                                        Data Pasien
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Lengkap</label>
                                                <input type="text" name="nama_pasien" class="form-control"
                                                    id="input_nama" value="{{ old('nama_pasien') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>NIK</label>
                                                <input type="text" name="nik_pasien" class="form-control"
                                                    id="input_nik" value="{{ old('nik_pasien') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tempat Lahir</label>
                                                <input type="text" name="tempat_lahir" class="form-control"
                                                    id="input_tempat_lahir" value="{{ old('tempat_lahir') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Lahir</label>
                                                <input type="date" name="tanggal_lahir" class="form-control"
                                                    id="input_tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat</label>
                                        <textarea name="alamat" class="form-control" id="input_alamat"
                                            rows="2" required>{{ old('alamat') }}</textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>No. HP</label>
                                                <input type="text" name="no_hp" class="form-control"
                                                    id="input_no_hp" value="{{ old('no_hp') }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Golongan Darah</label>
                                                <select name="golongan_darah" class="form-control" id="input_golongan_darah" required>
                                                    <option value="">-- Pilih --</option>
                                                    @foreach(['A','B','AB','O'] as $gd)
                                                        <option value="{{ $gd }}" {{ old('golongan_darah') == $gd ? 'selected' : '' }}>{{ $gd }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Agama</label>
                                                <select name="agama" class="form-control" id="input_agama" required>
                                                    <option value="">-- Pilih --</option>
                                                    @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                                                        <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Pendidikan Terakhir</label>
                                                <select name="pendidikan_terakhir" class="form-control" id="input_pendidikan" required>
                                                    <option value="">-- Pilih --</option>
                                                    @foreach(['SD','SMP','SMA/SMK','D3','S1','S2','S3','Lainnya'] as $p)
                                                        <option value="{{ $p }}" {{ old('pendidikan_terakhir') == $p ? 'selected' : '' }}>{{ $p }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Pekerjaan</label>
                                                <input type="text" name="pekerjaan" class="form-control"
                                                    id="input_pekerjaan" value="{{ old('pekerjaan') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Pilih Poli & Jadwal --}}
<div class="card mb-4">
    <div class="card-header bg-light">
        <h6 class="m-0 font-weight-bold text-secondary">Pilih Poli & Jadwal</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Pilih Poli</label>
                    <select name="poli" class="form-control" required>
                        <option value="">-- Pilih Poli --</option>
                        <option value="Poli Umum" {{ old('poli') == 'Poli Umum' ? 'selected' : '' }}>Poli Umum</option>
                        <option value="Poli Gigi" {{ old('poli') == 'Poli Gigi' ? 'selected' : '' }}>Poli Gigi</option>
                        <option value="Poli KIA" {{ old('poli') == 'Poli KIA' ? 'selected' : '' }}>Poli KIA</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Tanggal Kunjungan</label>
                                                <input type="date" name="tanggal_kunjungan" class="form-control"
                                                    value="{{ old('tanggal_kunjungan') }}"
                                                    min="{{ date('Y-m-d') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Keluhan</label>
                                        <textarea name="keluhan" class="form-control" rows="3"
                                            placeholder="Deskripsikan keluhan kamu" required>{{ old('keluhan') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-check"></i> Daftar Antrian
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

                            

<script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
<script>
    // Data profil user untuk auto-fill
    const profilUser = {
        nama: "{{ auth()->user()->name }}",
        nik: "{{ auth()->user()->nik }}",
        tempat_lahir: "{{ auth()->user()->tempat_lahir }}",
        tanggal_lahir: "{{ auth()->user()->tanggal_lahir }}",
        alamat: "{{ auth()->user()->alamat }}",
        no_hp: "{{ auth()->user()->no_hp }}",
        agama: "{{ auth()->user()->agama }}",
        pendidikan_terakhir: "{{ auth()->user()->pendidikan_terakhir }}",
        pekerjaan: "{{ auth()->user()->pekerjaan }}",
        golongan_darah: "{{ auth()->user()->golongan_darah }}",
    };

    function toggleForm(nilai) {
        if (nilai === 'diri_sendiri') {
            // Auto-fill data dari profil
            document.getElementById('input_nama').value = profilUser.nama;
            document.getElementById('input_nik').value = profilUser.nik;
            document.getElementById('input_tempat_lahir').value = profilUser.tempat_lahir;
            document.getElementById('input_tanggal_lahir').value = profilUser.tanggal_lahir;
            document.getElementById('input_alamat').value = profilUser.alamat;
            document.getElementById('input_no_hp').value = profilUser.no_hp;
            document.getElementById('input_pekerjaan').value = profilUser.pekerjaan;

            // Set select options
            setSelect('input_agama', profilUser.agama);
            setSelect('input_pendidikan', profilUser.pendidikan_terakhir);
            setSelect('input_golongan_darah', profilUser.golongan_darah);

            document.getElementById('label-data-pasien').innerText = 'Data Pasien (Data Kamu)';
        } else {
            // Kosongkan semua field
            document.getElementById('input_nama').value = '';
            document.getElementById('input_nik').value = '';
            document.getElementById('input_tempat_lahir').value = '';
            document.getElementById('input_tanggal_lahir').value = '';
            document.getElementById('input_alamat').value = '';
            document.getElementById('input_no_hp').value = '';
            document.getElementById('input_pekerjaan').value = '';
            setSelect('input_agama', '');
            setSelect('input_pendidikan', '');
            setSelect('input_golongan_darah', '');

            document.getElementById('label-data-pasien').innerText = 'Data Orang yang Didaftarkan';
        }
    }

    function setSelect(id, value) {
        const select = document.getElementById(id);
        for (let option of select.options) {
            option.selected = option.value === value;
        }
    }

    // Jalankan saat halaman pertama kali load
    window.onload = function() {
        const selected = document.querySelector('input[name="untuk"]:checked');
        if (selected) toggleForm(selected.value);
    };
</script>
</body>
</html>