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
        Schema::create('tr_setting_stok_opname_barang', function (Blueprint $table) {
            $table->id('id_setting_stok_opname_barang');
            $table->integer('id_setting_stok_opname');
            $table->integer('id_barang');
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
        Schema::dropIfExists('tr_setting_stok_opname_barang');
    }
};
