<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    protected $table =  'planillas';
    public $timestamps = false;
    protected $primaryKey = 'id';

    /**
    * Los atributos que son asignables en masa.
    *
    * @var array
    */
    protected $fillable = [
      'IdSigex', 
      'fecha_servicio', 
      'nro_planilla', 
      'orden_trabajo', 
      'cantidadMat', 
      'idEstado', 
      'sucursal_id',
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

    #[Column >>>]
    public $columns = [
      'IdSigex'=>['tipo'=>'int','visible'=>false,'name'=>'IdSigex','muestra'=>'Id en Sigex'],
      'fecha_servicio' =>['tipo'=>'date','visible'=>true,'name'=>'fecha_servicio','muestra'=>'Fecha de Servicio'],
      'nro_planilla'=>['tipo'=>'int','visible'=>true,'name'=>'nro_planilla','muestra'=>'Nro. Planilla'],
      'orden_trabajo'=>['tipo'=>'int','visible'=>true,'name'=>'orden_trabajo','muestra'=>'Orden de Trabajo'], 
      'cantidadMat'=>['tipo'=>'int','visible'=>true,'name'=>'cantidadMat','muestra'=>'Cant. Equipo'], 
      'idEstado'=>['tipo'=>'int','visible'=>false,'name'=>'idEstado','muestra'=>'Id Estado'], 
      
     
    ];

   #[ Relaciones ]
    public function servicio()
    {
        return $this->hasMany(Servicio::class,'planilla_id');
    }
    public function sucursal()
    {
        return $this->hasOne(Sucursales::class,'id','sucursal_id');
    }
}
