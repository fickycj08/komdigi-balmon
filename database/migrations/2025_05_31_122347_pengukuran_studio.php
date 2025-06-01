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
        Schema::create('pengukuran_studio', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_stl', 100)->nullable();
            $table->string('no_spt', 50)->nullable();
            $table->date('tgl_spt')->nullable();
            $table->string('jenis_sbk', 100)->nullable();
            $table->string('kecamatan', 100)->nullable();
            $table->text('jalan')->nullable();
            $table->string('merk_alat_ukur', 100)->nullable();
            $table->string('tipe_alat_ukur', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pengukuran_studio');
    }
};
