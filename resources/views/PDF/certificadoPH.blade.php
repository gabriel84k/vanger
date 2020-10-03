<!doctype html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div style="display:none;">{{$key=0}}</div>
    <div class="container-lg">
    
        @foreach($datos as $item)
           
            @if($item->realizoPH==1)
                <div style="display:none;">{{$key++}}</div>
                @if($idequipo!=0)
                    @if($idequipo==$item->elemento_id)
                        <table class="table table-borderless">
                            <thead >
                                <tr class="text-center">
                                    <th scope="col"> <h5>CERTIFICADO DE PH</h5></th>
                                    <th></th>
                                <th scope="col"> <img src="logo/sigex_pdf.png" style="    width: 150px;"></th>
                                
                                </tr>
                                
                            </thead> 
                            <tbody class="datos">
                                <tr>
                                    <td colspan="3"><br></td>
                                </tr>
                                <tr>
                                    <td><b>Nro de Orden:</b>{{$datos[0]->orden}}</td>
                                    <td></td>
                                    <td><b>Fecha Servicio:</b> {{date('d/m/Y')}}</td>
                                </tr>
                                <tr>
                                    <td><b>Cliente:</b> {{Auth::user()->name}}</td>
                                </tr>
                                <tr>
                                    <td><b>Sucursal:</b> {{$datos[0]->sucursal->nombre}}</td>
                                    <td></td>
                                    <td><b>Dirección:</b> {{$datos[0]->sucursal->domicilio}}</td>
                                </tr>
                            
                            </tbody>
                            
                        </table>
                        <table class="table-borderless table text-left">
                            <thead >
                                <tr class="text-center">
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="cuerpo">
                                @if ($item->realizoPH==1)    
                                    <tr><td colspan="3"><hr></td></tr>
                                    <tr>
                                        <td><b>Nro. Equipo:</b> {{$item->elemento->nro_equipo_evolution}}</td>
                                        <td><b>Codigo Interno:</b> -</td>
                                    
                                        <td><b>Tipo Equipo:</b>{{$item->elemento->tipo}}</td>
                                    </tr>
                                    <tr>
                                        
                                        <td><b>Marca:</b> {{$item->elemento->marca}}</td>
                                    
                                        <td><b>Capacidad:</b> {{$item->elemento->capacidad.' '.$item->elemento->unidad}}</td>
                                        
                                        <td><b>Vto. Carga:</b> {{date_format(date_create($item->elemento->vencimiento_carga),"m/Y")}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Vto. PH:</b> {{date_format(date_create($item->elemento->vencimiento_ph),"m/Y")}}</td>
                                        
                                        <!--<td>Nro Estampilla: </td>-->
                                        @if($item->calificacion==0)
                                            <td><b>Resultado:</b> </td>
                                        @elseif($item->calificacion==1)
                                            <td><b>Resultado:</b> Aprobado</td>
                                        @elseif($item->calificacion==2)
                                            <td><b>Resultado:</b> Rechazado</td>
                                        @elseif($item->calificacion==3)
                                            <td><b>Resultado:</b> Vigente</td>
                                        @endif 
                                        
                                        <td>
                                            
                                        </td>
                                    </tr>

                                @endif
                            </tbody>
                        </table>
                        <b>Mot. Rechazo:</b>
                            @foreach($item->rechazo as $rechazo)
                                {{$rechazo->motivo}}-
                            @endforeach
                        @break
                    @endif
                @else
                    @if($key>0)
                        <hr style="border-top: 3px dotted">
                    @endif
                    @if($key>$salto)
                        <div style="page-break-after: always; display: block; "></div>
                        <div style="display:none;">{{$salto+=3}}</div>
                    @endif
                    <table class="table table-borderless">
                        <thead >
                            <tr class="text-center">
                                <th scope="col"> <h5>CERTIFICADO DE PH</h5></th>
                                <th></th>
                                <th scope="col"> <img src="logo/sigex_pdf.png" style="width: 150px;"></th>
                            </tr>
                            
                        </thead> 
                        <tbody class="datos">
                            <tr>
                                <td colspan="3"><br></td>
                            </tr>
                            <tr>
                                <td><b>Nro de Orden:</b>{{$datos[0]->orden}}</td>
                                <td></td>
                                <td><b>Fecha Servicio:</b> {{date('d/m/Y')}}</td>
                            </tr>
                            <tr>
                                <td><b>Cliente:</b> {{Auth::user()->name}}</td>
                            </tr>
                            <tr>
                                <td><b>Sucursal:</b> {{$datos[0]->sucursal->nombre}}</td>
                                <td></td>
                                <td><b>Dirección:</b> {{$datos[0]->sucursal->domicilio}}</td>
                            </tr>
                        
                        </tbody>
                    </table>
                    <table class="table-borderless table text-left">
                        <thead >
                            <tr class="text-center">
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="cuerpo">
                            @if ($item->realizoPH==1)    
                                <tr><td colspan="3"><hr></td></tr>
                                <tr>
                                    <td><b>Nro. Equipo:</b> {{$item->elemento->nro_equipo_evolution}}</td>
                                    <td><b>Codigo Interno:</b> -</td>
                                
                                    <td><b>Tipo Equipo:</b>{{$item->elemento->tipo}}</td>
                                </tr>
                                <tr>
                                    
                                    <td><b>Marca:</b> {{$item->elemento->marca}}</td>
                                
                                    <td><b>Capacidad:</b> {{$item->elemento->capacidad.' '.$item->elemento->unidad}}</td>
                                    
                                    <td><b>Vto. Carga:</b> {{date_format(date_create($item->elemento->vencimiento_carga),"m/Y")}}</td>
                                </tr>
                                <tr>
                                    <td><b>Vto. PH:</b> {{date_format(date_create($item->elemento->vencimiento_ph),"m/Y")}}</td>
                                    
                                    <!--<td>Nro Estampilla: </td>-->
                                    @if($item->calificacion==0)
                                        <td><b>Resultado:</b> </td>
                                    @elseif($item->calificacion==1)
                                        <td><b>Resultado:</b> Aprobado</td>
                                    @elseif($item->calificacion==2)
                                        <td><b>Resultado:</b> Rechazado</td>
                                    @elseif($item->calificacion==3)
                                        <td><b>Resultado:</b> Vigente</td>
                                    @endif 
                                    
                                    <td>
                                        
                                    </td>
                                </tr>

                            @endif
                        </tbody>
                    </table>
                    <b>Mot. Rechazo:</b>
                        @foreach($item->rechazo as $rechazo)
                            {{$rechazo->motivo}}-
                        @endforeach
                @endif
            @else
                    @if($key>0)
                        <hr style="border-top: 3px dotted">
                    @endif
                    @if($key>$salto)
                        <div style="page-break-after: always; display: block; "></div>
                        <div style="display:none;">{{$salto+=3}}</div>
                    @endif
                    <table class="table table-borderless">
                        <thead >
                            <tr class="text-center">
                                <th scope="col"> <h5>CERTIFICADO DE PH</h5></th>
                                <th></th>
                                <th scope="col"> <img src="logo/sigex_pdf.png" style="width: 150px;"></th>
                            </tr>
                            
                        </thead> 
                        <tbody class="datos">
                            <tr>
                                <td colspan="3"><br></td>
                            </tr>
                            <tr>
                                <td><b>Nro de Orden:</b>{{$datos[0]->orden}}</td>
                                <td></td>
                                <td><b>Fecha Servicio:</b> {{date('d/m/Y')}}</td>
                            </tr>
                            <tr>
                                <td><b>Cliente:</b> {{Auth::user()->name}}</td>
                            </tr>
                            <tr>
                                <td><b>Sucursal:</b> {{$datos[0]->sucursal->nombre}}</td>
                                <td></td>
                                <td><b>Dirección:</b> {{$datos[0]->sucursal->domicilio}}</td>
                            </tr>
                        
                        </tbody>
                    </table>
                    <table class="table-borderless table text-left">
                        <thead >
                            <tr class="text-center">
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="cuerpo">
                            
                            <tr>
                                <td><b>No Contiene datos</b></td>
                            </tr>
                            
                        </tbody>
                    </table>
                    
               
            @endif
        @endforeach
    </div>

</body>
<style>
    .table>tbody>tr>td{
        height: 0px;
        padding: 0px;
    }
    .datos{
        font-size: 14px;
    }
   
    .cabeza>th{
        background-color:  #585a5c;
    }
    .cabeza{
        font-size: 14px;
        background-color: #828a90;
        color:white;
    }
    .cuerpo{
        font-size: 12px;
        border: 1px solid #9C9C9C;
    }
    .table.cuerpo tr td{
        padding-right: 10%;
        padding-top: 5%;
        
    }
    .footer{
        font-size: 10px;
    }
</style>
</html>