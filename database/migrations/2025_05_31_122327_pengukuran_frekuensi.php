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
        Schema::create('pengukuran_frekuensi', function (Blueprint $table) {
            $table->id();
            $table->integer('kanal')->nullable();
            $table->decimal('frekuensi_terukur_mhz', 10, 2)->nullable();
            $table->decimal('level_dbm', 10, 2)->nullable();
            $table->decimal('bandwidth_khz', 10, 2)->nullable();
            $table->decimal('field_strength_dbuvm', 10, 2)->nullable();
            $table->decimal('deviasi_frekuensi_khz', 10, 2)->nullable();
            $table->integer('kedalaman_modulasi_percent')->nullable();
            $table->decimal('output_power_tx', 10, 2)->nullable();
            $table->decimal('cable_loss', 10, 2)->nullable();
            $table->decimal('frekuensi_h1_mhz', 10, 2)->nullable();
            $table->decimal('level_h1_dbm', 10, 2)->nullable();
            $table->decimal('frekuensi_h2_mhz', 10, 2)->nullable();
            $table->decimal('level_h2_dbm', 10, 2)->nullable();
            $table->decimal('frekuensi_h3_mhz', 10, 2)->nullable();
            $table->decimal('level_h3_dbm', 10, 2)->nullable();
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();
            $table->text('alamat')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengukuran_frekuensi');
    }
};
