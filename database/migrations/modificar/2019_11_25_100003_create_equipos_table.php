<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('idequipo');
            $table->string('nro_equipo_evolution',10);
            $table->string('tipo',50)->nullable();
            $table->string('tipo_generico',50)->nullable();
            $table->double('capacidad')->nullable();
            $table->string('unidad',45)->nullable();
            $table->string('marca',50)->nullable();
            $table->string('fecha_fabricacion')->nullable();
            $table->string('fecha_ultimo_ph')->nullable();
            $table->string('sector',100)->nullable();
            $table->integer('baja');
            $table->string('codigo_interno_cliente',50)->nullable();
            $table->timestamp('vencimiento_carga');
            $table->timestamp('vencimiento_ph');
           
            $table->timestamps();
           
            #[  Se crean las restricciones de clave externa para:sucursal_id]
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
        Schema::table('equipos', function (Blueprint $table) {
            #--------------------------------------
            $table->dropForeign(['sucursales_id']);
            $table->dropColumn('sucursales_id');
            #--------------------------------------
        });
        Schema::dropIfExists('equipos');
    }
}
