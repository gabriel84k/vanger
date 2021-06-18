<?php

namespace App\Http\Controllers\Api;
use App\db\Inspeccion;
use App\db\Elemento;
use App\db\Puesto;
use App\db\Sector;
use App\db\Fotos;
use App\db\Sucursales;
use App\db\Revision_Periodica;
use App\Http\Controllers\logControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class Inspecciones extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'Funcionando...';
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
        try {
              
            #- [Modelo :: Inspecciones] -
                $Model_insp=(new Inspeccion)::where('idinspeccion',$request->input('id'))->first();
               
                if (!$Model_insp){
                    #- Create New Inspection.
                    $Model_insp=(new Inspeccion);
                    $Model_insp=$this->_Inspeccion($Model_insp,$request);
                    
                }else{
                    #- Update de la INSPECCION
                    $Model_insp=$this->_Inspeccion($Model_insp,$request);
                }   
               
                #- Obtenemos el id de las Revisiones periódicas.-
                    $RevPeriodicas=(new Revision_Periodica)::where('idControlPeriodico',$request->input('idControlPeriodico'))->first();
                   
                    if(!$RevPeriodicas){
                        return \Response::json(['status'=>-1,'descripcion'=>'No se Actualizó la revisión periódica. (Existe el Usuario?). No existen Revisiones Periodicas Creadas','data'=>'']);
                    }else{
                        $Model_insp->revision_periodica_id = $RevPeriodicas->id;
                       
                    }
                
                #------ Controlamos si: Inspecciones->Equipo[] contiene datos.------
                    #[Elementos]
                   
                    if (count($request->input('elemento.elemento'))>0){
                        
                        $MElemento=Elemento::where('idelementosigex','=',$request->input('elemento.elementobase.idequipo'))->first();
                        
                        if(!$MElemento){
                           //return $request->input('elemento.elementobase');
                            # New
                            $MElemento=(new Elemento);
                            $señal=1;

                        }else{
                            $señal=0;
                        }
                        $ElementoBase=$request->input('elemento.elementobase');
                       
                        $sucursal=(new Sucursales)::where('idsucursal',$ElementoBase['sucursal'])->first();
                        
                        if(!$sucursal){
                            return \Response::json(['status'=>-1,'descripcion'=>'No existe la Sucursal','data'=>'']);
                        }
                        $ElementoBase['sucursal_id']=$sucursal->id;
                       
                        unset($ElementoBase['sucursal']);
                        $MElemento->idTipoElemento=$ElementoBase['idTipoElemento'];
                        $MElemento->creadoMovil=$ElementoBase['creadoMovil'];
                        $MElemento->row_type=$ElementoBase['row_type'];
                        $MElemento->sucursal_id=$sucursal->id;
                        $MElemento->idelementosigex=$ElementoBase['idequipo'];
                        
                        switch ($señal) {
                            case 1: 
                               
                                $MElemento->save();
                                break;
                            case 0:
                               
                                $MElemento->update($ElementoBase);
                                break;
                        }
                        
                        $ElementoTipo= $this->_Elemento($MElemento,$request);
                        $Model_insp->elemento_id= $MElemento->id;
                       
                    
                    }
                    
                #------ Controlamos si: Inspecciones->Puestos->Equipo[] contiene datos.------  
                    #[Puestos]
                    $puesto=Puesto::where('idpuesto',$request->input('PUESTO.puesto.0.puestobase.idPuesto'))->first();
                    $Model_insp->puesto_id= $puesto->id;
                    $Model_insp->save();
      
                #- Grabamos.-
              
                #[Inspecciones Particulares]
                $InspeccionTipo=$request->input('tipoinsp.0');
                   
                $InspeccionTipo['inspeccion_id']=$Model_insp->id;
               
                //return $InspeccionTipo;
                $rowtype= $Model_insp->row_type;
                
                if ($Model_insp->$rowtype()->exists()){
                    
                    $Model_insp->$rowtype()->update($InspeccionTipo);
                }else{
                    
                    $MTipoInspeccion="\App\db\\".ucwords($rowtype);
                    $nueva= new $MTipoInspeccion();
                   
                    $nueva->create($InspeccionTipo);
                }
               
                
                $this->_Fotos($request,$Model_insp->id);
                return \Response::json(['status'=>0,'descripcion'=>'Control creado con éxito.','data'=>'']);
                
        } catch (\Exception $e) {
            return $e->getMessage();
            //$log=(new logControllers)->error($e, 'Inspecciones','store');
            return \Response::json(['status'=>-1,'descripcion'=>'Detalle completo: '.$e->getMessage().' Line:'.$e->getLine().'Api Controller: Inspecciones','data'=>'']);
            
        }
     # -]
    }
    
    /**
     * Funcion donde se crea el objeto Equipo
     */
    public function _Elemento(Elemento $MElemento, Request $request  ){
        try {  
            $Elementotipo=$request->input('elemento.elemento.0');
           
            $rowtype= $MElemento->row_type;
            if ($MElemento->$rowtype()->exists()){
                $TipoElemento=$MElemento->$rowtype();
                $señal=0;
            }else{
                $nuevo="\App\db\\". str_replace('s','',ucwords($rowtype));
                $TipoElemento= new $nuevo();
                $señal=1;
            }
            if (empty($Elementotipo['baja'])){
                $Elementotipo['baja'] =0;
            }
            $Elementotipo['elemento_id']=$MElemento->id;
            switch ($señal) {
                case 0:
                    $TipoElemento=$TipoElemento->update($Elementotipo);
                    break;
                case 1:
                    $TipoElemento=$TipoElemento->create($Elementotipo);
                    break;
            }
            return $TipoElemento;
           
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'descripcion'=>'Detalle completo: '.$th->getMessage().' Line:'.$th->getLine().'Api Controller: Inspeccion->_elemento','data'=>'']);
                
        }  
       
    }
    public function _Equipopuesto(Equipos $Equipos, $request  ){
        
        $Equipos->idequipo = $request->input('puesto.0.equipo.0.elemento_id');
        $Equipos->nro_equipo_evolution = $request->input('puesto.0.equipo.0.numeroDeEquipo');
        $Equipos->fecha_fabricacion = $request->input('puesto.0.equipo.0.FechaFabricacion');
        $Equipos->fecha_ultimo_ph =$request->input('puesto.0.equipo.0.fechaUltimaPH');
        
        #- Buscamos el modelo de sectores para obtener el id de la sucursal y el nombre del sector-------
        $sector=(new Sectores)::select('nombre','id','sucursales_id')
                                      ->where('idSector',$request->input('puesto.0.idSector'))->first();
        
        if (!is_null($sector) && $sector->count()>0){
            $Equipos->sector = $sector->nombre;
        }else{
            $Equipos->sector = '';
        }
        
        $Equipos->vencimiento_carga =$request->input('puesto.0.equipo.0.vencimientoDeCarga');
        $Equipos->vencimiento_ph =$request->input('puesto.0.equipo.0.vencimientoDePH');
        if (!empty($request->input('puesto.0.equipo.0.baja'))){
            $Equipos->baja =(int)$request->input('puesto.0.equipo.0.baja');
        }else{
            $Equipos->baja =0;
        }
        
        $Equipos->capacidad =$request->input('puesto.0.equipo.0.cap.0.capacidad');
        $Equipos->unidad =$request->input('puesto.0.equipo.0.cap.0.unidad');
        $Equipos->codigo_interno_cliente ='falta';
        $Equipos->marca =$request->input('puesto.0.equipo.0.marca.0.Marca');
        $Equipos->tipo =$request->input('puesto.0.equipo.0.tipo.0.tipoDeEquipo');
        $Equipos->tipo_generico ='falta';

        #- Claves.
        if ($sector->count()>0){
            $Equipos->sucursales_id =$sector->sucursales_id;
        }else{
            return \Response::json(['status'=>-1,'descripcion'=>'Error no se encuentra la Sucursal','data'=>'']);
        }
        return $Equipos;
    
    }
    /**
     * Funcion donde se crea el objeto Inspeccion
     */
    public function _Inspeccion(Inspeccion $Inspeccion, Request $request ){
       
        $date=str_replace("/","-",$request->get('fechahora'));
        $Inspeccion->fechahora=date_create($date);
        $Inspeccion->idinspeccion=$request->get('id');

        $Inspeccion->codigoControl=$request->get('codigoControl');
        
        $Inspeccion->incidencias=$request->get('incidencias');
        $Inspeccion->recomendacion=(is_null ($request->get('recomendacion')))?0:$request->get('recomendacion');
        $Inspeccion->elementoAusente=(is_null ($request->get('elementoAusente')))?0:$request->get('elementoAusente');
        $Inspeccion->elementoObstruido=(is_null ($request->get('elementoObstruido')))?0:$request->get('elementoObstruido');
        $Inspeccion->elementoIncompatible=(is_null ($request->get('elementoIncompatible')))?0:$request->get('elementoIncompatible');
        $Inspeccion->elementoVencido=(is_null ($request->get('elementoVencido')))?0:$request->get('elementoVencido');
        $Inspeccion->elementoNoRegistrado=(is_null ($request->get('elementoNoRegistrado')))?0:$request->get('elementoNoRegistrado');
        $Inspeccion->elementoSustituto=(is_null ($request->get('elementoVencido')))?0:$request->get('elementoVencido');$request->get('elementoSustituto');
        $Inspeccion->row_type=(is_null ($request->get('row_type')))?0:$request->get('row_type');
        $Inspeccion->codigoSustituto=$request->get('codigoSustituto');
        $Inspeccion->codigoEquipoSustituto=$request->get('codigoEquipoSustituto');
        
        if (!empty($request->get('estado'))){
            $Inspeccion->estado=$request->get('estado');
        }
        
        $Inspeccion->observaciones=$request->get('observaciones');
        return $Inspeccion;
        #revision_periodica_id, puesto_id, elemento_id
    }

    public function _Fotos(Request $request,$insp_id){
        try {
           //code...
          
            if (!is_null($request->input('fotos.0'))){
                /*$this->validate($request, [
                    'fotos.0.foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                ]);*/
            
                foreach ($request->input('fotos') as $key => $value) {
                
                    if ((new Fotos)::where('fotoevolution_id',$value['idCPInspeccion'])
                                    ->where('foto',$value['foto'])    
                                    ->exists()){

                    }else{
                        $fotos=(new Fotos);
                
                        $fotos->inspecciones_id=$insp_id;
                        $fotos->descripcion='';
                        $fotos->foto=$value['foto'];
                        $fotos->fotoevolution_id=$value['idCPInspeccion'];
                        $fotos->save();
                       
                    }
                }      
                
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
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
        
    }
}
