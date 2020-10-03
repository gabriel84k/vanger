<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Puestohidrante extends Model
{
        /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $table = 'puestohidrantes';
    protected $fillable = [
        'desfavorable', 
        'medidaGAbiente', 
        'medidaVidrioGabinete', 
        'tieneReduccion', 
        'materialPuertaGabinete', 
        'tipoGabinete', 
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
        'general'=>['titulo'=>'Detalle Puesto Bie',
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
        # [•Columnas especificas del Puesto Hidrante•] #
       'desfavorable'=> ['tipo'=>'int','visible'=>true,'name'=>'tipopuesto.desfavorable','muestra'=>'Desfavorable','verdetalle'=>true],
       'tipoGabinete'=>['tipo'=>'string','visible'=>false,'name'=>'tipopuesto.tipoGabinete','muestra'=>'Tipo Gabinete','verdetalle'=>true],
       'medidaGAbiente'=>['tipo'=>'string','visible'=>true,'name'=>'tipopuesto.medidaGAbiente','muestra'=>'Medida Gabinete','verdetalle'=>true],
       'medidaVidrioGabinete'=> ['tipo'=>'string','visible'=>true,'name'=>'tipopuesto.medidaVidrioGabinete','muestra'=>'Medida Vidrio','verdetalle'=>true],
       'materialPuertaGabinete'=>['tipo'=>'string','visible'=>false,'name'=>'tipopuesto.materialPuertaGabinete','muestra'=>'Material Puerta Gabinete','verdetalle'=>true],
       'tieneReduccion'=>['tipo'=>'string','visible'=>false,'name'=>'tipopuesto.tieneReduccion','muestra'=>'Tiene Reduccion?','verdetalle'=>true],
        # [•Columnas especificas del Puesto Base•] #
        'nroPuesto_ubicacion'=>['tipo'=>'string','visible'=>true,'func'=>['nameadapt',' '],'name'=>['nroPuesto','ubicacion'], 'muestra'=>'ubicación','verdetalle'=>true],
    ];
    

    #[Relaciones >>>]

    public function cpinspecciones()
    {
        return $this->hasMany(Cpinspeccion::class,'puesto_id');
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
