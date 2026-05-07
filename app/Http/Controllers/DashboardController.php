<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPasien = DB::table('pasien')->count();
        
        $kunjunganHariIni = DB::table('kunjungan')
            ->whereDate('created_at', Carbon::today())
            ->count();
            
        $kunjunganBulanIni = DB::table('kunjungan')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
            
        $totalKunjungan = DB::table('kunjungan')->count();

        $pasienBaru = DB::table('pasien')
            ->whereDate('created_at', Carbon::today())
            ->count();

        $antrianAktif = DB::table('kunjungan')
            ->whereDate('created_at', Carbon::today())
            ->count();

        return view('dashboard', compact(
            'totalPasien',
            'kunjunganHariIni', 
            'kunjunganBulanIni',
            'totalKunjungan',
            'pasienBaru',
            'antrianAktif'
        ));
    }
}