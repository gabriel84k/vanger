<?php

use Illuminate\Database\Seeder;
use App\db\Revision_Periodica;

class Revision_PeriodicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Revision_Periodica::class,10)->create();
    }
}
