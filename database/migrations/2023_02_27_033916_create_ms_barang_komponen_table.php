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
        Schema::create('ms_barang_komponen', function (Blueprint $table) {
            $table->id('id_barang_komponen');
            $table->integer('id_barang')->constrained('ms_barang');
            $table->integer('komponen_barang')->constrained('ms_barang');
            $table->double('qty_komponen');
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
        Schema::dropIfExists('ms_barang_komponen');
    }
};
