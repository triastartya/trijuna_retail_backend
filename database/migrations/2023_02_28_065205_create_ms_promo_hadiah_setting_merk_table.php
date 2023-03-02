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
        Schema::create('ms_promo_hadiah_setting_merk', function (Blueprint $table) {
            $table->id('id_promo_hadiah_setting_merk');
            $table->integer('id_promo_hadiah')->constrained('ms_promo_hadiah');
            $table->integer('id_merk')->constrained('ms_merk');
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
        Schema::dropIfExists('ms_promo_hadiah_setting_merk');
    }
};
