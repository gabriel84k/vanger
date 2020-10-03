<?php

namespace App\Http\Controllers\Api;

use App\db\Revision_Periodica;
use App\db\Inspeccion;

use App\db\Sucursales;
use App\db\Sector;
use App\db\Puesto;
use App\db\Elemento;
use App\db\Fotos;
use App\Http\Controllers\logControllers;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
 
class DatosController extends Controller
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
           
            \DB::beginTransaction();
            #[• Modelo :: Sucursales •] 
                foreach ($request->input('contrato.0.sucursales') as $key => $Sucursales) {
                
                    $Model_Suc=(new Sucursales)::where('idsucursal',$Sucursales['idSucursal'])->first();
                    if (!is_null($Model_Suc) && $Model_Suc->count() > 0){
                        #[• Asigna Id_Sucursal •]
                        $idSucursal=$Model_Suc->id;

                    }else{
                        #[• Si no hay Cargada Sucursales devuelve Error •]
                        return \Response::json(['status'=>-1,'descripcion'=>'No se encuentra la Sucursal.','data'=>'']);
                    }
                    
                    #[• Modelo :: Revisiones Periodicas •]
                        
                        $Model_RPeriodica=(new Revision_Periodica)::where('idControlPeriodico',$request->input('id'))->first();
                        
                        if(empty($Model_RPeriodica) || $Model_RPeriodica->count()==0){
                            #[•Crea Nueva RP•]
                            $Model_RPeriodica=(new Revision_Periodica);
                            try {
                                    //code...
                                
                                $Model_RPeriodica->nrocontrol=$request->input('nroControl');
                                $Model_RPeriodica->fecha=$request->input('fechaRealizado');
                                $Model_RPeriodica->estado=1;
                                $Model_RPeriodica->comentario=$request->input('observaciones');
                                $Model_RPeriodica->idControlPeriodico=$request->input('id');
                                $Model_RPeriodica->sucursal_id= $idSucursal;
                            
                                $Model_RPeriodica->save();
                            } catch (\Throwable $th) {
                                return $th->getMessage();
                            }
                        }else{
                            #[•Modifica RP•]
                            $Model_RPeriodica->nrocontrol=$request->input('nroControl');
                            $Model_RPeriodica->fecha=$request->input('fechaRealizado');
                            $Model_RPeriodica->estado=1;
                            $Model_RPeriodica->comentario=$request->input('observaciones');
                            $Model_RPeriodica->sucursal_id= $idSucursal;
                    
                            $Model_RPeriodica->update();
                        }
                    
                    #[• Fin RP •]
                   
                    #[• Modelo :: Sectores •]
                        foreach ($request->input('contrato.0.sucursales.0.sectores') as $key => $Sectores) {
                        
                            $Model_Sect=(new Sector)::where('idsector',$Sectores['idSector'])
                                                    ->where('sucursales_id',$idSucursal)
                                                    ->first();
                            if (is_null($Model_Sect)){
                                #[•Crea nuevo Sector•]
                                
                                $Model_Sect=(new Sector);
                                $Model_Sect->idsector=$Sectores['idSector'];
                                if (!empty($Sectores['numero'])){
                                    $Model_Sect->numero=$Sectores['numero'];
                                }else{
                                    $Model_Sect->numero=0;
                                }
                                $Model_Sect->nombre=$Sectores['sector'];
                                $Model_Sect->sucursales_id=$idSucursal; 
                                $sector_id=$Model_Sect->id;
                                
                                $Model_Sect->save();
                            }else{
                               #[•Modifica nuevo Sector•]
                                $sector_id=$Model_Sect->id;
                                //falta completar con llos otros datos.
                            }

                            #[• Modelo :: Puestos •] 
                                foreach ($Sectores['puestos'] as $key => $Puesto) {
                                   
                                    #[• Elementos •] 
                                    
                                    $elemento_id=$this->_elemento($Puesto,$idSucursal);
                                    
                                    if (!$elemento_id){
                                        $elemento_id=null;
                                    }
                                   
                                    #[• Puestos •]
                                    $MPuesto=Puesto::where('sector_id',$Model_Sect->id)->where('nroPuesto',$Puesto["nroPuesto"])->first();
                                   
                                    #[Transforma los valores null]
                                    if (empty($Puesto['nroPuesto'])){
                                        $Puesto['nroPuesto']=0;
                                    }
                                    if (empty($Puesto['ubicacion'])){
                                        $Puesto['ubicacion']='';
                                    }
                                    if (empty($Puesto['idPuesto'])){
                                        $Puesto['idPuesto']=0;
                                    }
                                    
                                    $Puesto['sector_id']=$Model_Sect->id;
                                    if (!$MPuesto){
                                       
                                        #[• Crea nuevo Puesto •]
                                        $MPuesto=(new Puesto);

                                        $MPuesto=$MPuesto->create($Puesto);
                                       
                                    }else{
                                        $MPuesto->idPuesto=$Puesto['nroPuesto'];
                                        $MPuesto->update($Puesto);
                                    }
                                    
                                    #[• Puesto Especifico•]
                                    $Puesto['TipoPuesto']['puesto_id']=$MPuesto->id;
                                    $Puesto['TipoPuesto']['class'];
                                   
                                    ///////ver si es puesto con elemento o no ////////////
                                    if ($elemento_id){
                                       
                                        if ($elemento_id==null){
                                            $Puesto['TipoPuesto']['elemento_id']=null;

                                        }else{
                                            $Puesto['TipoPuesto']['elemento_id']=$elemento_id->id;
                                            
                                        }
                                    }
                                   
                                    $rowtype=$MPuesto->row_type;
                                    if ($MPuesto->$rowtype()->exists()){
                                        unset($Puesto['TipoPuesto']['class']);
                                        $MPuestos= $MPuesto->$rowtype()->update($Puesto['TipoPuesto']);

                                        
                                    }else{
                                        $MTipoPuesto="\App\db\\".$Puesto['TipoPuesto']['class'];
                                        $nueva= new $MTipoPuesto();
                                        $nueva= $nueva->create($Puesto['TipoPuesto']);
                                       
                                    }
                                    
                                }
                            #[•Fin Puestos•]
                        }
                    #[•Fin Sectores•]
                }    
            #[•Fin Sucursales•]
            \DB::commit();
            
            return \Response::json(['status'=>0,'descripcion'=>'Se creo el Contrato N°'. $Model_RPeriodica->idControlPeriodico .'con éxito. ','data'=>'']);

        } catch (\Exception $e) {
            \DB::rollback();
            
            //$log=(new logControllers)->error($e, 'DatosController','store');
            return \Response::json(['status'=>-1,'descripcion'=>'Detalle completo: '.$e->getMessage().' Line:'.$e->getLine().'Api Controller: DatosController','data'=>$elemento_id]);
        }
    }
   
    public function _elemento($Puesto,$idSucursal){
       
        foreach ($Puesto['elemento'] as $key => $value) {
            try {  
               
                $elemento=Elemento::where('idelementosigex',$Puesto['elementobase']['idequipo'])
                                            ->where('sucursal_id',$idSucursal)
                                            ->first();
                #[•Elemento Base•]
                if (!$elemento){
                    $elemento=(new Elemento);
                    $señal=1;
                }else{
                    $señal=0;
                }
                
                $elemento->idTipoElemento=$Puesto['elementobase']['idTipoElemento'];
                $elemento->creadoMovil=$Puesto['elementobase']['creadoMovil'];
                $elemento->row_type=$Puesto['elementobase']['row_type'];
                $elemento->sucursal_id=$idSucursal;
                $elemento->idelementosigex=$Puesto['elementobase']['idequipo'];
                switch ($señal) {
                    case 0:
                        $elemento->update();
                        break;
                    case 1:
                        $elemento->save();
                        break;
                }

                #[•Elemento Especifico•]
                $rowtype= $elemento->row_type;
                if ($elemento->$rowtype()->exists()){
                    $TipoElemento=$elemento->$rowtype();
                    $señal=0;
                }else{
                    $nuevo="\App\db\\". str_replace('s','',ucwords($rowtype));
                    $TipoElemento= new $nuevo();
                    $señal=1;
                }
               
                switch ($rowtype) {
                    case 'extintor':
                        break;
                    case 'mangueras':
                        if (empty($value['codigoInternoCliente'])){
                            $value['codigoInternoCliente'] =0;
                        }
                        break;
                    case 'bombas':
                        break;
                }
                if (empty($value['baja'])){
                    $value['baja'] =0;
                }
                $value['elemento_id']=$elemento->id;
                switch ($señal) {
                    case 0:
                        $TipoElemento->update($value);
                        break;
                    case 1:
                        $TipoElemento->create($value);
                        break;
                }
                return $elemento;
            } catch (\Throwable $th) {
                return \Response::json(['status'=>-1,'descripcion'=>'Detalle completo: '.$th->getMessage().' Line:'.$th->getLine().'Api Controller: DatosController->_elemento','data'=>'']);
                
            }  
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
        try {
          
            $Control=(new Revision_Periodica)::where('idControlPeriodico',$id)->first();
            
            if ($Control){
                try {
                    \DB::beginTransaction();
                        $inspeccion=Inspeccion::where('revision_periodica_id',$Control->id)
                                                ->get();

                        

                        
                        foreach ($inspeccion as $key => $value) {

                            
                            $rowtype=$value->row_type;
                            $value->$rowtype()->delete();

                            $fotos=(new Fotos)::where('inspecciones_id',$value->id)->get();

                            foreach ($fotos as $fkey => $fvalue){
                             
                                if(Storage::disk('local')->exists('image/'.$fvalue->foto)){
                                    Storage::disk('local')->delete('image/'.$fvalue->foto);   
                                    
                                }
                                $fvalue->delete(); 
                            }


                            $value->delete();
                        }
                        $Control->delete();
                    \DB::commit();
                    return \Response::json(['status'=>0,'descripcion'=>'Se desvinculo el control con Id:'.$id. ', y sus Inspecciones completas.','data'=>'']);
                } catch (\Exception $e) {
                    \DB::rollback();
                    return $e->getMessage();
                    return \Response::json(['status'=>-1,'descripcion'=>$e->getMessage(),'data'=>'']);
                }
            }else{
                return \Response::json(['status'=>1,'descripcion'=>'No se encuentra el Id:'.$id,'data'=>'']);
            }
        } catch (\Exception $e) {
            $log=(new logControllers)->error($e, 'DatosController','destroy');
        }
    }
}

