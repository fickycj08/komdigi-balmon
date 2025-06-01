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
        Schema::create('gangguan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->dateTime('waktu_kejadian')->nullable();
            $table->string('jenis_gangguan')->nullable();
            $table->string('severity')->nullable();
            $table->string('nama_client')->nullable();
            $table->string('frekuensi')->nullable();
            $table->string('band_frekuensi')->nullable();
            $table->string('service')->nullable();
            $table->string('sub_service')->nullable();
            $table->string('sifat_gangguan')->nullable();
            $table->text('uraian_gangguan')->nullable();
            $table->float('latitude', 10, 6)->nullable();
            $table->float('longitude', 10, 6)->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('no_st')->nullable();
            $table->string('vic')->nullable();
            $table->string('no_laporan')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();

            // Foreign key (optional, bisa di-uncomment kalau tabel relasinya udah ada)
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('gangguan');
    }
};
