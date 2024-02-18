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
        Schema::create('tr_bayar_piutang', function (Blueprint $table) {
            $table->id('id_bayar_piutang');
            $table->date('tanggal_bayar');
            $table->string('nomor_bayar_piutang');
            $table->string('total_bayar_piutang');
            $table->string('keterangan');
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
        Schema::dropIfExists('tr_bayar_piutang');
    }
};
