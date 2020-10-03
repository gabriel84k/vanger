<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Inspeccionduchasegusur extends Model
{
    Protected $table='inspeccionduchasegusurs';
    public $timestamps = false;
    /**
    * Los atributos que son asignables en masa.
    *
    * @var array
    */
   protected $fillable = [
    'elementoAusente',
    'ducha',
    'lavaojos',
    'valvula',
    'presion_correcta',
    'manija_accionadora',
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
    'name'=>'Duchas',
    'codigoElemento'=>['tipo'=>'string','visible'=>true,'name'=>'codigoElemento','muestra'=>'Cod. Ele. Encontrado' ,'verdetalle'=>true],
    'elementoAusente'=>['tipo'=>'string','visible'=>false,'name'=>'elementoAusente','muestra'=>'Ausente','verdetalle'=>true],
    'ducha'=>['tipo'=>'bool','visible'=>true,'name'=>'ducha','muestra'=>'Ducha','verdetalle'=>true],
    'lavaojos'=>['tipo'=>'bool2','visible'=>true,'name'=>'lavaojos','muestra'=>'Funciona Lavaojos?','verdetalle'=>true],
    'valvula'=>['tipo'=>'bool2','visible'=>true,'name'=>'valvula','muestra'=>'Valvular Cierra Bien?','verdetalle'=>true],
    'presion_correcta'=>['tipo'=>'bool2','visible'=>true,'name'=>'presion_correcta','muestra'=>'Presión Correcta?','verdetalle'=>true],
    'manija_accionadora'=>['tipo'=>'bool2','visible'=>true,'name'=>'manija_accionadora','muestra'=>'Funciona Manija Accionadora?','verdetalle'=>true],
    'inspeccion_id'=>['tipo'=>'int','visible'=>false,'name'=>'inspeccion_id','muestra'=>'Id Inspeccion','verdetalle'=>false],

   ];
}
