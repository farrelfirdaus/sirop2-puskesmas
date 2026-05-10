<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class PasienDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $riwayat = Pendaftaran::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        $dokterAktif = Dokter::where('status', 'aktif')->count();

        return view('pasien.dashboard', compact('user', 'riwayat', 'dokterAktif'));
    }

    public function jadwal()
    {
        $dokter = Dokter::where('status', 'aktif')->get();
        return view('pasien.jadwal-dokter', compact('dokter'));
    }
}