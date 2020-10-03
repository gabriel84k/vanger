<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeccionkitsegusursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('inspeccionkitsegusurs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('elementoAusente',20)->nullable();
            $table->tinyInteger('gramillaAbsorbente')->nullable();
            $table->tinyInteger('tieneIDEquipo')->nullable();
            $table->tinyInteger('tieneBolsaAmarilla')->nullable();
            $table->tinyInteger('tieneMamelucoTyvex')->nullable();
            $table->tinyInteger('tieneAntiparra')->nullable();
            $table->tinyInteger('tieneGuantes')->nullable();
            $table->tinyInteger('tieneCajaAmarillaChica')->nullable();
            $table->tinyInteger('tieneCajaAmarillaGrande')->nullable();
            $table->tinyInteger('tieneCordonesAbsorbentes')->nullable();
            $table->tinyInteger('tieneVRM')->nullable();
            $table->string('mascaraID')->nullable();
            $table->tinyInteger('estadoMascara')->nullable();
            $table->string('vtoFiltroMascara')->nullable();
            $table->string('codigoElementoEncontrado', 20)->nullable();
            
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
        Schema::dropIfExists('inspeccionkitsegusurs');
    }
}
