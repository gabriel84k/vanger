<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeccionextintorchileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspeccionextintorchiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idEquipo')->nullable();
            $table->tinyInteger('cargaVencida')->nullable();
            $table->tinyInteger('elementoAusente')->nullable();
            $table->tinyInteger('elementoObstruido')->nullable();
            $table->tinyInteger('ubicacionIncorrecta')->nullable();
            $table->tinyInteger('lecturaManometroNoClara')->nullable();
            $table->tinyInteger('equipoDespintado')->nullable();
            $table->tinyInteger('equipoDespresurizado')->nullable();
            $table->tinyInteger('equipoDescargado')->nullable();
            $table->tinyInteger('faltaSenializacionEnAltura')->nullable();
            $table->tinyInteger('instruccionesNoLegibles')->nullable();
            $table->tinyInteger('sellosSeguridadDaniados')->nullable();
            $table->tinyInteger('carroDefectuoso')->nullable();
            $table->tinyInteger('mangueraRota')->nullable();
            $table->tinyInteger('gabineteEnMalEstado')->nullable();
            $table->string('otroProblema',250)->nullable();
            

            #[  Se crean las restricciones de clave externa para:puesto_id]
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
        Schema::dropIfExists('inspeccionextintorchile');
    }
}
