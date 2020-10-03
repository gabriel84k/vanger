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
            $table->date('fechaRecepcion')->nullable();
            $table->date('fechaReparaciones')->nullable();
            $table->date('fechaServicio')->nullable();
            $table->integer('calificacion')->nullable();
            $table->boolean('vehicular')->nullable();
            $table->string('dominio',10)->nullable();
            $table->boolean('realizarPH')->nullable();
            $table->boolean('realizarPintura')->nullable();
            $table->boolean('realizarOtros')->nullable();
            $table->string('observaciones',255)->nullable();
            $table->integer('estado')->nullable();
            $table->string('servicioARealizar',2);//not null
            $table->integer('calculoPH')->nullable();
           
            $table->float('reposicion')->nullable();
            $table->integer('estadoDelPolvo')->nullable();
            $table->integer('idMarcaLote')->nullable();
            $table->string('marcaLoteTexto',100)->nullable();
            $table->integer('idPotencial')->nullable();
            $table->boolean('realizoPH')->nullable();
            $table->string('inspeccionVisual',50)->nullable();
            $table->string('recipiente',50)->nullable();
            $table->integer('idOperadorInspeccion')->nullable();
            $table->integer('numeroCertificadoCarga')->nullable();
            $table->integer('numeroCertificadoPH')->nullable();
            
           
            #[  Se crean las restricciones de clave externa para:sectores_id y equipos_id]
                $table->bigInteger('planillas_id')->unsigned()->index();
                $table->foreign('planillas_id')->references('id')->on('planillas')->onDelete('cascade');
                
                $table->bigInteger('equipos_id')->unsigned()->index();
                $table->foreign('equipos_id')->references('id')->on('equipos');

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
