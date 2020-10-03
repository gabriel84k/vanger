<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\InspeccionExtintor;
use Faker\Generator as Faker;

$factory->define(InspeccionExtintor::class, function (Faker $faker) {
    return [
        'inspeccion_id'=>rand(1,10)
    ];
});
