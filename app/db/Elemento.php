<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Elemento extends Model
{
   
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'idTipoElemento',
        'idelementosigex',
        'creadoMovil',
        'row_type',
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

    #[--· Relaciones ·--]
    public function inspecciones()
    {
        return $this->hasMany(Inspeccion::class,'elemento_id');
    }

    public function equipos()
    {
        return $this->hasOne(Equipo::class,'elemento_id');
    }
    
    public function mangueras()
    {
        return $this->hasOne(Manguera::class,'elemento_id');
    }
    
    public function sucursales()
    {
        return $this->hasOne(Sucursales::class,'id','sucursal_id');
    }
    
    public function servicio()
    {
        return $this->hasMany(Servicio::class,'elemento_id');
    }    
}
