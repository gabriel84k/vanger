<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Puestoextintor extends Model
{
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $table = 'puestoextintors';
    protected $fillable = [
        'agente', 
        'capacidad', 
        'puesto_id', 
        'elemento_id'
    ];

    /**
     * Los atributos que deben ocultarse para las matrices.
     *
     * @var array
     */
    protected $hidden = [
        'created_at',
        'elemento_id',
        'id',
        'puesto_id',
        'updated_at'
    ];

    /**
     * Los atributos que se deben convertir a los tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        
    ];

    /**
     * Los atributos equivalentes entre sigexevolution y misextintores
     *
     * @var array
     */
    # [• Configuración •] #
    public $conf=[
        'general'=>['titulo'=>'Detalle Puesto Extintor',
                    'subtitulo'=>'Información del Puesto',
                    'classsubtitulo'=>'list-group-item',
                    'stylesubtitulo'=>'',
                    'classdato'=>'m-widget1__title title',
                    'styledato'=>'',
                    'classsubdato'=>'m-widget1__desc subtitle',
                    'stylesubdato'=>'',
                ],
    ];

    # [• Columnas •] #
    public $column = [

        # [• Columnas especificas del Puesto Extintor •] #
        'id'=>['tipo'=>'int','visible'=>false,'name'=>'tipopuesto.id','muestra'=>'Id','verdetalle'=>false],
        'agente'=>['tipo'=>'string','visible'=>true,'name'=>'tipopuesto.agente', 'muestra'=>'Agente Extintor','verdetalle'=>true],
        'capacidad'=>['tipo'=>'int','visible'=>true,'name'=>'tipopuesto.capacidad', 'muestra'=>'Capacidad','verdetalle'=>true],
        'puesto_id'=>['tipo'=>'key','visible'=>false,'name'=>'tipopuesto.puesto_id', 'muestra'=>'Id del Puesto','verdetalle'=>false],
        'elemento_id'=>['tipo'=>'key','visible'=>false,'name'=>'tipopuesto.elemento_id', 'muestra'=>'Id del Elemento','verdetalle'=>false],

        # [• Columnas especificas del Puesto Base •] #
        'nroPuesto_ubicacion'=>['tipo'=>'string','visible'=>true,'func'=>['nameadapt',' '],'name'=>['nroPuesto','ubicacion'], 'muestra'=>'ubicación','verdetalle'=>true],
        
    ];

    # [• Relaciones •] #
    public function inspecciones()
    {
        return $this->hasMany(Inspeccion::class,'puesto_id');
    }
    public function puestobase()
    {
        return $this->hasMany(Puesto::class,'puesto_id');
    }
    public function elemento()
    {
        return $this->hasOne(Elemento::class,'id','elemento_id');
    }
}
