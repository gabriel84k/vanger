<?php

use Illuminate\Database\Seeder;
use App\db\Cpinspeccion;

class CpinspeccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Cpinspeccion::class,10)->create();
    }
}
