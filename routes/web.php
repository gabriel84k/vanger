<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Auth::routes(['verify' => true]);


Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => '/Export'], function () {
    Route::get('/Sucursal', 'SSPExcel@export');
    Route::get('/Sucursal/{id}', 'SSPExcel@show');

});
Route::group(['prefix' => '/imprimir'], function () {
    Route::get('/CertCarga', 'PdfController@certificadocarga')->name('certificadocarga');
    Route::get('/GrupoCertCarga/{datos}', 'PdfController@certificadocarga_all')->name('certificadocarga_all');
    Route::get('/Operatividad/{datos}', 'PdfController@operatividad')->name('operatividad');
    Route::get('/CertificadoPH/{datos}/{idequipo}', 'PdfController@certificadoPH')->name('certificadoPH'); #[op es : 0=>Todos {servicio_id} y 1=>uno {equipo_id}]
    
    Route::group(['prefix' => '/Inspecciones'], function () {
        Route::get('/{datos}/{control}', 'PdfController@inspecciones')->name('Inspecciones'); 
        Route::get('/tipo/{datos}/{key}', 'PdfController@inspeccionesportipo')->name('Inspeccionesportipo'); 
    });
    Route::get('/Inutilizacion/{datos}', 'PdfController@Inutilizacion')->name('Inutilizacion'); 
    Route::get('/Equipos/{tipo}', 'PdfController@Equipos')->name('Equipos'); 

});


Route::group(['middleware' => 'logueado','prefix' => '/home'], function () {

    Route::group(['prefix' => '/Elementos'], function () {
        
            # Get-
            Route::get('/Equipos', 'ElementoController@viewElement')->Middleware('Permisos:Equipos');
            Route::get('/Bombas', 'ElementoController@viewElement')->Middleware('Permisos:Bombas');
            Route::get('/Mangueras', 'ElementoController@viewElement')->Middleware('Permisos:Mangueras');

            Route::get('/detalle/{id}/{tipo}', 'ElementoController@viewDetalle');
            Route::get('/search/{tipo}', 'ElementoController@Search');
            
            # Post-
            
            # Resource-
            Route::resource('/data', 'ElementoController');
        
        
    });
    Route::group(['prefix' => '/Puestos'], function () {
        Route::get('/detalle/{id}', 'PuestosController@show');
    });

    Route::group(['prefix' => '/Sucursales'], function () {
        # Get-
        Route::get('/', 'SucursalesController@view');
        Route::get('/all', 'SucursalesController@branchoffices');
        
        # Post-

        # Resource-
        Route::resource('/data', 'SucursalesController');

    });
    
    Route::group(['prefix' => '/Sectores'], function () {

        Route::get('/', 'SectoresController@view');
        Route::get('/detalle/{id}', 'SectoresController@viewDetalle');
        
        Route::resource('/data', 'SectoresController');

    });

    Route::group(['prefix' => '/Inspecciones'], function () {
        
        Route::get('/Insp-Equipo/{id}', 'InspeccionController@show_elemento');
        
        Route::get('/search/{idcontrol}', 'InspeccionController@Search');

        Route::resource('/', 'InspeccionController');
    });
    
   
    Route::group(['prefix' => '/Control-Periodicos'], function () {
        # Get-
        Route::get('/', 'RevisionPeriodicaController@view')->Middleware('Permisos:Controles');
        Route::get('/search', 'RevisionPeriodicaController@Search');

        # Recourse-
        Route::resource('/data', 'RevisionPeriodicaController');
    }); 

    Route::group(['prefix' => '/Planilla'], function () {
        # Get-
        Route::get('/', 'PlanillasController@view')->Middleware('Permisos:Planilla');
        Route::get('/search', 'PlanillasController@search');
        Route::get('/searchequipo/{id}', 'PlanillasController@searchequipo');

        # Recourse-
        Route::resource('/data', 'PlanillasController');
    });

    Route::group(['prefix' => '/Servicios'], function () {
        # Get-
        Route::get('/', 'ServiciosController@view');
        Route::get('/search', 'ServiciosController@Search');
        Route::get('/repuestos/{idservicio}', 'Reparaciones@index');

        # Recourse-
        Route::resource('/data', 'ServiciosController');
    });
    Route::group(['prefix' => '/log'],function(){
        Route::get('/logs_48191', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
    });
   
});



