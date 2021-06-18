<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeccionbiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspeccionbies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idManguera')->nullable();
            $table->string('union')->nullable();
            $table->tinyInteger('estadoUnion')->nullable();
            $table->integer( 'junta')->nullable();
            $table->tinyInteger( 'tieneLanza')->nullable();
            $table->integer( 'lanza')->nullable();
            $table->tinyInteger('tieneBoquilla')->nullable();
            $table->integer('boquilla')->nullable();
            $table->integer('boquilla_id')->nullable();
        
            $table->integer('estadoGabinete')->nullable();
            $table->integer('estadoVidrio')->nullable();
            $table->tinyInteger('requierePintura')->nullable();
            $table->tinyInteger('requiereReemplazoGabinete')->nullable();
            $table->tinyInteger('tieneMedioDeRuptura')->nullable();
    
            $table->integer('cuerpo')->nullable();
            $table->integer('tapaValvula')->nullable();
            $table->integer('volante')->nullable();
            $table->integer('tuerca')->nullable();
            $table->integer('cantidadLlavesDeAjuste')->nullable();
            $table->string('comentarioLlaveDeAjuste',255)->nullable();
            $table->tinyInteger('reduccionPresente')->nullable();
            $table->tinyInteger('requiereReemplazoValvula')->nullable();
            $table->integer('asiento')->nullable();
            $table->integer('vastago')->nullable();
          
            $table->integer('nichoHidrante')->nullable();
            $table->integer('rompaVidrio')->nullable();
            $table->integer('controles')->nullable();
        
            #[  Se crean las restricciones de clave externa para:sectores_id y equipos_id]
                $table->bigInteger('inspeccion_id')->unsigned()->index();
                $table->foreign('inspeccion_id')->references('id')->on('inspecciones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspeccionbies');
    }
}
