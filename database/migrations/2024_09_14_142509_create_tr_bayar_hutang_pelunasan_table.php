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
        Schema::create('tr_bayar_hutang_pelunasan', function (Blueprint $table) {
            $table->id('id_bayar_hutang_pelunasan');
            $table->string('nomor_pelunasan');
            $table->integer('id_bayar_hutang')->constrained('tr_bayar_hutang');
            $table->date('tanggal_bayar');
            $table->string('methode_bayar',20);
            $table->string('keterangan',200);
            $table->double('jumlah_bayar');
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
        Schema::dropIfExists('tr_bayar_hutang_pelunasan');
    }
};
