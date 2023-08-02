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
            $table->id('id_mutasi_lokasi');
            $table->string('nomor_mutasi_lokasi');
            $table->date('tanggal_mutasi_lokasi');
            $table->integer('id_lokasi_asal')->constrained('ms_lokasi');
            $table->integer('warehouse_asal')->constrained('ms_warehouse');
            $table->integer('id_lokasi_tujuan')->constrained('ms_lokasi');
            $table->integer('warehouse_tujuan')->constrained('ms_warehouse');
            $table->double('qty');
            $table->double('total_harga');
            $table->string('status_mutasi_lokasi');
            $table->boolean('is_deleted');
            $table->integer('deleted_by')->nullable();
            $table->date('deleted_at')->nullable();
            $table->text('deleted_reason')->nullable();
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
