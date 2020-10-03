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
                        <th scope="col"> <img src="logo/sigex_pdf.png" style="    width: 150px;"></th>
                        <th><h5>Constancia de Inutilización de Extintores</h5></th>
                        <th scope="col"> <img src="logo/sigex_pdf.png" style="    width: 150px;"></th>
                    
                    </tr>
                    
                </thead> 
                <tbody class="datos">
                    <tr>
                        <td colspan="3"><hr></td>
                    </tr>
                    <tr>
                        <td><b>Fecha:</b> {{date('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td><b>Cliente:</b> {{Auth::user()->name}}</td>
                    </tr>
                    <tr>
                        <td><b>Sucursal:</b> {{$datos[0]->sucursal->nombre}}</td>
                        <td></td>
                        
                    </tr>
                    <tr>
                        <td colspan="3"><b>Dirección:</b> {{$datos[0]->sucursal->domicilio}}</td>
                    </tr>
                    
                </tbody>
                
            </table>
            <table class="table text-center">
                <thead class="cabeza">
                    <tr class="text-center">
                                    
                        <th >N° de Fabricación</th>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Cap.</th>
                        <th>Motivo/s del NO Cumplimiento</th>
                    </tr>
                </thead> 
                <tbody class="cuerpo">
                
                    @foreach($datos as $item)
                        @if(count($item->rechazo)>0)
                            <tr>
                                <td>0000000</td>
                                <td>{{$item->elemento->tipo}}</td>
                                <td>{{$item->elemento->marca}}</td>
                                <td>{{$item->elemento->capacidad.' '.$item->elemento->unidad}}</td>
                                <td>
                                    @foreach($item->rechazo as $item_rechazo)
                                            {{$item_rechazo->motivo}}-
                                    @endforeach
                                </td>
                            </tr>
                        @endif
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