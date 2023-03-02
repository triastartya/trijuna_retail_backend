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
        Schema::create('tr_mutasi_lokasi_detail', function (Blueprint $table) {
            $table->id('id_mutasi_lokasi_detail');
            $table->integer('id_mutasi_lokasi')->constrained('tr_mutasi_lokasi');
            $table->integer('urut');
            $table->integer('id_barang')->constrained('ms_barang');
            $table->double('banyak',12,2);
            $table->string('kode_satuan',50);
            $table->double('isi',12,2);
            $table->double('qty',12,2);
            $table->double('harga_satuan',12,2);
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
        Schema::dropIfExists('tr_mutasi_lokasi_detail');
    }
};
