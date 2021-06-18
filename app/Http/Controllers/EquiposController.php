<?php

namespace App\Http\Controllers;
use App\db\Elemento;
use App\db\Equipo;
use App\db\Puesto;
use App\db\Sucursales;
use App\db\Inspeccion;


use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;


class EquiposController extends Controller
{
    
    
   
   
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    static public function index(){
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
            foreach ($sucursal as $key => $Suc_val) {
                $array_suc[$key]=$Suc_val->id;
            }

            $elemento=Elemento::whereIn('sucursal_id',$array_suc)->get();
            foreach ($elemento as $key => $elemt) {
                $arr_eq[$key]=$elemt->id;
            }
           
            $tipo=request()->tipo;
            
            if ($tipo==0){
                $elementotipo=Equipo::select('extintors.id','nro_equipo_evolution','tipo','tipo_generico','capacidad','unidad','marca',
                'fecha_fabricacion','fecha_ultimo_ph','sector','baja','codigo_interno_cliente',
                'vencimiento_carga','vencimiento_ph','elemento_id')
                                    ->WhereIn('elemento_id',$arr_eq)
                                    ->paginate($totalpage);    
                $pag = $elementotipo->toArray();
                $pag = ($pag["current_page"]-1)*$totalpage;
            }
            
            foreach ($elementotipo as $key => $valueEquipo) {
                $valueEquipo->item=($key+1)+$pag;
                $valueEquipo->capacidad=$valueEquipo->capacidad. ' ' .$valueEquipo->unidad;
                $valueEquipo->config=$valueEquipo->conf;
                $valueEquipo->columna=$valueEquipo->column;
                    if($valueEquipo->elemento_id){
                    $puestoinsp=Inspeccion::where('elemento_id',$valueEquipo->elemento_id)->first();
                    if ($puestoinsp){
                        $valueEquipo->puesto=$puestoinsp->puesto->nroPuesto.' - '.$puestoinsp->puesto->ubicacion;
                    }
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
    */
    static public function show($id)
    {
        $elementotipo=Equipo::find($id);
        $elementotipo->columnas=$elementotipo->column;
        $elementotipo->config=$elementotipo->conf;
        return $elementotipo;
    }
    
    /** @param  \Illuminate\Http\Request  $request */
    static public function search()
    {
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
        try {
            $user=Auth::user();
            if (!empty($campos['sucursal'])){
                $sucursal=Auth::user()->sucursales()->where('sucursales.id',$campos['sucursal'])->get();
            }else{
                $sucursal=Auth::user()->sucursales()->get();
            }
            if  (!empty($campos['pdf'])){
                if( $campos['pdf']!=''){
                    $paginate=10000;
                }
            }else{
                $paginate=$totalpage;
            }
            if ($señal==0){
                
                foreach ($sucursal as $key => $Suc_val) {
                    $array_suc[$key]=$Suc_val->id;
                }
                $equipos=(new Equipo)::select('extintors.id','nro_equipo_evolution','tipo','tipo_generico','capacidad','unidad','marca',
                                        'fecha_fabricacion','fecha_ultimo_ph','sector','baja','codigo_interno_cliente',
                                        'vencimiento_carga','vencimiento_ph','sucursal_id')
                                        ->join('elementos','elementos.id','extintors.elemento_id')
                                        ->whereIn('elementos.sucursal_id',$array_suc)
                                        ->paginate($totalpage);
                
            }else{    
                foreach ($sucursal as $key => $Suc_val) {
                    $array_suc[$key]=$Suc_val->id;
                }
               
                $equipos=(new Equipo)::select('extintors.id','nro_equipo_evolution','tipo','tipo_generico','capacidad','unidad','marca',
                                'fecha_fabricacion','fecha_ultimo_ph','sector','baja','codigo_interno_cliente',
                                'vencimiento_carga','vencimiento_ph','sucursal_id','elemento_id')
                                ->join('elementos','elementos.id','extintors.elemento_id')
                             
                               
                                ->where(function($query) use ($campos) { 
                                    if (!empty($campos['nequipo'])){
                                        if( $campos['nequipo']!=''){$query->where('nro_equipo_evolution',$campos['nequipo']);}
                                    }
                                    if (!empty($campos['sector'])){
                                        if( $campos['sector']!=''){$query->where('sector','like','%' .$campos['sector'].'%') ;}
                                    }
                                    if (!empty($campos['marca'])){
                                        if( $campos['marca']!=''){ $query->where('marca','like','%' .$campos['marca'].'%') ;}
                                    }
                                    if (!empty($campos['agente'])){
                                        if( $campos['agente']!=''){ $query->where('tipo','like','%' .$campos['agente'].'%') ;}
                                    }
                                    if (!empty($campos['codinterno'])){
                                        if( $campos['codinterno']!=''){ $query->where('codigo_interno_cliente',$campos['codinterno']);}
                                    }
                                    if (!empty($campos['capacidad'])){
                                        if( $campos['capacidad']!=''){ $query->where('capacidad',$campos['capacidad']);}
                                    }
                                    if (!empty($campos['Fdesde'])){
                                        if( $campos['Fdesde']!=''){ $query->whereBetween('vencimiento_carga',[$campos['Fdesde'],$campos['Fhasta']]);}
                                    }
                                    if (!empty($campos['Ffabricacion'])){
                                        if( $campos['Ffabricacion']!=''){ $query->where('fecha_fabricacion',$campos['Ffabricacion']);}
                                    }
                                    if (!empty($campos['sucursal'])){
                                        if( $campos['sucursal']!=''){ $query->where('elementos.sucursal_id',$campos['sucursal']);}
                                    }
                                })
                                ->where(function($query) use ($campos) { 
                                    if (!empty($campos['estado'])){
                                        if( $campos['estado']!=''){
                                            $query->where('baja','=',$campos['estado']);
                                        }else{
                                            $query->where('baja','<>',1);
                                        }
                                    }else{
                                        $query->where('baja','<>',-1); #[muestra solo los vigentes]
                                    }
                                })
                                ->whereIn('elementos.sucursal_id',$array_suc)
                                ->paginate($totalpage);
                                
                               
                               
            }

           
              
            $pag = $equipos->toArray();
            $pag = ($pag["current_page"]-1)*$totalpage;
            
            foreach ($equipos as $key => $valueEquipo) {
                $valueEquipo->item=($key+1)+$pag;
                $valueEquipo->config=$valueEquipo->conf;
                $valueEquipo->columna=$valueEquipo->column;
                $valueEquipo->capacidad=$valueEquipo->capacidad. ' ' .$valueEquipo->unidad;

                $puestoinsp=(new Inspeccion)::where('elemento_id',$valueEquipo->elemento_id)->first();
                if(!is_null($puestoinsp)){
                    $puesto = Puesto::find($puestoinsp->puesto_id);
                    $tipo_elemento=$puesto->row_type;
                    $puesto->$tipo_elemento;                   
                    $valueEquipo->puesto=$puestoinsp->puesto->nroPuesto.' - '.$puestoinsp->puesto->ubicacion;
                }
            }
            
            return $equipos;
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
