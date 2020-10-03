<?php

namespace App\Http\Controllers;

use App\db\Repuesto;
use App\db\Reparacion;

use Illuminate\Http\Request;

class Reparaciones extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($idservicio=0)
    {
        
        $reparaciones=Reparacion::where('idServiciosigex',$idservicio)->paginate(15);
        foreach ($reparaciones as $key => $value) {
            $value->servicio;
            $value->repuesto;
        }
        
        /*
        $reparaciones=(new Reparacion)::select('nombre','abreviatura','idRepuesto','resultado','repuestos.id')
                                        ->join('repuestos','repuestos.id','repuestos_id')
                                        ->join('servicios','servicios.id','servicios_id')
                                        ->where('idServiciosigex',$idservicio)
                                        ->paginate(15);
                                        */
        return $reparaciones;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
