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
        Schema::create('data_isr', function (Blueprint $table) {
            $table->id();
            $table->string('no_isr', 50)->nullable();
            $table->date('tanggal')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_isr');
    }
};
