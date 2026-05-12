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
    
    return response()->json([
        'Poli Umum' => [
            'sedang'   => \App\Models\Pendaftaran::where('poli', 'Poli Umum')
                            ->where('tanggal_kunjungan', $today)
                            ->where('status', 'selesai')->count(),
            'menunggu' => \App\Models\Pendaftaran::where('poli', 'Poli Umum')
                            ->where('tanggal_kunjungan', $today)
                            ->where('status', 'menunggu')->count(),
        ],
        'Poli Gigi' => [
            'sedang'   => \App\Models\Pendaftaran::where('poli', 'Poli Gigi')
                            ->where('tanggal_kunjungan', $today)
                            ->where('status', 'selesai')->count(),
            'menunggu' => \App\Models\Pendaftaran::where('poli', 'Poli Gigi')
                            ->where('tanggal_kunjungan', $today)
                            ->where('status', 'menunggu')->count(),
        ],
        'Poli KIA' => [
            'sedang'   => \App\Models\Pendaftaran::where('poli', 'Poli KIA')
                            ->where('tanggal_kunjungan', $today)
                            ->where('status', 'selesai')->count(),
            'menunggu' => \App\Models\Pendaftaran::where('poli', 'Poli KIA')
                            ->where('tanggal_kunjungan', $today)
                            ->where('status', 'menunggu')->count(),
        ],
        ]);
    })->name('antrian.realtime');
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