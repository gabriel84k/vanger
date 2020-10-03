<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idsigexservicio')->nullable(); 
            $table->integer('orden')->nullable(); 
            $table->timestamp('fechaRecepcion')->nullable(); 
            $table->timestamp('fechaReparaciones')->nullable(); 
            $table->timestamp('fechaServicio')->nullable(); 
            $table->integer('calificacion')->nullable(); 
            $table->tinyInteger('vehicular')->nullable(); 
            $table->string('dominio',10)->nullable(); 
            $table->tinyInteger('realizarPH')->nullable(); 
            $table->tinyInteger('realizarPintura')->nullable(); 
            $table->tinyInteger('realizarOtros')->nullable(); 
            $table->string('observaciones',255)->nullable(); 
            $table->integer('estado')->nullable(); 
            $table->string('servicioARealizar',2); 
            $table->integer('calculoPH')->nullable(); 
            $table->double('reposicion')->nullable(); 
            $table->integer('estadoDelPolvo')->nullable(); 
            $table->integer('idMarcaLote')->nullable(); 
            $table->string('marcaLoteTexto',100)->nullable(); 
            $table->integer('idPotencial')->nullable();
            $table->tinyInteger('realizoPH')->nullable(); 
            $table->string('inspeccionVisual',50)->nullable(); 
            $table->string('recipiente',50)->nullable(); 
            $table->integer('idOperadorInspeccion')->nullable(); 
            $table->integer('numeroCertificadoCarga')->nullable(); 
            $table->integer('numeroCertificadoPH')->nullable(); 

            #[  Se crean las restricciones de clave externa para:sectores_id y equipos_id]
                $table->bigInteger('planilla_id')->unsigned()->index();
                $table->foreign('planilla_id')->references('id')->on('planillas');

                $table->bigInteger('elemento_id')->unsigned()->index();
                $table->foreign('elemento_id')->references('id')->on('elementos');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicios');
    }
}
