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
        Schema::create('pos_pengeluaran', function (Blueprint $table) {
            $table->id('id_pengeluaran');
            $table->string('nama_pengeluaran',100);
            $table->string('keterangan',200)->nullable();
            $table->double('nominal',12,2);
            $table->integer('id_tutup_kasir')->nullable();
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
        Schema::dropIfExists('pos_pengeluaran');
    }
};
