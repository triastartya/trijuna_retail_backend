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
        Schema::create('tr_mutasi_lokasi', function (Blueprint $table) {
            $table->id('id_tr_mutasi_lokasi');
            $table->integer('id_reff');
            $table->date('tanggal_mutasi_lokasi');
            $table->integer('id_lokasi_asal')->constrained('ms_lokasi');
            $table->integer('warehouse_asal')->constrained('ms_warehouse');
            $table->integer('id_lokasi_tujuan')->constrained('ms_lokasi');
            $table->integer('warehouse_tujuan')->constrained('ms_warehouse');
            $table->double('qty');
            $table->double('total_harga');
            $table->string('status_mutasi_lokasi');
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
        Schema::dropIfExists('tr_mutasi_lokasi');
    }
};
