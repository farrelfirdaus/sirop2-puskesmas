<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokter', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('spesialisasi');
            $table->string('hari_praktik');
            $table->string('jam_praktik');
            $table->integer('kuota_per_hari')->default(20);
            $table->enum('status', ['aktif', 'tidak aktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokter');
    }
};