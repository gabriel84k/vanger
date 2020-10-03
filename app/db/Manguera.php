<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Manguera extends Model
{
    Protected $table='mangueras';
    protected $primaryKey = 'id';
    public $timestamps = false;
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'sector', 
        'codigoInterno', 
        'disponible', 
        'sustituto', 
        'observaciones', 
        'row_type', 
        'uniones', 
        'vencimientoDePH', 
        'codigoInternoCliente', 
        'longitudReal', 
        'numeroManguera', 
        'fechaUltimaPH', 
        'baja', 
        'lanzanombre', 
        'lanzatipo', 
        'boquillanombre', 
        'diametropulgada', 
        'diametromili', 
        'longitudmili', 
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
    public $conf=[
        'general'=>['titulo'=>'Manguera',
                    'subtitulo'=>'Información Básica del Elemento',
                    'classheard'=>'list-group-item ',
                    'styleheard'=>'',
                    'classdato'=>'m-widget1__title title text-center',
                    'styledato'=>'',
                    'classsubdato'=>'m-widget1__desc subtitle',
                    'stylesubdato'=>''
                ],
    ];
    public $column=[ 
        'name'=>'Manguera',
        "numeroManguera"=> ['tipo'=>'int','visible'=>true,'name'=>'numeroManguera','muestra'=>'Nro. Manguera','verdetalle'=>true],
        "longitudReal"=> ['tipo'=>'int','visible'=>false,'name'=>'longitudReal','muestra'=>'Longitud Real','verdetalle'=>false],
        "longitudmili"=> ['tipo'=>'int','visible'=>true,'name'=>'longitudmili','muestra'=>'Longitud','verdetalle'=>true],
        "diametro"=> ['tipo'=>'int','visible'=>true,'name'=>'diametromili','muestra'=>'Diametro','verdetalle'=>true],
        "uniones"=> ['tipo'=>'int','visible'=>true,'name'=>'uniones','muestra'=>'Uniones','verdetalle'=>true],        
        "lanzanombre"=> ['tipo'=>'int','visible'=>true,'name'=>'lanzanombre','muestra'=>'Lanza','verdetalle'=>true],
        "boquillanombre"=> ['tipo'=>'int','visible'=>true,'name'=>'boquillanombre','muestra'=>'Boquilla','verdetalle'=>true],
        "vencimientoDePH"=> ['tipo'=>'date','visible'=>true,'name'=>'vencimientoDePH','muestra'=>'Venc. PH','verdetalle'=>true],
        "sector"=> ['tipo'=>'int','visible'=>false,'name'=>'sector','muestra'=>'Sector','verdetalle'=>false],
        "codigoInterno"=> ['tipo'=>'int','visible'=>false,'name'=>'codigoInterno','muestra'=>'Cod. Interno','verdetalle'=>false],
        "disponible"=> ['tipo'=>'bool','visible'=>false,'name'=>'disponible','muestra'=>'Disponible','verdetalle'=>false],
        "sustituto"=> ['tipo'=>'bool','visible'=>false,'name'=>'sustituto','muestra'=>'Sustituto','verdetalle'=>false],
        "observaciones"=> ['tipo'=>'int','visible'=>false,'name'=>'observaciones','muestra'=>'Obvservaciones','verdetalle'=>true],
        "row_type"=> ['tipo'=>'int','visible'=>false,'name'=>'row_type','muestra'=>'Tipo','verdetalle'=>false],
        "codigoInternoCliente"=> ['tipo'=>'int','visible'=>false,'name'=>'codigoInternoCliente','muestra'=>'Cod. Int. Cliente','verdetalle'=>false],
        "fechaUltimaPH"=> ['tipo'=>'string','visible'=>false,'name'=>'fechaUltimaPH','muestra'=>'UFPH','verdetalle'=>false],
        "baja"=> ['tipo'=>'bool','visible'=>true,'name'=>'baja','muestra'=>'Estado','verdetalle'=>false],
        "lanzatipo"=> ['tipo'=>'int','visible'=>false,'name'=>'lanzatipo','muestra'=>'Tipo','verdetalle'=>false],
        'btnaccion'=>['tipo'=>'template-button','visible'=>true,'name'=>'accion','muestra'=>'Detalle','verdetalle'=>false],
    ];

    #[Relaciones >>>]
   
    public function elemento()
    {
        return $this->hasOne(Elemento::class,'elemento_id');
    }

}
