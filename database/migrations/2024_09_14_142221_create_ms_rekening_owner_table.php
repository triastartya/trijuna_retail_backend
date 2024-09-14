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
        Schema::create('ms_rekening_owner', function (Blueprint $table) {
            $table->id('id_rekening');
            $table->string('bank',50);
            $table->string('nama_rekening',100);
            $table->string('nomor_rekening',100);
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
        Schema::dropIfExists('ms_rekening_owner');
    }
};
