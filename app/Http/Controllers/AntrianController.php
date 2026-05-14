<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;
use Carbon\Carbon;

class AntrianController extends Controller
{
    public function index()
{
    $dariPasien = \App\Models\Pasien::select('nama as nama_pasien', 'nik as nik_pasien')->get();

    $dariPendaftaran = Pendaftaran::select('nama_pasien', 'nik_pasien')
        ->groupBy('nik_pasien', 'nama_pasien')
        ->get();

    $pasienList = $dariPasien->concat($dariPendaftaran)
        ->unique('nik_pasien')
        ->sortBy('nama_pasien')
        ->values();

    return view('admin.antrian.index', compact('pasienList'));
}

    public function getData(Request $request)
    {
        $poli  = $request->poli;
        $today = Carbon::today()->toDateString();

        $antrian = Pendaftaran::where('poli', $poli)
            ->where('tanggal_kunjungan', $today)
            ->whereIn('status', ['menunggu', 'dipanggil'])
            ->orderBy('nomor_antrian', 'asc')
            ->get();

        $sedangDipanggil = Pendaftaran::where('poli', $poli)
            ->where('tanggal_kunjungan', $today)
            ->where('status', 'dipanggil')
            ->first();

        $totalHariIni = Pendaftaran::where('poli', $poli)
            ->where('tanggal_kunjungan', $today)
            ->count();

        $menunggu = Pendaftaran::where('poli', $poli)
            ->where('tanggal_kunjungan', $today)
            ->where('status', 'menunggu')
            ->count();

        $selesai = Pendaftaran::where('poli', $poli)
            ->where('tanggal_kunjungan', $today)
            ->where('status', 'selesai')
            ->count();

        return response()->json([
            'antrian'         => $antrian,
            'sedangDipanggil' => $sedangDipanggil,
            'totalHariIni'    => $totalHariIni,
            'menunggu'        => $menunggu,
            'selesai'         => $selesai,
        ]);
    }

   public function tambah(Request $request)
{
    $poli  = $request->poli;
    $nik   = $request->nik_pasien;
    $nama  = $request->nama_pasien;
    $today = Carbon::today()->toDateString();

    // Cek duplikat
    $sudahAda = Pendaftaran::where('nik_pasien', $nik)
        ->where('poli', $poli)
        ->where('tanggal_kunjungan', $today)
        ->exists();

    if ($sudahAda) {
        return response()->json(['message' => 'Pasien sudah terdaftar di poli ini hari ini.'], 422);
    }

    // Ambil data terakhir pasien dari tabel pasien
    $dataPasien = \App\Models\Pasien::where('nik', $nik)->first();

    // Jika tidak ada di tabel pasien, cari di pendaftaran
    if (!$dataPasien) {
        $dataLama = Pendaftaran::where('nik_pasien', $nik)->latest()->first();
    }

    // Generate nomor antrian
    $lastNomor = Pendaftaran::where('poli', $poli)
        ->where('tanggal_kunjungan', $today)
        ->max('nomor_antrian');

    $nomorBaru = ($lastNomor ?? 0) + 1;

    try {
        Pendaftaran::create([
            'user_id'             => auth()->id() ?? 1,
            'poli'                => $poli,
            'nama_pasien'         => $nama,
            'nik_pasien'          => $nik,
            'tempat_lahir'        => $dataPasien->tempat_lahir ?? $dataLama->tempat_lahir ?? '-',
            'tanggal_lahir'       => $dataPasien->tanggal_lahir ?? $dataLama->tanggal_lahir ?? now()->toDateString(),
            'alamat'              => $dataPasien->alamat ?? $dataLama->alamat ?? '-',
            'no_hp'               => $dataPasien->no_hp ?? $dataLama->no_hp ?? '-',
            'agama'               => $dataPasien->agama ?? $dataLama->agama ?? '-',
            'pendidikan_terakhir' => $dataPasien->pendidikan_terakhir ?? $dataLama->pendidikan_terakhir ?? '-',
            'pekerjaan'           => $dataPasien->pekerjaan ?? $dataLama->pekerjaan ?? '-',
            'golongan_darah'      => $dataPasien->golongan_darah ?? $dataLama->golongan_darah ?? '-',
            'tanggal_kunjungan'   => $today,
            'keluhan'             => $request->keluhan ?? '-',
            'nomor_antrian'       => $nomorBaru,
            'untuk'               => 'diri_sendiri',
            'status'              => 'menunggu',
        ]);

        return response()->json(['message' => 'Pasien berhasil ditambahkan ke antrian.']);

    } catch (\Exception $e) {
        return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
    }
}
    public function panggilBerikutnya(Request $request)
    {
        $poli  = $request->poli;
        $today = Carbon::today()->toDateString();

        Pendaftaran::where('poli', $poli)
            ->where('tanggal_kunjungan', $today)
            ->where('status', 'dipanggil')
            ->update(['status' => 'selesai']);

        $berikutnya = Pendaftaran::where('poli', $poli)
            ->where('tanggal_kunjungan', $today)
            ->where('status', 'menunggu')
            ->orderBy('nomor_antrian', 'asc')
            ->first();

        if (!$berikutnya) {
            return response()->json(['message' => 'Tidak ada antrian yang menunggu.'], 404);
        }

        $berikutnya->update(['status' => 'dipanggil']);

        return response()->json(['message' => 'Berhasil memanggil antrian.', 'data' => $berikutnya]);
    }

    public function selesai(Request $request)
    {
        $poli  = $request->poli;
        $today = Carbon::today()->toDateString();

        $dipanggil = Pendaftaran::where('poli', $poli)
            ->where('tanggal_kunjungan', $today)
            ->where('status', 'dipanggil')
            ->first();

        if (!$dipanggil) {
            return response()->json(['message' => 'Tidak ada antrian yang sedang dipanggil.'], 404);
        }

        $dipanggil->update(['status' => 'selesai']);

        return response()->json(['message' => 'Antrian ditandai selesai.']);
    }

    public function lewati(Request $request)
    {
        $poli  = $request->poli;
        $today = Carbon::today()->toDateString();

        $dipanggil = Pendaftaran::where('poli', $poli)
            ->where('tanggal_kunjungan', $today)
            ->where('status', 'dipanggil')
            ->first();

        if (!$dipanggil) {
            return response()->json(['message' => 'Tidak ada antrian yang sedang dipanggil.'], 404);
        }

        $lastNomor = Pendaftaran::where('poli', $poli)
            ->where('tanggal_kunjungan', $today)
            ->max('nomor_antrian');

        $dipanggil->update([
            'status'        => 'menunggu',
            'nomor_antrian' => $lastNomor + 1,
        ]);

        return response()->json(['message' => 'Antrian dilewati.']);
    }

    public function panggilUlang(Request $request)
    {
        $poli  = $request->poli;
        $today = Carbon::today()->toDateString();

        $dipanggil = Pendaftaran::where('poli', $poli)
            ->where('tanggal_kunjungan', $today)
            ->where('status', 'dipanggil')
            ->first();

        if (!$dipanggil) {
            return response()->json(['message' => 'Tidak ada antrian yang sedang dipanggil.'], 404);
        }

        return response()->json(['message' => 'Memanggil ulang.', 'data' => $dipanggil]);
    }
}