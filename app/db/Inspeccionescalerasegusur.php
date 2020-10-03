<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Inspeccionescalerasegusur extends Model
{
    Protected $table='inspeccionescalerasegusurs';
    public $timestamps = false;
    /**
    * Los atributos que son asignables en masa.
    *
    * @var array
    */
    protected $fillable = [
    'elementoAusente',
    'estado_escalera',
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
    'name'=>'Escalera',
    'codigoElementoEncontrado'=>['tipo'=>'string','visible'=>true,'name'=>'codigoElementoEncontrado','muestra'=>'Cod. Ele. Encontrado','verdetalle'=>true],
    'elementoAusente'=>['tipo'=>'string','visible'=>false,'name'=>'elementoAusente','muestra'=>'Ausente','verdetalle'=>false],
    'estado_escalera'=>['tipo'=>'boolMal','visible'=>true,'name'=>'estado_escalera','muestra'=>'Estado Escalera', 'verdetalle'=>true],
    'inspeccion_id'=>['tipo'=>'int','visible'=>false,'name'=>'inspeccion_id','muestra'=>'Id Inspeccion','verdetalle'=>false],

   ];
}
