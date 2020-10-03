<?php

namespace App\Http\Controllers;
use App\db\Planilla;
use App\db\Sucursales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanillasController extends Controller
{
    public function __construct(){ 
        $this->middleware('auth'); 
       
    }
    public function view(){
        return view('Planilla.view');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       

        $user=Auth::user();
        $sucursales=Auth::user()->sucursales()->get();
        foreach ($sucursales as $key => $valSuc) {
            $arrSuc[$key]= $valSuc->id;
        }
          
        //foreach varias sucursales
        $Planilla=Planilla::select('planillas.id', 'IdSigex', 'fecha_servicio', 'nro_planilla', 'orden_trabajo', 'cantidadMat', 'idEstado', 'nombre')
                                ->whereIN('sucursal_id',$arrSuc)
                                ->join('sucursales','sucursales.id','sucursal_id')
                                ->orderby('fecha_servicio','DESC')
                                ->paginate(15);
        
       
        foreach ($Planilla as $key => $valPlan) {  
            $valPlan->columnas=$valPlan->columns;
        }     
        return $Planilla;  
        
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
    public function searchequipo($id){
        
   
        $Planilla=(new Planilla)::Select('planillas.id','fecha_servicio', 'nro_planilla', 'cantidadMat', 'orden_trabajo',
                                         'realizoPH','extintors.observaciones','calificacion','estado','servicioARealizar'
                                         )
                                ->join('servicios','servicios.planilla_id','planillas.id')
                                ->join('elementos','elementos.id','servicios.elemento_id')
                                ->join('extintors','extintors.elemento_id','elementos.id')
                                ->where('extintors.id',$id)
                                ->paginate(15);
        foreach ($Planilla as $key => $valPlan) {  
            $valPlan->columnas=$valPlan->columns;
        }   
        
        return $Planilla;   
    }

    /** @param  \Illuminate\Http\Request  $request */
    public function search(){
   
        $user=Auth::user();
        $sucursal=Auth::user()->sucursales()->get();
        $campos= request()->all();
        foreach ($sucursal as $key => $valSuc) {
            $arrSuc[$key]=$valSuc->id;
            # code...
        }
       
        //foreach varias sucursales
        $Planilla=(new Planilla)::select('planillas.id', 'IdSigex', 'fecha_servicio', 'nro_planilla', 'orden_trabajo', 'cantidadMat', 'idEstado', 'nombre')
                                ->whereIN('sucursal_id',$arrSuc)
                                ->join('sucursales','sucursales.id','sucursal_id')
                                ->where(function($query) use ($campos) { 
                                    if (!empty($campos['nroplantilla'])){
                                        if( $campos['nroplantilla']!=''){$query->where('nro_planilla','=',$campos['nroplantilla']);}
                                    }
                                    if (!empty($campos['fservicio'])){
                                        if( $campos['fservicio']!=''){ $query->whereDate('fecha_servicio','=',date($campos['fservicio']));}
                                    }
                                    if (!empty($campos['orden'])){
                                        if( $campos['orden']!=''){ $query->where('orden_trabajo','like','%' .$campos['orden'].'%') ;}
                                    }
                                    if (!empty($campos['sucursal'])){
                                        if( $campos['sucursal']!=''){ $query->where('sucursales.nombre','like','%' .$campos['sucursal'].'%') ;}
                                    }
                                })
                                ->orderby('fecha_servicio','DESC')
                                ->paginate(15);
        return $Planilla;   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
