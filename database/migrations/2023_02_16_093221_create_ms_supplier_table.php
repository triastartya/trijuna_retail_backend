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
            $table->string('alamat');
            $table->string('kota');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('keterangan');
            $table->boolean('is_pkp');
            $table->boolean('is_tanpa_po');
            $table->integer('limit_hutang');
            $table->string('no_handphone');
            $table->string('email');
            $table->double('sisa_hutang',12,2);
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
        Schema::dropIfExists('ms_suppliers');
    }
};
