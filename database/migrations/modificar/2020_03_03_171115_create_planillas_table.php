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
            $table->date('fecha_servicio');
            $table->integer('nro_planilla');
            $table->string('orden_trabajo')->nullable();
            $table->integer('cantidadMat')->nullable();
            $table->integer('idEstado');

            $table->bigInteger('sucursales_id')->unsigned()->index();
            $table->foreign('sucursales_id')->references('id')->on('sucursales');

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
