<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\Equipo;
use Faker\Generator as Faker;

$factory->define(Equipo::class, function (Faker $faker) {
    return [
            'idequipo' => $faker->randomDigit,
            'nro_equipo_evolution' => $faker->randomNumber ,
            'tipo' => $faker->creditCardType,
            'tipo_generico'=> $faker->creditCardType,
            'capacidad' =>$faker->numberBetween($min = 1000, $max = 9000),
            'unidad' => 'Kg',
            'marca' => $faker->company,
            'fecha_fabricacion' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'fecha_ultimo_ph' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'sector' => $faker->jobTitle,
            'codigo_interno_cliente' => $faker->randomNumber,
            'vencimiento_carga'=> $faker->date($format = 'Y-m-d', $max = 'now'),
            'vencimiento_ph'=> $faker->date($format = 'Y-m-d', $max = 'now'),
            'baja'=> 1,
            'elemento_id'=>rand(1,10),
            
    ];
});
