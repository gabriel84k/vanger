<?php

use Illuminate\Database\Seeder;
use App\db\Puestoextintor;
class PuestoextintorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Puestoextintor::class,10)->create();
    }
}
