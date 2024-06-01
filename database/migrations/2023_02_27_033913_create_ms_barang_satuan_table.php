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
        Schema::create('ms_barang_satuan', function (Blueprint $table) {
            $table->id('id_barang_satuan');
            $table->integer('id_barang')->constrained('ms_barang');
            $table->integer('id_satuan')->constrained('ms_satuan');
            $table->integer('isi');
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
        Schema::dropIfExists('ms_barang_satuan');
    }
};
