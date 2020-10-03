<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\Reparacion;
use Faker\Generator as Faker;

$factory->define(Reparacion::class, function (Faker $faker) {
    return [
        'idrepsigex'=>rand(1,10), 
        'resultado'=>rand(1,10), 
        'idServiciosigex'=>rand(1,10),
        'idRepuestosigex'=>rand(1,10), 
        'servicio_id'=>rand(1,10),
        'repuesto_id'=>rand(1,10)
    ];
});
