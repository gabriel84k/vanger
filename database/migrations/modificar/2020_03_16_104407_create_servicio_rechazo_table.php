<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioRechazoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_rechazo', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->bigInteger('servicio_id')->unsigned()->nullable()->index();
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');

            $table->bigInteger('rechazo_id')->unsigned()->nullable()->index();
            $table->foreign('rechazo_id')->references('id')->on('rechazos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('servicio_rechazo');
    }
}
