<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;



$factory->define(User::class, function (Faker $faker) {

    
    return [
        'idusuario' => 1,
        'name'=> 'gabriel',
        'direccion' => 'rivadavia 2121',
        'permisos'=>'{"Equipos":true,"Controles":true,"Planilla":true,"Repuesto":true}',
        'user' => 'gabriel',
        'verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'estado' =>1,
           
           
    ];
});

