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
        Schema::create('tr_input_stok_opname_detail', function (Blueprint $table) {
            $table->id('id_input_stok_opname_detail');
            $table->integer('id_input_stok_opname');
            $table->integer('id_barang');
            $table->double('qty_fisik',12,2);
            $table->text('keterangan');
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
        Schema::dropIfExists('tr_input_stok_opname_detail');
    }
};
