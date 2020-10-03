<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReparacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reparaciones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idrepsigex');
            $table->integer('resultado'); 
            $table->integer('idServiciosigex'); 
            $table->integer('idRepuestosigex'); 
            
            #[  Se crean las restricciones de clave externa para:sectores_id y equipos_id]
                $table->bigInteger('servicio_id')->unsigned()->index();
                $table->foreign('servicio_id')->references('id')->on('servicios');

                $table->bigInteger('repuesto_id')->unsigned()->index();
                $table->foreign('repuesto_id')->references('id')->on('repuestos');    

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reparaciones');
    }
}
