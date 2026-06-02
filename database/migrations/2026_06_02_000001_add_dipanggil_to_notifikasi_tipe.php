<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum kolom tipe di tabel notifikasi untuk tambah nilai 'dipanggil'
        DB::statement("ALTER TABLE notifikasi MODIFY COLUMN tipe ENUM('jadwal_h1','jadwal_hari_ini','status_berubah','dipanggil') NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE notifikasi MODIFY COLUMN tipe ENUM('jadwal_h1','jadwal_hari_ini','status_berubah') NOT NULL");
    }
};