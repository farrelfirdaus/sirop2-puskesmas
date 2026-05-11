<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Profil — SIROP</title>
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f4ff;
            min-height: 100vh;
            margin: 0;
        }

        .page-wrapper {
            display: flex;
            min-height: 100vh;
            align-items: stretch;
        }

        /* ── SIDE PANEL ── */
        .side-panel {
            width: 340px;
            flex-shrink: 0;
            background: #4E73DF;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px 36px;
        }

        .side-panel::before {
            content: '';
            position: absolute;
            top: -100px; right: -100px;
            width: 320px; height: 320px;
            border-radius: 50%;
            background: rgba(255,255,255,0.07);
        }

        .side-panel::after {
            content: '';
            position: absolute;
            bottom: -80px; left: -60px;
            width: 240px; height: 240px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
        }

        /* Logo — plain text, no box */
        .side-logo {
            font-size: 44px;
            font-weight: 700;
            color: #fff;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 1;
        }

        .side-content {
            position: relative;
            z-index: 1;
        }

        .side-content h2 {
            font-size: 28px;
            font-weight: 700;
            color: #fff;
            line-height: 1.3;
            margin: 0 0 14px;
        }

        .side-content p {
            font-size: 14px;
            color: rgba(255,255,255,0.65);
            line-height: 1.7;
            margin: 0;
        }

        /* Steps — hanya 2 langkah */
        .side-steps {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .step-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 12px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .step-item.active {
            background: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.25);
        }

        .step-item.done {
            background: rgba(255,255,255,0.06);
            border-color: rgba(255,255,255,0.08);
            opacity: 0.7;
        }

        .step-num {
            width: 28px; height: 28px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            color: #fff;
            font-size: 12px; font-weight: 600;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .step-item.active .step-num {
            background: #fff;
            color: #4E73DF;
        }

        .step-label {
            font-size: 13px; font-weight: 500;
            color: rgba(255,255,255,0.7);
        }

        .step-item.active .step-label { color: #fff; }

        /* ── FORM AREA ── */
        .form-area {
            flex: 1;
            padding: 48px 52px;
            overflow-y: auto;
            background: #f8f9ff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header { margin-bottom: 32px; }

        .form-eyebrow {
            font-size: 11px; font-weight: 600;
            letter-spacing: 1.8px; text-transform: uppercase;
            color: #4E73DF; margin-bottom: 8px;
        }

        .form-header h1 {
            font-size: 26px; font-weight: 700;
            color: #1a1f36; margin: 0 0 6px; line-height: 1.25;
        }

        .form-header p { font-size: 14px; color: #8a94a6; margin: 0; }

        .alert-danger {
            background: #fff0f0;
            border: 1px solid #f5c6cb;
            border-left: 4px solid #e74c3c;
            border-radius: 10px;
            padding: 14px 16px; margin-bottom: 24px;
            font-size: 13px; color: #c0392b;
        }

        .section-label {
            font-size: 11px; font-weight: 600;
            letter-spacing: 1.4px; text-transform: uppercase;
            color: #b0b8cc; margin: 24px 0 14px;
            display: flex; align-items: center; gap: 10px;
        }

        .section-label::after {
            content: ''; flex: 1; height: 1px; background: #e8ecf4;
        }

        .row-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        .form-group { margin-bottom: 16px; }

        .form-group label {
            font-size: 12px; font-weight: 600; color: #4a5568;
            letter-spacing: 0.3px; margin-bottom: 6px; display: block;
        }

        .input-wrapper { position: relative; }

        .input-wrapper .field-icon {
            position: absolute; left: 13px; top: 50%;
            transform: translateY(-50%);
            color: #b0b8cc; font-size: 14px;
            pointer-events: none; width: 16px; text-align: center;
        }

        .input-wrapper.textarea-wrapper .field-icon { top: 14px; transform: none; }

        .input-wrapper input,
        .input-wrapper select,
        .input-wrapper textarea {
            width: 100%;
            padding: 11px 14px 11px 40px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px; color: #1a1f36;
            background: #fff;
            border: 1.5px solid #e2e8f4;
            border-radius: 10px; outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            appearance: none; -webkit-appearance: none;
        }

        .input-wrapper input::placeholder,
        .input-wrapper textarea::placeholder { color: #c4c9d8; }

        .input-wrapper input:focus,
        .input-wrapper select:focus,
        .input-wrapper textarea:focus {
            border-color: #4E73DF;
            box-shadow: 0 0 0 3px rgba(78,115,223,0.1);
        }

        .input-wrapper textarea { height: 88px; resize: none; padding-top: 11px; }

        .select-arrow {
            position: absolute; right: 13px; top: 50%;
            transform: translateY(-50%);
            color: #b0b8cc; font-size: 12px; pointer-events: none;
        }

        .btn-submit {
            width: 100%; padding: 14px;
            background: #4E73DF; color: #fff;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px; font-weight: 600;
            border: none; border-radius: 12px; cursor: pointer;
            margin-top: 28px;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            letter-spacing: 0.2px;
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
            box-shadow: 0 4px 14px rgba(78,115,223,0.35);
        }

        .btn-submit:hover { background: #3d62cc; box-shadow: 0 6px 18px rgba(78,115,223,0.4); }
        .btn-submit:active { transform: scale(0.99); }

        .security-note {
            display: flex; align-items: center; justify-content: center; gap: 6px;
            margin-top: 16px; font-size: 12px; color: #a0aabb;
        }

        .security-note i { color: #4E73DF; font-size: 12px; }

        @media (max-width: 900px) {
            .side-panel { display: none; }
            .form-area { padding: 32px 24px; }
        }
    </style>
</head>
<body>

<div class="page-wrapper">

    <!-- Side Panel -->
    <div class="side-panel">
        <!-- Logo tanpa kotak di "S" -->
        <div class="side-logo">
    <i class="fas fa-hospital" style="margin-right: 10px;"></i>SIROP
</div>

        <div class="side-content">
            <h2>Satu langkah lagi untuk memulai</h2>
            <p>Lengkapi profil kamu agar kami bisa memberikan layanan terbaik yang sesuai kebutuhanmu.</p>
        </div>

        <!-- Hanya 2 langkah -->
        <div class="side-steps">
            <div class="step-item active">
                <div class="step-num">1</div>
                <span class="step-label">Data Diri</span>
            </div>
            
        </div>
    </div>

    <!-- Form Area -->
    <div class="form-area">
        <div class="form-header">
            <div class="form-eyebrow">Profil Pengguna</div>
            <h1>Lengkapi Data Diri</h1>
            <p>Harap lengkapi data diri kamu sebelum menggunakan layanan</p>
        </div>

        @if($errors->any())
            <div class="alert-danger">
                @foreach($errors->all() as $error)
                    <div><i class="fas fa-exclamation-circle" style="margin-right:6px;"></i>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('profil.simpan') }}">
            @csrf

            <div class="section-label">Identitas</div>
            <div class="row-grid">
                <div class="form-group">
                    <label>NIK</label>
                    <div class="input-wrapper">
                        <i class="fas fa-id-card field-icon"></i>
                        <input type="text" name="nik" value="{{ old('nik') }}" placeholder="16 digit NIK" maxlength="16" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>No. HP</label>
                    <div class="input-wrapper">
                        <i class="fas fa-phone field-icon"></i>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="No. HP aktif" required>
                    </div>
                </div>
            </div>

            <div class="section-label">Tempat & Tanggal Lahir</div>
            <div class="row-grid">
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <div class="input-wrapper">
                        <i class="fas fa-map-marker-alt field-icon"></i>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Kota kelahiran" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <div class="input-wrapper">
                        <i class="fas fa-calendar field-icon"></i>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                    </div>
                </div>
            </div>

            <div class="section-label">Alamat</div>
            <div class="form-group">
                <label>Alamat Lengkap</label>
                <div class="input-wrapper textarea-wrapper">
                    <i class="fas fa-home field-icon"></i>
                    <textarea name="alamat" placeholder="Jalan, nomor rumah, RT/RW, kelurahan, kecamatan..." required>{{ old('alamat') }}</textarea>
                </div>
            </div>

            <div class="section-label">Informasi Lainnya</div>
            <div class="row-grid">
                <div class="form-group">
                    <label>Agama</label>
                    <div class="input-wrapper">
                        <i class="fas fa-star-and-crescent field-icon"></i>
                        <select name="agama" required>
                            <option value="">-- Pilih Agama --</option>
                            @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Konghucu'] as $agama)
                                <option value="{{ $agama }}" {{ old('agama') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down select-arrow"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label>Golongan Darah</label>
                    <div class="input-wrapper">
                        <i class="fas fa-tint field-icon"></i>
                        <select name="golongan_darah" required>
                            <option value="">-- Pilih --</option>
                            @foreach(['A','B','AB','O'] as $gd)
                                <option value="{{ $gd }}" {{ old('golongan_darah') == $gd ? 'selected' : '' }}>{{ $gd }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down select-arrow"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label>Pendidikan Terakhir</label>
                    <div class="input-wrapper">
                        <i class="fas fa-graduation-cap field-icon"></i>
                        <select name="pendidikan_terakhir" required>
                            <option value="">-- Pilih --</option>
                            @foreach(['SD','SMP','SMA/SMK','D3','S1','S2','S3','Lainnya'] as $p)
                                <option value="{{ $p }}" {{ old('pendidikan_terakhir') == $p ? 'selected' : '' }}>{{ $p }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down select-arrow"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label>Pekerjaan</label>
                    <div class="input-wrapper">
                        <i class="fas fa-briefcase field-icon"></i>
                        <input type="text" name="pekerjaan" value="{{ old('pekerjaan') }}" placeholder="Pekerjaan saat ini" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                Simpan &amp; Lanjutkan
                <i class="fas fa-arrow-right"></i>
            </button>

            <p class="security-note">
                <i class="fas fa-lock"></i> Data kamu tersimpan dengan aman &amp; terenkripsi
            </p>
        </form>
    </div>

</div>
</body>
</html>