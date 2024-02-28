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
        Schema::create('ms_barang', function (Blueprint $table) {
            $table->id('id_barang');
            $table->integer('id_divisi')->constrained('ms_divisi')->nullable();
            $table->integer('id_group')->constrained('ms_group')->nullable();
            $table->string('kode_barang',50)->nullable();
            $table->string('barcode',50)->nullable();
            $table->string('image',100)->nullable();
            $table->string('persediaan',50)->nullable();
            $table->string('nama_barang',100)->nullable();
            $table->string('kode_satuan',50)->nullable();
            $table->integer('id_merk')->constrained('ms_merk')->nullable();
            $table->string('ukuran',20)->nullable();
            $table->string('warna',20)->nullable();
            $table->double('berat',12,2)->nullable();
            $table->integer('id_supplier')->constrained('ms_supplier')->nullable();
            $table->double('harga_order',12,2)->default(0)->nullable();
            $table->double('harga_beli_terakhir',12,2)->default(0)->nullable();
            $table->double('hpp_average',12,2)->default(0)->nullable();
            $table->boolean('is_ppn')->default(false)->nullable();
            $table->string('nama_label',100)->nullable();
            $table->integer('id_satuan')->constrained('ms_satuan')->nullable();
            $table->integer('margin')->default(0)->nullable();
            $table->integer('tahun_produksi')->nullable();
            $table->integer('stok_min')->default(0)->nullable();
            $table->boolean('is_active')->default(true)->nullable();
            $table->integer('diskon')->default(0)->nullable();
            $table->date('diskon_mulai')->nullable();
            $table->date('diskon_selesai')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->index('kode_satuan');
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
        Schema::dropIfExists('ms_barang');
    }
};
