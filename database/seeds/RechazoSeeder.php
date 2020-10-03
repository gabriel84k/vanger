<?php

use Illuminate\Database\Seeder;
use App\db\Rechazo;
class RechazoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Rechazo::class,10)->create();
    }
}
