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
        Schema::create('tr_retur_pembelian', function (Blueprint $table) {
            $table->id('id_retur_pembelian');
            $table->integer('jenis_retur');
            $table->string('nomor_retur_pembelian',50);
            $table->date('tanggal_retur_pembelian');
            $table->integer('id_warehouse')->constrained('ms_warehouse');
            $table->integer('id_supplier')->constrained('ms_supplier');
            $table->integer('mekanisme');
            $table->double('total_harga');
            $table->double('qty');
            $table->string('status_retur');
            $table->boolean('is_deleted');
            $table->integer('user_deleted');
            $table->date('time_deleted');
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
        Schema::dropIfExists('tr_retur_pembelian');
    }
};
