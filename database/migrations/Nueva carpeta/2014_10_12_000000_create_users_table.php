<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idusuario')->nullable();
            $table->string('direccion',100)->nullable();
            $table->string('name')->nullable();
            $table->string('user')->unique();
            $table->string('permisos',100)->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->string('password');
            $table->boolean('estado');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
