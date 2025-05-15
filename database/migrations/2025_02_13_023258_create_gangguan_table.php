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
        Schema::create('gangguan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('waktu_kejadian');
            $table->string('jenis_gangguan');
            $table->string('severity');
            $table->string('nama_client');
            $table->decimal('frekuensi', 10, 4);
            $table->string('band_frekuensi');
            $table->string('service');
            $table->string('sub_service');
            $table->string('sifat_gangguan');
            $table->text('uraian_gangguan');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('gangguan');
    }
};
