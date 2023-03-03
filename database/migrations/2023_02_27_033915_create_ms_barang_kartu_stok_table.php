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
        Schema::create('ms_barang_kartu_stok', function (Blueprint $table) {
            $table->id('id_kartu_stok');
            $table->integer('tahun');
            $table->integer('bulan');
            $table->date('tanggal');
            $table->integer('id_barang')->constrained('ms_barang');
            $table->integer('id_warehouse')->constrained('ms_warehouse');
            $table->string('nomor_reff');
            $table->integer('id_header_tans');
            $table->integer('id_detail_trans');
            $table->double('stok_awal',12,2)->default(0);
            $table->double('nominal_awal',12,2)->default(0);
            $table->double('stok_masuk',12,2)->default(0);
            $table->double('nominal_masuk',12,2)->default(0);
            $table->double('stok_keluar',12,2)->default(0);
            $table->double('nominal_keluar',12,2)->default(0);
            $table->double('stok_akhir',12,2)->default(0);
            $table->double('nominal_akhir',12,2)->default(0);
            $table->string('keterangan')->nullable();
            $table->integer('user_created');
            $table->integer('user_updated');
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
        Schema::dropIfExists('ms_barang_kartu_stok');
    }
};
