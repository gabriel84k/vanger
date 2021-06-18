<?php
namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\db\Equipos;
class Elemento 
{
    public function equipo($Puesto){
        return $puesto;
        foreach ($Puesto['equipo'] as $key => $value) {
                                            
            $Model_Equipo=(new Equipos)::where('idequipo',$value['elemento_id'])
                                        ->where('sucursales_id',$idSucursal)
                                        ->get();
            
            if ($Model_Equipo->count()==0){
                $Model_Equipo=(new Equipos);
                $Model_Equipo->idequipo = $value['elemento_id'];
                $Model_Equipo->nro_equipo_evolution = $value['numeroDeEquipo'];
                if (!empty($value['FechaFabricacion'])){
                    $Model_Equipo->fecha_fabricacion = $value['FechaFabricacion'];
                }else{
                    $Model_Equipo->fecha_fabricacion ='01/00';
                }
                $Model_Equipo->fecha_ultimo_ph =$value['fechaUltimaPH'];
                $Model_Equipo->sector =$request->input('contrato.0.sucursales.0.sectores.0.sector');
                $Model_Equipo->vencimiento_carga =$value['vencimientoDeCarga'];
                $Model_Equipo->vencimiento_ph =$value['vencimientoDePH'];
                if (!empty($value['baja'])){
                    $Model_Equipo->baja =$value['baja'];
                }else{
                    $Model_Equipo->baja =0;
                }
                $Model_Equipo->capacidad =(float)$value['cap'][0]['capacidad'];
                $Model_Equipo->unidad =$value['cap'][0]['unidad'];
                $Model_Equipo->codigo_interno_cliente ='falta';
                $Model_Equipo->marca =$value['marca'][0]['Marca'];
                $Model_Equipo->tipo =$value['tipo'][0]['tipoDeEquipo'];
                $Model_Equipo->tipo_generico ='falta';
                #- Claves.

                $Model_Equipo->sucursales_id =$idSucursal;//$request->input('contrato.sucursales.sectores.puestos.equipo.sucursal.idSucursal');

                $Model_Equipo->save();
            }else{
                $Model_Equipo=$Model_Equipo[0];

                $Model_Equipo->idequipo = $value['elemento_id'];
                $Model_Equipo->nro_equipo_evolution = $value['numeroDeEquipo'];
                if (!empty($value['FechaFabricacion'])){
                    $Model_Equipo->fecha_fabricacion = $value['FechaFabricacion'];
                }else{
                    $Model_Equipo->fecha_fabricacion ='01/00';
                }
                $Model_Equipo->fecha_ultimo_ph =$value['fechaUltimaPH'];
                $Model_Equipo->sector =$request->input('contrato.0.sucursales.0.sectores.0.sector');
                $Model_Equipo->vencimiento_carga =$value['vencimientoDeCarga'];
                $Model_Equipo->vencimiento_ph =$value['vencimientoDePH'];
                if (!empty($value['baja'])){
                    $Model_Equipo->baja =$value['baja'];
                }else{
                    $Model_Equipo->baja =0;
                }
                $Model_Equipo->capacidad =(float)$value['cap'][0]['capacidad'];
                $Model_Equipo->unidad =$value['cap'][0]['unidad'];
                $Model_Equipo->codigo_interno_cliente ='falta';
                $Model_Equipo->marca =$value['marca'][0]['Marca'];
                $Model_Equipo->tipo =$value['tipo'][0]['tipoDeEquipo'];
                $Model_Equipo->tipo_generico ='falta';
                #- Claves.

                $Model_Equipo->sucursales_id =$idSucursal;//$request->input('contrato.sucursales.sectores.puestos.equipo.sucursal.idSucursal');
                $Model_Equipo->update();
            }

        }
    }
    public function manguera(){

    }
}
 

?>