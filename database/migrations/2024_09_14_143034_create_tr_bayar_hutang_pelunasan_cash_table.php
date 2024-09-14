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
        Schema::create('tr_bayar_hutang_pelunasan_cash', function (Blueprint $table) {
            $table->id('id_bayar_hutang_pelunasan_cash');
            $table->integer('id_bayar_hutang_pelunasan')->constrained('tr_bayar_hutang_pelunasan');;
            $table->string('penerima_uang',100);
            $table->string('pemberi_uang',100);
            $table->string('keterangan',200);
            $table->dateTime('waktu_penyerahan');
            $table->double('nominal_bayar');
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
        Schema::dropIfExists('tr_bayar_hutang_pelunasan_cash');
    }
};
