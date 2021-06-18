<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuestoduchasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puestoduchas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigoElemento')->nullable();
            $table->string('mismoElemento')->nullable();
            $table->string('tipo_ducha')->nullable();
            $table->timestamps();
            #[  Se crean las restricciones de clave externa para:puesto_id]
                $table->bigInteger('puesto_id')->unsigned()->index();
                $table->foreign('puesto_id')->references('id')->on('puestos')->onDelete('cascade');     
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('puestoduchas');
    }
}
