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
        Schema::create('pos_tutup_kasir_detail_pengeluaran', function (Blueprint $table) {
            $table->id('id_tutup_kasir_detail_pengeluaran');
            $table->integer('id_tutup_kasir')->constrained('pos_tutup_kasir');
            $table->integer('id_pengeluaran')->constrained('pos_pengeluaran');
            $table->string('nama_pengeluaran',100);
            $table->double('nominal',12,2);
            $table->text('keterangan');
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
        Schema::dropIfExists('pos_tutup_kasir_detail_pengeluaran');
    }
};
