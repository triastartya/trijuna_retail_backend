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
        Schema::create('ms_promo_diskon_setting_barang', function (Blueprint $table) {
            $table->id("id_promo_diskon_setting_barang");
            $table->integer('id_promo_diskon')->constrained('ms_promo_diskon');
            $table->integer('id_barang')->constrained('ms_barang');
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
        Schema::dropIfExists('ms_promo_diskon_setting_barang');
    }
};