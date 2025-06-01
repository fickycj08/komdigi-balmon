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
        Schema::create('lokasi_pemancar', function (Blueprint $table) {
            $table->id();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->text('alamat')->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('telp_fax', 50)->nullable();
            $table->decimal('tinggi_lokasi_mdpl', 10, 2)->nullable();
            $table->decimal('tinggi_gedung_m', 10, 2)->nullable();
            $table->decimal('tinggi_menara_m', 10, 2)->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('lokasi_pemancar');
    }
};
