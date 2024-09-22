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
        Schema::create('tr_faktur_pajak', function (Blueprint $table) {
            $table->id('id_faktur_pajak');
            $table->integer('id_penerimaan');
            $table->double('total_transaksi');
            $table->double('dasar_pengenaan_pajak');
            $table->double('ppn');
            $table->string('no_seri');
            $table->string('tanggal_faktur_pajak');
            $table->string('nama_ttd_faktur');
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
        Schema::dropIfExists('tr_faktur_pajak');
    }
};