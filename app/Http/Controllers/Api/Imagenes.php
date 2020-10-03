<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\logControllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Image;

class Imagenes extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'Funcionando...';
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
        try {
            $file = $request->file('imagen');

            //obtenemos el nombre del archivo
            $nombre = $file->getClientOriginalName();
          
            //indicamos que queremos guardar un nuevo archivo en el disco local
            //\Storage::disk('public')->put($nombre,  \File::get($file)); #- Este es para hosting dedicado un VPS
            \Storage::disk('compartido')->put($nombre,  \File::get($file));   #- Este se usa para un hosting compartido
            
            return \Response::json(['status'=>0,'descripcion'=> 'Imagenen publicada con éxito','data'=>'']);
         } catch (\Exception $th) {
            //$log=(new logControllers)->error($th, 'Imagenes','store');
            return \Response::json(['status'=>-1,'descripcion'=>'Imagenen NO publicada '.$th->getMessage() ,'data'=>'']);
            
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
