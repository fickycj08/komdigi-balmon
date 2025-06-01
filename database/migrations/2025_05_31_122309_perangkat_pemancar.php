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
        Schema::create('perangkat_pemancar', function (Blueprint $table) {
            $table->id();
            $table->string('merk', 100)->nullable();
            $table->string('jenis_type', 100)->nullable();
            $table->string('nomor_seri', 50)->nullable();
            $table->string('negara_pembuat', 100)->nullable();
            $table->integer('tahun_pembuat')->nullable();
            $table->decimal('frekuensi_mhz', 10, 2)->nullable();
            $table->string('kelas_emisi', 20)->nullable();
            $table->decimal('bandwidth_khz', 10, 2)->nullable();
            $table->integer('kedalaman_modulasi_percent')->nullable();
            $table->decimal('max_power_dbm', 10, 2)->nullable();
            $table->string('jenis_antena', 100)->nullable();
            $table->string('polarisasi', 50)->nullable();
            $table->integer('jumlah_elemen_bay')->nullable();
            $table->decimal('gain_db', 10, 2)->nullable();
            $table->string('beam_arah', 100)->nullable();
            $table->string('jenis_kabel_feeder', 100)->nullable();
            $table->string('tipe_kabel', 100)->nullable();
            $table->decimal('panjang_kabel_m', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('perangkat_pemancar');
    }
};
