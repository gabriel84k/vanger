<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\Inspeccion;
use Faker\Generator as Faker;

$factory->define(Inspeccion::class, function (Faker $faker) {
    return [
        'fechahora'=>now(),
        'codigoControl'=>123,
        'observaciones'=>'',
        'estado'=>0,
        'recomendacion'=>'asdasd',
        'codigoSustituto'=>'asd123',
        'codigoEquipoSustituto'=>'adas2312',
        'row_type'=>'inspeccionextintor',
        'revision_periodica_id'=>rand(1,10), 
        'puesto_id'=>rand(1,10), 
        'elemento_id'=>rand(1,10)
    ];
});
