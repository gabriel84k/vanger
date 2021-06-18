<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idsector');
            $table->string('numero',10);
            $table->string('nombre',127);
            $table->timestamps();
            #[  Se crean las restricciones de clave externa para:sucursal_id]
                $table->bigInteger('sucursales_id')->unsigned()->index();
                $table->foreign('sucursales_id')->references('id')->on('sucursales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sector', function (Blueprint $table) {
            #--------------------------------------
            $table->dropForeign(['sucursal_id']);
            $table->dropColumn('sucursal_id'); 
            #--------------------------------------
        });
        Schema::dropIfExists('sector');
    }
}
