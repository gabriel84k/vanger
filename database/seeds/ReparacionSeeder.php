<?php

use Illuminate\Database\Seeder;
use App\db\Reparacion;
class ReparacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Reparacion::class,10)->create();
    }
}
