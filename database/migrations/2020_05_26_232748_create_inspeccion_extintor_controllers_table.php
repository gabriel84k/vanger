<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeccionExtintorControllersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspeccion_extintors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idEquipo')->nullable();
            $table->tinyInteger('cargaVencida')->nullable();
            $table->tinyInteger('elementoAusente')->nullable();
            $table->tinyInteger('elementoObstruido')->nullable();
            $table->tinyInteger('carroDefectuoso')->nullable();
            $table->tinyInteger('equipoUsado')->nullable();
            $table->tinyInteger('equipoDespintado')->nullable();
            $table->tinyInteger('equipoDespresurizado')->nullable();
            $table->tinyInteger('alturaIncorreta')->nullable();
            $table->tinyInteger('faltaSenializacionEnAltura')->nullable();
            $table->tinyInteger('faltaSenializacionEnChapa')->nullable();
            $table->tinyInteger('faltaTarjeta')->nullable();
            $table->tinyInteger('faltaPrecinto')->nullable();
            $table->tinyInteger('soporteDefectuoso')->nullable();
            $table->tinyInteger('medioDeRupturaAusente')->nullable();
            $table->tinyInteger('mangueraRota')->nullable();
            $table->tinyInteger('otroProblema')->nullable();
            $table->integer('pesoActual')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('inspeccion_extintor_controllers');
    }
}
