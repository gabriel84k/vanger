<?php

namespace App\Exports;



use App\db\Sucursales;
use App\db\Sectores;
use App\db\Puestos;
use App\db\Equipos;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

use Illuminate\Support\Collection as Collection;

class SectoresExport implements WithMultipleSheets
{
    use Exportable;

    protected $id;
    function __construct($id){
       
      if ($id!=0){
          $this->id=$id;
      }else{
          $this->id=null;
      }
    }

    public function sheets(): array
    {
       
        $sheets = [];
        $user=Auth::user();
        if ($this->id){
            $sucursalx=(new Sucursales)->where('id',$this->id)->get();
        }else{
            $sucursalx=$user->sucursales()->get();
        }
        if ($sucursalx) {
            foreach ($sucursalx as $key => $sucursal) {
                
                $sheets[] = new SucursalSheet($sucursal,$user);
            }
        }
        

        return $sheets;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
 
   
  
    

}
