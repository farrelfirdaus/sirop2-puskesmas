<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('pendaftaran', function (Blueprint $table)  {
        $table->string('jenis_pembayaran')->nullable()->after('tanggal_kunjungan');
        $table->string('nama_asuransi')->nullable()->after('jenis_pembayaran');
    });
}

public function down()
{
   Schema::table('pendaftaran', function (Blueprint $table) {
        $table->dropColumn(['jenis_pembayaran', 'nama_asuransi']);
    });
}
};
