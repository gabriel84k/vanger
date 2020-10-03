<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Exports\SectoresExport;
use Maatwebsite\Excel\Facades\Excel;

class SSPExcel extends Controller
{
    public function export() 
    {
        try {
            
            return Excel::download(new SectoresExport(0), 'Sucursales.xlsx');
        } catch (\Throwable $th) {
            return $th;
            return 'No existen sectores; puestos y Equipos, como asi también inspecciones';
        }   
        
        //return Excel::download(new SectoresExport, 'Sectores.xlsx');
    }
    public function show($id){
      
        try {
            //return Excel::download(new SectoresExport($id), 'Sucursal.xlsx');
            return (new SectoresExport($id))->download('Sucursal.xlsx');
        } catch (\Throwable $th) {
           dd($th);
            return 'No existen sectores; puestos y Equipos, como asi también inspecciones';
        }  
    } 
}
