<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\Rechazo;
use Faker\Generator as Faker;

$factory->define(Rechazo::class, function (Faker $faker) {
    return [
        'servicio_id'=>rand(1,10),
        'rechazo_id'=>rand(1,10),
    ];
});
