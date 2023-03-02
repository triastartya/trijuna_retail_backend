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
        Schema::create('tr_repacking', function (Blueprint $table) {
            $table->id('id_repacking');
            $table->date('tanggal_repacking');
            $table->integer('id_warehouse')->constrained('ms_warehouse');
            $table->text('keterangan');
            $table->integer('id_barang')->constrained('ms_barang');
            $table->double('qty_barang',12,2);
            $table->double('hpp_avarage',12,2);
            $table->double('total_hpp_avarage',12,2);
            $table->double('total_hpp_avarage_repacking',12,2);
            $table->string('status_repacking');
            $table->boolean('is_deleted');
            $table->integer('user_deleted');
            $table->date('time_deleted');
            $table->integer('user_created');
            $table->integer('user_updated');
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
        Schema::dropIfExists('tr_repacking');
    }
};
