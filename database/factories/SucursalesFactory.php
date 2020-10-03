<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\Sucursales;
use Faker\Generator as Faker;

$factory->define(Sucursales::class, function (Faker $faker) {
    return [
        'idsucursal' => $faker->randomDigit,
        'nombre' => $faker->jobTitle,
        'domicilio'=>'asdasd'
    ];
});
