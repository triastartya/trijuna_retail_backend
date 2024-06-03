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
        Schema::create('tr_audit_stok_opname', function (Blueprint $table) {
            $table->id('id_audit_stok_opname');
            $table->string('nomor_audit_stok_opname',50);
            $table->integer('id_warehouse')->constrained('ms_warehouse');
            $table->integer('id_setting_stok_opname')->nullable();
            $table->integer('id_group')->nullable();
            $table->integer('id_rak')->nullable();
            $table->datetime('waktu_capture_stok')->nullable();
            $table->double('jumlah_fisik',12,2);
            $table->double('total_nominal_fisik',12,2);
            $table->double('jumlah_sistem_capture_stok',12,2);
            $table->double('total_nominal_sistem_capture_stok',12,2);
            $table->datetime('waktu_capture_stok_adj')->nullable();
            $table->double('jumlah_fisik_adj',12,2)->default(0);
            $table->double('total_nominal_fisik_adj',12,2)->default(0);
            $table->double('jumlah_sistem_capture_stok_adj',12,2)->default(0);
            $table->double('total_nominal_sistem_capture_stok_adj',12,2)->default(0);
            $table->double('jumlah_proses_selisih',12,2)->default(0);
            $table->double('total_nominal_proses_selisih',12,2)->default(0);
            $table->text('keterangan')->nullable();
            $table->text('keterangan_adj')->nullable();
            $table->text('keterangan_proses')->nullable();
            $table->string('status',20);
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('created_by_adj')->nullable();
            $table->integer('created_by_proses')->nullable();
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
        Schema::dropIfExists('tr_audit_stok_opname');
    }
};
