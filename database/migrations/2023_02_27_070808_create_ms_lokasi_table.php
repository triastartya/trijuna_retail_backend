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
        Schema::create('ms_lokasi', function (Blueprint $table) {
            $table->id('id_lokasi');
            $table->string('kode',50);
            $table->string('nama',100);
            $table->text('alamat');
            $table->string('telepon',50);
            $table->string('npwp',50);
            $table->string('server',50);
            $table->boolean('is_use');
            $table->boolean('is_active');
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
        Schema::dropIfExists('ms_lokasi');
    }
};
