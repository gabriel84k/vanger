<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Puestos::all() ;
        /*
        $user=Auth::user();
   
        $sucursal=Auth::user()->sucursales()->get();
       
        foreach ($sucursal as $key => $value) {

            $sectores=(new Sectores)::where('Sucursales_id',$value->id)->get();
            foreach ($sectores as $key_sectores => $value_sectores) {
                $puestos=$value_sectores->puestos()->simplePaginate(15);
               
                foreach ($puestos as $key => $value_insp) {

                    $equipo=(new EquipoController)->show($value_insp->equipos_id);
                    #- Equipos.-
                    $value_insp->Nroequipo=$equipo->nro_equipo_evolution;
                    $value_insp->tipo=$equipo->tipo;
                    $value_insp->Cap_equipo=$equipo->capacidad;
                    $value_insp->vtocarga=$equipo->vencimiento_carga;
                    $value_insp->PH=$equipo->vencimiento_ph;
                    $value_insp->FF=$equipo->fecha_fabricacion;
                    #- sucursal.-
                    $value_insp->nrosucursal=$value->idsucursal;
                    $value_insp->sucursal=$value->nombre;
                    #- Sectores.-
                    $value_insp->idsector=$value_sectores->idsector;
                    $value_insp->sector=$value_sectores->nombre;
                   
               }
              
               
            }
           
        }*/
    }
}
