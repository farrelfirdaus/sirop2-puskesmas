<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('dokter_id')->constrained('dokter');
            $table->string('nama_pasien');
            $table->string('nik_pasien', 20);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('no_hp', 15);
            $table->string('agama', 50);
            $table->string('pendidikan_terakhir', 50);
            $table->string('pekerjaan', 100);
            $table->string('golongan_darah', 5);
            $table->date('tanggal_kunjungan');
            $table->text('keluhan');
            $table->integer('nomor_antrian');
            $table->enum('untuk', ['diri_sendiri', 'orang_lain'])->default('diri_sendiri');
            $table->enum('status', ['menunggu', 'selesai', 'batal'])->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};