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
                        <th scope="col"><h4>INSPECCIONES</h4></th>
                        <th></th>
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
                        <td colspan="3"><b>Cliente: </b> {{Auth::user()->name}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Sucursal: </b> FALTA</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Dirección: </b> FALTA</td>
                    </tr>
                    <tr>
                        <td style="width:290px"><b>Nro Control: </b> {{$control}}</td>
                            
                        <td style="width:200px"><b>Fecha de Control: </b> {{date_format(date_create($datos[0]->fechahora),"d/m/Y")}}</td>
                            
                        <td><b>Cant. Inspecciones: </b> {{count($datos)}}</td>
                        </td>
                    
                        
                    </tr>
                    <tr><td></td></tr>
                
                    <tr>
                    
                    <td>  <br><b>Sector:</b> {{$datos[0]->puesto->sector->nombre}}</td>
                    </tr>
                </tbody>
                
            </table>
            <table class="table text-center">
                <thead class="cabeza">
                    <tr class="text-center">
                    
                        <th >Puesto</th>
                        <th>Tipo</th>
                    
                        <th>Elemento</th>
                        <th>Detalle de la Insp.</th>
                    
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
                            <td style="text-align: left;">({{$item->puesto->idPuesto}}) - {{$item->puesto->ubicacion}}</td>
                            <td>{{
                                    strtoupper(str_replace(["segusur",'egusur'], [""," de derrame"], $item->puesto->row_type))
                                }}
                            </td>
                            
                            @if ($item->elemento)
                                @if ($item->elemento->row_Type="extintor")
                                    <td>[{{$item->elemento->nro_equipo_evolution}}]-[{{$item->elemento->tipo}}]-[{{$item->elemento->capacidad}} {{$item->elemento->unidad}}]</td>
                                @else
                                <td>[{{$item->elemento->numeroManguera}}]-[{{$item->elemento->longitudReal}}]-[{{$item->elemento->diametromili}} {{$item->elemento->unidad}}]</td>
                                @endif
                            @else
                                <td>[{{$item->puesto->tipopuesto->codigoElemento}}]</td>
                            @endif
                            
                            <td>{{$item->incidencias }}</td>
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
        .cuerpo tr td{
            vertical-align:middle;
        }
        .footer{
            font-size: 12px;
        }
        .trestado{
            background-color: #e9adad62;
        }
    </style>
</html>