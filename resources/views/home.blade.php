@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <comp-menu :mostrarmenu="{{ Auth::user()->permisos }}"></comp-menu>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h3><i class="fa-sigex-title fa-building-o"></i><span class="badge badge-secondary">Sucursales</span></h3>
                </div>
                
                <div class="card-body">
                    @if (session('status'))
                       
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                   
                </div>
              
            </div>
            <comp-Sucursales></comp-Sucursales>
        </div>
    </div>
    
</div>
@endsection
