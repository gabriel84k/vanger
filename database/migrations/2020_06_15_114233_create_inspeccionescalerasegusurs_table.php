<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeccionescalerasegusursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspeccionescalerasegusurs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('elementoAusente',20)->nullable();
            $table->string('estado_escalera',250)->nullable();
            $table->string('codigoElementoEncontrado', 20)->nullable();
            
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
        Schema::dropIfExists('inspeccionescalerasegusurs');
    }
}
