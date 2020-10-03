<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fotos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion',255)->nullable();
            $table->string('foto');
            $table->integer('fotoevolution_id')->unsigned();

            $table->bigInteger('cpinspeccions_id')->unsigned()->index();
            $table->foreign('cpinspeccions_id')->references('id')->on('Cpinspeccions')->onDelete('cascade');
           
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fotos');
    }
}
