<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\db\Servicio;
use Faker\Generator as Faker;

$factory->define(Servicio::class, function (Faker $faker) {
    return [
                'idsigexservicio'=>$faker->randomDigit,
                'orden'=>$faker->randomDigit,
                'fechaRecepcion'=>now(),
                'fechaReparaciones'=>now(),
                'fechaServicio'=>now(),
                'calificacion'=>$faker->randomDigit,
                'vehicular'=>false,
                'dominio'=>'abcdefgh', 
                'realizarPH'=>true,
                'realizarPintura'=>false,
                'realizarOtros'=>true,
                'observaciones'=>$faker->address,
                'estado'=>$faker->randomDigit,
                'servicioARealizar'=>'RP', 
                'calculoPH'=>$faker->randomDigit,
                'reposicion'=>$faker->randomDigit,
                'estadoDelPolvo'=>$faker->randomDigit,
                'idMarcaLote'=>$faker->randomDigit,
                'marcaLoteTexto'=>$faker->address,
                'idPotencial'=>$faker->randomDigit,
                'realizoPH'=>true,
                'inspeccionVisual'=>$faker->streetName,
                'recipiente'=>$faker->streetName,
                'idOperadorInspeccion'=>$faker->randomDigit,
                'numeroCertificadoCarga'=>$faker->randomDigit,
                'numeroCertificadoPH'=>$faker->randomDigit,
                'planilla_id'=>rand(1,10),
                'elemento_id'=>rand(1,10),
    ];
});
