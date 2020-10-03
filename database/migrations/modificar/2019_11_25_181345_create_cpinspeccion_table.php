<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCpinspeccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cpinspeccions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('fecha_inspeccion');
            $table->string('tarjeta_control',10)->nullable();
            $table->integer('idinspeccion')->unique();
            $table->double('peso_actual')->nullable();
            $table->string('incidencias')->nullable();
            $table->integer('estado')->nullable();
            $table->string('detalle_error',255)->nullable();
            $table->string('observaciones',255)->nullable();
            $table->timestamps();
           
            #[  Se crean las restricciones de clave externa para:sectores_id y equipos_id]
                $table->bigInteger('revision_periodicas_id')->unsigned()->index();
                $table->foreign('revision_periodicas_id')->references('id')->on('revision_periodicas')->onDelete('cascade');
                
                $table->bigInteger('puestos_id')->unsigned()->index();
                $table->foreign('puestos_id')->references('id')->on('puestos');

                $table->bigInteger('equipos_id')->nullable()->unsigned()->index();
                $table->foreign('equipos_id')->references('id')->on('equipos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cpinspeccions', function (Blueprint $table) {
            #--------------------------------------
            $table->dropForeign(['revision_periodicas_id']);
            $table->dropColumn('revision_periodicas_id');
            #--------------------------------------
            $table->dropForeign(['puestos_id']);
            $table->dropColumn('puestos_id');
            #--------------------------------------
            $table->dropForeign(['equipos_id']);
            $table->dropColumn('equipos_id');
            #--------------------------------------
        });
        Schema::dropIfExists('cpinspeccions');
    }
}
