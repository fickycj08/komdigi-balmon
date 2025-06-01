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
        Schema::create('stasiun_radio', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penyelenggara', 100)->nullable();
            $table->text('alamat')->nullable();
            $table->string('kelurahan', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->string('telp_fax', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stasiun_radio');
    }
};
