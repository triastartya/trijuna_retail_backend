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
        Schema::create('ms_promo_hadiah_setting_supplier', function (Blueprint $table) {
            $table->id('id_promo_hadiah_setting_supplier');
            $table->integer('id_promo_hadiah')->constrained('ms_promo_hadiah');
            $table->integer('id_supplier')->constrained('ms_supplier');
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
        Schema::dropIfExists('ms_promo_hadiah_setting_supplier');
    }
};
