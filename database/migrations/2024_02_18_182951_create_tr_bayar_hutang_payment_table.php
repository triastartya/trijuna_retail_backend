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
        Schema::create('tr_bayar_hutang_payment', function (Blueprint $table) {
            $table->id('id_bayar_hutang_payment');
            $table->integer('id_bayar_hutang');
            $table->date('tanggal_bayar_hutang');
            $table->string('cara_bayar');
            $table->integer('id_rekening_pengirim')->nullable();
            $table->string('no_rekening_pengirim')->nullable();
            $table->string('bank_pengirim')->nullable();
            $table->string('atas_nama_pengirim')->nullable();
            $table->integer('id_rekening_penerima')->nullable();
            $table->string('no_rekening_penerima')->nullable();
            $table->string('bank_penerima')->nullable();
            $table->string('atas_nama_penerima')->nullable();
            $table->string('keterangan')->nullable();
            $table->double('total_bayar');
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
        Schema::dropIfExists('tr_bayar_hutang_payment');
    }
};
