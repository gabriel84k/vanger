<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeccionecasegusurTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspeccionecasegusurs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('elementoAusente')->nullable();
            $table->tinyInteger('campana')->nullable();
            $table->tinyInteger('valvula_purga')->nullable();
            $table->tinyInteger('manometro')->nullable();
            $table->integer('codigoElementoEncontrado')->nullable();
            
            #[  Se crean las restricciones de clave externa para:puesto_id]
                $table->bigInteger('inspeccion_id')->unsigned()->index();
                $table->foreign('inspeccion_id')->references('id')->on('inspecciones');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspeccionecasegusurs');
    }
}
