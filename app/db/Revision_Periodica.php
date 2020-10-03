<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Revision_Periodica extends Model
{
    protected $table = 'revision_periodicas';
    /**
    * Los atributos que son asignables en masa.
    *
    * @var array
    */
   protected $fillable = [
    'fecha', 
    'comentario', 
    'estado', 
    'nrocontrol', 
    'idControlPeriodico',  
    'sucursal_id'
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

        #- [•Columnas locales•] -#
        'fecha'=>['tipo'=>'date','visible'=>true,'name'=>'fecha','muestra'=>'Fecha '],
        'sucursal'=>['tipo'=>'string','visible'=>true,'name'=>'sucursal','muestra'=>'Sucursal'],
        'comentario'=>['tipo'=>'string','visible'=>true,'name'=>'comentario','muestra'=>'Comentario'],
        'btnaccion'=>['tipo'=>'template-button','visible'=>true,'name'=>'accion','muestra'=>'Detalle'],
        #- [•Fin Columnas Locales•] -#
    ];
   #[Relaciones >>>]
   public function inspecciones()
   {
       return $this->hasMany(Inspeccion::class,'revision_periodica_id');
   }
   
   public function cpinspecciones()
   {
       return $this->hasMany(Cpinspeccion::class,'revision_periodica_id');
   }
   public function sucursales()
   {
       return $this->hasOne(Sucursales::class,'id','sucursal_id');
   }
}
