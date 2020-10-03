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
            $table->string('resultado');//: repar.resultado, #integer
            $table->integer('idServiciosigex');//: repar.idServicio, #integer
            $table->integer('idRepuestosigex');//: repar.idRepuesto, #integer
            
            #[  Se crean las restricciones de clave externa para:Servicios_id y equipos_id]
                $table->bigInteger('servicios_id')->unsigned()->index();
                $table->foreign('servicios_id')->references('id')->on('servicios')->onDelete('cascade');
                
                $table->bigInteger('repuestos_id')->unsigned()->index();
                $table->foreign('repuestos_id')->references('id')->on('repuestos')->onDelete('cascade');
             
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
