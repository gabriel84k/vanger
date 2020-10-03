<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Repuesto extends Model
{
    //
    protected $table = 'repuestos';
    public $timestamps = false;

    public function reparacion()
    {
        return $this->hasMany(reparacion::class,'repuestos_id');
    }
}
