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
        Schema::create('ms_member_poin_history', function (Blueprint $table) {
            $table->id('id_member_poin_history');
            $table->integer('id_penjualan');
            $table->string('no_faktur',150);
            $table->integer('id_barang');
            $table->string('keterangan',150);
            $table->double('nominal');
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
        Schema::dropIfExists('ms_member_poin_history');
    }
};
