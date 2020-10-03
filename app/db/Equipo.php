<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    Protected $table = 'extintors';
    protected $primaryKey = 'id';
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'idequipo',
        'nro_equipo_evolution',
        'tipo',
        'tipo_generico',
        'capacidad',
        'unidad',
        'marca',
        'fecha_fabricacion',
        'fecha_ultimo_ph',
        'sector',
        'codigo_interno_cliente',
        'vencimientoVidaUtil',
        'vencimiento_carga',
        'vencimiento_ph',
        'baja',
        'empresaAnterior',
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
    
    #[--· Columnas ·--]#
    public $conf = [
        'general' => [

            'titulo' => 'Extintor',
            'subtitulo' => 'Información Básica del Elemento',
            'classheard' => 'list-group-item ',
            'styleheard' => '',
            'classdato' => 'm-widget1__title title text-center',
            'styledato' => '',
            'classsubdato' => 'm-widget1__desc subtitle',
            'stylesubdato' => ''
        ],
    ];
    public $column = [

        'item' => [ 'tipo'=>'int', 'visible'=>true, 'name'=>'item', 'muestra'=>'N° Orden', 'verdetalle'=>false ],
        'nro_equipo_evolution' => [
            'tipo'=>'int',
            'visible'=>true,
            'name'=>'nro_equipo_evolution',
            'muestra'=>'Nro Equipo',
            'verdetalle'=>true
        ],
        'tipo' => [
            'tipo'=>'int',
            'visible'=>true,
            'name'=>'tipo',
            'muestra'=>'Agente',
            'verdetalle'=>true
        ],
        'tipo_generico' => [
            'tipo'=>'int',
            'visible'=>false,
            'name'=>'tipo_generico',
            'muestra'=>'Tipo Generico',
            'verdetalle'=>false
        ],
        'empresaAnterior' => [
            'tipo'=>'int',
            'visible'=>false,
            'name'=>'empresaAnterior',
            'muestra'=>'emperesa anterior',
            'verdetalle'=>false
        ],
        'ubicacion' => [
            'tipo'=>'int',
            'visible'=>true,
            'name'=>'puesto',
            'muestra'=>'Ubicación',
            'verdetalle'=>true
        ],
        'capacidad' => [
            'tipo'=>'int',
            'visible'=>true,
            'name'=>'capacidad',
            'muestra'=>'Capacidad',
            'verdetalle'=>true
        ],
        'unidad' => [
            'tipo'=>'int',
            'visible'=>false,
            'name'=>'unidad',
            'muestra'=>'Unidad',
            'verdetalle'=>true
        ],
        'marca' => [
            'tipo'=>'int',
            'visible'=>true,
            'name'=>'marca',
            'muestra'=>'Marca',
            'verdetalle'=>true
        ],
        'fecha_fabricacion' => [
            'tipo'=>'int',
            'visible'=>true,
            'name'=>'fecha_fabricacion',
            'muestra'=>'FF',
            'verdetalle'=>true
        ],
        'fecha_ultimo_ph' => [
            'tipo'=>'int',
            'visible'=>false,
            'name'=>'fecha_ultimo_ph',
            'muestra'=>'FUPH',
            'verdetalle'=>true
        ],
        'codigo_interno_cliente' => [
            'tipo'=>'int',
            'visible'=>false,
            'name'=>'codigo_interno_cliente',
            'muestra'=>'Cod. Interno Cliente',
            'verdetalle'=>true
        ],
        'vencimiento_carga' => [
            'tipo'=>'date',
            'visible'=>true,
            'name'=>'vencimiento_carga',
            'muestra'=>'Vencimiento Carga',
            'verdetalle'=>true
        ],
        'vencimiento_ph' => [
            'tipo'=>'date',
            'visible'=>false,
            'name'=>'vencimiento_ph',
            'muestra'=>'Vencimiento PH',
            'verdetalle'=>true
        ],
        'FV' => [
            'tipo'=>'string',
            'visible'=>false,
            'name'=>'FV',
            'muestra'=>'Vto. PH o Carga',
            'verdetalle'=>false
        ],
        'baja' => [
            'tipo'=>'int',
            'visible'=>false,
            'name'=>'baja',
            'muestra'=>'Baja',
            'verdetalle'=>false
        ],
        'btnaccion' => [
            'tipo'=>'template-button',
            'visible'=>true,
            'name'=>'accion',
            'muestra'=>'Detalle',
            'verdetalle'=>false
        ],
      
    ];

    #[--· Relaciones ·--]#
    
    public function elemento()
    {
        return $this->hasOne(Elemento::class,'elemento_id');
    }
    
    public function servicio()
    {
        return $this->hasMany(Servicio::class,'elemento_id','elemento_id');
    }
}
