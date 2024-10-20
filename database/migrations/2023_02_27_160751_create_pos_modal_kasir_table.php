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
        Schema::create('pos_modal_kasir', function (Blueprint $table) {
            $table->id('id_modal_kasir');
            $table->integer('id_user_kasir')->constrained('users');
            $table->date('tanggal_modal_kasir');
            $table->double('modal_kasir',12,2);
            $table->boolean('is_deleted')->default(false);
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
        Schema::dropIfExists('pos_modal_kasir');
    }
};
