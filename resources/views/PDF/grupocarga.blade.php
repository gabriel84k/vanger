<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
       
    <div class="container-lg">
       
        <table class="table table-borderless">
            <thead >
                <tr class="text-center">
                    <th scope="col"> <img src="logo/sigex_pdf.png" style="width: 100px;"></th>
                    <th><h5>Constancia del Servicio de Mantenimiento y Recarga de Extintores</h5></th>
                    <th scope="col"> <img src="logo/sigex_pdf.png" style="width: 100px;"></th>
                   
                </tr>
                
            </thead> 
            <tbody class="datos">
                <tr>
                    <td colspan="3"><hr></td>
                </tr>
                <tr>
                    <td><b>Fecha:</b> {{date_format(date_create($datos[0]->fecha_servicio),"d/m/Y")}}</td>
                </tr>
                <tr>
                    <td colspan="3"><b>Cliente:</b> {{Auth::user()->name}}</td>
                </tr>
                <tr>
                    <td colspan="3"><b>Sucursal:</b> {{$datos[0]->sucursal->nombre}}</td>
                </tr>
                <tr>
                    <td colspan="3"><b>Dirección:</b> {{$datos[0]->sucursal->domicilio}}</td>
                </tr>
                
            </tbody>
               
        </table>
        
        <table class="table text-center">
            <thead class="cabeza">
                <tr class="text-center">
                    <th class="equipo">Nº Extintor</th>
                    <th class="tipo">Tipo de Equipo</th>
                    <th class="marca">Marca</th>
                    <th class="cap" >Cap.</th>
                    <th class="fecha" >Mant. y Rec.</th>
                    <th class="fecha" >Vto. de PH</th>
                    <th class="obs">Observaciones</th>
                </tr>
            </thead> 
            <tbody class="cuerpo">
               
                @foreach($datos as $item)
                 
                    <tr>
                        <td>{{$item->elemento->nro_equipo_evolution}}</td>
                        <td>{{$item->elemento->tipo}}</td>
                        <td>{{$item->elemento->marca}}</td>
                        <td>{{$item->elemento->capacidad.' '.$item->elemento->unidad}}</td>
                        <td>{{date_format(date_create($item->elemento->vencimiento_carga),"m/y")}}</td>
                        <td>{{date_format(date_create($item->elemento->vencimiento_ph),"m/y")}}</td>
                        <td>{{$item->observaciones}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
       
    </div>
    <footer class="footer" style="padding-top: 5%">        
        <p>NOTAS: La validez del servicio realizado coincide con la fecha del vencimiento de mantenimiento yla recarga. La garantía será
            efectiva si no se ha violado el precinto de seguridad.</p>
            <br><br><br>
            <div class="row">
                <table>
                    <tbody>
                        <tr class="text-center">
                            <td colspan="2" style="width: 35em;">
                                <div class="col-lg-6">
                                    <div style="height:7em;"></div>
                                    ________________________          
                                    <p>Recibí Conforme</p>
                                </div>
                            </td>
                            <!--
                            <td colspan="3" style="width: 10em;">
                                <div class="col-lg-6" >
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    ________________________
                                    <p>Vanger</p>
                                </div>
                            </td>
                            -->
                        </tr>
                    </tbody>
                </table>
            </div>
    </footer>

</body>
<style>
    .table>tbody>tr>td{
        height: 0px;
        padding: 0px;
    }
    .datos{
        font-size: 10px;
    }
    .cabeza{
        font-size: 12px;
        background-color: #828a90;
        color:white;
    }
    .cabeza>tr{
        .equipo{
            width: 27%;
        }
        .tipo{
            width: 18%;
        }
        .marca{
            width: 10%;
        }
        .cap{
            width: 6%;
        }
        .fecha{
            width: 14%;
        }
        .obs{
            width: 25%;
        }
        /*Total   100%*/          
    }
    
    .cuerpo{
        font-size: 12px;
        border: 1px solid #9C9C9C;
    }
    .footer{
        font-size: 12px;
    }
</style>
</html>