<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Inspeccion extends Model
{
    Protected $table='inspecciones';
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'fechahora',
        'codigoControl',
        'observaciones',
        'estado',
        'recomendacion',
        'elementoAusente',
        'elementoObstruido',
        'elementoIncompatible',
        'elementoVencido', 
        'elementoNoRegistrado',
        'elementoSustituto',
        'codigoSustituto',
        'codigoEquipoSustituto',
        'revision_periodica_id', 
        'puesto_id', 
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

    # [Configura Campos particulares para la Información Básica del Puesto]
    public $Attr_particulares=[    
        'inspeccionextintor' => [
            # •Columnas Extintor• #
            # •Codigo del Elemento + Agente + Capacidad + unidad
            'elemento' => [
                            'tipo' => 'string',
                            'visible' => false,
                            'func' => ['nameadapt',' '],
                            'name' => ['elemento.nro_equipo_evolution','elemento.tipo','elemento.capacidad','elemento.unidad'],
                            'muestra' => 'Elemento',
                            'verdetalle' => true
                        ],
        ],
        'inspeccionbie' => [
            # •Columnas Bie #
            # •Codigo del 
            'elemento'=>['tipo'=>'string',
                            'visible'=>false,
                            'func'=>['nameadapt',' '],
                            'name'=>['elemento.numeroManguera','elemento.longitudmili','elemento.diametromili'],
                            'muestra'=>'Elemento',
                            'verdetalle'=>true
                        ],
        ],
        'inspeccionkitsegusur' => [
            # •Columnas Kit de Derrame• #
            # •Codigo Elemento
            'codigoElemento'=>['tipo'=>'string',
                                'visible'=>false,
                                'name'=>'',
                                'muestra'=>'Código Elemento',
                                'verdetalle'=>true
                            ],
            # •Modelo
            'modelo'=>['tipo'=>'string',
                        'visible'=>false,
                        'name'=>'puesto.tipopuesto.modelo',
                        'muestra'=>'Modelo',
                        'verdetalle'=>true
                    ],
        ],
        'inspeccionpuertasegusur' => [
            # •Columnas Puerta• #
            # •Codigo Elemento
            'codigoElemento'=>['tipo'=>'string',
                                'visible'=>false,
                                'name'=>'puesto.tipopuesto.codigoElemento',
                                'muestra'=>'Código Elemento',
                                'verdetalle'=>true
                            ],
        ],
        'inspeccionescalerasegusur' => [
            # •Columnas Escalera• #
            # •Codigo Elemento
            'codigoElemento'=>['tipo'=>'string',
                                'visible'=>false,
                                'name'=>'puesto.tipopuesto.codigoElemento',
                                'muestra'=>'Código Elemento',
                                'verdetalle'=>true
                            ],
        ],
        'inspeccionduchasegusur' => [
            # •Columnas Ducha• #
            # •Codigo Elemento
            'codigoElemento'=>['tipo'=>'string',
                                'visible'=>false,
                                'name'=>'puesto.tipopuesto.codigoElemento',
                                'muestra'=>'Código Elemento',
                                'verdetalle'=>true
                            ],
            'tipo_ducha'=>['tipo'=>'string',
                            'visible'=>false,
                            'name'=>'puesto.tipopuesto.tipo_ducha',
                            'muestra'=>'Tipo Ducha',
                            'verdetalle'=>true,
                            'func'=>['muestraducha']
                            ],
                        
        ],
        'inspeccionecasegusur' => [
            # •Columnas Eca• #
            # •Codigo Elemento
            'codigoElemento'=>['tipo'=>'string',
                                'visible'=>false,
                                'name'=>'puesto.tipopuesto.codigoElemento',
                                'muestra'=>'Código Elemento',
                                'verdetalle'=>true
                            ],
        ]
    ];
    #- [• Configuraciones •] -#
    public $conf=[
        'incidencias'=>['inicio'=>0,
                        'fin'=>30,
                        'style'=>'color:blue;',
                    ],
        'general'=>['titulo'=>'Inspecciones',
                    'combopdf'=>'PDF por Tipo',
                    'botonpdf'=>'Inspecciones',
                    
                ],
        'filas'=>[  'fila_estado'=>'alert alert-danger',
                    'botondetalle'=>['nombre'=>'Ver Detalle',
                                     'clase'=>'btn btn-outline-success',
                                     'style'=>'font-size:9px'
                    ],
                    'combofoto'=>['nombre'=>'Desplegar...',
                                  'habilitado'=>'btn-success',
                                  'deshabilitad'=>'btn-secondary disabled'
                                ]
                ],
        'imagen'=>['titulo'=>'Imagenes',
                    'styleheard'=>'color: #138e48;',
                    'classzoom'=>'card zoom',
                    'stylemodal'=>'background: grey;',
                    'styleimg'=>'width: 55%;',
                    'classimg'=>'card-img-top   rounded mx-auto d-block']
    ];
    public $column=[
        #- [• Columnas locales •] -#
            'fechahora'=>['tipo'=>'date','visible'=>true,'name'=>'fechahora','muestra'=>'Fecha de Inspección','verdetalle'=>true],

        #- [• Columnas del Puesto •] -#
            'sectornombre'=>['tipo'=>'string','visible'=>true,'name'=>'puesto.sector.nombre','muestra'=>'Sector','verdetalle'=>false],
            'nroPuesto'=>['tipo'=>'string','visible'=>true,'name'=>'puesto.nroPuesto','muestra'=>'Nro','verdetalle'=>true],
            'ubicacionpuesto'=>['tipo'=>'string','visible'=>true,'name'=>'puesto.ubicacion','muestra'=>'Puesto','verdetalle'=>true],
            'puestorowtype'=>['tipo'=>'string','visible'=>true,'name'=>'puesto.row_type','muestra'=>'Tipo','func'=>['row_type'],'verdetalle'=>false],
            
        #- [• Columnas del Elememnto Personalizada •] -#
            'elemento'=>['tipo'=>'string','visible'=>true,'name'=>'elemento','muestra'=>'Elemento','verdetalle'=>false],
            'estado'=>['tipo'=>'int','visible'=>false,'name'=>'estado','muestra'=>'Estado','func'=>['estado'],'verdetalle'=>true],
            'incidencias'=>['tipo'=>'string','visible'=>true,'name'=>'incidencias','muestra'=>'Incidencias','verdetalle'=>false],
            'observaciones'=>['tipo'=>'string','visible'=>true,'name'=>'observaciones','muestra'=>'Observaciones','verdetalle'=>false],
            'imagenes'=>['tipo'=>'template-datos','visible'=>true,'name'=>'imagenes','muestra'=>'Imagenes','verdetalle'=>false],
            'btnaccion'=>['tipo'=>'template-button','visible'=>true,'name'=>'accion','muestra'=>'Detalle','verdetalle'=>false],
        #- [• Fin Columnas Locales •] -#
        
    ];
    

    #[Relaciones >>>]
    public function inspeccionextintor()
    {
        return $this->hasOne(Inspeccionextintor::class,'inspeccion_id');
    }
    public function inspeccionbie()
    {
        return $this->hasOne(Inspeccionbie::class,'inspeccion_id');
    }
    public function inspeccionecasegusur()
    {
        return $this->hasOne(Inspeccionecasegusur::class,'inspeccion_id');
    }
    public function inspeccionduchasegusur()
    {
        return $this->hasOne(inspeccionduchasegusur::class,'inspeccion_id');
    }

    public function inspeccionpuertasegusur()
    {
        return $this->hasOne(Inspeccionpuertasegusur::class,'inspeccion_id');
    }
    public function inspeccionescalerasegusur()
    {
        return $this->hasOne(Inspeccionescalerasegusur::class,'inspeccion_id');
    }
    public function inspeccionkitsegusur()
    {
        return $this->hasOne(Inspeccionkitsegusur::class,'inspeccion_id');
    }        
    public function puesto()
    {
        return $this->hasOne(Puesto::class,'id','puesto_id');
    }
    public function elemento()
    {
        return $this->hasOne(Elemento::class,'id','elemento_id');
    }
}

