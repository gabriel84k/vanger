<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\Elemento;
use Faker\Generator as Faker;

$factory->define(Elemento::class, function (Faker $faker) {
    return [
        'sucursal_id'=>rand(1,10),
        'row_type'=>'equipos',

    ];
});
