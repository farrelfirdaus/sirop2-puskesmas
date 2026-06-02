<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PasienDashboardController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\AntrianController;

// Redirect ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
Route::get('/login', [LoginController::class, 'showForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// =====================
// ROUTE ADMIN
// =====================
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('pasien', PasienController::class);

    // Kelola dokter
    Route::resource('dokter', DokterController::class);

    // Lihat semua pendaftaran
    Route::get('/pendaftaran', [PendaftaranController::class, 'indexAdmin'])
        ->name('pendaftaran.admin');
    Route::patch('/pendaftaran/{id}/status', [PendaftaranController::class, 'updateStatus'])
        ->name('pendaftaran.updateStatus');
    // Antrian
    Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian.index');
    Route::post('/antrian/tambah', [AntrianController::class, 'tambah'])->name('antrian.tambah');
    Route::post('/antrian/panggil-berikutnya', [AntrianController::class, 'panggilBerikutnya'])->name('antrian.panggilBerikutnya');
    Route::post('/antrian/selesai', [AntrianController::class, 'selesai'])->name('antrian.selesai');
    Route::post('/antrian/lewati', [AntrianController::class, 'lewati'])->name('antrian.lewati');
    Route::post('/antrian/panggil-ulang', [AntrianController::class, 'panggilUlang'])->name('antrian.panggilUlang');
    Route::get('/antrian/data', [AntrianController::class, 'getData'])->name('antrian.getData');
});

// =====================
// ROUTE PASIEN
// =====================
Route::middleware(['auth', 'pasien'])->group(function () {
    // Lengkapi profil (wajib sebelum akses fitur lain)
    Route::get('/lengkapi-profil', [ProfilController::class, 'show'])
        ->name('profil.lengkapi');
    Route::post('/lengkapi-profil', [ProfilController::class, 'simpan'])
        ->name('profil.simpan');

    // Dashboard pasien
    Route::get('/beranda', [PasienDashboardController::class, 'index'])
        ->name('pasien.dashboard');

    // Jadwal dokter
    Route::get('/jadwal-dokter', [PasienDashboardController::class, 'jadwal'])
        ->name('pasien.jadwal');

    // Pendaftaran antrian
    Route::get('/daftar-antrian', [PendaftaranController::class, 'create'])
        ->name('pendaftaran.create');
    Route::post('/daftar-antrian', [PendaftaranController::class, 'store'])
        ->name('pendaftaran.store');

    // Riwayat kunjungan
    Route::get('/riwayat', [PendaftaranController::class, 'riwayat'])
        ->name('pendaftaran.riwayat');

    // Edit profil
    Route::get('/profil', [ProfilController::class, 'edit'])
        ->name('profil.edit');
    Route::patch('/profil', [ProfilController::class, 'update'])
        ->name('profil.update');
    // Notifikasi
    Route::get('/notifikasi', [NotifikasiController::class, 'index'])
        ->name('notifikasi.index');
    Route::get('/notifikasi/jumlah', [NotifikasiController::class, 'jumlahBelumDibaca'])
        ->name('notifikasi.jumlah');
    Route::patch('/notifikasi/{id}/baca', [NotifikasiController::class, 'tandaiDibaca'])
        ->name('notifikasi.baca');
    // Antrian Realtime
    Route::get('/api/antrian-realtime', function() {
    $today = now()->toDateString();

    $buatDataPoli = function($poli) use ($today) {
        $dipanggil = \App\Models\Pendaftaran::where('poli', $poli)
                        ->where('tanggal_kunjungan', $today)
                        ->where('status', 'dipanggil')
                        ->first();

        return [
            'nomor_dipanggil' => $dipanggil ? $dipanggil->nomor_antrian : null,
            'nama_dipanggil'  => $dipanggil ? $dipanggil->nama_pasien : null,
            'sudah_dilayani'  => \App\Models\Pendaftaran::where('poli', $poli)
                                    ->where('tanggal_kunjungan', $today)
                                    ->where('status', 'selesai')->count(),
            'menunggu'        => \App\Models\Pendaftaran::where('poli', $poli)
                                    ->where('tanggal_kunjungan', $today)
                                    ->where('status', 'menunggu')->count(),
        ];
    };

    return response()->json([
        'Poli Umum' => $buatDataPoli('Poli Umum'),
        'Poli Gigi' => $buatDataPoli('Poli Gigi'),
        'Poli KIA'  => $buatDataPoli('Poli KIA'),
    ]);
    })->name('antrian.realtime');

    // API posisi antrian pasien yang sedang login
    Route::get('/api/posisi-antrian-saya', function() {
        $today = now()->toDateString();
        $userId = auth()->id();

        // Cari antrian aktif pasien hari ini (menunggu atau dipanggil)
        $antrian = \App\Models\Pendaftaran::where('user_id', $userId)
            ->where('tanggal_kunjungan', $today)
            ->whereIn('status', ['menunggu', 'dipanggil', 'selesai'])
            ->first();

        if (!$antrian) {
            return response()->json(['ada' => false]);
        }

        // Hitung berapa orang di depan pasien ini (nomor antrian lebih kecil, masih menunggu/dipanggil)
        $didepan = 0;
        if ($antrian->status === 'menunggu') {
            $didepan = \App\Models\Pendaftaran::where('poli', $antrian->poli)
                ->where('tanggal_kunjungan', $today)
                ->where('status', 'menunggu')
                ->where('nomor_antrian', '<', $antrian->nomor_antrian)
                ->count();
        }

        return response()->json([
            'ada'           => true,
            'poli'          => $antrian->poli,
            'nomor_antrian' => $antrian->nomor_antrian,
            'status'        => $antrian->status,
            'posisi'        => $didepan,
        ]);
    })->name('antrian.posisi-saya');
// Batalkan antrian
    Route::patch('/pendaftaran/{id}/batal', [PendaftaranController::class, 'batalkan'])
        ->name('pendaftaran.batal');
// Download bukti antrian PDF
Route::get('/pendaftaran/{id}/cetak', [PendaftaranController::class, 'cetakPDF'])
    ->name('pendaftaran.cetak');
});
// Verifikasi antrian via QR Code (bisa diakses tanpa login)
Route::get('/verifikasi-antrian/{id}', function($id) {
    $pendaftaran = \App\Models\Pendaftaran::findOrFail($id);
    return view('verifikasi-antrian', compact('pendaftaran'));
})->name('antrian.verifikasi');