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
        Schema::create('pos_refund', function (Blueprint $table) {
            $table->id('id_refund');
            $table->integer('id_user_kasir')->constrained('users');
            $table->integer('id_penjualan')->constrained('pos_penjualan');
            $table->date('tanggal_refund');
            $table->string('keterangan',200);
            $table->double('total_refund',12,2);
            $table->boolean('is_deleted');
            $table->integer('deleted_by')->nullable();
            $table->date('deleted_at')->nullable();
            $table->text('deleted_reason')->nullable();
            $table->integer('created_by');
            $table->integer('updated_by');
            $table->integer('id_tutup_kasir')->nullable();
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
        Schema::dropIfExists('pos_refund');
    }
};
