<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Puestoeca extends Model
{
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $table = 'puestoecas';
    protected $fillable = [
        'codigoElemento', 
        'puesto_id', 
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
        'general'=>['titulo'=>'Detalle Puesto Eca',
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
        # [•Columnas especificas del Puesto ECA•] #
        'id'=>['tipo'=>'key','visible'=>false,'name'=>'tipopuesto.id','muestra'=>'Id','verdetalle'=>false],
        'codigoElemento'=>['tipo'=>'string','visible'=>true,'name'=>'tipopuesto.codigoElemento','muestra'=>'Codigo Elemento en el Puesto','verdetalle'=>true],
        'puesto_id'=>['tipo'=>'key','visible'=>false,'name'=>'tipopuesto.puesto_id','muestra'=>'Id del Puesto','verdetalle'=>false],
        # [•Columnas especificas del Puesto Base•] #
        'nroPuesto_ubicacion'=>['tipo'=>'string','visible'=>true,'func'=>['nameadapt',' '],'name'=>['nroPuesto','ubicacion'], 'muestra'=>'ubicación','verdetalle'=>true],
    ];
    

    #[Relaciones >>>]

    public function inspecciones()
    {
        return $this->hasMany(Inspeccion::class,'puesto_id');
    }
    public function puestobase()
    {
        return $this->hasMany(Puesto::class,'puesto_id');
    }
  
}
