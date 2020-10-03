<?php

use Illuminate\Database\Seeder;
use App\db\Puesto;

class PuestosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Puesto::class,10)->create();
    }
}
