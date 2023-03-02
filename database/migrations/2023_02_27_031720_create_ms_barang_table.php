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
            $table->id();
            $table->integer('id_divisi')->constrained('ms_divisi');
            $table->integer('id_group')->constrained('ms_group');
            $table->string('kode_barang',50);
            $table->string('barcode',50);
            $table->string('image',100);
            $table->string('persediaan',50);
            $table->string('nama_barang',100);
            $table->integer('id_merek')->constrained('ms_merek');
            $table->string('ukuran',20);
            $table->string('warna',20);
            $table->double('berat',12,2);
            $table->string('id_supplier')->constrained('ms_supplier');
            $table->double('harga_order',12,2);
            $table->double('harga_beli_terakhir',12,2);
            $table->double('hpp_average',12,2);
            $table->boolean('is_ppn');
            $table->string('nama_label',100);
            $table->integer('id_satuan')->constrained('ms_satuan');
            $table->integer('margin');
            $table->integer('qty_grosir1');
            $table->double('harga_grosir1',12,2);
            $table->integer('qty_grosir2');
            $table->double('harga_grosir2',12,2);
            $table->integer('tahun_produksi',12.2);
            $table->integer('stok_min');
            $table->boolean('is_active');
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
