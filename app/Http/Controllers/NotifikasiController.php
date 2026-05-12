<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    public function index()
    {
        $notifikasi = Notifikasi::where('user_id', Auth::id())
            ->latest()
            ->get();

        // Tandai semua sebagai dibaca
        Notifikasi::where('user_id', Auth::id())
            ->where('dibaca', false)
            ->update(['dibaca' => true]);

        return response()->json($notifikasi);
    }

    public function jumlahBelumDibaca()
    {
        $jumlah = Notifikasi::where('user_id', Auth::id())
            ->where('dibaca', false)
            ->count();

        return response()->json(['jumlah' => $jumlah]);
    }

    public function tandaiDibaca($id)
    {
        $notifikasi = Notifikasi::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notifikasi->update(['dibaca' => true]);

        return response()->json(['success' => true]);
    }

    // Cek jadwal H-1 dan hari H, buat notifikasi otomatis
    public static function cekJadwal($userId)
{
    $today    = now()->toDateString();
    $tomorrow = now()->addDay()->toDateString();

    // Cek jadwal hari ini
    $jadwalHariIni = Pendaftaran::where('user_id', $userId)
        ->where('tanggal_kunjungan', $today)
        ->where('status', 'menunggu')
        ->get();

    foreach ($jadwalHariIni as $p) {
        $sudahAda = \App\Models\Notifikasi::where('user_id', $userId)
            ->where('pendaftaran_id', $p->id)
            ->where('tipe', 'jadwal_hari_ini')
            ->where('created_at', '>=', now()->startOfDay())
            ->exists();

        if (!$sudahAda) {
            \App\Models\Notifikasi::create([
                'user_id'        => $userId,
                'judul'          => 'Jadwal Kunjungan Hari Ini',
                'pesan'          => 'Kamu ada jadwal kunjungan hari ini di ' . $p->poli . '. No. Antrian: ' . $p->nomor_antrian,
                'tipe'           => 'jadwal_hari_ini',
                'pendaftaran_id' => $p->id,
            ]);
        }
    }

    // Cek jadwal H-1
    $jadwalBesok = Pendaftaran::where('user_id', $userId)
        ->where('tanggal_kunjungan', $tomorrow)
        ->where('status', 'menunggu')
        ->get();

    foreach ($jadwalBesok as $p) {
        $sudahAda = \App\Models\Notifikasi::where('user_id', $userId)
            ->where('pendaftaran_id', $p->id)
            ->where('tipe', 'jadwal_h1')
            ->where('created_at', '>=', now()->startOfDay())
            ->exists();

        if (!$sudahAda) {
            \App\Models\Notifikasi::create([
                'user_id'        => $userId,
                'judul'          => 'Pengingat Jadwal Besok',
                'pesan'          => 'Besok kamu ada jadwal kunjungan di  ' . $p->poli . '. No. Antrian: ' . $p->nomor_antrian,
                'tipe'           => 'jadwal_h1',
                'pendaftaran_id' => $p->id,
            ]);
        }
    }
}
}