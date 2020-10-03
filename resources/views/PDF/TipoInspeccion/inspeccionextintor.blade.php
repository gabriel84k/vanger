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
                        <th scope="col"><h4>INSPECCION EXTINTOR</h4></th>
                        <th></th>
                        <th scope="col"> <img src="logo/sigex_pdf.png" style="width: 150px;"></th>
                       
                    </tr>
                    
                </thead> 
                <tbody class="datos">
                    <tr>
                        <td colspan="3"><hr></td>
                    </tr>
                    <tr>
                        <td><b>Fecha: </b> {{date('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Cliente: </b> {{Auth::user()->name}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Sucursal: </b> falta</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Dirección: </b> falta</td>
                    </tr>
                    <tr>
                        <td style="width:290px"><b>Nro Control: </b> {{$control}}</td>
                            
                        <td style="width:200px"><b>Fecha de Control: </b> {{date_format(date_create($datos[0]->fechahora),"d/m/Y")}}</td>
                            
                        <td><b>Cant. Inspecciones: </b> {{count($datos)}}</td>
                        </td>
 
                        
                    </tr>
                    <tr><td></td></tr>
                    <tr>
                        <!--<td><b>Sector: <b>{{$datos[0]->sector}}</td>-->
                    </tr>
                </tbody>
                   
            </table>
            <table class="text-center">
                <thead class="cabeza">
                    <tr class="text-center wid" >
                        <!-- Detalle del puesto-->
                        <th>Sector</th>
                        <th>Puesto</th>
                        <th>Codigo</th>
                        

                        <!-- Detalle de la inspeccion-->
                        <th>Carga Vencida</th>
                        
                        <th>Elemento Ausente</th>
                        
                        <th>Elemento Obstruido</th>
                        
                        <th>Carro Defectuoso</th>
                        
                        <th>Equipo Usado</th>
                        
                        <th>Equipo Despintado</th>
                
                        <th>Equipo Despresurizado</th>
            
                        <th>Altura Incorrecta</th>
            
                        <th>Falta Senialización en Altura</th>
        
                        <th>Falta Senialización en Chapa</th>
    
                        <th>Falta Tarjeta</th>

                        <th>Falta Precinto</th>

                        <th>Soporte Defectuoso</th>

                        <th>Medio de Ruptura Ausente</th>

                        <th>Manguera Rota</th>
                        
                        <th>Otro Problema</th>
                    </tr>
                </thead> 
                <tbody class="cuerpo">
              
                    @foreach($datos as $item)
                        
                            @if($item->incidencias)
                                <div style="display:none">{{$trestado='trestado'}}</div>
                            @else
                                <div style="display:none">{{$trestado=''}}</div>
                            @endif
                            
                            <tr class={{$trestado}} style="text-align: center;">
                                
                                <td style="width: 1px" >{{$item->puesto->sector->nombre}}</td>
                                <td style="width: 1px" style="text-align: left;">[{{$item->puesto->nroPuesto}}] - {{$item->puesto->ubicacion}}</td>
                                <td style="width: 1px">{{$item->puesto->extintor->elemento_id}}</td>
                                
                               
                                @if ($item->DetalleInspeccion->cargaVencida!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                                @if ($item->DetalleInspeccion->elementoAusente!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                                @if ($item->DetalleInspeccion->elementoObstruido!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                               

                                @if ($item->DetalleInspeccion->carroDefectuoso!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                                
                                @if ($item->DetalleInspeccion->equipoUsado!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif

                                @if ($item->DetalleInspeccion->equipoDespintado!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                                
                                @if ($item->DetalleInspeccion->equipoDespresurizado!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                                
                                @if ($item->DetalleInspeccion->alturaIncorreta!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                            
                                @if ($item->DetalleInspeccion->faltaSenializacionEnAltura!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                                
                                @if ($item->DetalleInspeccion->faltaSenializacionEnChapa!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                        
                                @if ($item->DetalleInspeccion->faltaTarjeta!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                            
                                @if ($item->DetalleInspeccion->faltaPrecinto!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif

                                @if ($item->DetalleInspeccion->soporteDefectuoso!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                                @if ($item->DetalleInspeccion->medioDeRupturaAusente!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                                @if ($item->DetalleInspeccion->mangueraRota!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                                @if ($item->DetalleInspeccion->otroProblema!=0)
                                    <td style="width: 1px">Sí</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                              
                                
                            </tr>
                       
                    @endforeach
                </tbody>
            </table>
           
        </div>
        <footer class="footer" style="padding-top: 5%">
            
        </footer>
    
    </body>
    <style>
        .table>tbody>tr>td{
            height: 0px;
            padding: 0px;
        }
        .datos{
            font-size: 12px;
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
        .cuerpo>tr>td{
            vertical-align:middle;
            padding: 0rem !important;

        }
        .footer{
            font-size: 12px;
        }
        .trestado{
            background-color: #F79D9D;
        }
        .wid{
           height: 50px;
        }
        .wid>th{
            width: 1px !important;
            font-size: 10px;
            vertical-align: center;
        }
       
    </style>
</html>