<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\Planilla;
use Faker\Generator as Faker;

$factory->define(Planilla::class, function (Faker $faker) {
    return [
        'IdSigex'=>$faker->randomDigit,
        'fecha_servicio'=>now(),
        'nro_planilla'=>$faker->randomDigit,
        'orden_trabajo'=>$faker->streetName,
        'cantidadMat'=>$faker->randomDigit,
        'idEstado'=>1,
        'sucursal_id'=>2
    ];
});
