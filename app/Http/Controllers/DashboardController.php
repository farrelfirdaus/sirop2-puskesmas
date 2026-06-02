<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pendaftaran;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $namaHari = now()->locale('id')->dayName; // e.g. "Senin"

        // ── Summary Cards ────────────────────────────────────────────
        $totalHariIni  = Pendaftaran::whereDate('tanggal_kunjungan', $today)->count();
        $totalMenunggu = Pendaftaran::whereDate('tanggal_kunjungan', $today)
                            ->where('status', 'menunggu')->count();
        $totalDipanggil = Pendaftaran::whereDate('tanggal_kunjungan', $today)
                            ->where('status', 'dipanggil')->count();
        $totalSelesai  = Pendaftaran::whereDate('tanggal_kunjungan', $today)
                            ->where('status', 'selesai')->count();
        $totalPasien   = User::where('role', 'pasien')->count();

        // ── Grafik 7 hari — breakdown per poli ──────────────────────
        $polis  = ['Poli Umum', 'Poli Gigi', 'Poli KIA'];
        $labels = [];
        $grafikPerPoli = ['Poli Umum' => [], 'Poli Gigi' => [], 'Poli KIA' => []];

        for ($i = 6; $i >= 0; $i--) {
            $tgl      = now()->subDays($i)->toDateString();
            $labels[] = now()->subDays($i)->locale('id')->isoFormat('ddd, D/M');
            foreach ($polis as $poli) {
                $grafikPerPoli[$poli][] = Pendaftaran::where('poli', $poli)
                    ->whereDate('tanggal_kunjungan', $tgl)
                    ->count();
            }
        }

        // ── Pie chart status hari ini ────────────────────────────────
        $statusHariIni = [
            'menunggu'  => $totalMenunggu,
            'dipanggil' => $totalDipanggil,
            'selesai'   => $totalSelesai,
            'batal'     => Pendaftaran::whereDate('tanggal_kunjungan', $today)
                            ->where('status', 'batal')->count(),
        ];

        // ── Antrian per poli (card kecil) ───────────────────────────
        $antrianPerPoli = [];
        foreach ($polis as $poli) {
            $dipanggil = Pendaftaran::where('poli', $poli)
                ->whereDate('tanggal_kunjungan', $today)
                ->where('status', 'dipanggil')
                ->first();
            $antrianPerPoli[$poli] = [
                'nomor_dipanggil' => $dipanggil ? $dipanggil->nomor_antrian : null,
                'menunggu'        => Pendaftaran::where('poli', $poli)
                                        ->whereDate('tanggal_kunjungan', $today)
                                        ->where('status', 'menunggu')->count(),
                'selesai'         => Pendaftaran::where('poli', $poli)
                                        ->whereDate('tanggal_kunjungan', $today)
                                        ->where('status', 'selesai')->count(),
            ];
        }

        // ── Dokter aktif hari ini ────────────────────────────────────
        $dokterHariIni = Dokter::where('status', 'aktif')->get()
            ->filter(function ($d) use ($namaHari) {
                // hari_praktik disimpan sebagai string misal "Senin,Rabu,Jumat"
                $hariList = array_map('trim', explode(',', $d->hari_praktik));
                return in_array($namaHari, $hariList);
            })
            ->map(function ($d) use ($today) {
                $d->pasien_hari_ini = Pendaftaran::where('poli', $d->spesialisasi)
                    ->whereDate('tanggal_kunjungan', $today)
                    ->whereIn('status', ['menunggu', 'dipanggil', 'selesai'])
                    ->count();
                return $d;
            });

        return view('dashboard', compact(
            'totalHariIni',
            'totalMenunggu',
            'totalDipanggil',
            'totalSelesai',
            'totalPasien',
            'labels',
            'grafikPerPoli',
            'statusHariIni',
            'antrianPerPoli',
            'dokterHariIni'
        ));
    }
}