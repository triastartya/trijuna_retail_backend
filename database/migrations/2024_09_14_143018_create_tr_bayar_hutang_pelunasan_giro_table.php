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
        Schema::create('tr_bayar_hutang_pelunasan_giro', function (Blueprint $table) {
            $table->id('id_bayar_hutang_pelunasan_giro');
            $table->integer('id_bayar_hutang_pelunasan')->constrained('tr_bayar_hutang_pelunasan');;
            $table->string('no_giro',100);
            $table->date('tanggal_jatuh_tempo');
            $table->double('nominal_bayar');
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
        Schema::dropIfExists('tr_bayar_hutang_pelunasan_giro');
    }
};
