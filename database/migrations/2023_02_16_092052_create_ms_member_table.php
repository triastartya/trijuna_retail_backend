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
        Schema::create('ms_member', function (Blueprint $table) {
            $table->id('id_member');
            $table->string('kode_member');
            $table->string('nama_member');
            $table->string('alamat');
            $table->string('kota');
            $table->string('kecamatan');
            $table->string('kelurahan');
            $table->string('pekerjaan')->nullable();
            $table->string('jenis_kelamin');
            $table->string('no_handphone');
            $table->string('email');
            $table->string('password');
            $table->string('jenis_identitas');
            $table->string('nomor_identitas');
            $table->date('tanggal_daftar');
            $table->integer('limit_piutang');
            $table->double('sisa_piutang',12,2)->default(0);
            $table->integer('jumlah_poin')->default(0);
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
        Schema::dropIfExists('ms_customers');
    }
};
