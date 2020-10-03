<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Inspeccionkitsegusur extends Model
{
    Protected $table='inspeccionkitsegusurs';
    public $timestamps = false;
    /**
    * Los atributos que son asignables en masa.
    *
    * @var array
    */
    protected $fillable = [
    'elementoAusente',
    'gramillaAbsorbente',
    'tieneIDEquipo',
    'tieneBolsaAmarilla',
    'tieneMamelucoTyvex',
    'tieneAntiparra',
    'tieneGuantes',    
    'tieneCajaAmarillaChica',
    'tieneCajaAmarillaGrande',
    'tieneCordonesAbsorbentes',
    'tieneVRM',
    'mascaraID',
    'estadoMascara',
    'vtoFiltroMascara',
    'codigoElementoEncontrado',
    'inspeccion_id'
     
   ];


   /**
    * Los atributos que deben ocultarse para las matrices.
    *
    * @var array
    */
   protected $hidden = [
      
   ];

   /**
    * Los atributos que se deben convertir a los tipos nativos.
    *
    * @var array
    */
   protected $casts = [
       
   ];
   
   public $column = [
    'name'=>'Kit de Derrames',
    'codigoElementoEncontrado'=>['tipo'=>'int','visible'=>true,'name'=>'codigoElementoEncontrado','muestra'=>'Codigo Encontrado', 'verdetalle'=>true],
    'elementoAusente'=>['tipo'=>'string','visible'=>false,'name'=>'elementoAusente','muestra'=>'Ausente', 'verdetalle'=>false],
    'gramillaAbsorbente'=>['tipo'=>'cumple','visible'=>true,'name'=>'gramillaAbsorbente','muestra'=>'Gramilla Absorbente', 'verdetalle'=>true,'modelo'=>[1]],
    'tieneIDEquipo'=>['tipo'=>'bool','visible'=>true,'name'=>'tieneIDEquipo','muestra'=>'Tiene ID Equipo', 'verdetalle'=>true,'modelo'=>[2,3]],
    'tieneBolsaAmarilla'=>['tipo'=>'bool','visible'=>true,'name'=>'tieneBolsaAmarilla','muestra'=>'Tiene Bolsa Amarilla', 'verdetalle'=>true,'modelo'=>[2,3]],
    'tieneMamelucoTyvex'=>['tipo'=>'bool','visible'=>true,'name'=>'tieneMamelucoTyvex','muestra'=>'Tiene Mameluco Tyvex', 'verdetalle'=>true,'modelo'=>[2,3]],
    'tieneAntiparra'=>['tipo'=>'bool','visible'=>true,'name'=>'tieneAntiparra','muestra'=>'Tiene Antiparra', 'verdetalle'=>true,'modelo'=>[2,3]],
    'tieneGuantes'=>['tipo'=>'bool','visible'=>true,'name'=>'tieneGuantes','muestra'=>'Tiene Guantes', 'verdetalle'=>true,'modelo'=>[2,3]],
    'tieneCajaAmarillaChica'=>['tipo'=>'bool','visible'=>true,'name'=>'tieneCajaAmarillaChica','muestra'=>'Tiene Caja Amarilla Chica', 'verdetalle'=>true,'modelo'=>[2,3]],
    'tieneCajaAmarillaGrande'=>['tipo'=>'bool','visible'=>true,'name'=>'tieneCajaAmarillaGrande','muestra'=>'Tiene Caja Amarilla Grande', 'verdetalle'=>true,'modelo'=>[2,3]],
    'tieneCordonesAbsorbentes'=>['tipo'=>'bool','visible'=>true,'name'=>'tieneCordonesAbsorbentes','muestra'=>'Tiene Cordones Absorbentes', 'verdetalle'=>true,'modelo'=>[2,3]],
    'tieneVRM'=>['tipo'=>'bool','visible'=>true,'name'=>'tieneVRM','muestra'=>'Tiene VRM', 'verdetalle'=>true,'modelo'=>[2,3]],
    'mascaraID'=>['tipo'=>'int','visible'=>true,'name'=>'mascaraID','muestra'=>'Mascara ID', 'verdetalle'=>true,'modelo'=>[3]],
    'estadoMascara'=>['tipo'=>'string','visible'=>true,'name'=>'estadoMascara','muestra'=>'Estado Mascara', 'verdetalle'=>true,'modelo'=>[3]],
    'vtoFiltroMascara'=>['tipo'=>'string','visible'=>true,'name'=>'vtoFiltroMascara','muestra'=>'Vto Filtro Mascara', 'verdetalle'=>true,'modelo'=>[3]],
    'inspeccion_id'=>['tipo'=>'int','visible'=>false,'name'=>'inspeccion_id','muestra'=>'Id Inspeccion', 'verdetalle'=>false],

   ];
}

