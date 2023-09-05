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
        Schema::create('pos_penjualan_detail', function (Blueprint $table) {
            $table->id('id_pos_penjualan_detail');
            $table->integer('id_pos_penjualan')->constrained('pos_penjualan');
            $table->integer('urut');
            $table->integer('id_barang')->constrained('ms_barang');
            $table->double('qty_jual',12,2);
            $table->string('kode_satuan');
            $table->double('harga_jual',12,2);
            $table->double('diskon1',12,2);
            $table->double('diskon2',12,2);
            $table->double('sub_total',12,2);
            $table->string('display_diskon1',10);
            $table->string('display_diskon2',10);
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
        Schema::dropIfExists('pos_penjualan_barang');
    }
};