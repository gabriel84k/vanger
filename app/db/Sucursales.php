<?php

namespace App\db;
use App\db\Planilla;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Sucursales extends Model
{
    protected $table='sucursales';
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'idsucursal',
        'nombre',
        'domicilio'
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

    # [• Configuración •] #
    public $conf=[
       
        'sucursal'=>[
            'classnombre'=>'',
            'stylenombre'=>'',
            'textexcel'=>'Listado de Sucursal',
            'classicon'=>'fa fa-file-excel-o fa fa-download',
            'tooltip'=>'Descargar listado de la Sucursal'
        ],
        'sector'=>[
            'nombre'=>'Sectores',
            'classnombre'=>'col-sm-5 border-right',
            'stylenombre'=>''
        ],
        'puestos'=>[
            'btnnombre'=>'Ver Detalle',
            'btnstyle'=>'font-size: 9px;',
            'btnclass'=>'btn btn-outline-success',


        ]
        
    ];

    # [• Relaciones •] #

    public function users()
    {
        return $this->belongsToMany(User::class, 'usuarios_sucursales')->withPivot('user_id');
    }
    public function planilla()
    {
        return $this->hasMany(Planilla::class,'sucursal_id');
    }
    public function revisionperiodicas()
    {
        return $this->hasMany(Revision_Periodica::class,'sucursal_id');
    }
    public function elementos()
    {
        return $this->hasMany(Elemento::class,'sucursal_id');
    }
    public function puesto()
    {
        return $this->hasOne(Puesto::class,'id','puesto_id');
    }
    public function sectors()
    {
        return $this->hasMany(Sector::class,'sucursales_id');
    }
   
}
