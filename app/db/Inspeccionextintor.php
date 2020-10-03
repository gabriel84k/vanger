<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Inspeccionextintor extends Model
{
    Protected $table='inspeccion_extintors';
     /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
      'idEquipo',
      'cargaVencida',
      'elementoAusente',
      'elementoObstruido',
      'carroDefectuoso',
      'equipoUsado',
      'equipoDespintado',
      'equipoDespresurizado',
      'alturaIncorreta',
      'faltaSenializacionEnAltura',
      'faltaSenializacionEnChapa',
      'faltaTarjeta',
      'faltaPrecinto',
      'soporteDefectuoso',
      'medioDeRupturaAusente',
      'mangueraRota',
      'otroProblema',
      'pesoActual',
      'inspeccion_id'
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
    
    public $column = [
        'name'=>'Extintores',
        
        'idEquipo'=>[ 'tipo'=>'int',
                      'visible'=>false,
                      'name'=>'idEquipo',
                      'muestra'=>'Id',
                      'verdetalle'=>true
                    ],
        'cargaVencida'=>[ 'tipo'=>'bool',
                          'visible'=>true,
                          'name'=>'cargaVencida',
                          'muestra'=>'Carga Vencida',
                          'verdetalle'=>true
                        ],
        'elementoAusente'=>['tipo'=>'bool','visible'=>true,'name'=>'elementoAusente','muestra'=>'Elemento Ausente','verdetalle'=>true],
        'elementoObstruido'=>['tipo'=>'bool','visible'=>true,'name'=>'elementoObstruido','muestra'=>'Elemento Obstruido','verdetalle'=>true],
        'carroDefectuoso'=>['tipo'=>'bool','visible'=>true,'name'=>'carroDefectuoso','muestra'=>'Carro Defectuoso','verdetalle'=>true],
        'equipoUsado'=>['tipo'=>'bool','visible'=>true,'name'=>'equipoUsado','muestra'=>'Equipo Usado','verdetalle'=>true],
        'equipoDespintado'=>['tipo'=>'bool','visible'=>true,'name'=>'equipoDespintado','muestra'=>'Equipo Despintado','verdetalle'=>true],
        'equipoDespresurizado'=>['tipo'=>'bool','visible'=>true,'name'=>'equipoDespresurizado','muestra'=>'Equipo Despresurizado','verdetalle'=>true],
        'alturaIncorreta'=>['tipo'=>'bool','visible'=>true,'name'=>'alturaIncorreta','muestra'=>'Altura Incorrecta','verdetalle'=>true],
        'faltaSenializacionEnAltura'=>['tipo'=>'bool','visible'=>true,'name'=>'faltaSenializacionEnAltura','muestra'=>'Falta Senialización en Altura','verdetalle'=>true],
        'faltaSenializacionEnChapa'=>['tipo'=>'bool','visible'=>true,'name'=>'faltaSenializacionEnChapa','muestra'=>'Falta Senialización en Chapa','verdetalle'=>true],
        'faltaTarjeta'=>['tipo'=>'bool','visible'=>true,'name'=>'faltaTarjeta','muestra'=>'Falta Tarjeta','verdetalle'=>true],
        'faltaPrecinto'=>['tipo'=>'bool','visible'=>true,'name'=>'faltaPrecinto','muestra'=>'Falta Precinto','verdetalle'=>true],
        'soporteDefectuoso'=>['tipo'=>'bool','visible'=>true,'name'=>'soporteDefectuoso','muestra'=>'Soporte Defectuoso','verdetalle'=>true],
        'medioDeRupturaAusente'=>['tipo'=>'bool','visible'=>true,'name'=>'medioDeRupturaAusente','muestra'=>'Medio de Ruptura Ausente','verdetalle'=>true],
        'mangueraRota'=>['tipo'=>'bool','visible'=>true,'name'=>'mangueraRota','muestra'=>'Manguera Rota','verdetalle'=>true],
        'otroProblema'=>['tipo'=>'string','visible'=>true,'name'=>'otroProblema','muestra'=>'Otro Problema','verdetalle'=>true],
        'pesoActual'=>['tipo'=>'int','visible'=>false,'name'=>'pesoActual','muestra'=>'Peso Actual','verdetalle'=>false],

    ];
      
    
    #[Relaciones >>>]
}
