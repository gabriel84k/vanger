<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\db\Planilla;
use App\db\Sucursales;
use App\db\Equipo;
use App\db\Elemento;
use App\db\Servicio;
use App\db\Reparacion;
use App\db\Repuesto;
use App\db\Rechazo;
use App\Http\Controllers\logControllers;
use Eastwest\Json\Exceptions\EncodeDecode;


class PlanillasController extends Controller
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
           
            foreach ($request->all() as $key => $value) {
                $campos=json_decode($value);
            }
           
            $sucursal=(new Sucursales)::where('idsucursal',$campos->SUCURSALES->idSucursal)->first();
 
            if($sucursal){

                #[ Planillas ] -
                \DB::beginTransaction();
                        $Planilla=(new Planilla)::where('IdSigex',$campos->id)->first();
                    
                        if (is_null($Planilla) || $Planilla->count()==0){
                            
                            $Planilla=(new Planilla);
                            $Planilla=$this->_Planillas($Planilla,$campos);
                            
                            $Planilla->save();
                        }else{ 

                            $Planilla=$this->_Planillas($Planilla,$campos);
                            $Planilla->update();
                        }
                    #[ Servicios ] -
                        
                        foreach ( $campos->SERVICIOS as $key => $valServ ) {
                            
                            #[ Equipos ]-
                                foreach ( $valServ->EQUIPOS as $key => $valEq ) {
                                    /* -Controlar si existe el equipo- */
                                    $elemento=Elemento::where('idelementosigex',$valEq->elemento_id)
                                                        //->where('sucursal_id',$idSucursal)
                                                        ->first();
                                   
                                    if ($elemento){
                                        $elemento->idelementosigex=$valEq->elemento_id;
                                        $elemento->idTipoElemento=1;
                                        $elemento->creadoMovil=0;
                                        $elemento->row_type='equipos';
                                        $elemento->sucursal_id=$sucursal->id;

                                        $elemento->update();

                                        $equipo=Equipo::where('elemento_id',$elemento->id)->first();
                                       
                                        $equipo=$this->_Extintor($equipo,$valEq,$elemento);
                                        $equipo->update();
                                        
                                    }else{
                                        $elemento=(new Elemento);
                                        $elemento->idelementosigex=$valEq->elemento_id;
                                        $elemento->idTipoElemento=1;
                                        $elemento->creadoMovil=0;
                                        $elemento->row_type='equipos';
                                        $elemento->sucursal_id=$sucursal->id;

                                        $elemento->save();

                                        $equipo=(new Equipo);
                                        $equipo=$this->_Extintor($equipo,$valEq,$elemento);
                                        $equipo->save();
                                    }
                                    
                                }
                        
                            
                        
                            $servicio=(new Servicio)::where('idsigexservicio',$valServ->idsigexservicio)->first();
                           
                            if ($servicio){
                                $servicio=$this->_Servicio($servicio,$valServ,$Planilla->id,$elemento->id);
                            
                                $servicio->update();
                            }else{
                                $servicio=(new Servicio);
                                $servicio=$this->_Servicio($servicio,$valServ,$Planilla->id,$elemento->id);
                               
                                $servicio->save();
                               
                            }
                            #[ Rechazos]
                                foreach ($valServ->MOTIVOSRECHAZO as $key => $valRech) {
                                    $rechazo=(new Rechazo)::where('id',$valRech->id)->first();
                                    
                                    if ($rechazo){
                                        $rechazo->idRechsigex=$valRech->id;
                                        $rechazo->motivo=$valRech->motivo;
                                        $rechazo->update();
                                        $servicio->rechazo()->attach($rechazo->id);
                                    
                                    }else{
                                        $rechazo=(new Rechazo);
                                       
                                        $rechazo->idRechsigex=$valRech->id;
                                        $rechazo->motivo=$valRech->motivo;
                                        $rechazo->save();
                                        
                                        $servicio->rechazo()->attach($rechazo->id);
                                    }
                                    
                                }
                            #[ Reparaciones]
                                foreach ( $valServ->REPARACIONES as $key => $valRep ) {
                                
                                    #[ Repuestos ]    
                                        $repuesto=(new Repuesto)::where('idRepuesto',$valRep->repuesto->idRepuesto)->first();
                                    
                                        if($repuesto){
                                            #update.-
                                            $repuesto->nombre=$valRep->repuesto->nombre;
                                            $repuesto->abreviatura=$valRep->repuesto->abreviatura;
                                            $repuesto->update();
                                        }else{
                                            #nuevo.-
                                        
                                            $repuesto=(new Repuesto);
                                            $repuesto->idRepuesto=$valRep->repuesto->idRepuesto;
                                            $repuesto->nombre=$valRep->repuesto->nombre;
                                            $repuesto->abreviatura=$valRep->repuesto->abreviatura;
                                            $repuesto->save();
                                        }


                                    $reparacion=(new Reparacion)::where('idrepsigex',$valRep->idreparacion)->first();
                                    if ($reparacion){
                                        $reparacion=$this->_Reparacion($reparacion,$valRep,$servicio,$repuesto);
                                        $reparacion->update();

                                    }else{
                                        $reparacion=(new Reparacion);
                                        $reparacion=$this->_Reparacion($reparacion,$valRep,$servicio,$repuesto);
                                        $reparacion->save();
                                    }
                                }
                        }
                        \DB::commit();
                        #- Respodemos con codigo 200 ok y con text.-+
                        
                        return \Response::json(['status'=>0,'descripcion'=>'Se creo la Planilla Correctamente.','data'=>'']);
            }else{
                return \Response::json(['status'=>1,'descripcion'=>'No existe la sucursal'.'Api Controller: Planilla Store','data'=>'']);
            }
        } catch (\Exception $e) {
            //return \Response::json(['status'=>-1,'descripcion'=>'Error al Crear la Planilla.','data'=>$e->getMessage()]);
            \DB::rollback();
            //$log=(new logControllers)->error($e, 'Planilla','store');
            
            return \Response::json(['status'=>-1,'descripcion'=>'Detalle completo: '.$e->getMessage().' Line:'.$e->getLine().'Api Controller: Planilla','data'=>'']);
            //return $e->getMessage();
        }
    }
    #[ finct. Reparaciones]
    private function _Reparacion(Reparacion $reparacion, $valRep,$servicio,$repuesto){
        $reparacion->idrepsigex=$valRep->idreparacion;
        $reparacion->resultado=$valRep->resultado;
        $reparacion->idServiciosigex=$valRep->idServicio;
        $reparacion->idRepuestosigex=$valRep->repuesto->idRepuesto;

        $reparacion->servicio_id=$servicio->id;
        $reparacion->repuesto_id=$repuesto->id;
        return $reparacion;
    }

    #[ funct. Planilla]
    private function _Planillas(Planilla $planilla, $campos){
     
        $planilla->IdSigex=$campos->id;
        $planilla->fecha_servicio=$campos->fecha;
        $planilla->nro_planilla=$campos->nroPlanilla;
        $planilla->orden_trabajo=$campos->ordenNumero;
        $planilla->cantidadMat=$campos->cantidadMat;
        $planilla->idEstado=$campos->idEstado;
       
        $sucursal=(new Sucursales)::where('idsucursal',$campos->SUCURSALES->idSucursal)->first();
 
        if($sucursal){
            $planilla->sucursal_id=$sucursal->id;
        }else{
            #error si no existe sucursal
        }
        return $planilla;
    }

    #[ funct. Equipo]
    private function _Extintor(Equipo $Equipos, $campos ,$elemento ){
       try {
           //code...
       
            $Equipos->elemento_id = $elemento->id;
            $Equipos->nro_equipo_evolution = $campos->numeroDeEquipo;
            $Equipos->fecha_fabricacion = $campos->FechaFabricacion;
            $Equipos->fecha_ultimo_ph = $campos->fechaUltimaPH;
            $Equipos->row_type = 'extintor';
            if (isset($campos->sustituto)){
                $Equipos->sustituto = $campos->sustituto;
            }else{
                $Equipos->sustituto = false;
            }
            if (isset($campos->disponible)){
                $Equipos->disponible = $campos->disponible;
            }else{
                $Equipos->disponible = false;
            }
            if (isset($campos->observaciones)){
                $Equipos->observaciones = $campos->observaciones;
            }else{
                $Equipos->observaciones = '';
            }

            if (isset($campos->sector)){
                $Equipos->sector = $campos->sector;
            }else{
                $Equipos->sector = '';
            }
            if (isset($campos->vencimientoVidaUtil)){
                $Equipos->vencimientoVidaUtil = $campos->vencimientoVidaUtil;
            }
            if (isset($campos->vencimientoDeCarga)){
                $Equipos->vencimiento_carga = $campos->vencimientoDeCarga;
            }
            if (isset($campos->vencimientoDePH)){
                $Equipos->vencimiento_ph = $campos->vencimientoDePH;
            }
            if (!empty($campos->baja)){
                $Equipos->baja = (int)$campos->baja;
            }else{
                $Equipos->baja = 0;
            }
            if (isset($campos->capacidad)){
                $Equipos->capacidad = $campos->capacidad;
            }
            if (isset($campos->unidad)){
                $Equipos->unidad = $campos->unidad;
            }
            if (isset($campos->codigoInternoCliente)){
                $Equipos->codigo_interno_cliente = $campos->codigoInternoCliente;
            }
            $Equipos->codigoInterno =$campos->codigoInterno;
            $Equipos->marca =$campos->Marca;
            $Equipos->tipo = $campos->tipoDeEquipo;
            $Equipos->tipo_generico ='falta';
            
            return $Equipos;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    #[ funct. Servicio]
    private function _Servicio(Servicio $servicio, $campos,$idPlanilla,$idElemento  ){

        $servicio->idsigexservicio=$campos->idsigexservicio;
        $servicio->calificacion =$campos->calificacion;
        //$servicio->idPotencial =$campos->potencial; // controllar null
        $servicio->calculoPH =$campos->calculoPH;
        $servicio->recipiente =$campos->recipiente;
        $servicio->fechaRecepcion =$campos->fechaRecepcion;
        //$servicio->idOperadorInspeccion =$campos->idOperadorInspeccion;
        $servicio->operadorInspeccion = $campos->operadorInspeccion;
        $servicio->numeroTarjetaMunicipal = $campos->numeroTarjetaMunicipal;
        $servicio->nroEstampilla = $campos->nroEstampilla;

        $servicio->realizarPintura =$campos->realizarPintura;
        $servicio->numeroCertificadoCarga =$campos->numeroCertificadoCarga;
        $servicio->estadoDelPolvo =$campos->estadoDelPolvo;
        $servicio->idMarcaLote =$campos->idMarcaLote;
        $servicio->realizarOtros =$campos->realizarOtros;
        $servicio->marcaLoteTexto =$campos->marcaLoteTexto;
        $servicio->realizoPH =$campos->realizoPH;
        $servicio->observaciones =$campos->observaciones;
        
        //$servicio->idPotencial =$campos->idPotencial; //controlar null
        $servicio->servicioARealizar =$campos->servicioARealizar;
        $servicio->numeroCertificadoPH =$campos->numeroCertificadoPH;
        $servicio->estado =$campos->estado;
        $servicio->realizarPH =$campos->realizarPH;
        $servicio->inspeccionVisual =$campos->inspeccionVisual;
        
        $servicio->orden =$campos->orden;
        
        $servicio->reposicion =$campos->reposicion;
        $servicio->fechaReparaciones =$campos->fechaReparaciones;
        $servicio->vehicular =$campos->vehicular;
        $servicio->dominio =$campos->dominio;
        $servicio->fechaServicio =$campos->fechaServicio;
        #- Claves.
            $servicio->planilla_id =$idPlanilla;
            $servicio->elemento_id=$idElemento;

        return $servicio;
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
        
        try {
            \DB::beginTransaction();
            $Planilla = Planilla::where('IdSigex',$id)->first();
            
            if ($Planilla){
                //$servicio = Reparacion::where('servicio_id',$Planilla->id)->delete(); 
                $servicio = Servicio::where('planilla_id',$Planilla->id)->get(); 
                foreach ($servicio as $key => $valserv) {
                    # code...
                    $rep=Reparacion::where('servicio_id',$valserv->id)->delete(); 
                    $valserv->delete();
                }
                if ($servicio){
                    $resp = Planilla::destroy($Planilla->id);
                    \DB::commit();
                    return \Response::json(['status'=>0,'descripcion'=>'Planilla Despublicada','data'=>$resp]);
                }
            }else{
                return \Response::json(['status'=>0,'descripcion'=>'Planilla no Encontrada','data'=>'']);
            }
            
        } catch (\Throwable $th) {
            \DB::rollback();
            return \Response::json(['status'=>-1,'descripcion'=>$th->getMessage().' Line:'.$th->getLine(),'data'=>'']);
           
        }
    }
}
