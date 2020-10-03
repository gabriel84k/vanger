<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Inspeccionecasegusur extends Model
{
    Protected $table='inspeccionecasegusurs';
    public $timestamps = false;
    /**
    * Los atributos que son asignables en masa.
    *
    * @var array
    */
   protected $fillable = [
    'elementoAusente',
    'campana',
    'valvula_purga',
    'manometro',
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
    'name'=>'Eca',
    'codigoElementoEncontrado'=>['tipo'=>'cumple','visible'=>true,'name'=>'codigoElementoEncontrado','muestra'=>'Cod. Ele. Encontrado','verdetalle'=>false],
    'elementoAusente'=>['tipo'=>'cumple','visible'=>false,'name'=>'elementoAusente','muestra'=>'Ausente','verdetalle'=>false],
    'campana'=>['tipo'=>'cumple','visible'=>true,'name'=>'campana','muestra'=>'Estado Campana','verdetalle'=>false],
    'valvula_purga'=>['tipo'=>'cumple','visible'=>true,'name'=>'valvula_purga','muestra'=>'Valvula de Purga','verdetalle'=>false],
    'manometro'=>['tipo'=>'cumple','visible'=>true,'name'=>'manometro','muestra'=>'Estado Manómetro','verdetalle'=>false],
    'inspeccion_id'=>['tipo'=>'int','visible'=>false,'name'=>'inspeccion_id','muestra'=>'Id Inspeccion','verdetalle'=>false],

   ];
}
