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
    Schema::table('pendaftaran', function (Blueprint $table) {
        $table->string('poli')->after('user_id');
        $table->dropForeign(['dokter_id']);   // hapus foreign key dulu
        $table->dropColumn('dokter_id');      // baru hapus kolomnya
    });
}

public function down()
{
    Schema::table('pendaftaran', function (Blueprint $table) {
        $table->dropColumn('poli');
        $table->unsignedBigInteger('dokter_id')->nullable(); // rollback
    });
}
};
