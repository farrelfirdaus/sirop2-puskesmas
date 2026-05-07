<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien');
            $table->text('keluhan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};