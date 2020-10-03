<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Puestopuerta extends Model
{
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $table = 'puestopuertas';
    protected $fillable = [
        'tipo_puerta',
        'tiene_barral',
        'tiene_cerradura',
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
        'general'=>['titulo'=>'Detalle Puesto Puerta',
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
        # [•Columnas especificas del Puesto Puerta•] #
       'id'=> ['tipo'=>'key','visible'=>false,'name'=>'tipopuesto.id','muestra'=>'Id','verdetalle'=>false],
       'codigoElemento'=>['tipo'=>'string','visible'=>true,'name'=>'tipopuesto.codigoElemento','muestra'=>'Codigo Elemento en el Puesto','verdetalle'=>true],
       'puesto_id'=> ['tipo'=>'key','visible'=>false,'name'=>'tipopuesto.puesto_id','muestra'=>'Id del Puesto','verdetalle'=>false],
       'tipo_puerta'=> ['tipo'=>'string','visible'=>true,'name'=>'tipopuesto.tipo_puerta','muestra'=>'Tiene Puerta?','verdetalle'=>true],
       'tiene_barral'=>['tipo'=>'string','visible'=>true,'name'=>'tipopuesto.tiene_barral','muestra'=>'Tiene Barral?','verdetalle'=>true],
       'tiene_cerradura'=>['tipo'=>'string','visible'=>true,'name'=>'tipopuesto.tiene_cerradura','muestra'=>'Tiene Cerradura?','verdetalle'=>true],
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
