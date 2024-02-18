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
        Schema::create('tr_bayar_hutang_potongan', function (Blueprint $table) {
            $table->id('id_bayar_hutang_potongan');
            $table->integer('id_bayar_hutang');
            $table->integer('id_penerimaan');
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
        Schema::dropIfExists('tr_titip_tagihan_potongan');
    }
};
