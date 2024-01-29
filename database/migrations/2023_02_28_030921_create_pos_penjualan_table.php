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
            $table->integer('id_member')->nullable();
            $table->double('total_diskon_dalam',12,2)->default(0);
            $table->double('total_transaksi',12,2);
            $table->double('diskon_luar_persen',12,2)->default(0);
            $table->double('diskon_luar_nominal',12,2)->default(0);
            $table->double('ongkos_kirim',12,2)->default(0);
            $table->double('pembulatan',12,2)->default(0);
            $table->double('total_transaksi2',12,2);
            $table->double('total_bayar',12,2);
            $table->double('kembali',12,2)->default(0);
            $table->double('biaya_bank')->default(0);
            $table->boolean('is_using_voucher')->default(false);
            $table->string('id_pos_kasir');
            $table->integer('id_tutup_kasir')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->integer('deleted_by')->nullable();
            $table->date('deleted_at')->nullable();
            $table->text('deleted_reason')->nullable();
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
        Schema::dropIfExists('pos_penjualan');
    }
};
