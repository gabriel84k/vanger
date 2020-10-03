<?php

use Illuminate\Database\Seeder;

use App\db\Inspeccion;

class InspeccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Inspeccion::class,10)->create();
    }
}
