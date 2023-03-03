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
        Schema::create('pos_refund_detail', function (Blueprint $table) {
            $table->id('id_refund_detail');
            $table->integer('id_refund')->constrained('pos_refund');
            $table->integer('urut');
            $table->integer('id_barang')->constrained('ms_barang');
            $table->double('qty_jual',12,2);
            $table->string('kode_satuan',100);
            $table->double('harga_jual',12,2);
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
        Schema::dropIfExists('pos_refund_detail');
    }
};
