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
            <div class="col-md-4">
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
            <div class="col-md-4">
                <div class="form-group">
                    <label>Tanggal Kunjungan</label>
                    <input type="date" name="tanggal_kunjungan" class="form-control"
                        value="{{ old('tanggal_kunjungan') }}"
                        min="{{ date('Y-m-d') }}" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Jenis Pembayaran</label>
                    <select name="jenis_pembayaran" class="form-control" required
                            onchange="toggleAsuransi(this.value)">
                        <option value="">-- Pilih --</option>
                        <option value="umum" {{ old('jenis_pembayaran') == 'umum' ? 'selected' : '' }}>Umum</option>
                        <option value="bpjs" {{ old('jenis_pembayaran') == 'bpjs' ? 'selected' : '' }}>BPJS Kesehatan</option>
                        <option value="asuransi" {{ old('jenis_pembayaran') == 'asuransi' ? 'selected' : '' }}>Asuransi</option>
                    </select>
                </div>
            </div>
        </div>

       {{-- Nama Asuransi, muncul kalau pilih Asuransi --}}
<div class="row" id="row-asuransi" style="display: {{ old('jenis_pembayaran') == 'asuransi' ? 'flex' : 'none' }};">
    <div class="col-md-4">
        <div class="form-group">
            <label>Nama Asuransi</label>

            {{-- Dropdown --}}
            <select class="form-control" id="input-asuransi"
                    onchange="toggleInputAsuransi(this.value)"
                    name="nama_asuransi">
                <option value="">-- Pilih Asuransi --</option>
                <option value="Allianz" {{ old('nama_asuransi') == 'Allianz' ? 'selected' : '' }}>Allianz</option>
                <option value="AXA Mandiri" {{ old('nama_asuransi') == 'AXA Mandiri' ? 'selected' : '' }}>AXA Mandiri</option>
                <option value="Prudential" {{ old('nama_asuransi') == 'Prudential' ? 'selected' : '' }}>Prudential</option>
                <option value="Manulife" {{ old('nama_asuransi') == 'Manulife' ? 'selected' : '' }}>Manulife</option>
                <option value="Cigna" {{ old('nama_asuransi') == 'Cigna' ? 'selected' : '' }}>Cigna</option>
                <option value="Lainnya">Lainnya</option>
            </select>

            {{-- Input text, muncul menggantikan dropdown kalau pilih Lainnya --}}
            <input type="text" class="form-control" id="input-asuransi-lainnya"
                   name="nama_asuransi"
                   placeholder="Tulis nama asuransi kamu"
                   value="{{ old('nama_asuransi') }}"
                   style="display: none;">

            {{-- Tombol kembali ke dropdown --}}
            <small id="link-kembali-asuransi" style="display:none;">
                <a href="#" onclick="kembaliKeDropdown(); return false;">
                    ← Pilih dari daftar
                </a>
            </small>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Search filter
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });

    // Logout konfirmasi
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
    function toggleAsuransi(val) {
    const row = document.getElementById('row-asuransi');
    const input = document.getElementById('input-asuransi');
    if (val === 'asuransi') {
        row.style.display = 'flex';
        input.setAttribute('required', 'required');
    } else {
        row.style.display = 'none';
        input.removeAttribute('required');
    }
}
function toggleInputAsuransi(val) {
    if (val === 'Lainnya') {
        document.getElementById('input-asuransi').style.display = 'none';
        document.getElementById('input-asuransi').removeAttribute('name');
        document.getElementById('input-asuransi-lainnya').style.display = 'block';
        document.getElementById('input-asuransi-lainnya').setAttribute('name', 'nama_asuransi');
        document.getElementById('input-asuransi-lainnya').setAttribute('required', 'required');
        document.getElementById('input-asuransi-lainnya').focus();
        document.getElementById('link-kembali-asuransi').style.display = 'block';
    }
}

function kembaliKeDropdown() {
    document.getElementById('input-asuransi').style.display = 'block';
    document.getElementById('input-asuransi').setAttribute('name', 'nama_asuransi');
    document.getElementById('input-asuransi').value = '';
    document.getElementById('input-asuransi-lainnya').style.display = 'none';
    document.getElementById('input-asuransi-lainnya').removeAttribute('name');
    document.getElementById('input-asuransi-lainnya').removeAttribute('required');
    document.getElementById('input-asuransi-lainnya').value = '';
    document.getElementById('link-kembali-asuransi').style.display = 'none';
}
</script>
</body>
</body>
</html>