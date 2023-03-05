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
        Schema::create('tr_setting_stok_opname', function (Blueprint $table) {
            $table->id('id_setting_stok_opname');
            $table->string('nomor_stok_opname',50);
            $table->datetime('tanggal_setting_stok_opname');
            $table->string('jenis_stok_opname');
            $table->text('keterangan');
            $table->double('total_fisik_harga_jual',12,2);
            $table->double('total_capture_harga_jual',12,2);
            $table->double('total_selisih_harga_jual',12,2);
            $table->double('total_capture_hpp_average',12,2);
            $table->double('total_fisik_hpp_average',12,2);
            $table->double('total_selisih_hpp_average',12,2);
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
        Schema::dropIfExists('tr_setting_stok_opname');
    }
};
