<!DOCTYPE html>
<html lang="id">
<head>
    <title>Beranda Pasien — SIROP</title>
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
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $user->name) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $user->email) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>NIK</label>
                                        <input type="text" class="form-control"
                                            value="{{ $user->nik }}" disabled>
                                        <small class="text-muted">NIK tidak bisa diubah</small>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
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