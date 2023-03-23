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
        Schema::create('tr_setting_harga_detail_lokasi', function (Blueprint $table) {
            $table->id('id_setting_harga_detail_lokasi');
            $table->integer('id_setting_harga_detail')->constrained('tr_setting_harga_detail');
            $table->integer('id_lokasi')->constrained('ms_lokasi');
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
        Schema::dropIfExists('tr_setting_harga_detail_lokasi');
    }
};
