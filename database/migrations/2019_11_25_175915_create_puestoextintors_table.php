<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuestoextintorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('puestoextintors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('agente',100);
            $table->float('capacidad')->nullable();
            $table->timestamps();
            #[  Se crean las restricciones de clave externa para:sectores_id y equipos_id]
                $table->bigInteger('puesto_id')->unsigned()->index();
                $table->foreign('puesto_id')->references('id')->on('puestos');
                
                $table->bigInteger('elemento_id')->nullable()->unsigned()->index();
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
        Schema::table('puestoextintor', function (Blueprint $table) {
            #--------------------------------------
            $table->dropForeign(['sectores_id']);
            $table->dropColumn('sectores_id');
            #--------------------------------------
            $table->dropForeign(['equipo_id']);
            $table->dropColumn('equipo_id');
            #--------------------------------------
        });
        Schema::dropIfExists('puestos');
    }
}
