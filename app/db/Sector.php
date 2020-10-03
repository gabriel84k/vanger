<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $table = 'sectores';
    protected $fillable = [
        'idsector',
        'numero',
        'nombre',
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

    #[Relaciones >>>]

    public function puesto()
    {
        return $this->hasMany(Puesto::class,'sector_id');
    }
    
}
