<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\Sector;
use Faker\Generator as Faker;

$factory->define(Sector::class, function (Faker $faker) {
    return [
        'idsector'=>$faker->randomDigit,
        'numero'=>$faker->randomDigit,
        'nombre'=>$faker->jobTitle,
        'sucursales_id' => 2,
    ];
});
