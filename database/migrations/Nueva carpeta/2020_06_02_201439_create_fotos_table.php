<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion',255);
            $table->string('foto',100);
            $table->bigInteger('fotoevolution_id')->unsigned()->index();
               
            #[  Se crean las restricciones de clave externa para:sectores_id y equipos_id]
                $table->bigInteger('inspecciones_id')->unsigned()->index();
                $table->foreign('inspecciones_id')->references('id')->on('inspecciones');  
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fotos');
    }
}
