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
        Schema::create('tr_produksi', function (Blueprint $table) {
            $table->id('id_produksi');
            $table->string('nomor_produksi');
            $table->date('tanggal_produksi');
            $table->integer('id_warehouse')->constrained('ms_warehouse');
            $table->text('keterangan')->nullable();
            $table->integer('id_barang')->constrained('ms_barang');
            $table->double('qty_produksi',12,2);
            $table->double('hpp_avarage_produksi',12,2);
            $table->double('total_hpp_avarage_produksi',12,2);
            $table->double('total_hpp_avarage_komponen',12,2);
            $table->string('status_produksi');
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
        Schema::dropIfExists('tr_produksi');
    }
};
