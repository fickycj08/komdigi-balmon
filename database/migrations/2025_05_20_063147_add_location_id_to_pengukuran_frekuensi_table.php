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
    Schema::table('pengukuran_frekuensi', function (Blueprint $table) {
        $table->foreignId('location_id')
            ->nullable() // Optional: kalau boleh kosong
            ->constrained('locations') // Relasi ke tabel locations
            ->onDelete('set null');    // Optional: kalau lokasi dihapus, set null
    });
}

public function down()
{
    Schema::table('pengukuran_frekuensi', function (Blueprint $table) {
        $table->dropForeign(['location_id']);
        $table->dropColumn('location_id');
    });
}

};
