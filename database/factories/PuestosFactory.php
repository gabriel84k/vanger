<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\Puesto;
use Faker\Generator as Faker;

$factory->define(Puesto::class, function (Faker $faker) {
    return [
        'nroPuesto'=>$faker->randomDigit,
        'ubicacion'=>$faker->jobTitle,
        'habilitado'=>true,
        'row_type'=>'puestoextintor',
        'sector_id'=>rand(1,10),
        

    ];
});
