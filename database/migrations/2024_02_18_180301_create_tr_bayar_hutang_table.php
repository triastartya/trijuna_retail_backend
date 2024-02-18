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
        Schema::create('tr_bayar_hutang', function (Blueprint $table) {
            $table->id('id_bayar_hutang');
            $table->string('nomor_titip_tagihan');
            $table->date('tanggal_titip_tagihan');
            $table->date('tanggal_rencana_bayar');
            $table->string('keterangan');
            $table->double('total_titip_tagihan',12,2);
            $table->double('total_potongan',12,2);
            $table->double('total_bayar',12,2);
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
        Schema::dropIfExists('tr_titip_tagihan_supplier');
    }
};
