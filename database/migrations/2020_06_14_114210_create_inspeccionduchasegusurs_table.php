<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeccionduchasegusursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspeccionduchasegusurs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('elementoAusente',20)->nullable();
            $table->tinyInteger('ducha')->nullable();
            $table->tinyInteger('lavaojos')->nullable();
            $table->tinyInteger('valvula')->nullable();
            $table->tinyInteger('presion_correcta')->nullable();
            $table->tinyInteger('manija_accionadora')->nullable();
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
        Schema::dropIfExists('inspeccionduchasegusurs');
    }
}
