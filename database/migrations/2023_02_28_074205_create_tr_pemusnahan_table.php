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
        Schema::create('tr_pemusnahan', function (Blueprint $table) {
            $table->id('id_pemusnahan');
            $table->date('tanggal_pemusnahan');
            $table->integer('id_warehouse');
            $table->string('keterangan');
            $table->double('total_hpp_avarage',12,2);
            $table->string('status_pemusnahan');
            $table->boolean('is_deleted');
            $table->integer('user_deleted');
            $table->date('time_deleted');
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
        Schema::dropIfExists('tr_pemusnahan');
    }
};
