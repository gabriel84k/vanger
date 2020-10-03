@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">
        <comp-menu :mostrarmenu="{{Auth::user()->permisos}} "></comp-menu>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h3>
                                <i class="fa-sigex-title fa-building-o"></i>
                                <span class="badge badge-secondary">Sucursales</span>
                            </h3>
                        </div>
                        
                        <div class="col text-right">
                            
                            <a href="../Export/Sucursal" class='btn btn-success' title="Descargar listado de todas las Sucursales">
                                <i class="fa fa-file-excel-o fa fa-download" aria-hidden="true"></i>
                                &nbsp;&nbsp;
                                <span class="glyphicon glyphicon-save">Listado de Sucursales</span>
                            </a>
                            
                        </div>
                    </div>
                </div>
                
                <comp-Sucursales :param="{{ Auth::user()->permisos }}"></comp-Sucursales>
            </div>
            
            
        </div>
        
    </div>
    <comp-footer :visible="true"></comp-footer>
</div>
@endsection