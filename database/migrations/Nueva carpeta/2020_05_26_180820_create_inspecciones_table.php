<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspeccionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspecciones', function (Blueprint $table) {
            $table->bigIncrements('id');//
            $table->timestamp('fechahora');// = Column(DateTime)
            $table->integer('idinspeccion');
            $table->integer('codigoControl');// = Column(Integer)
            $table->string('observaciones',250);// = Column(String(255, convert_unicode=True))
            $table->integer('estado');// = Column(Integer, nullable = False)
            $table->string('recomendacion',200);// = Column(String(200, convert_unicode=True))
            $table->tinyInteger('elementoAusente')->default(false);// = Column(Boolean, default=False) 
            $table->tinyInteger('elementoObstruido')->default(false);// = Column(Boolean, default=False) 
            $table->tinyInteger('elementoIncompatible')->default(false);// = Column(Boolean, default=False) 
            $table->tinyInteger('elementoVencido')->default(false);// = Column(Boolean, default=False) 
            $table->tinyInteger('elementoNoRegistrado')->default(false);// = Column(Boolean, default=False) 
            $table->tinyInteger('elementoSustituto')->default(false);// = Column(Boolean, default=False)
            $table->string('row_type',200);// = Column(String(200, convert_unicode=True))
            $table->string('codigoSustituto',200);// = Column(String(200, convert_unicode=True))
            $table->string('codigoEquipoSustituto',200);// = Column(String(200, convert_unicode=True))
            $table->timestamps();

            #[  Se crean las restricciones de clave externa para:sectores_id y equipos_id]
                $table->bigInteger('revision_periodica_id')->unsigned()->index();
                $table->foreign('revision_periodica_id')->references('id')->on('revision_periodicas');
                
                $table->bigInteger('puesto_id')->unsigned()->index();
                $table->foreign('puesto_id')->references('id')->on('puestos');
                
                $table->bigInteger('elemento_id')->nullable()->unsigned()->index();
                $table->foreign('elemento_id')->references('id')->on('elementos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inspecciones');
    }
}
