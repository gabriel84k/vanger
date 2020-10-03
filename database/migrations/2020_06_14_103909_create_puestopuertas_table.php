<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuestopuertasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puestopuertas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigoElemento')->nullable();
            $table->string('tipo_puerta')->nullable();
            $table->string('tiene_barral')->nullable();
            $table->string('tiene_cerradura')->nullable();
            $table->timestamps();
            #[  Se crean las restricciones de clave externa para:puesto_id]
                $table->bigInteger('puesto_id')->unsigned()->index();
                $table->foreign('puesto_id')->references('id')->on('puestos');        

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puestopuertas');
    }
}
