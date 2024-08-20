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
        Schema::create('pos_tutup_kasir_detail_pendapatan_cash', function (Blueprint $table) {
            $table->id();
            $table->integer('id_tutup_kasir_detail_pendapatan')->constrained('pos_tutup_kasir_detail_pendapatan');
            $table->double('nominal');
            $table->double('bayar');
            $table->double('kembalian');
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
        Schema::dropIfExists('pos_tutup_kasir_detail_pendapatan_cash');
    }
};
