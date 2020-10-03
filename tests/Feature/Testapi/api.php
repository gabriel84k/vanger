<?php

namespace Tests\Feature\Testapi;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class api extends TestCase
{
    
  
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testapicarga(){
        $res=
        $this->call('POST', 'api/Sigex/Inspecciones/', array(
            "id"=> 207,
            "nroControl"=> 51,
            "fechaProgramacion"=> "2020-06-15",
            "fechaRealizado"=> "2020-06-15",
            "observaciones"=> "",
            "estado"=> 1,
            "tipo"=> 1,
            "contrato"=>array(  
                "nroContrato"=> "CO010",
                "fechaCarga"=> "2019-06-24",
                "periodo"=> 7,
                "estado"=> 1,
                "fechaInicio"=> "2019-06-24",
                "fechaFin"=> "2020-08-30",
                "observaciones"=> "",
                "cod_Cliente"=> 195,
                "idSucursal"=> 354,
                "id"=> 11,
                "sucursales"=>array(
                    "idSucursal"=> 354,
                    "nombre"=> "Aeroparque",
                    "sectores"=>array(
                        "idSector"=> 160,
                        "numero"=> "001",
                        "sector"=> "General",
                        "cod_Cliente"=> 195,
                        "idSucursal"=> 534,
                        "estadoSubida"=> 1,
                        "habilitado"=> 1,
                        "puestos"=>array(
                            "idPuesto"=> 4270,
                            "nroPuesto"=> "001",
                            "ubicacion"=> "Escalera",
                            "habilitado"=> 1,
                            "idCapacidad"=> 1,
                            "idSector"=> 160,
                            "tipoDeEquipo"=>array(
                                "tipoDeEquipo"=> "ABC-PQS",
                                "tipogenerico"=>array(
                                    "tipo"=> "Polvo",
                                    "tipoExtintor"=> "bajaPresion",
                                    "idTipoElemento"=> 1,
                                    "id"=> 1
                                )
                            ),
                            "equipo"=> array(
                                    "elemento_id"=> 18715,
                                    "numeroDeEquipo"=> "11897",
                                    "FechaFabricacion"=> "04\\/98",
                                    "fechaUltimaPH"=> "06\\/12",
                                    "vencimientoDeCarga"=> "2016-09-16",
                                    "vencimientoDePH"=> "2017-06-01",
                                    "codigoInternoCliente"=> "3",
                                    "observaciones"=> "",
                                    "disponible"=> true,
                                    "vencimientoVidaUtil"=> "2018-04-01",
                                    "tipo"=>array (
                                        "tipoDeEquipo"=> "HCFC 123",
                                        "tipogenerico"=>array(
                                            "tipo"=> "Halogenado",
                                            "tipoExtintor"=> "bajaPresion",
                                            "idTipoElemento"=> 1,
                                            "id"=> 5
                                        )
                                    ),
                                    "idCapacidad"=> 1,
                                    "marca"=>array (
                                        "id"=> 10,
                                        "Marca"=> "DRAGON",
                                        "marcaMOST"=> "Otros"
                                    ),
                                    "codCliente"=> 290,
                                    "sucursal"=>array(
                                        "idSucursal"=> 629,
                                        "nombre"=> "22 DE SEPTIEMBRE S.A. - Casa Central",
                                        "sectores"=>array()
                                    ),
                                    "idEquipo"=> 4
                                
                            )

                        ),
                    ),
                ),
            ),
            "inspecciones"=> array(
                "fechahora"=> "08/12/2019 01=>00=>00",
                "observaciones"=> "",
                "estado"=> 1,
                "idControlPeriodico"=> 207,
                "puesto"=> array(
                    "idPuesto"=> 4270,
                    "nroPuesto"=> "001",
                    "ubicacion"=> "Escalera",
                    "habilitado"=> 1,
                    "idCapacidad"=> 1,
                    "idSector"=> 160,
                    "tipoDeEquipo"=> array(
                        "tipoDeEquipo"=> "ABC-PQS",
                        "tipogenerico"=> array(
                            "tipo"=> "Polvo",
                            "tipoExtintor"=> "bajaPresion",
                            "idTipoElemento"=> 1,
                            "id"=> 1
                        )
                    ),
                    "equipo"=> array(
                        "elemento_id"=> 18715,
                        "numeroDeEquipo"=> "11897",
                        "FechaFabricacion"=> "04\\/98",
                        "fechaUltimaPH"=> "06\\/12",
                        "vencimientoDeCarga"=> "2016-09-16",
                        "vencimientoDePH"=> "2017-06-01",
                        "codigoInternoCliente"=> "3",
                        "observaciones"=> "",
                        "disponible"=> true,
                        "vencimientoVidaUtil"=> "2018-04-01",
                        "tipo"=> array(
                            "tipoDeEquipo"=> "HCFC 123",
                            "tipogenerico"=> array(
                                "tipo"=> "Halogenado",
                                "tipoExtintor"=> "bajaPresion",
                                "idTipoElemento"=> 1,
                                "id"=> 5
                            )
                        ),
                        "idCapacidad"=> 1,
                        "marca"=> array(
                            "id"=> 10,
                            "Marca"=> "DRAGON",
                            "marcaMOST"=> "Otros"
                        ),
                        "codCliente"=> 290,
                        "sucursal"=> array(
                            "idSucursal"=> 629,
                            "nombre"=> "22 DE SEPTIEMBRE S.A. - Casa Central",
                            "sectores"=> array()
                        ),
                        "idEquipo"=> 4
                    )
                ),
                "equipo"=> array(
                    "elemento_id"=> 18715,
                    "numeroDeEquipo"=> "11897",
                    "FechaFabricacion"=> "04\\/98",
                    "fechaUltimaPH"=> "06\\/12",
                    "vencimientoDeCarga"=> "2016-09-16",
                    "vencimientoDePH"=> "2017-06-01",
                    "codigoInternoCliente"=> "3",
                    "observaciones"=> "",
                    "disponible"=> true,
                    "vencimientoVidaUtil"=> "2018-04-01",
                    "tipo"=> array(
                        "tipoDeEquipo"=> "HCFC 123",
                        "tipogenerico"=> array(
                            "tipo"=> "Halogenado",
                            "tipoExtintor"=> "bajaPresion",
                            "idTipoElemento"=> 1,
                            "id"=> 5
                        )
                    ),
                    "idCapacidad"=> 1,
                    "marca"=> array(
                        "id"=> 10,
                        "Marca"=> "DRAGON",
                        "marcaMOST"=> "Otros"
                    ),
                    "codCliente"=> 290,
                    "sucursal"=> array(
                        "idSucursal"=> 629,
                        "nombre"=> "22 DE SEPTIEMBRE S.A. - Casa Central",
                        "sectores"=> array()
                    ),
                    "idEquipo"=> 4
                ),
                "id"=> 13333,
                "fotos"=> array()
            )

        ));
        dd($res);
    }
    
}
