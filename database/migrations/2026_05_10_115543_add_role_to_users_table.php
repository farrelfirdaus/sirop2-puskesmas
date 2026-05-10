<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'pasien'])->default('pasien')->after('email');
            $table->string('nik', 20)->nullable()->after('role');
            $table->string('tempat_lahir')->nullable()->after('nik');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->text('alamat')->nullable()->after('tanggal_lahir');
            $table->string('no_hp', 15)->nullable()->after('alamat');
            $table->string('agama', 50)->nullable()->after('no_hp');
            $table->string('pendidikan_terakhir', 50)->nullable()->after('agama');
            $table->string('pekerjaan', 100)->nullable()->after('pendidikan_terakhir');
            $table->string('golongan_darah', 5)->nullable()->after('pekerjaan');
            $table->boolean('profil_lengkap')->default(false)->after('golongan_darah');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role','nik','tempat_lahir','tanggal_lahir',
                'alamat','no_hp','agama','pendidikan_terakhir','pekerjaan',
                'golongan_darah','profil_lengkap']);
        });
    }
};