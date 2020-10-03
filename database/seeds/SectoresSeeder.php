<?php

use Illuminate\Database\Seeder;
use App\db\Sector;

class SectoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Sector::class,10)->create();
    }
}
