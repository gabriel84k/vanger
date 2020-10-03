<?php

namespace App\Http\Controllers\Api;

use App\db\Sucursales;
use App\db\Sector;
use App\db\Puesto;
use App\db\Elemento;
use App\db\Fotos;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SPEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            
            $idSucursal = $request->get('idSucursal');
            $sucursal = Sucursales::where('idsucursal',$idSucursal)->first();
        
            if ($sucursal){
                $idSucursal = $sucursal->id;
        
            }else{
                /* Habilitar si queremos crear la sucursal*/
                #$sucursal = ( new Sucursales);
                #$sucursal->idsucursal = $request->get('idSucursal');
                #$sucursal->nombre = $request->get('nombre');
                #$sucursal->domicilio = $request->get('calle');
                #$sucursal->save();
                #$idSucursal = $sucursal->id;
                return \Response::json(['status'=>-1,'descripcion'=>'No existe Sucursal Por Favor crear Sucursal para continuar. ','data'=> '' ]);
            }
       
            #[• Modelo :: Sectores •]
            foreach ($request->input('sectores') as $key => $Sectores) {
                            
                $Model_Sect = Sector::where('idsector',$Sectores['idSector'])
                                        ->where('sucursales_id', $idSucursal)
                                        ->first();
               
                if (is_null($Model_Sect)){
                    #[•Crea nuevo Sector•]
                    
                    $Model_Sect = (new Sector);
                    $Model_Sect->idsector = $Sectores['idSector'];
                    if ( !empty( $Sectores['numero'] ) ){
                        $Model_Sect->numero = $Sectores['numero'];
                    }else{
                        $Model_Sect->numero = 0;
                    }
                    $Model_Sect->nombre = $Sectores['sector'];
                    $Model_Sect->sucursales_id = $idSucursal; 
                    $sector_id = $Model_Sect->id;
                    
                    $Model_Sect->save();

                }else{
                    #[•Modifica nuevo Sector•]
                    $sector_id=$Model_Sect->id;
                    //falta completar con llos otros datos.
                }

                #[• Modelo :: Puestos •] 
                    foreach ($Sectores['puestos'] as $key => $Puesto) {
                    
                        #[• Elementos •] 
                        if ($Puesto["puestobase"]['row_type'] != 'bie' || $Puesto["puestobase"]['row_type'] != 'extintor'){
                            $elemento_id=$this->_Elemento($Puesto,$idSucursal);
                            
                            if (!$elemento_id){
                                $elemento_id=null;
                            }
                        }else{
                            $elemento_id=null;
                        }
                    
                        #[• Puestos •]
                        $MPuesto = Puesto::where('sector_id',$Model_Sect->id)
                                            ->where('nroPuesto',$Puesto["puestobase"]["nroPuesto"])
                                            ->first();
                                   
                        #[Transforma los valores null]
                        if ( empty( $Puesto["puestobase"]['nroPuesto'] ) ){
                            $Puesto["puestobase"]['nroPuesto'] = 0;
                        }
                        if ( empty( $Puesto["puestobase"]['ubicacion'] ) ){
                            $Puesto["puestobase"]['ubicacion'] = '';
                        }
                        if ( empty( $Puesto["puestobase"]['idPuesto'] ) ){
                            $Puesto["puestobase"]['idPuesto'] = 0;
                        }
                        
                        $Puesto["puestobase"]['sector_id'] = $Model_Sect->id;
                        
                        if (!$MPuesto){
                            
                            #[• Crea nuevo Puesto •]
                            $MPuesto=(new Puesto);

                            $MPuesto=$MPuesto->create($Puesto["puestobase"]);
                            
                        }else{
                            $MPuesto->idPuesto = $Puesto["puestobase"]['nroPuesto'];
                            $MPuesto->update($Puesto["puestobase"]);
                        }
                       
                        #[• Puesto Especifico•]
                        $Puesto['puesto']['puesto_id'] = $MPuesto->id;
                    
                        ///////ver si es puesto con elemento o no ////////////
                        if ($elemento_id){
                        
                            if ($elemento_id == null){
                                $Puesto['puesto']['elemento_id'] = null;

                            }else{
                                
                                $Puesto['puesto']['elemento_id'] = $elemento_id->id;
                                
                            }
                        }
                    
                        $rowtype = $MPuesto->row_type;
                        if ( $MPuesto->$rowtype()->exists() ){
                            unset( $Puesto['puesto']['class'] );
                            $MPuestos = $MPuesto->$rowtype()->update($Puesto['puesto']);

                            
                        }else{
                            $MTipoPuesto="\App\db\\". $Puesto['puesto']['class'];
                            $nueva = new $MTipoPuesto();
                            $nueva = $nueva->create($Puesto['puesto']);
                        
                        }
                        
                    
                        
                    }
                #[•Fin Puestos•]
            }
          
            foreach ($request->input('equipossinpuesto') as $key => $equipossinpuestos) {
               
                   
                    $elemento_id=$this->_Elemento($equipossinpuestos['elemento'],$idSucursal);
                    
                

            }
            return \Response::json(['status'=>0,'descripcion'=>'Se crearon los sectores puestos y elementos correctamente.','data'=> '' ]);
            #[•Fin Sectores•]
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'descripcion'=>'Error no se pudo terminar la operación. Error: '.$th->getMessage().' Linea: '.$th->getLine(),'data'=> '' ]);
                
        }
    }
    public function _Elemento($Puesto,$idSucursal){
        
        if (!empty($Puesto['elemento'])){
            
            $value=$Puesto['elemento'];
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
        //
    }
}
