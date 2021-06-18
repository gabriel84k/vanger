<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\db\Manguera;
use App\db\Elemento;
use App\db\Puesto;
use App\db\Sucursales;
use App\db\Inspeccion;


use Illuminate\Support\Facades\Auth;

class MangueraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    static public function index()
    {
        try {
            
            $user=Auth::user();
            $sucursal=Auth::user()->sucursales()->get();
            # - Páginas totales en tabla -#
                if (request()->get('total')){
                    if (request()->get('total')>14 && request()->get('total')<101){
                        $totalpage=request()->get('total');
                    }else{
                        $totalpage=15;
                    }
                    
                }else{
                    $totalpage=15;
                }
            #- Fin Paginas Totales-#
            $arr_eq=[];
            foreach ($sucursal as $key => $Suc_val) {
                $array_suc[$key]=$Suc_val->id;
            }

            $elemento=Elemento::whereIn('sucursal_id',$array_suc)->get();
            foreach ($elemento as $key => $elemt) {
                $arr_eq[$key]=$elemt->id;
            }
           
            $tipo=request()->tipo;
            
            if ($tipo==2){
                $elementotipo=Manguera::WhereIn('elemento_id',$arr_eq)->paginate( $totalpage);    
            }
            
            foreach ($elementotipo as $key => $valueEquipo) {
                $valueEquipo->config=$valueEquipo->conf;
                $valueEquipo->columna=$valueEquipo->column;
                $puestoinsp=Inspeccion::where('elemento_id',$valueEquipo->elemento_id)->first();
                if ($puestoinsp){
                    $valueEquipo->puesto=$puestoinsp->puesto->nroPuesto.' - '.$puestoinsp->puesto->ubicacion;
                }
            }
            
            
            return $elementotipo;
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    static public function show($id)
    {
        $elementotipo=Manguera::find($id);
        $elementotipo->columnas=$elementotipo->column;
        $elementotipo->config=$elementotipo->conf;
        return $elementotipo;
    }
    static public function search()
    {
       
        try{
            $señal=0;
            $campos= request()->all();
            # - Páginas totales en tabla -#
                if (request()->get('total')){
                    if (request()->get('total')>14 && request()->get('total')<101){
                        $totalpage=request()->get('total');
                    }else{
                        $totalpage=15;
                    }
                    
                }else{
                    $totalpage=15;
                }
            #- Fin Paginas Totales-#
            foreach ($campos as $key => $value) {
                if ($value!=''){
                    $señal=1;
                }
            };
            $user=Auth::user();
            $sucursal=Auth::user()->sucursales()->get();
        
            foreach ($sucursal as $key => $Suc_val) {
                $array_suc[$key]=$Suc_val->id;
            }

            $elemento=Elemento::whereIn('sucursal_id',$array_suc)->get();
            foreach ($elemento as $key => $elemt) {
                $arr_eq[$key]=$elemt->id;
            }
           
            //$tipo=request()->tipo;
            
            //if ($tipo==2){
          
                $elementotipo=Manguera::WhereIn('elemento_id',$arr_eq)
                                    ->where(function($query) use ($campos) {
                                        if ($campos['nanguera']!=''){
                                            
                                            $query->where('numeroManguera','like','%'.$campos['nanguera'].'%');
                                        }
                                        if ($campos['longitud']!=''){
                                            
                                            $query->where('longitudmili',$campos['longitud']);
                                        }
                                        if ($campos['diametro']!=''){
                                            
                                            $query->where('diametromili',$campos['diametro']);
                                        }
                                        if ($campos['uniones']!=''){
                                            
                                            $query->where('uniones','%'.$campos['uniones'].'%');
                                        }
                                        if ($campos['lanza']!=''){
                                            
                                            $query->where('lanzanombre',$campos['lanza']);
                                        }
                                        if ($campos['Fhasta']!=''){
                                            
                                            $query->where('fechaUltimaPH',$campos['Fhasta']);
                                        }
                                        if ($campos['boquilla']!=''){
                                            
                                            $query->where('boquillanombre',$campos['boquilla']);
                                        }
                                        if ($campos['estado']!=''){
                                            
                                            $query->where('baja',$campos['estado']);
                                        }
                                     })
                                    ->paginate($totalpage);   
                
            //}
                  
       
            
            foreach ($elementotipo as $key => $valueEquipo) {
                $valueEquipo->columna=$valueEquipo->column;
                $puestoinsp=Inspeccion::where('elemento_id',$valueEquipo->elemento_id)->first();
                if ($puestoinsp){
                    $valueEquipo->puesto=$puestoinsp->puesto->nroPuesto.' - '.$puestoinsp->puesto->ubicacion;
                }
            
            }    
            return $elementotipo;
        } catch (\Throwable $th) {
           dd($th->getMessage());
        }        
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
