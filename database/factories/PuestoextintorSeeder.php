<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\Puestoextintor;
use Faker\Generator as Faker;

$factory->define(Puestoextintor::class, function (Faker $faker) {
    return [
        'agente'=>$faker->jobTitle,
        'capacidad'=>$faker->randomDigit,
        'puesto_id'=>rand(1,10),
        'elemento_id'=>null,
    ];
});
