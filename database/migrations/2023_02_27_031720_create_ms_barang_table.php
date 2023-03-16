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
            $table->integer('id_divisi')->constrained('ms_divisi');
            $table->integer('id_group')->constrained('ms_group');
            $table->string('kode_barang',50);
            $table->string('barcode',50);
            $table->string('image',100);
            $table->string('persediaan',50);
            $table->string('nama_barang',100);
            $table->integer('id_merk')->constrained('ms_merk');
            $table->string('ukuran',20)->nullable();
            $table->string('warna',20)->nullable();
            $table->double('berat',12,2)->nullable();
            $table->string('id_supplier')->constrained('ms_supplier');
            $table->double('harga_order',12,2)->default(0);
            $table->double('harga_beli_terakhir',12,2)->default(0);
            $table->double('hpp_average',12,2)->default(0);
            $table->boolean('is_ppn')->default(false);
            $table->string('nama_label',100)->nullable();
            $table->integer('id_satuan')->constrained('ms_satuan');
            $table->integer('margin')->default(0);
            $table->integer('qty_grosir1')->default(0);
            $table->double('harga_grosir1',12,2)->default(0);
            $table->integer('qty_grosir2')->default(0);
            $table->double('harga_grosir2',12,2)->default(0);
            $table->integer('tahun_produksi')->nullable();
            $table->integer('stok_min')->default(0);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('ms_barang');
    }
};
