<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManguerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mangueras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer("elemento_id");
            $table->string("numeroManguera" );
            $table->string("codigoInterno" );
            $table->timestamp("fechaUltimaPH" );
            $table->timestamp("vencimientoDePH" );
            $table->string("codigoInternoCliente" )->nullable();
            $table->string("observaciones" )->nullable();
            $table->string("sector")->nullable();
            $table->integer("diametroid"); //Hacer la otra tabla relacionada
            $table->double("longitud" );
            $table->double("longitudReal" );
            $table->string("lanza" );
            $table->string("boquilla" );
            $table->string("uniones" );
            $table->tinyInteger("sustituto");
            $table->tinyInteger("disponible" );
            $table->tinyInteger("baja" );
            $table->timestamps();


            #[  Se crean las restricciones de clave externa para:sucursal_id]
            $table->bigInteger('sucursale_id')->unsigned()->index();
            $table->foreign('sucursale_id')->references('id')->on('sucursales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mangueras');
    }
}
