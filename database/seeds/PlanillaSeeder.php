<?php

use Illuminate\Database\Seeder;
use App\db\Planilla;

class PlanillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Planilla::class,10)->create();
    }
}
