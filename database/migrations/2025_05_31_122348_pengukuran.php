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
        Schema::create('pengukuran', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_isr_id');
            $table->unsignedBigInteger('stasiun_radio_id');
            $table->unsignedBigInteger('lokasi_pemancar_id');
            $table->unsignedBigInteger('perangkat_pemancar_id');
            $table->unsignedBigInteger('pengukuran_frekuensi_id');
            $table->unsignedBigInteger('pengukuran_studio_id');
            $table->date('tanggal_pengukuran')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Foreign key
            $table->foreign('data_isr_id')->references('id')->on('data_isr')->onDelete('cascade');
            $table->foreign('stasiun_radio_id')->references('id')->on('stasiun_radio')->onDelete('cascade');
            $table->foreign('lokasi_pemancar_id')->references('id')->on('lokasi_pemancar')->onDelete('cascade');
            $table->foreign('perangkat_pemancar_id')->references('id')->on('perangkat_pemancar')->onDelete('cascade');
            $table->foreign('pengukuran_frekuensi_id')->references('id')->on('pengukuran_frekuensi')->onDelete('cascade');
            $table->foreign('pengukuran_studio_id')->references('id')->on('pengukuran_studio')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengukuran');
    }
};
