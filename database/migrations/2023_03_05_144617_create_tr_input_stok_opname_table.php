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
        Schema::create('tr_input_stok_opname', function (Blueprint $table) {
            $table->id('id_input_stok_opname');
            $table->integer('id_setting_stok_opname');
            $table->string('keterngan',200);
            $table->double('hpp_average',12,2);
            $table->integer('id_user');
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
        Schema::dropIfExists('tr_input_stok_opname');
    }
};
