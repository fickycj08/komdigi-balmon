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
        Schema::create('pengganggu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gangguan_id');
            $table->string('nama');
            $table->string('jenis_organisasi');
            $table->string('kontak')->nullable();
            $table->decimal('frekuensi', 10, 4);
            $table->string('band_frekuensi');
            $table->string('status_pelanggaran');
            $table->string('service');
            $table->string('sub_service');
            $table->string('kecamatan');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->unsignedBigInteger('location_id');
            $table->string('jalan');
            $table->string('alamat_lengkap');
            $table->timestamps();

            // Foreign key
            $table->foreign('gangguan_id')->references('id')->on('gangguan')->onDelete('cascade');
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengganggu');
    }
};
