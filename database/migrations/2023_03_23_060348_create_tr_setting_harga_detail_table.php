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
        Schema::create('tr_setting_harga_detail', function (Blueprint $table) {
            $table->id('id_setting_harga_detail');
            $table->datetime('tanggal_mulai_berlaku');
            $table->integer('id_setting_harga')->constrained('tr_setting_harga');
            $table->integer('id_barang')->constrained('ms_barang');
            $table->double('harga_jual');
            $table->double('qty_grosir1');
            $table->double('harga_grosir1');
            $table->double('qty_grosir2');
            $table->double('harga_grosir2');
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
        Schema::dropIfExists('tr_setting_harga_detail');
    }
};
