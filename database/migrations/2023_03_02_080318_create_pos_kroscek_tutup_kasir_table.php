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
        Schema::create('pos_kroscek_tutup_kasir', function (Blueprint $table) {
            $table->id('id_kroscek_tutup_kasir');
            $table->integer('id_tutup_kasir')->constrained('pos_tutup_kasir');
            $table->double('pendapatan_versi_user',12,2);
            $table->double('pendapatan_versi_system',12,2);
            $table->double('selisih',12,2);
            $table->text('keterangan');
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
        Schema::dropIfExists('pos_kroscek_tutup_kasir');
    }
};
