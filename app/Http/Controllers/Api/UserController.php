<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\logControllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\db\Sucursales;
use App\db\usuarios_sucursales;


class UserController extends Controller
{
    public function AuthRouteAPI(Request $request){
        return $request->user();
    }
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
           
           
            $request->validate([
              
                'idUsuarioMisExtintores' => 'required',
                'nombreUsuario' => 'required',
                'textoContrasenia' => 'required',
            ]);

        # -Obtenemos los parametros.-
            $Permiso_Eq=($request->get('permisoNoMostrarEquipos'))?false:true;
            $Permiso_Cont=($request->get('permisoNoMostrarRevision'))?false:true;
            $Permiso_Pla=($request->get('permisoNoMostrarPlanilla'))?false:true;
            $Permiso_rep=($request->get('permisoNoMostrarRepuestos'))?false:true;
            $Permiso_Man=($request->get('permisoNoMostrarMangueras'))?false:true;
            $Permiso_Bom=($request->get('permisoNoMostrarBombas'))?false:true;

            $Permiso_planilla_PDF=($request->get('permisoPDF_Planillas'))?true:false;
            $Permiso_inspecciones_PDF=($request->get('permisoPDF_Inspecciones'))?true:false;
            $Permiso_equipos_PDF=($request->get('permisoPDF_Equipos'))?true:false;

            $permisos=json_encode(['Equipos'=>$Permiso_Eq,
                                        'Controles'=>$Permiso_Cont,
                                        'Planilla'=>$Permiso_Pla,
                                        'Repuesto'=>$Permiso_rep, 
                                        'Mangueras'=>$Permiso_Man, 
                                        'Bombas'=>$Permiso_Bom, 
                                        'pdfPlanilla' => $Permiso_planilla_PDF,
                                        'pdfinspecciones' => $Permiso_inspecciones_PDF,
                                        'pdfequipos' => $Permiso_equipos_PDF
                                    ]);
            //$token=$request->input('token');
            $sucursales=$request->get('sucursales'); #- Array(idsucursal , nombre)
           
            $iduserME=$request->get('idUsuarioMisExtintores');
            
            
          
            $user=$request->get('nombreUsuario');
            $pass=$request->get('textoContrasenia');
            $cliente=$request->get('Cliente');
           
            $codCliente='';
            $nombre='';
            $direccion='';
            
            foreach ($cliente as $key => $value) {
              
                $nombre=$value['nombre'];
                $direccion=$value['calle'];
                $codCliente=$value['cod_cliente'];
            }

           
            $usuario= (new User)::where('user',$user)->first();
            if (is_null($usuario) || $usuario->count()<1){
                if ( $user && $pass){
                    
                # -Creamos el usuario.-
                    \DB::beginTransaction();
                    $usuario= new User;
                
                    $usuario->idusuario=$iduserME;
                    $usuario->direccion=$direccion;
                    $usuario->permisos=$permisos; # habilita o deshabilita el menú [0:todos, 1:revisiones periodicas]
                    $usuario->user=$user;
                    $usuario->name=$nombre;
                    $usuario->verified_at=now();
                    $usuario->password=Hash::make($pass);
                    $usuario->estado=true;
                  
                    $usuario->save();
                    
                    #- Cargamos las reaciones entre Sucursales y Usuarios
                    foreach ($sucursales as $key => $value) {
                        $M_sucursal= (new Sucursales)::where('idSucursal',$value['idSucursal'])->first();
                        
                        if (is_null($M_sucursal) || $M_sucursal->count()<1){
                            $M_sucursal=new Sucursales;
                            $M_sucursal->idsucursal=$value['idSucursal'];
                            $M_sucursal->nombre=$value['nombre'];
                            $M_sucursal->domicilio=$value['calle'];
                            $M_sucursal->save();
                            $M_sucursal->users()->attach($usuario->id);
                        }else{
                            $M_sucursal->users()->attach($usuario->id);
                            
                        }
                        
                    }

                    \DB::commit();
                #- Respodemos con codigo 200 ok o con text.-
                   
                    
                    
                    return \Response::json(['status'=>0,'descripcion'=>'Usuario y Sucursales Creadas con Éxito','data'=>'']);

                }else{
                    \DB::rollback();
                    #- Respodemos con codigo 200 error o con text.-
                    
                    return \Response::json(['status'=>-1,'descripcion'=>'El usuario y contraseña no pueden ser vacios.','data'=>'']);
                }

            }else{
                    $usuario->idusuario=$iduserME;
                    $usuario->direccion=$direccion;
                    $usuario->permisos=$permisos; # habilita o deshabilita el menú [0:todos, 1:revisiones periodicas]
                    $usuario->user=$user;
                    $usuario->name=$nombre;
                    $usuario->password=bcrypt($pass);

                     #- Cargamos las reaciones entre Sucursales y Usuarios
                    
                     foreach ($sucursales as $key => $value) {
                        $M_sucursal=Sucursales::where('idSucursal',$value['idSucursal'])->first();
                        if ($M_sucursal){
                            $M_sucursal->idsucursal=$value['idSucursal'];
                            $M_sucursal->nombre=$value['nombre'];
                            $M_sucursal->domicilio=$value['calle'];
                            $M_sucursal->update();   
                                                   
                        }else{
                            $M_sucursal=(new Sucursales);
                            $M_sucursal->idsucursal=$value['idSucursal'];
                            $M_sucursal->nombre=$value['nombre'];
                            $M_sucursal->domicilio=$value['calle'];
                            $M_sucursal->save();
                            $M_sucursal->users()->attach($usuario->id);
                        }
                     }
                if ($usuario->estado==false){
                    
                    $usuario->estado=true;
                    $usuario->update();
                    return \Response::json(['status'=>0,'descripcion'=>'El usuario: '.$usuario->name.' a sido Activado.','data'=>'']);
                }else{
                   
                    $usuario->update();
                    return \Response::json(['status'=>1,'descripcion'=>'El usuario: '.$usuario->name.', ya existe y esta Activado ','data'=>'']);
                }

            }
           
        } catch (\Exception $e) {
            
            \DB::rollback();
            return \Response::json(['status'=>-1,'descripcion'=>'Detalle completo: '.$e->getMessage().' Line:'.$e->getLine().'Api Controller: User','data'=>'']); 
            
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
        try {
            $user=(new User)::where('idusuario',$id)->first();
            if ($user->count()>0){
                $user->estado=0;
                $user->update();
                return \Response::json(['status'=>0,'descripcion'=>'El usuario: '.$user->name.' a sido Desactivado.','data'=>'']);
            }
        } catch (\Throwable $th) {
            //$log=(new logControllers)->error($th, 'Imagenes','destroy');
            return \Response::json(['status'=>-1,'descripcion'=>$th.getMessage(),'data'=>'']);
           
        }
       
    }

    /**
     * Elimina sucursal y todo lo que se relaciona
     * 
     */
    public function Destroy_sucursal($id,$nivel){
        try {
           
            $sucursal=Sucursales::where('idsucursal',$id)->first();
            if ($nivel==0){
                $sucursal->delete();
            }else{

                foreach ($sucursal->sectors as $key => $value) {
                    $value->delete();
                }
                foreach ($sucursal->elementos as $key => $value) {
                    $value->delete();
                }
                foreach ($sucursal->planilla as $key => $value) {
                    $value->delete();
                }
                foreach ($sucursal->revisionperiodicas as $key => $value) {
                    $value->delete();
                }
            }
            return \Response::json(['status'=>0,'descripcion'=>'La Sucursal: '.$sucursal->nombre.' a sido Eliminada y todo lo relacionado a ella.','data'=>'']);
            
        } catch (\Throwable $th) {
            //$log=(new logControllers)->error($th, 'Imagenes','destroy');
            return \Response::json(['status'=>-1,'descripcion'=>$th.getMessage(),'data'=>'']);
          
        }
    }
}
