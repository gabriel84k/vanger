<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puestos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("nroPuesto");
            $table->string("ubicacion");
            $table->tinyInteger("habilitado");
            $table->integer("idSector");
            $table->integer("idPuesto");
            $table->string("row_type");   
            $table->timestamps();

            #[  Se crean las restricciones de clave externa para:sectores_id]
                $table->bigInteger('sector_id')->unsigned()->index();
                $table->foreign('sector_id')->references('id')->on('sectores');
                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puestos');
    }
}
