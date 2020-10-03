@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row justify-content-center">
      <comp-menu :mostrarmenu="{{ Auth::user()->permisos }}"></comp-menu>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                        
                        @if ($tipo==0)
                            <h3><i class="fa-sigex-title fa-fire-extinguisher" aria-hidden="true"></i><span class="badge badge-secondary">Extintores</span></h3>
                        @elseif ($tipo==2)
                            <h3><i class="fa-sigex-title fa-tint" aria-hidden="true"></i><span class="badge badge-secondary">Mangueras</span></h3>
                        @elseif ($tipo==1)
                            <h3><i class="fa-sigex-title fa-tint" aria-hidden="true"></i><span class="badge badge-secondary">Bombas</span></h3>
                        @endif
                        
                </div>
                
                <div class="card-body">
                    @if (session('status'))
                       
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <comp-elemento :idelemento={{$idelemento}} :param="{{ Auth::user()->permisos }}" :elemn="{{$tipo}}"></comp-elemento>
                </div>
            </div>
        </div>
        <comp-footer :visible="true"></comp-footer>
    </div>
    
</div>
@endsection