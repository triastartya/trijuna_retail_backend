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
        Schema::create('users_group_menus', function (Blueprint $table) {
            $table->id('id_user_group');
            $table->integer('id_group')->constrained('user_groups');
            $table->integer('id_menu')->constrained('menus');
            $table->boolean('use_create');
            $table->boolean('use_read');
            $table->boolean('use_update');
            $table->boolean('use_delete');
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
        Schema::dropIfExists('users_group_menus');
    }
};
