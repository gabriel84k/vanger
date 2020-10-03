<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user','Api\UserController@AuthRouteAPI');


Route::group(['prefix' => '/Sigex'], function () {
    
  Route::resource('CreateUser', 'Api\UserController');
  
  
  Route::delete('EliminarSucursal/{id}','Api\UserController@Destroy_sucursal');

  Route::resource('Controles', 'Api\DatosController');

  Route::resource('Equipos', 'Api\CargaEquipos');
  
  Route::resource('Inspecciones', 'Api\Inspecciones');
  Route::resource('Imagenes', 'Api\Imagenes');

 
  Route::resource('Planillas', 'Api\PlanillasController');
  
  Route::resource('SPE', 'Api\SPEController');
      
  
  Route::group(['prefix' => '/Conf'], function () {
    Route::get('/clear-cache', function() {
        $exitCode = Artisan::call('config:clear');
        $exitCode = Artisan::call('cache:clear');
        $exitCode = Artisan::call('config:cache');
        
        return 'Cache Borrado Correctamente!!'; 
    });
    Route::get('/down', function() {
      $exitCode = Artisan::call('down');
      
      return 'Sitio puesto en Mantención'; 
    });
    Route::get('/link', function() {
      $exitCode = Artisan::call('storage:link');
      
      return 'Crea link en public para storage.'; 
    });
  });

});


