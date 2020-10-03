<?php

namespace App\Http\Controllers;
use App\db\Inspeccion;
use App\db\Revision_Periodica;
use App\db\Sector;
use App\db\Elemento;
use App\db\Puesto;
use App\db\Fotos;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class InspeccionController extends Controller
{
    /**
     *  Mostrar una lista del recurso.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inspecciones=(new Inspeccion)::paginate(12);
        return  $inspecciones;
    }

    public function _Insp($Insp){
        foreach ($Insp as $key => $Item) {
            # [- Se Agrega la Configuración de las inspecciones-] # 
               
                $Item->config=$Item->conf;
            # [- Se Agrega la relación correspondiente al tipo de -] #
                $Item->columnas=$Item->column;
                $Item->ColParticulares=$Item->Attr_particulares;
                $Insp_rowtype=$Item->row_type;
            
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
                if ($Item->elemento_id){
                    $idelemento=$Item->elemento_id;
                    $elemento = Elemento::find($idelemento);
                    $elemento_rowtype=$elemento->row_type;
                    $Item->elemento=$elemento->$elemento_rowtype;
                    $Item->elemento->columnas=$elemento->$elemento_rowtype->column;
                }
                
                $Item->fotos=[];
                /*
                    $insp_fotos=(new Fotos)::where('cpinspeccions_id',$value->id)->get();   
                    foreach ($insp_fotos as $key => $fotos_url) {
                        if (Storage::disk('compartido')->exists($fotos_url->foto)){
                            $fotos_url->visible=\Storage::disk('compartido')->getVisibility($fotos_url->foto);
                            $fotos_url->url='../images/'.$fotos_url->foto;
                            Storage::disk('compartido')->download($fotos_url->foto);
                        }else{
                            $fotos_url->visible='#';
                            $fotos_url->url='#';
                        }
                    }
                    $value->fotos=$insp_fotos;
                */
        }
    
        return  $Insp;
    }
    public static function show($tipopuesto)
    {
        try {
            $idpuesto=$tipopuesto->puesto_id;
            $Insp=Inspeccion::where('puesto_id', $idpuesto)->paginate(12);
            //return _Insp($Insp);
            foreach ($Insp as $key => $Item) {
                # [- Se Agrega la Configuración de las inspecciones-] #    
               
                    $Item->config=$Item->conf;
                # [- Se Agrega la relación correspondiente al tipo de -] #
              
                    $Item->columnas=$Item->column;
                    $Item->ColParticulares=$Item->Attr_particulares;
                    $Insp_rowtype=$Item->row_type;
            
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
                    if ($Item->elemento_id){
                        $idelemento=$Item->elemento_id;
                        $elemento = Elemento::find($idelemento);
                        $elemento_rowtype=$elemento->row_type;
                        $Item->elemento=$elemento->$elemento_rowtype;
                        $Item->elemento->columnas=$elemento->$elemento_rowtype->column;
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
            return \Response::json(['status'=>0,'descripcion'=>'Detalle del Error: '. $th->getMessage() ,'Linea: '=>$th->getLine() ]);
            dd($th);
        }
    }
    public function show_elemento($id)
    {
        try{
            $Insp=Inspeccion::where('elemento_id', $id)->paginate(12);

            return $this->_Insp($Insp);
        } catch (\Throwable $th) {
            dd($th);
        }
    }
    public function search($idcontrol){
        $Controles=(new Revision_Periodica)::where('id',$idcontrol)->first();
        
        try {
            //code...
            $campos= request()->all();
            $señal=0;
            foreach ($campos as $key => $value) {
                if ($value!=''){
                    $señal=1;
                }
            };
            
            $arr=[];
            $Insp= Inspeccion::where('revision_periodica_id',$Controles->id);
            if ($campos['incidencia']!=''){
                $Insp->where('incidencias','like','%'.$campos['incidencia'].'%');
            }
            $Insp=$Insp->paginate(12);
           
            /*Filtro de Busqueda*/
            foreach ($Insp as $key => $Item) {
                
                if ($señal!=0){
                                      
                    $puesto=$Item->puesto()->where(function($query) use ($campos) { 
                                            if ($campos['sector']!=''){
                                                
                                                $sector= Sector::where('nombre','like','%'.$campos['sector'].'%')->first();
                                                if($sector){
                                                    $query->where('sector_id',$sector->id);
                                                }else{
                                                    $query->where('sector_id',-1);
                                                }
                                                
                                            }
                                            if ($campos['puesto']!=''){
                                                $query->where('ubicacion','like','%'.$campos['puesto'].'%');
                                            }
                                            if ($campos['tipo']!=''){
                                               
                                                $query->where('row_type','like','%'.$campos['tipo'].'%');
                                            }
                                        })->first();
                    
                   
                    
                }else{
                    $puesto=$Item->puesto()->first();
                }

                if ($puesto){
                   
                    $arr[$key]=$Item->id;
                }else{
                    $Insp->pull($key);  
                   
                }
            }
       
            $Insp= Inspeccion::whereIn('id',$arr)->paginate(12);
            
            foreach ($Insp as $key => $Item) {
            # [- Se Agrega la Configuración de las inspecciones-] #    
                $Item->config=$Item->conf;
            # [- Se Agrega la relación correspondiente al tipo de -] #
                $Insp_rowtype=$Item->row_type;
                $Item->columnas=$Item->column;
                $Item->ColParticulares=$Item->Attr_particulares;
               

            # [- Se Agrga los Puestos Correspondientes -] #
                $puesto = Puesto::find($Item->puesto_id);
                
                if ($puesto){
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
                /*    $insp_fotos=(new Fotos)::where('Inspecciones_id',$Insp->id)->get();  
                
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
                    $Insp->fotos=$insp_fotos;
                */  
                }
            }
            
            
            return  $Insp;
        } catch (\Throwable $th) {
          
           dd($th);
        }
        
        
    }
}
