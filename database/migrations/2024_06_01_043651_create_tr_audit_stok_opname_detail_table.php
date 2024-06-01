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
        Schema::create('tr_audit_stok_opname_detail', function (Blueprint $table) {
            $table->id('id_audit_stok_opname_detail');
            $table->integer('id_audit_stok_opname')->constrained('tr_audit_stok_opname');
            $table->integer('no_urut');
            $table->integer('id_barang')->constrained('ms_barang');
            $table->double('harga_jual',12,2);
            $table->double('hpp_avarage',12,2);
            $table->datetime('waktu_capture_stok');
            $table->double('qty_fisik',12,2);
            $table->double('qty_sistem_capture_stok',12,2);
            $table->double('sub_total_fisik',12,2);
            $table->double('sub_total_sistem_capture_stok',12,2);
            $table->datetime('waktu_capture_stok_adj');
            $table->double('qty_fisik_adj',12,2)->default(0);
            $table->double('qty_sistem_capture_stok_adj',12,2)->default(0);
            $table->double('sub_total_fisik_adj',12,2)->default(0);
            $table->double('sub_total_sistem_capture_stok_adj',12,2)->default(0);
            $table->double('qty_proses_selisih',12,2)->default(0);
            $table->double('sub_total_proses_selisih',12,2);
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
        Schema::dropIfExists('tr_audit_stok_opname_detail');
    }
};
