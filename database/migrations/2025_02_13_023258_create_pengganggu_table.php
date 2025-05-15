<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        Schema::create('pengganggu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gangguan_id')->constrained('gangguan')->onDelete('cascade');
            $table->string('nama');
            $table->string('jenis_organisasi');
            $table->string('kontak')->nullable();
            $table->decimal('frekuensi', 10, 4);
            $table->string('band_frekuensi');
            $table->string('status_pelanggaran');
            $table->string('service');
            $table->string('sub_service');
            $table->string('kab_kota');
            $table->string('kecamatan');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('pengganggu');
    }
}; 