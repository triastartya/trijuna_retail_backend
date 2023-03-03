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
        Schema::create('ms_barang_stok', function (Blueprint $table) {
            $table->id('id_barang_stok');
            $table->integer('id_barang')->constrained('ms_barang');
            $table->integer('id_warehouse')->constrained('ms_warehouse');
            $table->double('qty');
            $table->double('stok_min')->default(0);
            $table->double('stok_max')->default(0);
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
        Schema::dropIfExists('ms_barang_stok');
    }
};