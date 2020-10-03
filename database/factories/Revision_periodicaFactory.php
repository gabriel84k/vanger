<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\Revision_Periodica;
use Faker\Generator as Faker;

$factory->define(Revision_Periodica::class, function (Faker $faker) {
    return [
        'fecha'=>now(),
        'comentario'=> $faker->company,
        'estado'=>1,
        'idControlPeriodico'=>rand(1,10),
        'nrocontrol'=>rand(1,10),
        'sucursal_id'=>rand(1,10),
    ];
});
