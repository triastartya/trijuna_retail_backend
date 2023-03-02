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
        Schema::create('tr_produksi_detail', function (Blueprint $table) {
            $table->id('id_produksi_detail');
            $table->integer('id_produksi')->constrained('ms_produksi');
            $table->integer('id_barang')->constrained('ms_barang');
            $table->double('qty',12,2);
            $table->string('kode_satuan');
            $table->double('hpp_average',12,2);
            $table->double('sub_total',12,2);
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
        Schema::dropIfExists('tr_produksi_detail');
    }
};
