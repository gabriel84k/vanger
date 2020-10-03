<?php

namespace Tests\Feature\Testapi;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class apiuser extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testapiuser(){
        $res=
        $this->call('POST', 'api/Sigex/CreateUser/', array(
            'nombreUsuario' => 'prueba',
            'textoContrasenia' => '1234',
            'sucursales' => [array("idSucursal"=>354,"nombre"=>"PROSEGUR S.A.")],
            'codCliente' => '00000100',
            'permisos' => 0,
            'idUsuarioMisExtintores'=> 2,
          
        ));
        dd($res);
    }
}
