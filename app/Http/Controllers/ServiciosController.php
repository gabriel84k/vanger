<?php

namespace App\Http\Controllers;

use App\db\Servicio;
use App\db\Planilla;
use App\db\Reparacion;
use App\db\Rechazo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ServiciosController extends Controller
{

    public function __construct(){ 
        $this->middleware('auth'); 
       
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
    public function show_pdf($id)
    {
        try {
            
            $servicios=Servicio::where('planilla_id',$id)->paginate(10000);
            foreach ($servicios as $key => $valServ) {
                //$valServ->planilla;
                $valServ->sucursal=$valServ->planilla->sucursal;
                $rowtype=$valServ->elemento->row_type;
                $valServ->elemento=$valServ->elemento->$rowtype;
                $valServ->CantRepuesto=$valServ->reparacion;
                $valServ->rechazo;
                $Rep=(new Reparacion)::where('idServiciosigex',$valServ->idsigexservicio)->count();
                $valServ->CantRepuesto=$Rep;
            }
            return $servicios;
        } catch (\Throwable $th) {
            dd($th->getMessage());  
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function show($id)
    {
        try {
            
            $servicios=Servicio::with(['planilla','elemento'])->where('planilla_id',$id)->paginate(15);
           
            foreach ($servicios as $key => $valSer) {
                $valSer->columnas=$valSer->columns;
                $valSer->planilla->sucursal;

                $rowtype= $valSer->elemento->row_type;
                $valSer->elemento->$rowtype;
                $valSer->elemento->columnas=$valSer->elemento->$rowtype->column;
                $valSer->rechazo;
                
                $Rep=Reparacion::where('idServiciosigex',$valSer->idsigexservicio)->count();
                $valSer->CantRepuesto=$Rep;

            }
            return $servicios;
        } catch (\Throwable $th) {
            dd($th->getMessage()); 
        }
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
