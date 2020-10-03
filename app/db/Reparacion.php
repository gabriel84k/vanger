<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Reparacion extends Model
{
    protected $table = 'reparaciones';
    public $timestamps = false;

     /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'idrepsigex', 
        'resultado',
        'idServiciosigex', 
        'idRepuestosigex', 
        'servicio_id', 
        'repuesto_id',
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
        'idrepsigex' =>['tipo'=>'string','visible'=>false,'name'=>'idrepsigex','muestra'=>'Id repuesto sigex'],
        'resultado'=>['tipo'=>'string','visible'=>true,'name'=>'resultado','muestra'=>'Resultado'],
        'idServiciosigex'=>['tipo'=>'string','visible'=>false,'name'=>'idServiciosigex','muestra'=>'Id servicio sigex'],
        'idRepuestosigex'=>['tipo'=>'string','visible'=>false,'name'=>'idRepuestosigex','muestra'=>'Id repuesto sigex'],
        'servicio_id'=>['tipo'=>'string','visible'=>false,'name'=>'servicio_id','muestra'=>'Id servicio'],
        'repuesto_id'=>['tipo'=>'string','visible'=>false,'name'=>'repuesto_id','muestra'=>'Id repuesto'],
    ];

    #[ Relaciones ]
   
    public function servicio()
    {
        return $this->hasOne(Servicio::class, 'id','servicio_id');
    }
    public function repuesto()
    {
        return $this->hasOne(Repuesto::class,'id', 'repuesto_id');
    }
}
