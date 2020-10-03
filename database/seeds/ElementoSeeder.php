<?php

use Illuminate\Database\Seeder;
use App\db\Elemento;
class ElementoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Elemento::class,10)->create();
    }
}
