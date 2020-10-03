<?php

namespace App\Http\Controllers;
use App\db\Sector;
use App\db\Puesto;
use App\db\Elemento;
use App\db\Sucursales;
use App\db\Fotos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SucursalesController extends Controller
{

    public function __construct(){ 
        $this->middleware('auth'); 
        
    }
    public function view(){
        return view('Sucursales.view');
    }
    public function branchoffices(){
        $user=Auth::user();
        $sucursal=Auth::user()->sucursales()->get();
        return $sucursal;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function index()
    {
        try {
           
            $user=Auth::user();
            $sucursal=Auth::user()->sucursales()->get();
            
            foreach ($sucursal as $key => $value) {
                $value->config=$value->conf;
                $sectores=(new Sector)::where('sucursales_id',$value->id)->get();
               
                if ($sectores->isNotEmpty()){
                    
                    foreach ($sectores as $key_sectores => $value_sectores) {
                        $puestos=$value_sectores->puesto()
                                                ->orderby('nroPuesto')->paginate(12);
                        
                        
               
                        foreach ($puestos as $key => $value_insp) {
                            $Puesto=Puesto::find($value_insp->id);
                            
                            $value_insp->columnas=$Puesto->column;
                       
                            $tipo_puesto=$Puesto->row_type;
                            $value_insp->tipopuesto=$Puesto->$tipo_puesto;
                            $value_insp->tipopuesto->columnas=$Puesto->$tipo_puesto->column;
                            $value_insp->tipopuesto->config=$Puesto->$tipo_puesto->conf;
                            
                            #[ Cargamos los elementos al puesto correspondiente ]#
                            if (isset($value_insp->tipopuesto)){
                                if ($value_insp->tipopuesto->elemento){
                                      
                                    
                                    $rowtype =$value_insp->tipopuesto->elemento->row_type;
                                    if ($rowtype=='mangueras'){
                                      
                                           
                                            $value_insp->nro_equipo=$value_insp->tipopuesto->elemento->$rowtype->numeroManguera;
                                            
                                        //}
                                    }else{
                                            $value_insp->nro_equipo=$value_insp->tipopuesto->elemento->$rowtype->nro_equipo_evolution;
                                    }
                                    
                                    
                                    $value_insp->tipopuesto->elemento->tipoelemento=$value_insp->tipopuesto->elemento->$rowtype;
                                    
                                    $value_insp->tipopuesto->inspecciones=InspeccionController::show($value_insp->tipopuesto);
                                    $elemento = Elemento::find($value_insp->tipopuesto->elemento_id);
                                    $elemento_rowtype=$elemento->row_type;
                                   
                                    $value_insp->tipopuesto->element=$elemento->$elemento_rowtype;
                                    $value_insp->tipopuesto->element->columnas=$elemento->$elemento_rowtype->column;

                                }else{
                                    $value_insp->tipopuesto->element=null;
                                    $value_insp->tipopuesto->inspecciones=InspeccionController::show($value_insp->tipopuesto);
                                }
                            }
                           
                        }
                        
                        $value_sectores['puestos']=$puestos;
                        
                    }
                    $value['sectores']=$sectores;
                    
                }else{
                    
                    $value['sectores']=null;
                   
                }
              
                
            }
            return $sucursal;
        } catch (\Throwable $th) {
            return $th->getMessage().' - linea: '.$th->getLine();
        }
           
       
    }
    public function Search_puesto($id_sectores){
       
        try {
            //code...
          
     
            $sectores=(new Sectores)::find($id_sectores)->get();
            if ($sectores){
                foreach ($sectores as $key_sectores => $value_sectores) {
                    $puestos=$value_sectores->puestos()->orderby('numero_puesto')->paginate(12);
                
                    foreach ($puestos as $key => $value_insp) {

                        $equipo=(new EquipoController)->show($value_insp->equipos_id);
                        
                        $value_insp->Nroequipo=$equipo->nro_equipo_evolution;
                        $value_insp->tipo=$equipo->tipo;
                        $value_insp->Cap_equipo=$equipo->capacidad .' '.$equipo->unidad;
                        $value_insp->vtocarga=$equipo->vencimiento_carga;
                        $value_insp->PH=$equipo->vencimiento_ph;
                        $value_insp->FF=$equipo->fecha_fabricacion;
                       

                        $inspecciones=$value_insp->cpinspecciones()->get();
                        foreach ($inspecciones as $key => $value_fotos) {
                            $fotos=(new Fotos)::where('cpinspeccions_id', $value_fotos->idinspeccion)->get();
                            $value_fotos['fotos']=$fotos;
                        }

                        $value_insp['inspecciones']= $inspecciones;
                    }
                $value_sectores['puestos']=$puestos;
                }
            }
            return \Response::json(['status'=>0,'descripcion'=>'Todo funcionó correctamente','data'=>'']);
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'descripcion'=>'No se encuentra la Sucursal.','data'=>$th->getmenssage()]);
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
    public function show($id)
    {
       
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
