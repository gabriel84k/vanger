<?php

use Illuminate\Database\Seeder;
use App\db\InspeccionExtintor;
class InspeccionextintorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(InspeccionExtintor::class,10)->create();
    }
}
