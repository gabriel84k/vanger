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
           
            $table->timestamp('fecha');
            $table->text('comentario')->nullable();
            $table->boolean('estado')->nullable();
            $table->integer('nrocontrol')->nullable();
            $table->integer('idControlPeriodico')->unique();
            $table->timestamps();

            #[  Se crean las restricciones de clave externa para:sectores_id y equipos_id]
                $table->bigInteger('sucursales_id')->unsigned()->index();
                $table->foreign('sucursales_id')->references('id')->on('sucursales');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('revision_periodicas', function (Blueprint $table) {
            #--------------------------------------
            $table->dropForeign(['sucursal_id']);
            $table->dropColumn('sucursal_id');
            #--------------------------------------
        });
        Schema::dropIfExists('revision_periodicas');
    }
}
