<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranController extends Controller
{
    public function create()
    {
        $dokter = Dokter::where('status', 'aktif')->get();
        return view('pasien.daftar-antrian', compact('dokter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dokter_id'           => 'required|exists:dokter,id',
            'tanggal_kunjungan'   => 'required|date|after_or_equal:today',
            'keluhan'             => 'required|string',
            'untuk'               => 'required|in:diri_sendiri,orang_lain',
            'nama_pasien'         => 'required|string',
            'nik_pasien'          => 'required|string|max:20',
            'tempat_lahir'        => 'required|string',
            'tanggal_lahir'       => 'required|date',
            'alamat'              => 'required|string',
            'no_hp'               => 'required|string|max:15',
            'agama'               => 'required|string',
            'pendidikan_terakhir' => 'required|string',
            'pekerjaan'           => 'required|string',
            'golongan_darah'      => 'required|string',
        ]);

        // Hitung nomor antrian
        $jumlahAntrian = Pendaftaran::where('dokter_id', $request->dokter_id)
            ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
            ->count();

        // Cek kuota
        $dokter = Dokter::find($request->dokter_id);
        if ($jumlahAntrian >= $dokter->kuota_per_hari) {
            return back()->with('error', 'Maaf, kuota dokter untuk tanggal ini sudah penuh!');
        }

        $nomorAntrian = $jumlahAntrian + 1;

        Pendaftaran::create([
            'user_id'             => Auth::id(),
            'dokter_id'           => $request->dokter_id,
            'nama_pasien'         => $request->nama_pasien,
            'nik_pasien'          => $request->nik_pasien,
            'tempat_lahir'        => $request->tempat_lahir,
            'tanggal_lahir'       => $request->tanggal_lahir,
            'alamat'              => $request->alamat,
            'no_hp'               => $request->no_hp,
            'agama'               => $request->agama,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'pekerjaan'           => $request->pekerjaan,
            'golongan_darah'      => $request->golongan_darah,
            'tanggal_kunjungan'   => $request->tanggal_kunjungan,
            'keluhan'             => $request->keluhan,
            'nomor_antrian'       => $nomorAntrian,
            'untuk'               => $request->untuk,
            'status'              => 'menunggu',
        ]);

        return redirect()->route('pendaftaran.riwayat')
            ->with('success', 'Pendaftaran berhasil! Nomor antrian kamu: ' . $nomorAntrian);
    }

    public function riwayat()
    {
        $riwayat = Pendaftaran::where('user_id', Auth::id())
            ->with('dokter')
            ->latest()
            ->get();
        return view('pasien.riwayat', compact('riwayat'));
    }

    public function indexAdmin()
    {
        $pendaftaran = Pendaftaran::with(['dokter', 'user'])
            ->latest()
            ->get();
        return view('admin.pendaftaran.index', compact('pendaftaran'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['status' => $request->status]);
        return back()->with('success', 'Status berhasil diupdate!');
    }
}