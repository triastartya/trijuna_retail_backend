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
        Schema::create('pos_tutup_kasir', function (Blueprint $table) {
            $table->id('id_tutup_kasir');
            $table->integer('id_user_kasir')->constrained('users');
            $table->date('tanggal_tutup_kasir');
            $table->double('modal_kasir',12,2);
            $table->double('pengeluaran',12,2);
            $table->double('penerimaan',12,2);
            $table->double('sisa_saldo',12,2);
            $table->text('keterangan');
            $table->string('status_tutup_kasir',10);
            $table->integer('id_kroscek_tutup_kasir');
            $table->boolean('is_deleted');
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
        Schema::dropIfExists('pos_tutup_kasir');
    }
};
