<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_promo_bonus', function (Blueprint $table) {
            $table->id('id_promo_bonus');
            $table->string('kode_promo_bonus');
            $table->string('nama_promo_bonus');
            $table->boolean('is_kelipatan');
            $table->string('keterangan',200);
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->string('gambar');
            $table->boolean('is_active');
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ms_promo_bonus');
    }
};
