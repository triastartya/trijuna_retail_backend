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
        Schema::create('pos_tutup_kasir_detail_pendapatan', function (Blueprint $table) {
            $table->id('id_tutup_kasir_detail_pendapatan');
            $table->integer('id_tutup_kasir')->constrained('pos_tutup_kasir');
            $table->integer('id_payment_method')->constrained('pos_payment_method');
            $table->string('payment_method',100);
            $table->double('nominal',12,2);
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
        Schema::dropIfExists('pos_tutup_kasir_detail_pendapatan');
    }
};
