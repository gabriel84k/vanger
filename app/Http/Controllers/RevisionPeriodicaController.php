<?php

namespace App\Http\Controllers;

use App\db\Revision_Periodica;
use App\db\Inspeccion;
use App\db\Elemento;
use App\db\Sucursales;
use App\db\Puesto;
use App\db\Fotos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RevisionPeriodicaController extends Controller
{
    public function view(){
        return view('Controles-Periodicos.view');
    }

     /** @param  \Illuminate\Http\Request  $request */
    public function search()
    {
        $señal=0;
        $campos= request()->all();
        foreach ($campos as $key => $value) {
            if ($value!='' ||  !is_null($value)){
                $señal=1;
            }
        };
        
        $user=Auth::user();
       
        $sucursal=Auth::user()->sucursales()->get();
        $arr_id=array();
        foreach ($sucursal as $key => $suc_value) {
            $arr_id[$key]=$suc_value->id;
        }
        try {
            if ($señal==0){
                
                $Rperiodicas= (new Revision_Periodica)::whereIN('sucursal_id',$arr_id)->paginate(5);
                foreach ($Rperiodicas as $key => $value) {
                    $value->columnas=$value->column;
                    $value->sucursal= Sucursales::find($value->sucursal_id);
                }
                
            }else{    
             
                $Rperiodicas=
                (new Revision_Periodica)::where(function($query) use ($campos,$arr_id) { 
                                            if($campos['sucursal']!=''){
                                                $query->where('sucursal_id',$campos['sucursal']);
                                            }else{
                                                $query->whereIN('sucursal_id',$arr_id);
                                            }
                                            if($campos['Fdesde']!=''){ $query->whereBetween('fecha',[$campos['Fdesde'],$campos['Fhasta']]);}
                                        })
                                        ->paginate(5);
              
                foreach ($Rperiodicas as $key => $value) {
                    $value->columnas=$value->column;
                    $value->sucursal= Sucursales::find($value->sucursal_id);
                }
                
            }
            
            return $Rperiodicas;
        } catch (\Throwable $th) {
            dd($th);
        }        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $user=Auth::user();
       
        $sucursal=Auth::user()->sucursales()->get();
        $arr_id=array();
        foreach ($sucursal as $key => $suc_value) {
            $arr_id[$key]=$suc_value->id;
        }
       
        $Rperiodicas= (new Revision_Periodica)::whereIN('sucursal_id',$arr_id)->paginate(5);
        foreach ($Rperiodicas as $key => $value) {
            $value->columnas=$value->column;
            $value->sucursal= Sucursales::find($value->sucursal_id);
        }
      
        return $Rperiodicas;
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
     * @param  \App\db\Revision_Periodica  
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id,$pdf=0)
    {
       
        $Controles=(new Revision_Periodica)::where('id',$id)->first();
        
        try {
            //code...
            $campos= request()->all();
            $señal=0;
            foreach ($campos as $key => $value) {
                if ($value!=''){
                    $señal=1;
                }
            };
         
            $Insp= Inspeccion::where('revision_periodica_id',$Controles->id);
            
            if ($pdf!=0){
                $Insp=$Insp->get();
            }else{
                $Insp=$Insp->paginate(12);
            }
            
          
            foreach ($Insp as $key => $Item) {
            # [- Se Agrega la Configuración de las inspecciones-] #    
               
                $Item->config=$Item->conf;
             # [- Se Agrega la relación correspondiente al tipo de -] #
                $Insp_rowtype=$Item->row_type;
                $Item->columnas=$Item->column;
                $Item->ColParticulares=$Item->Attr_particulares;
               

            # [- Se Agrga los Puestos Correspondientes -] #
                $puesto = Puesto::find($Item->puesto_id);
                $puesto_rowtype=$puesto->row_type;
                $puesto->tipopuesto=$puesto->$puesto_rowtype;
                $puesto->tipopuesto->columnas=$puesto->$puesto_rowtype->column;
                $puesto->sector;
                $Item->puesto=$puesto;
              
                $Item->$Insp_rowtype->columnas= $Item->$Insp_rowtype->column;
                $Item->$Insp_rowtype->codigoelemento= $puesto->tipopuesto->codigoElemento;
                $Item->DetalleInspeccion=$Item->$Insp_rowtype;
            
                
             # [- Se Agrga los Equipos Correspondientes -] #
                $elemento = Elemento::find($Item->elemento_id);
                if ($elemento ){
                    $elemento_rowtype=$elemento->row_type;
                
                    $Item->elemento=$elemento->$elemento_rowtype;
                }else{
                    $Item->elemento=null;
                }
                $Item->fotos=[];
               
                $insp_fotos=(new Fotos)::where('inspecciones_id',$Item->id)->get();  
               
                foreach ($insp_fotos as $key => $fotos_url) {
                    if (Storage::disk('compartido')->exists($fotos_url->foto)){
                        $fotos_url->visible=\Storage::disk('compartido')->getVisibility($fotos_url->foto);
                        $fotos_url->url="/images/".$fotos_url->foto; //\Storage::disk('compartido')->getAdapter()->getPathPrefix().$fotos_url->foto;
                        Storage::disk('compartido')->download($fotos_url->foto);
                    }else{
                        $fotos_url->visible='#';
                        $fotos_url->url='#';
                    }
                }
                $Item->fotos=$insp_fotos;
                
            }
           
            return  $Insp;
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'descripcion'=>'Detalle del Error: '. $th->getMessage() ,'Linea: '=>$th->getLine() ]);
           dd($th);
        }
        
        
    }
    /* IMPRESIONES PDF */
        #[TIPO DE PUESTO]#
        public function pdftipopuesto(Request $request, $idcontrol,$rowtype){
            $Controles=(new Revision_Periodica)::where('id',$idcontrol)->first();
            $Insp=$Controles->inspecciones()->where('row_type','like',$rowtype)->get();
            try{
                foreach ($Insp as $key => $Item) {
               
                # [- Se Agrega la relación correspondiente al tipo de -] #
                    $Insp_rowtype=$Item->row_type;
                    $Item->columnas=$Item->column;
                    $Item->ColParticulares=$Item->Attr_particulares;
                    
    
                # [- Se Agrga los Puestos Correspondientes -] #
                    $puesto = Puesto::find($Item->puesto_id);
                    $puesto_rowtype=$puesto->row_type;
                    $puesto->tipopuesto=$puesto->$puesto_rowtype;
                    $puesto->tipopuesto->columnas=$puesto->$puesto_rowtype->column;
                    $puesto->sector;
                    $Item->puesto=$puesto;
                    $Item->$Insp_rowtype->columnas= $Item->$Insp_rowtype->column;
                    $Item->$Insp_rowtype->codigoelemento= $puesto->tipopuesto->codigoElemento;
                    $Item->DetalleInspeccion=$Item->$Insp_rowtype;
                
                    
                    # [- Se Agrga los Equipos Correspondientes -] #
                    $elemento = Elemento::find($Item->elemento_id);
                    if ($elemento ){
                        $elemento_rowtype=$elemento->row_type;
                    
                        $Item->elemento=$elemento->$elemento_rowtype;
                    }else{
                        $Item->elemento=null;
                    }
                    $Item->fotos=[];
                    
                }
                return  $Insp;
                
            } catch (\Throwable $th) {
              
               dd($th);
            }

                                                
            
        }
        public function general(Request $request, $idcontrol){
            $Controles=(new Revision_Periodica)::where('id',$idcontrol)->first();
            $sucursal=$Controles->sucursales()->first();
            $Insp=$Controles->inspecciones()->get();
            try{
                foreach ($Insp as $key => $Item) {
                
                # [- Se Agrega la relación correspondiente al tipo de -] #
                    $Insp_rowtype=$Item->row_type;
                    $Item->columnas=$Item->column;
                    $Item->ColParticulares=$Item->Attr_particulares;
                                   
                    $Item->sucursal=$sucursal;
    
                # [- Se Agrga los Puestos Correspondientes -] #
                    $puesto = Puesto::find($Item->puesto_id);
                    $puesto_rowtype=$puesto->row_type;
                    $puesto->tipopuesto=$puesto->$puesto_rowtype;
                    $puesto->sector;
                    $Item->puesto=$puesto;
                    $Item->$Insp_rowtype->columnas= $Item->$Insp_rowtype->column;
                    $Item->$Insp_rowtype->codigoelemento= $puesto->tipopuesto->codigoElemento;
                    $Item->DetalleInspeccion=$Item->$Insp_rowtype;
                
                    
                    # [- Se Agrga los Equipos Correspondientes -] #
                    $elemento = Elemento::find($Item->elemento_id);
                    if ($elemento ){
                        $elemento_rowtype=$elemento->row_type;
                    
                        $Item->elemento=$elemento->$elemento_rowtype;
                    }else{
                        $Item->elemento=null;
                    }
                   
                }
                return  $Insp;
                
            } catch (\Throwable $th) {
              
               dd($th);
            }

                                                
            
        }
}
