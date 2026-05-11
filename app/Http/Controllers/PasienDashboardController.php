<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class PasienDashboardController extends Controller
{
    public function index()
    {
        $riwayat = Pendaftaran::where('user_id', Auth::id())
            ->latest()
            ->take(5)
            ->get();

        $antrianAktif = Pendaftaran::where('user_id', Auth::id())
            ->whereDate('tanggal_kunjungan', today())
            ->where('status', 'menunggu')
            ->latest()
            ->first();

        $sudahDilayani = Pendaftaran::whereDate('tanggal_kunjungan', today())
            ->where('status', 'selesai')
            ->count();

        $menunggu = Pendaftaran::whereDate('tanggal_kunjungan', today())
            ->where('status', 'menunggu')
            ->count();

        $dokterAktif = Dokter::where('status', 'aktif')->count();

        return view('pasien.dashboard', compact(
            'riwayat', 'antrianAktif', 'sudahDilayani', 'menunggu', 'dokterAktif'
        ));
    }

    public function jadwal()
    {
        $dokter = Dokter::where('status', 'aktif')->get();
        return view('pasien.jadwal-dokter', compact('dokter'));
    }
}