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
        Schema::create('tr_penerimaan_tanpa_po', function (Blueprint $table) {
            $table->id('id_penerimaan');
            $table->integer('jenis_penerimaan');
            $table->integer('id_supplier');
            $table->string('nomor_penerimaan',50);
            $table->string('no_nota',100);
            $table->date('tanggal_nota');
            $table->integer('id_lokasi')->constrained('ms_lokasi');
            $table->integer('id_warehouse')->constrained('ms_warehouse');
            $table->text('keterangan')->nullable();
            $table->string('status_penerimaan',20);
            $table->double('qty',12,2);
            $table->double('sub_total1',12,2);
            $table->double('diskon_persen',12,2);
            $table->double('diskon_nominal',12,2);
            $table->double('sub_total2',12,2);
            $table->double('ppn_nominal',12,2);
            $table->double('pembulatan',12,2);
            $table->double('total_transaksi',12,2);
            $table->double('total_biaya_barcode',12,2);
            $table->boolean('is_deleted')->default(false);
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
        Schema::dropIfExists('tr_penerimaan_tanpa_po');
    }
};
