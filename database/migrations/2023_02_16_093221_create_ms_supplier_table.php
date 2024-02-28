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
        Schema::create('ms_supplier', function (Blueprint $table) {
            $table->id('id_supplier');
            $table->string('kode_supplier');
            $table->string('nama_supplier');
            $table->string('alamat')->nullable();
            $table->string('kota')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('keterangan')->nullable();
            $table->boolean('is_pkp')->nullable();
            $table->boolean('is_tanpa_po')->nullable();
            $table->string('bank_rekening')->nullable();
            $table->string('nama_pemilik_rekening')->nullable();
            $table->string('nomor_rekening')->nullable();
            $table->integer('limit_hutang')->nullable();
            $table->string('no_handphone')->nullable();
            $table->string('email')->nullable();
            $table->double('sisa_hutang',12,2);
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
        Schema::dropIfExists('ms_suppliers');
    }
};
