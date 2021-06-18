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
        Schema::create('extintors', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('nro_equipo_evolution',10)->nullable();
            $table->string('tipo',50)->nullable();
            $table->string('tipo_generico',50)->nullable();
            $table->float('capacidad')->nullable();
            $table->string('unidad',10)->nullable();
            $table->string('marca',50)->nullable();
            $table->string('fecha_fabricacion',10)->nullable();
            $table->string('fecha_ultimo_ph',10)->nullable();
            $table->string('sector',100)->nullable();
            $table->string('codigo_interno_cliente',20)->nullable();
            $table->string('codigoInterno',20)->nullable();
            $table->date('vencimiento_carga');
            $table->date('vencimiento_ph');
            $table->date('vencimientoVidaUtil')->nullable();
            $table->integer('baja')->nullable();
            $table->string('row_type')->nullable();
            $table->tinyInteger('sustituto')->nullable();
            $table->tinyInteger('disponible')->nullable();
            $table->string('observaciones',250)->nullable();
            $table->timestamps();

            #[  Se crean las restricciones de clave externa para:sectores_id y equipos_id]
                $table->bigInteger('elemento_id')->unsigned()->index();
                $table->foreign('elemento_id')->references('id')->on('elementos')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('extintors');
    }
}
