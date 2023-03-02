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
        Schema::create('tr_pemesanan_detail', function (Blueprint $table) {
            $table->id('id_pemesanan_detail');
            $table->integer('id_pemesanan')->constrained('ms_pemesanan');
            $table->integer('urut');
            $table->integer('id_barang')->constrained('ms_barang');
            $table->double('banyak',12,2);
            $table->double('banyak_terima',12,2);
            $table->string('kode_satuan',50);
            $table->double('isi',12,2);
            $table->double('qty',12,2);
            $table->double('qty_terima',12,2);
            $table->double('harga_order',12,2);
            $table->double('diskon_persen_1',12,2);
            $table->double('diskon_nominal_1',12,2);
            $table->double('diskon_persen_2',12,2);
            $table->double('diskon_nominal_2',12,2);
            $table->double('diskon_persen_3',12,2);
            $table->double('diskon_nominal_3',12,2);
            $table->double('sub_total',12,2);
            $table->double('qty_bonus',12,2);
            $table->string('nama_bonus',50);
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
        Schema::dropIfExists('tr_pemesanan_detail');
    }
};
