@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">
        <comp-menu :mostrarmenu="{{ Auth::user()->permisos }}"></comp-menu>
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                        <h3><i class="fa-sigex-title fa-free-code-camp" aria-hidden="true"></i><span class="badge badge-secondary">Inspecciones</span></h3>
                </div>
                
                <div class="card-body">
                    @if (session('status'))
                       
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <comp-controlesperiodicos ></comp-controlesperiodicos>
                </div>
            </div>
        </div>
        <comp-footer :visible="true"></comp-footer>
    </div>
    
</div>
@endsection