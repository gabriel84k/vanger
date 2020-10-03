<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuestohidrantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puestohidrantes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('desfavorable')->nullable();
            $table->string('medidaGAbiente')->nullable(); 
            $table->string('medidaVidrioGabinete')->nullable();
            $table->string('tieneReduccion')->nullable();
            $table->string('materialPuertaGabinete')->nullable();
            $table->string('tipoGabinete')->nullable();
            $table->timestamps();
            #[  Se crean las restricciones de clave externa para:sectores_id y equipos_id]
                $table->bigInteger('puesto_id')->unsigned()->index();
                $table->foreign('puesto_id')->references('id')->on('puestos');
                
                $table->bigInteger('elemento_id')->nullable()->unsigned()->index();
                $table->foreign('elemento_id')->references('id')->on('elementos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puestohidrantes');
    }
}
