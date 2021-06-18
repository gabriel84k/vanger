<?php

namespace App\Http\Controllers;

use App\db\Servicio;
use App\db\Planilla;
use App\db\Reparacion;
use App\db\Equipo;
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
    public function show_pdf($id, $est='', $hidden='')
    {
        try {
           
            $count=Servicio::where('planilla_id',$id)->count();    
           
            
            $totalrechazo = 0;
            $realizoPH = 0;
            $servicios=Servicio::where('planilla_id',$id)->paginate($count+1);
            foreach ($servicios as $key => $valServ) {
                $valServ->sucursal=$valServ->planilla->sucursal;
                $valServ->fecha_servicio=$valServ->planilla->fecha_servicio;
                $rowtype=$valServ->elemento->row_type;
                $valServ->elemento=$valServ->elemento->$rowtype;
                if ($valServ->elemento->sustituto != 0){
                    $valServ->cantsusti++;
                }
                $valServ->CantRepuesto=$valServ->reparacion;
                $valServ->rechazo;
                $Rep=(new Reparacion)::where('idServiciosigex',$valServ->idsigexservicio)->count();
                $valServ->CantRepuesto=$Rep;
                
                if(count($valServ->rechazo) > 0){
                    $totalrechazo ++;
                };
                
                if ($valServ->realizoPH){
                    $realizoPH ++;
                }
                
            }
            $servicios->totalrechazo = $totalrechazo;
            $servicios->realizoPH = $realizoPH;
            switch($est){
                
                case 'json':
                    
                    return $servicios->makeHidden($hidden)->toJson();
                case 'array':
                    return $servicios->makeHidden($hidden)->toArray();
                default:
                    return $servicios;    
            }
            
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
           
            # - Páginas totales en tabla -#
            if (request()->get('total')){
                if (request()->get('total')>14 && request()->get('total')<101){
                    $totalpage=request()->get('total');
                }else{
                    $totalpage=15;
                }
                
            }else{
                $totalpage=15;
            }
            #- Fin Paginas Totales-#
            $servicios=Servicio::with(['planilla','elemento'])
                                ->where('planilla_id',$id)
                                ->where(function($query){
                                    if (request('idequipo')!=0){
                                        $equipo=Equipo::where('id',request('idequipo'))->first();
                                        
                                        $query->where('elemento_id',$equipo->elemento_id);
                                    }
                                })
                                ->paginate($totalpage);
          
            foreach ($servicios as $key => $valSer) {
                $valSer->columnas=$valSer->columns;
                $valSer->planilla->sucursal->sectors;
                
                $rowtype= $valSer->elemento->row_type;
                $valSer->elemento->$rowtype;
                
                $valSer->elemento->columnas=$valSer->elemento->$rowtype->column;
                $inspec=$valSer->elemento->inspecciones->last();
                if ($inspec){
                    $valSer->elemento->puesto=$inspec->puesto->ubicacion;
                }else{
                    $valSer->elemento->puesto=$valSer->elemento->$rowtype->sector;
                }
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
