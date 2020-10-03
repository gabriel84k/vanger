<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Rechazo extends Model
{
    protected $table = 'rechazos';
    public $timestamps = false;



    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_rechazo')->withPivot('rechazo_id');
    }
}
