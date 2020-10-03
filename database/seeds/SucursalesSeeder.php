<?php

use Illuminate\Database\Seeder;
use App\db\Sucursales;

class SucursalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Sucursales::class,10)->create();        
    }
}
