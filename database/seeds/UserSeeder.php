<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create();    
        #---> crea los factory en la relacion entre usuarios y sucursales
        $usuarios = User::all();
        foreach ($usuarios as $usuario) {
            \DB::table('Usuarios_Sucursales')->insert([
                'sucursales_id' => 2,
                'user_id' => $usuario->id,
                
            ]);
        } 
    }
}
