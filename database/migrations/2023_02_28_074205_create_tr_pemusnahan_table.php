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
        Schema::create('tr_pemusnahan', function (Blueprint $table) {
            $table->id('id_pemusnahan');
            $table->date('tanggal_pemusnahan');
            $table->integer('id_warehouse');
            $table->string('keterangan');
            $table->double('total_hpp_avarage',12,2);
            $table->string('status_pemusnahan');
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
        Schema::dropIfExists('tr_pemusnahan');
    }
};
