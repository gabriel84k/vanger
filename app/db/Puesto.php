<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'nroPuesto', 
        'ubicacion', 
        'habilitado', 
        'idSector', 
        'idPuesto', 
        'row_type', 
        'sector_id'
        
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

    public $conf=[
       
    ];

    # [• Columnas •] #
    public $column = [
        #- [•Columnas locales•] -#
        'nroPuesto'=>['tipo'=>'string','visible'=>true,'name'=>'nroPuesto','muestra'=>'Nro Puesto','verdetalle'=>true],
        'ubicacion'=>['tipo'=>'string','visible'=>true,'name'=>'ubicacion','muestra'=>'Ubicacion','verdetalle'=>true],
        'habilitado'=>['tipo'=>'int','visible'=>true,'name'=>'habilitado','muestra'=>'Habilitado','verdetalle'=>false],
        'row_type'=>['tipo'=>'string','visible'=>true,'name'=>'row_type','muestra'=>'Tipo de Puesto','verdetalle'=>false],
        'sector_id'=>['tipo'=>'int','visible'=>false,'name'=>'sector_id','muestra'=>'Id del Sector','verdetalle'=>false],
        
        #- [•Columnas extrernas•] -#
        
            #-[•Elementos•]
            'element'=>['tipo'=>'template-datos','visible'=>true,'name'=>'element','muestra'=>'Elemento'],
            'Btnelement'=>['tipo'=>'template-button','visible'=>true,'name'=>'btndetalle','muestra'=>' Detalle'],

    ];

    # [• Relaciones •] #
    public function inspecciones()
    {
        return $this->hasMany(Inspeccion::class,'puesto_id');
    }
    public function sector()
    {
        return $this->hasOne(Sector::class,'id','sector_id');
    }
    public function extintor()
    {
        return $this->hasOne(Puestoextintor::class,'puesto_id');
    }
    public function bie()
    {
        return $this->hasOne(Puestohidrante::class,'puesto_id');
    }
    public function ecasegusur()
    {
        return $this->hasOne(Puestoeca::class,'puesto_id');
    }
    public function duchasegusur()
    {
        return $this->hasOne(Puestoducha::class,'puesto_id');
    }
    public function puertasegusur()
    {
        return $this->hasOne(Puestopuerta::class,'puesto_id');
    }
    public function esacalerasegusur()
    {
        return $this->hasOne(Puestoescalera::class,'puesto_id');
    }
    public function kitegusur()
    {
        return $this->hasOne(Puestokitderrame::class,'puesto_id');
    }    
}
