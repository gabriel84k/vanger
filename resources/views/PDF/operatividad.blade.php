<!--
    Para Visualizar todo el array de datos, se coloca al inicio o en
        alguna parte del documento esta variable {{$datos[0]}}, esto 
        te permite ver donde se encuentran las propiedades del objeto.
    El Funcion que genera estas variables se encuentra en el archivo
        PdfController ->  certificadoPH
-->
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
                        <th scope="col"> <img src="logo/sigex_pdf.png" style="    width: 100px;"></th>
                        <th><h5>Certificado de Operatividad y Garantía</h5></th>
                        <th scope="col"> <img src="logo/sigex_pdf.png" style="    width: 100px;"></th>
                    
                    </tr>
                    
                </thead> 
                <tbody class="datos">
                    <tr>
                        <td colspan="3"><hr></td>
                    </tr>
                    <tr>
                        <td><b>Código y Nombre del Cliente:</b> {{Auth::user()->name}}</td>
                        <td></td>
                        <td><b>Fecha:</b> {{date('d/m/Y')}}</td>
                    </tr>
                
                    <tr>
                        <td><b>Sucursal:</b> {{$datos[0]->sucursal->nombre}}</td>
                        <td></td>
                        
                    </tr>
                    <tr>
                        <td colspan="3"><b>Dirección:</b> {{$datos[0]->sucursal->domicilio}}</td>
                    </tr>
                    <tr>
                        <td><b>Orden de Trabajo:</b>{{$datos[0]->planilla->orden_trabajo}}</td>
                    </tr>
                </tbody>
                
            </table>
            <table class="table text-center">
                <thead class="cabeza">
                    <tr class="text-center">
                                    
                        <th >N° Equipo</th>
                        <th>Tipo</th>
                        <th>Cap.</th>
                        <th>Marca</th>
                        <th>Año Fab.</th>
                        <th>F.U. PH</th>
                        <th>Vto. Carga</th>
                        <th>Vto. PH</th>
                        <th>Res. PH</th>
                        
                        <!--<th>N° Estampilla</th>-->
                        <th>Sector</th>
                    </tr>
                </thead> 
                <tbody class="cuerpo">
                
                    @foreach($datos as $item)
                        
                        <tr>
                            <td>{{$item->elemento->nro_equipo_evolution}}</td>
                            <td>{{$item->elemento->tipo}}</td>
                            <td>{{$item->elemento->capacidad.' '.$item->elemento->unidad}}</td>
                            <td>{{$item->elemento->marca}}</td>
                            <td>{{$item->elemento->fecha_fabricacion}}</td>
                            <td>{{date_format(date_create($item->elemento->fecha_ultimo_ph),"m/y")}}</td>
                            <td>{{date_format(date_create($item->elemento->vencimiento_carga),"m/y")}}</td>
                            <td>{{date_format(date_create($item->elemento->vencimiento_ph),"m/y")}}</td>
                            
                            @if($item->calificacion==0)
                                <td></td>
                            @elseif($item->calificacion==1)
                                <td>Aprobado</td>
                            @elseif($item->calificacion==2)
                                <td>Rechazado</td>
                            @elseif($item->calificacion==3)
                                <td>Vigente</td>
                            @endif
                            
                            <!--<td>NUMERO DE ESTAMPILLA</td>-->
                            <td>{{$item->sector}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        
        </div>

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
        .cabeza>th{
            background-color:  #585a5c;
        }
        
        .footer{
            font-size: 10px;
        }
    </style>
</html>