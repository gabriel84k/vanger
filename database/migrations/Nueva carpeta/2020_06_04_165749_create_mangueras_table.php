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
            $table->string("sector")->nullable();
            $table->string("codigoInterno")->nullable();
            $table->tinyInteger("disponible")->nullable();
            $table->tinyInteger("sustituto")->nullable();
            $table->string("observaciones")->nullable();
            $table->string("row_type");
            $table->string("uniones")->nullable();
            $table->string("vencimientoDePH");
            $table->tinyInteger("codigoInternoCliente")->nullable();
            $table->integer("longitudReal");
            $table->string("numeroManguera");
            $table->string("fechaUltimaPH")->nullable();
            $table->tinyInteger("baja");
            $table->string("lanzanombre")->nullable();//nombre
            $table->string("lanzatipo")->nullable();//tipo
            $table->string("boquillanombre")->nullable();//nombre
            $table->integer("diametropulgada");//pulgada
            $table->double("diametromili");//milimetro
            $table->string("longitudmili");//milimetros
           
            #[  Se crean las restricciones de clave externa para:sectores_id y equipos_id]
                $table->bigInteger('elemento_id')->unsigned()->index();
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
        Schema::dropIfExists('mangueras');
    }
}
