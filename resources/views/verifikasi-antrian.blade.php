<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Antrian — SIROP</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        .header { margin-bottom: 20px; }
        .header h1 { color: #4e73df; font-size: 22px; margin: 0; }
        .header p { color: #666; font-size: 13px; margin: 5px 0 0; }
        .nomor {
            background: #4e73df;
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
        }
        .nomor h2 { font-size: 13px; margin: 0 0 5px; opacity: 0.9; }
        .nomor h1 { font-size: 48px; margin: 0; font-weight: bold; }
        .nomor p { font-size: 13px; margin: 5px 0 0; opacity: 0.9; }
        .info { text-align: left; margin: 20px 0; }
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }
        .info-row span:first-child { color: #666; }
        .info-row span:last-child { font-weight: bold; }
        .status {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            margin: 15px 0;
        }
        .menunggu { background: #fff3cd; color: #856404; }
        .selesai { background: #d1e7dd; color: #0f5132; }
        .batal { background: #f8d7da; color: #842029; }
        .valid { color: #1cc88a; font-size: 40px; margin: 10px 0; }
        .batal-icon { color: #e74a3b; font-size: 40px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1>🏥 SIROP</h1>
            <p>Sistem Informasi Rekam Online Puskesmas</p>
            <p>Verifikasi Antrian</p>
        </div>

        @if($pendaftaran->status != 'batal')
            <div class="valid">
                <i class="fas fa-check-circle"></i>
            </div>
            <p style="color:#1cc88a; font-weight:bold">Antrian Valid!</p>
        @else
            <div class="batal-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <p style="color:#e74a3b; font-weight:bold">Antrian Dibatalkan!</p>
        @endif

        <div class="nomor">
            <h2>NOMOR ANTRIAN</h2>
            <h1>{{ str_pad($pendaftaran->nomor_antrian, 3, '0', STR_PAD_LEFT) }}</h1>
            <p>{{ $pendaftaran->poli }}</p>
        </div>

        <span class="status {{ $pendaftaran->status }}">
            {{ ucfirst($pendaftaran->status) }}
        </span>

        <div class="info">
            <div class="info-row">
                <span>Nama Pasien</span>
                <span>{{ $pendaftaran->nama_pasien }}</span>
            </div>
            <div class="info-row">
                <span>NIK</span>
                <span>{{ $pendaftaran->nik_pasien }}</span>
            </div>
            <div class="info-row">
                <span>Poli</span>
                <span>{{ $pendaftaran->poli }}</span>
            </div>
            <div class="info-row">
                <span>Tanggal Kunjungan</span>
                <span>{{ \Carbon\Carbon::parse($pendaftaran->tanggal_kunjungan)->format('d M Y') }}</span>
            </div>
            <div class="info-row">
                <span>Jam Daftar</span>
                <span>{{ \Carbon\Carbon::parse($pendaftaran->created_at)->format('H:i') }} WIB</span>
            </div>
        </div>

        <p style="font-size:11px; color:#999; margin-top:20px">
            Diverifikasi pada {{ now()->format('d M Y, H:i') }} WIB
        </p>
    </div>
</body>
</html>