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
                        <th scope="col"> 
                            <img src="logo/sigex_pdf.png" style="width: 100px;">
                        </th>
                        <th  scope="col">
                            <h5 style="font-size: 14px;">REPORTE DE EXTINTORES</h5>
                        </th>
                        <th scope="col"> 
                            <h5 style="font-size: 10px;" class="info">
                                Office: +54 297- 4480206
                                vangersrl@gmail.com
                                Vanger S.R.L. - Los Molles 603 - Jose Perez 3575 - Comodoro Rivadavia  (Chubut)
                                www.Vangersrl.com
                            </h5>
                                
                        </th>
                    </tr>
                    
                </thead> 
                <tbody class="datos">
                    <tr>
                        <td colspan="3"><hr></td>
                    </tr>
                    <tr colspan="3">
                        <td><b>Fecha del Reporte:</b> {{date('d/m/Y')}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Cliente:</b> {{Auth::user()->name}}</td>
                    </tr>
                    <tr>
                        <td colspan="3"><b>Sucursal:</b> {{($datos[0])?$datos[0]->sucursal:''}}</td>
                    </tr>
                    
                    <tr>
                        <td colspan="3"><b> Cantidad de Extintores Reportados:</b> {{count($datos)}}</td>
                    </tr>
                </tbody>
                   
            </table>
            
            <table class="table text-center">
                <thead class="cabeza">
                    <tr class="text-center">
                        <th >Nº Cert.</th>
                        <th >N° EXT./SSF</th>
                        <th >Agente</th>
                        <th >Marca</th>
                        <th >Cap.</th>
                        <th >VTO. MANT</th>
                        <th >VTO. PH</th>
                        
                    </tr>
                </thead> 
                <tbody class="cuerpo">
                   
                    @foreach($datos as $item)
                    {{  $mes=date_format(date_create(),"m")}}
                    {{  $año=date_format(date_create(),"Y")}}

                    {{  $VCaño=date_format(date_create($item->vencimiento_carga),"Y")}}
                    {{  $VCmes=date_format(date_create($item->vencimiento_carga),"m")}}
                    {{  $PHaño=date_format(date_create($item->vencimiento_ph),"Y")}}
                    {{  $PHmes=date_format(date_create($item->vencimiento_ph),"m")}}
                    
                        @if (($año >= $VCaño && $VCmes < $mes) || ($VCaño < $año) || ($año >= $PHaño && $PHmes < $mes) || ($PHaño < $año))
                            <tr style="background-color: rgb(218, 160, 160);">
                                <td>{{$item->nro_equipo_evolution}}</td>
                                <td>{{$item->codigo_interno_cliente}}</td>
                                <td>{{$item->tipo}}</td>
                                <td>{{$item->marca}}</td>
                                <td>{{$item->capacidad.' '.$item->unidad}}</td>
                                <td>{{$VCmes.'/'.$VCaño}}</td>
                                <td>{{$PHmes.'/'.$PHaño}}</td>
                            
                            </tr> 
                        @else
                            <tr>
                                <td>{{$item->nro_equipo_evolution}}</td>
                                <td>{{$item->codigo_interno_cliente}}</td>
                                <td>{{$item->tipo}}</td>
                                <td>{{$item->marca}}</td>
                                <td>{{$item->capacidad.' '.$item->unidad}}</td>
                                <td>{{$VCmes.'/'.$VCaño}}</td>
                                <td>{{$PHmes.'/'.$PHaño}}</td>

                            </tr> 
                        @endif
                    @endforeach
                </tbody>
            </table>
            <div>
                <SUB><cite>Filtros Aplicados [</cite></SUB>
                @foreach($filtros as $key=>$item)
                    @if ($key != 'pdf' && $key != 'sucursal'  )
                        @switch($key)
                            @case('sucursalnombre')
                                
                                <SUB><cite>Sucursal : {{$item}} ; </cite></SUB>
                                @break
                            @case('estado')
                                @if ($item== 0)
                                    <SUB><cite>{{$key}} : Activo ; </cite></SUB>
                                @else
                                    <SUB><cite>{{$key}} : Baja ; </cite></SUB>
                                @endif
                                
                                @break
                            @case('Fdesde')
                                <SUB><cite>{{$key}} : {{date_format(date_create($item),"m/Y")}} ; </cite></SUB>
                                @break
                            @case('Fhasta')
                            <SUB><cite>{{$key}} : {{date_format(date_create($item),"m/Y")}} ; </cite></SUB>
                                @break
                            @default
                                <SUB><cite>{{$key}} : {{$item}} ; </cite></SUB>        
                        @endswitch
                        
                    @endif
                @endforeach
                <SUB><cite>]</cite></SUB>
            </div>
                
        </div>
        <footer class="footer" style="padding-top: 5%">    
            <div style="font-size: 8px;">
               
            </div>
                <br><br><br>
                <div class="row">
                    <table>
                        <tbody>
                            <tr class="text-center">
                               
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
            font-size: 11px;
        }
        .info{
            font-style:italic;
            font-weight:bold;
            font-size:2em;
            font-color:#2c2c2c;
            font-family:'Helvetica','Verdana','Monaco',sans-serif;
        }
        .cabeza{
            font-size: 11px;
            background-color: #828a90;
            color:white;
        }
        .filaerror{
            background-color: rgb(218, 160, 160);
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