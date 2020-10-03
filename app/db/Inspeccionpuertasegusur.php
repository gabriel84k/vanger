<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Inspeccionpuertasegusur extends Model
{
    Protected $table='inspeccionpuertasegusurs';
    public $timestamps = false;
    /**
    * Los atributos que son asignables en masa.
    *
    * @var array
    */
    protected $fillable = [
    'elementoAusente',
    'cartel_senializacion',
    'barral',
    'cerradura',
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
    'name'=>'Puerta',
    #- [•Columnas locales•] -#
        'codigoElementoEncontrado'=>['tipo'=>'string','visible'=>true,'name'=>'codigoElementoEncontrado','muestra'=>'Cod. Ele. Encontrado','verdetalle'=>true],    
        'elementoAusente'=>['tipo'=>'bool','visible'=>true,'name'=>'elementoAusente','muestra'=>'Ausente','verdetalle'=>false],
        'cartel_senializacion'=>['tipo'=>'bool2','visible'=>true,'name'=>'cartel_senializacion','muestra'=>'Cartel Señalizacion','verdetalle'=>true],
        'barral'=>['tipo'=>'bool2','visible'=>true,'name'=>'barral','muestra'=>'Barral en Condiciones','verdetalle'=>true],
        'cerradura'=>['tipo'=>'bool2','visible'=>true,'name'=>'cerradura','muestra'=>'Cerradura en Condiciones','verdetalle'=>true],
        'inspeccion_id'=>['tipo'=>'int','visible'=>false,'name'=>'inspeccion_id','muestra'=>'Id Inspeccion','verdetalle'=>true],
    
        
   ];
}
