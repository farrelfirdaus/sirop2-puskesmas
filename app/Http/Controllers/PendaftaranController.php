<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PendaftaranController extends Controller
{
    /**
     * Ambil daftar tanggal libur nasional dari API (di-cache 24 jam)
     */
    private function getTanggalLibur(int $tahun): array
    {
        $cacheKey = "libur_nasional_{$tahun}";

        return Cache::remember($cacheKey, now()->addHours(24), function () use ($tahun) {
            try {
                $response = Http::timeout(5)->get("https://dayoffapi.vercel.app/api?year={$tahun}");
                if ($response->successful()) {
                    $data = $response->json();
                    if (is_array($data)) {
                        return array_column($data, 'tanggal');
                    }
                }
            } catch (\Exception $e) {
                // Kalau API gagal, kembalikan array kosong — validasi hari Minggu tetap jalan
            }
            return [];
        });
    }

    /**
     * Cek apakah tanggal adalah hari kerja dan bukan libur nasional
     */
    private function isTanggalValid(string $tanggal): array
    {
        $carbon = Carbon::parse($tanggal);

        // Cek Minggu
        if ($carbon->dayOfWeek === Carbon::SUNDAY) {
            return ['valid' => false, 'pesan' => 'Puskesmas tidak buka pada hari Minggu.'];
        }

        // Cek libur nasional
        $tahun = $carbon->year;
        $liburTahunIni = $this->getTanggalLibur($tahun);

        if (in_array($tanggal, $liburTahunIni)) {
            return ['valid' => false, 'pesan' => 'Tanggal yang dipilih adalah hari libur nasional.'];
        }

        return ['valid' => true, 'pesan' => ''];
    }

    public function create()
    {
        $dokter = Dokter::where('status', 'aktif')->get();
        return view('pasien.daftar-antrian', compact('dokter'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal_kunjungan'   => 'required|date|after_or_equal:today|before_or_equal:' . now()->addDays(3)->toDateString(),
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
            'poli'                => 'required|string|in:Poli Umum,Poli Gigi,Poli KIA',
            'jenis_pembayaran'    => 'required|in:umum,bpjs,asuransi',
            'nama_asuransi'       => 'nullable|string',
        ]);

        // Validasi hari kerja + libur nasional (server-side)
        $cekTanggal = $this->isTanggalValid($request->tanggal_kunjungan);
        if (!$cekTanggal['valid']) {
            return back()->withInput()->with('error', $cekTanggal['pesan']);
        }

        // Hitung nomor antrian per poli
        $jumlahAntrian = Pendaftaran::where('poli', $request->poli)
            ->where('tanggal_kunjungan', $request->tanggal_kunjungan)
            ->count();

        // Cek kuota per poli (default 20)
        $kuotaPerPoli = 20;
        if ($jumlahAntrian >= $kuotaPerPoli) {
            return back()->withInput()->with('error', 'Maaf, kuota ' . $request->poli . ' untuk tanggal ini sudah penuh!');
        }

        $nomorAntrian = $jumlahAntrian + 1;

        Pendaftaran::create([
            'user_id'             => Auth::id(),
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
            'poli'                => $request->poli,
            'jenis_pembayaran'    => $request->jenis_pembayaran,
            'nama_asuransi'       => $request->nama_asuransi,
        ]);

        return redirect()->route('pendaftaran.riwayat')
            ->with('success', 'Pendaftaran berhasil! Nomor antrian kamu: ' . $nomorAntrian);
    }

    public function riwayat()
    {
        $riwayat = Pendaftaran::where('user_id', Auth::id())
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

    public function batalkan($id)
    {
        $pendaftaran = Pendaftaran::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($pendaftaran->status === 'selesai') {
            return back()->with('error', 'Antrian yang sudah selesai tidak bisa dibatalkan!');
        }

        $today = now()->toDateString();
        if ($pendaftaran->tanggal_kunjungan <= $today) {
            return back()->with('error', 'Antrian tidak bisa dibatalkan pada hari kunjungan!');
        }

        $pendaftaran->update(['status' => 'batal']);

        \App\Models\Notifikasi::create([
            'user_id'        => Auth::id(),
            'judul'          => 'Antrian Berhasil Dibatalkan',
            'pesan'          => 'Antrian kamu di ' . $pendaftaran->poli . ' pada tanggal ' .
                                Carbon::parse($pendaftaran->tanggal_kunjungan)->format('d M Y') .
                                ' telah dibatalkan.',
            'tipe'           => 'status_berubah',
            'pendaftaran_id' => $pendaftaran->id,
        ]);

        return back()->with('success', 'Antrian berhasil dibatalkan!');
    }

    public function cetakPDF($id)
    {
        $pendaftaran = Pendaftaran::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $qrUrl = url('/verifikasi-antrian/' . $pendaftaran->id);

        $pdf = Pdf::loadView('pasien.cetak-antrian', compact('pendaftaran', 'qrUrl'))
            ->setPaper('a5', 'portrait');
        $pdf->getDomPDF()->set_option('isRemoteEnabled', true);
        $pdf->getDomPDF()->set_option('isFontSubsettingEnabled', true);

        $namaFile = 'bukti-antrian-' . str_replace(' ', '-', strtolower($pendaftaran->nama_pasien)) . '-no' . $pendaftaran->nomor_antrian . '.pdf';
        return $pdf->download($namaFile);
    }

    public function updateStatus(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->update(['status' => $request->status]);

        $statusLabel = [
            'menunggu' => 'Menunggu',
            'selesai'  => 'Selesai',
            'batal'    => 'Batal',
        ];

        \App\Models\Notifikasi::create([
            'user_id'        => $pendaftaran->user_id,
            'judul'          => 'Status Antrian Diupdate',
            'pesan'          => 'Status antrian kamu pada tanggal ' .
                                Carbon::parse($pendaftaran->tanggal_kunjungan)->format('d M Y') .
                                ' telah diubah menjadi: ' . ($statusLabel[$request->status] ?? $request->status),
            'tipe'           => 'status_berubah',
            'pendaftaran_id' => $pendaftaran->id,
        ]);

        return back()->with('success', 'Status berhasil diupdate!');
    }
}