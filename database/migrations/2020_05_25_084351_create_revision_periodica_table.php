<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRevisionPeriodicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('revision_periodicas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('fecha')->nullable(); 
            $table->string('comentario')->nullable(); 
            $table->tinyInteger('estado')->nullable();
            $table->integer('nrocontrol')->nullable(); 
            $table->integer( 'idControlPeriodico');  
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
        Schema::dropIfExists('revision_periodica');
    }
}
