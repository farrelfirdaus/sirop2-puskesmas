<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->string('nik', 20)->unique()->after('id');
            $table->string('nama', 255)->after('nik');
            $table->string('tempat_lahir', 255)->after('nama');
            $table->date('tanggal_lahir')->after('tempat_lahir');
            $table->text('alamat')->after('tanggal_lahir');
            $table->string('no_hp', 15)->after('alamat');
            $table->string('agama', 50)->after('no_hp');
            $table->string('pendidikan_terakhir', 50)->after('agama');
            $table->string('pekerjaan', 100)->after('pendidikan_terakhir');
            $table->string('golongan_darah', 5)->after('pekerjaan');
        });
    }

    public function down(): void
    {
        Schema::table('pasien', function (Blueprint $table) {
            $table->dropColumn(['nik','nama','tempat_lahir','tanggal_lahir','alamat','no_hp','agama','pendidikan_terakhir','pekerjaan','golongan_darah']);
        });
    }
};