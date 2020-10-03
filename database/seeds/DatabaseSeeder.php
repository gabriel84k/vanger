<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
           
            /*'sucursales',
            'elementos',
            'equipos',
            'users',
            //'usuarios_sucursales'
            'sectores',
            'puestos',
            'puestoextintors',
            'revision_periodicas',
            'cpinspeccions',
            'inspecciones',
            'inspeccion_extintors',
            'planillas',
            'servicios',
            'repuestos',
            'reparaciones',*/
            'rechazos'

            
        ]);
        
        /*$this->call(SucursalesSeeder::class);
        $this->call(ElementoSeeder::class);
        $this->call(EquiposSeeder::class);
        $this->call(UserSeeder::class);
        //$this->call(Usuarios_Sucursales::class);
        $this->call(SectoresSeeder::class);
        $this->call(PuestosSeeder::class);
        $this->call(PuestoextintorSeeder::class);
        $this->call(Revision_PeriodicaSeeder::class);
        $this->call(CpinspeccionSeeder::class);
        $this->call(InspeccionSeeder::class);
        $this->call(InspeccionextintorSeeder::class);
        $this->call(PlanillaSeeder::class);
        $this->call(ServicioSeeder::class);
        $this->call(RepuestoSeeder::class);
        $this->call(ReparacionSeeder::class);*/
        $this->call(RechazoSeeder::class);
     
        
        
    }

    protected function truncateTables(array $tables){
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        foreach ($tables as $table){ 
            //vacia la tabla para que no vuele cuando se corre de nuevo el seed
            DB::table($table)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
    
}
