<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        $kunjunganHariIni  = Pendaftaran::whereDate('tanggal_kunjungan', $today)->count();
        $totalPasien       = User::where('role', 'pasien')->count();
        $totalKunjungan    = User::where('role', 'pasien')->whereDate('created_at', $today)->count();
        $kunjunganBulanIni = Pendaftaran::where('status', 'menunggu')
                            ->whereDate('tanggal_kunjungan', $today)
                            ->count();

        // Grafik 7 hari terakhir
        $grafik = [];
        for ($i = 6; $i >= 0; $i--) {
            $tanggal  = now()->subDays($i)->toDateString();
            $hari     = now()->subDays($i)->locale('id')->isoFormat('ddd');
            $grafik[] = [
                'hari'   => $hari,
                'jumlah' => Pendaftaran::whereDate('tanggal_kunjungan', $tanggal)->count(),
            ];
        }

        // Antrian per poli
        $antrianPerPoli = [
            'Poli Umum' => [
                'sedang'   => Pendaftaran::where('poli', 'Poli Umum')
                                ->where('tanggal_kunjungan', $today)
                                ->where('status', 'selesai')->count(),
                'menunggu' => Pendaftaran::where('poli', 'Poli Umum')
                                ->where('tanggal_kunjungan', $today)
                                ->where('status', 'menunggu')->count(),
            ],
            'Poli Gigi' => [
                'sedang'   => Pendaftaran::where('poli', 'Poli Gigi')
                                ->where('tanggal_kunjungan', $today)
                                ->where('status', 'selesai')->count(),
                'menunggu' => Pendaftaran::where('poli', 'Poli Gigi')
                                ->where('tanggal_kunjungan', $today)
                                ->where('status', 'menunggu')->count(),
            ],
            'Poli KIA' => [
                'sedang'   => Pendaftaran::where('poli', 'Poli KIA')
                                ->where('tanggal_kunjungan', $today)
                                ->where('status', 'selesai')->count(),
                'menunggu' => Pendaftaran::where('poli', 'Poli KIA')
                                ->where('tanggal_kunjungan', $today)
                                ->where('status', 'menunggu')->count(),
            ],
        ];

        // Nomor antrian yang sedang dipanggil per poli
        $nomorAntrian  = Pendaftaran::where('status', 'menunggu')
                            ->whereDate('tanggal_kunjungan', $today)
                            ->max('nomor_antrian') ?? 0;
        $sudahDilayani = Pendaftaran::where('status', 'selesai')
                            ->whereDate('tanggal_kunjungan', $today)->count();
        $menunggu      = Pendaftaran::where('status', 'menunggu')
                            ->whereDate('tanggal_kunjungan', $today)->count();

        return view('dashboard', compact(
            'kunjunganHariIni',
            'totalPasien',
            'totalKunjungan',
            'kunjunganBulanIni',
            'grafik',
            'nomorAntrian',
            'sudahDilayani',
            'menunggu',
            'antrianPerPoli'
        ));
    }
}