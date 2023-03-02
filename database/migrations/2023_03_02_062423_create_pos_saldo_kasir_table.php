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
        Schema::create('pos_saldo_kasir', function (Blueprint $table) {
            $table->id('id_saldo_kasir');
            $table->integer('id_user_kasir')->constrained('users');
            $table->date('tanggal_saldo_kasir');
            $table->integer('id_tutup_kasir');
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
        Schema::dropIfExists('pos_saldo_kasir');
    }
};
