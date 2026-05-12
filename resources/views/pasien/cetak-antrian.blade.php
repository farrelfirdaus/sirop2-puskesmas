@php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Antrian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #4e73df;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #4e73df;
            font-size: 24px;
            margin: 0;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 13px;
        }
        .nomor-antrian {
            text-align: center;
            background: #4e73df;
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }
        .nomor-antrian h2 {
            font-size: 14px;
            margin: 0 0 5px;
            opacity: 0.9;
        }
        .nomor-antrian h1 {
            font-size: 48px;
            margin: 0;
            font-weight: bold;
        }
        .nomor-antrian p {
            margin: 5px 0 0;
            font-size: 13px;
            opacity: 0.9;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .info-table tr td {
            padding: 8px 10px;
            font-size: 13px;
            border-bottom: 1px solid #eee;
        }
        .info-table tr td:first-child {
            color: #666;
            width: 40%;
            font-weight: bold;
        }
        .qr-section {
            text-align: center;
            margin: 20px 0;
        }
        .qr-section img {
            width: 120px;
            height: 120px;
        }
        .qr-section p {
            font-size: 11px;
            color: #666;
            margin: 5px 0 0;
        }
        .footer {
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 15px;
            margin-top: 20px;
            font-size: 11px;
            color: #999;
        }
        .status {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .status-menunggu { background: #fff3cd; color: #856404; }
        .status-selesai { background: #d1e7dd; color: #0f5132; }
        .status-batal { background: #f8d7da; color: #842029; }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>SIROP</h1>
        <p>Sistem Informasi Rekam Online Puskesmas</p>
        <p>Bukti Pendaftaran Antrian</p>
    </div>

    {{-- Nomor Antrian --}}
    <div class="nomor-antrian">
        <h2>NOMOR ANTRIAN</h2>
        <h1>{{ str_pad($pendaftaran->nomor_antrian, 3, '0', STR_PAD_LEFT) }}</h1>
        <p>{{ $pendaftaran->poli }}</p>
    </div>

    {{-- Info Pasien --}}
    <table class="info-table">
        <tr>
            <td>Nama Pasien</td>
            <td>{{ $pendaftaran->nama_pasien }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>{{ $pendaftaran->nik_pasien }}</td>
        </tr>
        <tr>
            <td>Poli</td>
            <td>{{ $pendaftaran->poli }}</td>
        </tr>
        <tr>
            <td>Tanggal Kunjungan</td>
            <td>{{ \Carbon\Carbon::parse($pendaftaran->tanggal_kunjungan)->format('d M Y') }}</td>
        </tr>
        <tr>
            <td>Jam Daftar</td>
            <td>{{ \Carbon\Carbon::parse($pendaftaran->created_at)->format('H:i') }} WIB</td>
        </tr>
        <tr>
            <td>Keluhan</td>
            <td>{{ $pendaftaran->keluhan }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                <span class="status status-{{ $pendaftaran->status }}">
                    {{ ucfirst($pendaftaran->status) }}
                </span>
            </td>
        </tr>
        <tr>
            <td>Tanggal Cetak</td>
            <td>{{ now()->format('d M Y, H:i') }} WIB</td>
        </tr>
    </table>

    {{-- QR Code --}}
    <div class="qr-section">
    @php
        $qrLibUrl = 'https://chart.googleapis.com/chart?chs=120x120&cht=qr&chl=' . urlencode($qrUrl);
        // Ambil QR sebagai base64 menggunakan GD
        $imgContent = @file_get_contents($qrLibUrl);
        $qrBase64 = $imgContent ? base64_encode($imgContent) : null;
    @endphp
    
    @if($qrBase64)
        <img src="data:image/png;base64,{{ $qrBase64 }}" style="width:120px; height:120px">
    @else
        <div style="width:120px; height:120px; border:2px solid #ccc; display:flex; align-items:center; justify-content:center; margin:0 auto; font-size:10px; text-align:center; color:#999">
            QR Code<br>tidak tersedia
        </div>
    @endif
    <p>Scan QR Code untuk verifikasi antrian</p>
    <p style="font-size:10px; color:#999">{{ $qrUrl }}</p>
</div>

    {{-- Footer --}}
    <div class="footer">
        <p>Dokumen ini dicetak otomatis oleh sistem SIROP</p>
        <p>{{ now()->format('d M Y, H:i') }} WIB</p>
    </div>

</body>
</html>