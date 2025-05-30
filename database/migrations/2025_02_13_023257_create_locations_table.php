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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->string('kota');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('kode_wilayah');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('locations');
    }
};
