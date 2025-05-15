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
        Schema::create('penanganan_gangguan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gangguan_id')->constrained('gangguan')->onDelete('cascade');
            $table->text('analisis');
            $table->text('tindakan');
            $table->string('penyebab_gangguan');
            $table->string('status_aduan');
            $table->timestamp('tanggal_penanganan');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('penanganan_gangguan');
    }
};
