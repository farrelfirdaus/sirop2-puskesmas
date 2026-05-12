<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pendaftaran;
use App\Http\Controllers\NotifikasiController;
use Illuminate\Support\Facades\Auth;

class PasienDashboardController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $today = now()->toDateString();

        NotifikasiController::cekJadwal($user->id);

        $riwayat = Pendaftaran::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        $dokterAktif = Dokter::where('status', 'aktif')->count();

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

        return view('pasien.dashboard', compact(
            'user', 'riwayat', 'dokterAktif', 'antrianPerPoli'
        ));
    }

    public function jadwal()
    {
        $dokter = Dokter::where('status', 'aktif')->get();
        return view('pasien.jadwal-dokter', compact('dokter'));
    }
}