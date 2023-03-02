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
        Schema::create('pos_penjualan_peyment', function (Blueprint $table) {
            $table->id('id_penjualan_peyment');
            $table->integer('id_pos_penjualan')->constrained('pos_penjualan');
            $table->integer('urut');
            $table->string('jenis_pembayar');
            $table->double('jumlah_bayar');
            $table->text('keterangan');
            $table->integer('id_voucher');
            $table->integer('id_payment_method');
            $table->integer('id_bank');
            $table->integer('id_edc');
            $table->string('trace_number',50);
            $table->string('jenis_kartu',50);
            $table->string('card_holder',50);
            $table->date('tanggal_jatuh_tempo_piutang');
            $table->text('keterangan_piutang');
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
        Schema::dropIfExists('pos_penjualan_peyment');
    }
};
