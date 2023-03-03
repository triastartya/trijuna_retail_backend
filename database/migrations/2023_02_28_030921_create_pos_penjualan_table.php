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
        Schema::create('pos_penjualan', function (Blueprint $table) {
            $table->id('id_penjualan');
            $table->integer('id_user_kasir')->constrained('users');
            $table->boolean('is_bayar');
            $table->date('tanggal_penjualan');
            $table->string('nota_penjualan',50);
            $table->integer('id_member');
            $table->double('diskon_dalam',12,2);
            $table->double('total_transaksi',12,2);
            $table->double('diskon_luar_persen',12,2);
            $table->double('diskon_luar_nominal',12,2);
            $table->double('ongkos_kirim',12,2);
            $table->double('total_transaksi2',12,2);
            $table->double('total_bayar',12,2);
            $table->double('kembalian',12,2);
            $table->boolean('is_deleted');
            $table->integer('user_deleted');
            $table->date('time_deleted');
            $table->integer('user_created');
            $table->integer('user_updated');
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
        Schema::dropIfExists('pos_penjualan');
    }
};
