<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlanillasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planillas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('IdSigex'); 
            $table->timestamp('fecha_servicio');  
            $table->integer('nro_planilla'); 
            $table->string('orden_trabajo',255)->nullable();  
            $table->integer('cantidadMat'); 
            $table->integer('idEstado');

            #[  Se crean las restricciones de clave externa para:sectores_id y equipos_id]
                $table->bigInteger('sucursal_id')->unsigned()->index();
                $table->foreign('sucursal_id')->references('id')->on('sucursales');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planillas');
    }
}
