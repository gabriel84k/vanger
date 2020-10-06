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
                            <h5 style="font-size: 14px;">REPORTE DE EXTINTORES/SSF</h5>
                        </th>
                        <th scope="col"> 
                            <h5 style="font-size: 10px;" class="info">
                                +342 453654  - +342 2981520
                                ventas@sigex.com.ar
                                Parque Tecnológico Litoral Centro – Ruta Nacional 168 – Paraje «El Pozo»
                                www.Sigex.com.ar
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
                       						
                        <th >Nro Equipo</th>
                        <th >Ubicación</th>
                        <th >Agente</th>
                        <th >Marca</th>
                        <th >Capacidad</th>
                        <th >FF</th>
                        <th >VTO. Carga</th>
                        
                        
                    </tr>
                </thead> 
                <tbody class="cuerpo">
                   
                    @foreach($datos as $item)
                    {{  $mes=date_format(date_create(),"m")}}
                    {{  $año=date_format(date_create(),"Y")}}

                    {{  $VCaño=date_format(date_create($item->vencimiento_carga),"Y")}}
                    {{  $VCmes=date_format(date_create($item->vencimiento_carga),"m")}}
                    
                    
                        @if (($año >= $VCaño && $VCmes < $mes) || ($VCaño < $año))
                            <tr style="background-color: rgb(218, 160, 160);">
                                <td>{{$item->nro_equipo_evolution}}</td>
                                <td>{{$item->ubicacion}}</td>
                                <td>{{$item->tipo}}</td>
                                <td>{{$item->marca}}</td>
                                <td>{{$item->capacidad.' '.$item->unidad}}</td>
                                <td>{{$VCmes.'/'.$VCaño}}</td>
                            
                            </tr> 
                        @else
                            <tr>
                                <td>{{$item->nro_equipo_evolution}}</td>
                                <td>{{$item->ubicacion}}</td>
                                <td>{{$item->tipo}}</td>
                                <td>{{$item->marca}}</td>
                                <td>{{$item->capacidad.' '.$item->unidad}}</td>
                                <td>{{$VCmes.'/'.$VCaño}}</td>

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
                                <td colspan="2" style="width: 35em;">
                                    <div class="col-lg-6">
                                        <div style="height:7em;"></div>
                                        ________________________          
                                        <p>Recibí Conforme</p>
                                    </div>
                                </td>
                                <td colspan="3" style="width: 14em;">
                                    <div class="col-lg-6" >
                                        <br>
                                        
                                        __________________________
                                        <div class="text-left">
                                            <!--<div class="col-lg-2" >
                                                <b>Germán Ricardo Alvarez</b>
                                            </div>
                                            <div class="col-lg-2" >
                                                Ing. Civil Industrial
                                            </div>
                                            <div class="col-lg-2" >
                                                <b>Soc. Acman Ltda.</b>
                                            </div>
                                            <div class="col-lg-2" >
                                                21-13.456.789.4
                                            </div>-->
                                        </div>
                                    </div>
                                </td>
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