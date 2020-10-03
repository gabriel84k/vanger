<?php

namespace App\Http\Controllers;

use App\db\Puestos;
use Illuminate\Http\Request;


/**
 * NO SE UTILIZA PORQUE NO HAY ABMS DESDE LA WEB
 */


class PuestosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $puesto=(new Puestos)::find($id);
        return $puesto;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\db\Puestos  $puestos
     * @return \Illuminate\Http\Response
     */
    public function edit(Puestos $puestos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\db\Puestos  $puestos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Puestos $puestos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\db\Puestos  $puestos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Puestos $puestos)
    {
        //
    }
}
