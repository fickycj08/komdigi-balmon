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
        Schema::create('monitoring', function (Blueprint $table) {
            $table->id();
            $table->string('upt')->nullable();
            $table->string('stasiun_monitor')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('kab_kota')->nullable();
            $table->string('alamat')->nullable();
            $table->decimal('lat', 10, 6)->nullable();
            $table->decimal('lng', 10, 6)->nullable();
            $table->string('no_spt')->nullable();
            $table->integer('isrmon_jumlah_isr')->nullable();
            $table->integer('isrmon_target')->nullable();
            $table->integer('isrmon_termonitor')->nullable();
            $table->float('isrmon_capaian')->nullable();
            $table->integer('target_pita')->nullable();
            $table->integer('occ_target_pita')->nullable();
            $table->float('occ_capaian')->nullable();
            $table->integer('iden_jumlah_termonitor')->nullable();
            $table->integer('iden_target')->nullable();
            $table->integer('iden_teridentifikasi')->nullable();
            $table->float('iden_capaian')->nullable();
            $table->float('capaian_pk_obs')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('monitoring');
    }
};
