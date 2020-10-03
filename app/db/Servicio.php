<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';
    public $timestamps = false;
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'idsigexservicio', 
        'orden', 
        'fechaRecepcion', 
        'fechaReparaciones', 
        'fechaServicio', 
        'calificacion', 
        'vehicular', 
        'dominio',
        'realizarPH', 
        'realizarPintura', 
        'realizarOtros', 
        'observaciones', 
        'estado', 
        'servicioARealizar', 
        'calculoPH', 
        'reposicion', 
        'estadoDelPolvo', 
        'idMarcaLote', 
        'marcaLoteTexto', 
        'idPotencial', 
        'realizoPH', 
        'inspeccionVisual', 
        'recipiente', 
        'idOperadorInspeccion', 
        'numeroCertificadoCarga', 
        'numeroCertificadoPH', 
        'planilla_id', 
        'elemento_id'
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
    
    #[Column >>> Estas columnas se muestran en el vueTable]
    public $columns = [
        # - Asociadas-# 
        # - Equipo
        
        # - Principales del modelo - #
        'idsigexservicio'=>['tipo'=>'string','visible'=>false,'name'=>'idsigexservicio','muestra'=>'Id Servicio'],
        'calificacion'=>['tipo'=>'string','visible'=>true,'name'=>'calificacion','muestra'=>'Calificacion'], 
        'servicioARealizar'=>['tipo'=>'string','visible'=>true,'name'=>'servicioARealizar','muestra'=>'Servicio a Realizar'],
        'estado'=>['tipo'=>'string','visible'=>false,'name'=>'estado','muestra'=>'Estado'],
        'observaciones'=>['tipo'=>'string','visible'=>true,'name'=>'observaciones','muestra'=>'Observaciones'],
        
    ];

    #[ Relaciones ]
   
    public function rechazo()
    {
        return $this->belongsToMany(Rechazo::class, 'servicio_rechazo')->withPivot('servicio_id');
    }
    public function elemento()
    {
        return $this->hasOne(Elemento::class, 'id','elemento_id');
    }
    public function planilla(){
        return $this->hasOne(Planilla::class, 'id','planilla_id');
    }
    
}
