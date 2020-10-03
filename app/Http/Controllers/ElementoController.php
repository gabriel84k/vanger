<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ElementoController extends Controller
{
    private $tipo;
    public function __construct(){ 
        $this->middleware('auth'); 
        
    }
    public function viewElement(){
        
        if (strrpos(\Request::route()->uri(), 'Equipos')>-1){
            $this->tipo=0; # Equipos
        }else if(strrpos(\Request::route()->uri(), 'Bombas')>-1){
            $this->tipo=1; # Bombas
        }else if(strrpos(\Request::route()->uri(), 'Mangueras')>-1){
            $this->tipo=2; # Mangueras
        }
        
        return view('Elementos.view',['idelemento'=>0,'dist'=>2,'tipo'=>$this->tipo]);
    }
    /**
     * Show the form for creating a new resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function viewDetalle($id,$tipo){
        return view('Elementos.view',['idelemento'=>$id,'dist'=>2,'tipo'=>$tipo]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        
        switch (request()->tipo) {
            case 0:
                $elemento=EquiposController::index();
                return $elemento;
                break;
            case 1:
                $elemento=BombaController::index();
                return $elemento;
                break;
            case 2:
                $elemento=MangueraController::index();
                return $elemento;
                break;

            default:
                # code...
                break;
        }
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
    public function show_pdf($tipo)
    {
        try {
           
            switch ($tipo) {
                case 0:
                    $elemento=EquiposController::search();
                  
                    return $elemento;
                    break;
                case 1:
                    $elemento=BombaController::search();
                    return $elemento;
                    break;
                case 2:
                    $elemento=MangueraController::search();
                    return $elemento;
                    break;
    
                default:
                    # code...
                    break;
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
             
        switch (request()->tipo) {
            case 0:
                $elemento=EquiposController::show($id);
                break;
            case 1:
                $elemento=BombaController::show($id);
                break;
            case 2:
                $elemento=MangueraController::show($id);
                break;
            default:
                $elemento=[];
                break;
        }
        return $elemento;
    }

    static public function Search($tipo)
    {
       
        switch ($tipo) {
            case 0:
                return EquiposController::search();
                break;
            case 1:
                return BombaController::search();
                break;
            case 2:
                return MangueraController::search();
                break;
            default:
                $elemento=[];
                break;
        }
        //return $elemento;
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
