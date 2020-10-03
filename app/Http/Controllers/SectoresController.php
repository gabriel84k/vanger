<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use App\db\Sucursales;
use App\db\Sectores;
use App\db\Puestos;
use App\db\Equipos;
use Illuminate\Http\Request;

class SectoresController extends Controller
{

     /**
     * Middleware para que solo se pueda utilizar la aplicación con un usuario logueado
     * De caso contrario, Laravel redireccionara a la pantalla de inicio
     */
    public function __construct(){ 
        $this->middleware('auth'); 
       
    }

    public function viewDetalle($id){
        //$idsector=$request->input('idsector');
        
        return view('Sectores.view',['idsector'=>$id,'dist'=>2]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=Auth::user();
        $sucursal=Auth::user()->sucursales()->get();
        //foreach varias sucursales
        $Sectores=(new Sectores)::where('sucursales_id',$sucursal[0]->id)->get();
        
        return $Sectores;
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
        $sectores=(new Sectores)::where('id',$id)->get();
        $puestos=(new Puestos)::where('Sectores_id',$sectores[0]->id)->get();
        
        foreach ($puestos as $key => $value) {
            $equipos=(new Equipos)::select('nro_equipo_evolution','tipo')->where('id',$value->equipos_id)->get();
            
            $value['Equipos']=$equipos;
            
            
        }
        $arr_completo=array('Sectores'=>$sectores,'Puestos'=>$puestos,'Cant_puestos'=>count($puestos));
        return $arr_completo ;
      
       
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
