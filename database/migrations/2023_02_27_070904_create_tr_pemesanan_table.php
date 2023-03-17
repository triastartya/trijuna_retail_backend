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
        Schema::create('tr_pemesanan', function (Blueprint $table) {
            $table->id('id_pemesanan');        
            $table->integer('id_supplier')->constrained('ms_supplier');
            $table->string('nomor_pemesanan',50);
            $table->date('tanggal_pemesanan');
            $table->date('tangal_expired_pemesanan');
            $table->integer('id_lokasi')->constrained('ms_lokasi');
            $table->integer('id_warehouse')->constrained('ms_warehouse');
            $table->date('tanggal_kirim');
            $table->text('keterangan')->nullable();
            $table->string('status_pemesanan',20);
            $table->double('qty',12,2);
            $table->double('sub_total1',12,2);
            $table->double('diskon_persen',12,2)->default(0);
            $table->double('diskon_nominal',12,2)->default(0);
            $table->double('sub_total2',12,2);
            $table->double('ppn_nominal',12,2)->default(0);
            $table->double('total_transaksi',12,2);
            $table->boolean('is_deleted')->nullable();
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
        Schema::dropIfExists('tr_pemesanan');
    }
};
