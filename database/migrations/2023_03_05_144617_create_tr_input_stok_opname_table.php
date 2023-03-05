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
        Schema::create('tr_input_stok_opname', function (Blueprint $table) {
            $table->id('id_input_stok_opname');
            $table->integer('id_setting_stok_opname');
            $table->integer('id_barang');
            $table->double('qty_fisik',12,2);
            $table->double('qty_capture',12,2);
            $table->double('qty_selisih',12,2);
            $table->string('keterngan',200);
            $table->double('hpp_average',12,2);
            $table->double('harga_jual',12,2);
            $table->double('sub_total_fisik_harga_jual',12,2);
            $table->double('sub_total_capture_harga_jual',12,2);
            $table->double('sub_total_selisih_harga_jual',12,2);
            $table->double('sub_total_fisik_hpp_average',12,2);
            $table->double('sub_total_capture_hpp_average',12,2);
            $table->double('sub_total_selisih_hpp_average',12,2);
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
        Schema::dropIfExists('tr_input_stok_opname');
    }
};
