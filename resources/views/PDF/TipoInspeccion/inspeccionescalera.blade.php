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
                        <th colspan="2" scope="col" style=" width: 150px;"><h4>INSPECCION ESCALERA</h4></th>
                        
                        <th scope="col"> <img src="logo/sigex_pdf.png" style="    width: 150px;"></th>
                       
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
                        <td ><b>Cliente: </b> {{Auth::user()->name}}</td>
                   
                        <td style="width:290px"><b>Sucursal: </b> falta</td>
                   
                        <td ><b>Dirección: </b> falta</td>
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
                    <tr class="wid">
                        <!-- Detalle del puesto-->
                        <th>Sector</th>
                        <th>Puesto</th>
                        <th>Codigo</th>
                        <th>Modelo</th>

                        <!-- Detalle de la inspeccion-->
                        <th>Estado Escalera</th>
                        <th>Código Elemento Encontrado</th>
                        
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
                                <td style="width: 1px">{{$item->puesto->esacalerasegusur->codigoElemento}}</td>
                                <td style="width: 1px">{{$item->puesto->esacalerasegusur->modelo }}</td>
                               
                                @if ($item->DetalleInspeccion->elementoAusente!=0)
                                    <td style="width: 1px">Si</td>
                                @else
                                    <td style="width: 1px">No</td>
                                @endif
                              
                                @if ($item->DetalleInspeccion->estado_escalera==0)
                                    <td style="width: 1px">Mal</td>
                                @elseif($item->DetalleInspeccion->estado_escalera==1)
                                    <td style="width: 1px">Bien</td>
                                @elseif($item->DetalleInspeccion->estado_escalera==2)
                                    <td style="width: 1px">No Aplica</td>
                                @elseif($item->DetalleInspeccion->estado_escalera==3)
                                    <td style="width: 1px">No Encontrada</td>
                                @endif
                                
                                <td style="width: 1px">{{$item->DetalleInspeccion->codigoElementoEncontrado}}</td>
                                
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
           height: 12px;
        }
        .wid>th{
            width: 1px !important;
            vertical-align: center;
            font-size: 15px;
           
        }
        .wid>th>p{
           
            /*writing-mode: vertical-rl;*/
            /*transform: rotate(-90deg);*/
        }
    </style>
</html>