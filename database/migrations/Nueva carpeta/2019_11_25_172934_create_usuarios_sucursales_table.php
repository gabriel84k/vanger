<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosSucursalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Usuarios_Sucursales', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('sucursales_id')->unsigned()->nullable()->index();
            $table->foreign('sucursales_id')->references('id')->on('sucursales')->onDelete('cascade');

            $table->bigInteger('user_id')->unsigned()->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
                
        Schema::dropIfExists('usuarios_sucursales');
    }
}
