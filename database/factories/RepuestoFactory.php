<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\Repuesto;
use Faker\Generator as Faker;

$factory->define(Repuesto::class, function (Faker $faker) {
    return [
        'idRepuesto'=>rand(1,10), 
        'nombre'=>$faker->state,
        'abreviatura'=>$faker->state,
    ];
});
