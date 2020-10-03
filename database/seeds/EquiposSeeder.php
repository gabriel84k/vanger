<?php

use Illuminate\Database\Seeder;
use App\db\Equipo;

class EquiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Equipo::class,10)->create();
    }
}
