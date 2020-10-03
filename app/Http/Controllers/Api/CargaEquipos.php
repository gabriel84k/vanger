<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\db\Sucursales;
use App\db\Equipo;
use App\db\Elemento; 

class CargaEquipos extends Controller
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
            #------ Controlamos si: Existe el elemento entonces lo creamos o actualizamos.------
                    #[Elementos]
                     
                    $campos=$request->all();
                  
                    $sucursal=(new Sucursales)::where('idsucursal',$campos['idSucursal'])->first();
                    if(!$sucursal){
                        return \Response::json(['status'=>-1,'descripcion'=>'No existe la Sucursal','data'=>'']);
                    }
                    $res=0;
                    $arr=[];
                    foreach ($campos['elemento'] as $key => $valelemento) {
                        $res++;
                        $MElemento=Elemento::where('idelementosigex','=',$valelemento['idelementosigex'])->first();
                        
                        if(!$MElemento){
                            # New
                            $MElemento=(new Elemento);

                            $valelemento['sucursal_id']=$sucursal->id;
                            $MElemento=$MElemento->create($valelemento);
                            $MElemento->save();
                            
                        }else{
                           
                            $valelemento['sucursal_id']=$sucursal->id;
                            $MElemento->update($valelemento);
                            
                        }
                       
                        $ElementoTipo= $this->_Elemento($MElemento,$campos['equipos'][$key]);
                      
                        if ($ElementoTipo != 'ok'){
                             
                            array_push ( $arr ,'Se Produjo un error al crear uno de los elementos: '. $ElementoTipo );
                        }
                    }
                    return \Response::json(['status'=>0,'descripcion'=>'Total de elementos procesados: '. $res,'data'=> '' ]);
           //\DB::commit();
           
       } catch (\Exception $e) {
            return \Response::json(['status'=>-1,'descripcion'=>'Error no se pudo terminar la operación. Error: '.$e->getMessage().' Linea: '.$e->getLine(),'data'=> '' ]);
                      
       }
   }
    /**
     * Funcion donde se crea el objeto Equipo
     */
    public function _Elemento(Elemento $MElemento, $Elementotipo  ){
        try {  
            
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
            return 'ok';
           
        } catch (\Throwable $th) {
            return \Response::json(['status'=>-1,'descripcion'=>'Detalle completo: '.$th->getMessage().' Line:'.$th->getLine().'Api Controller: Inspeccion->_elemento','data'=>'']);
                
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
