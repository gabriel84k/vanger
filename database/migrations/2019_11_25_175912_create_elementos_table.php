<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElementosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elementos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idelementosigex');
            $table->integer('idTipoElemento')->nullable();
            $table->tinyInteger('creadoMovil')->nullable();
            $table->string('row_type')->nullable(); 
            
            $table->timestamps();
            #[  Se crean las restricciones de clave externa para:sectores_id y equipos_id]
                $table->bigInteger('sucursal_id')->unsigned()->index();
                $table->foreign('sucursal_id')->references('id')->on('sucursales')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elementos');
    }
}
