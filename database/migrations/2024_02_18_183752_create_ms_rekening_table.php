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
        Schema::create('ms_rekening', function (Blueprint $table) {
            $table->id('id_rekening');
            $table->integer('id_supplier');
            $table->boolean('pemilik');
            $table->string('no_rekening');
            $table->string('bank');
            $table->string('atas_nama');
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
        Schema::dropIfExists('ms_rekening');
    }
};
