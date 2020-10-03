<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\Cpinspeccion;
use Faker\Generator as Faker;

$factory->define(Cpinspeccion::class, function (Faker $faker) {
    return [
        'fecha_inspeccion'=>now(),
        'tarjeta_control'=>$faker->lastName ,
        'peso_actual'=>$faker->randomDigit,
        'detalle_error'=>$faker->jobTitle,
        'observaciones'=>$faker->jobTitle,
        'idinspeccion'=>rand(1,10),
        'estado'=>1,
        'puesto_id'=>rand(1,10),
        'equipo_id'=>rand(1,10),
        'revision_periodica_id'=>rand(1,10),
    ];
});
