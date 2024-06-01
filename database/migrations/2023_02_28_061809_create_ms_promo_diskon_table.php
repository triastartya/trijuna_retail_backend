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
        Schema::create('ms_promo_diskon', function (Blueprint $table) {
            $table->id('id_promo_diskon');
            $table->boolean('is_nominal');
            $table->string('kode_promo_diskon');
            $table->string('nama_promo_diskon');
            $table->double('minimal_qty')->default(0);
            $table->double('diskon')->default(0);
            $table->integer('kuota')->default(0);
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->string('gambar');
            $table->boolean('is_active');
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
        Schema::dropIfExists('ms_promo_diskon');
    }
};
