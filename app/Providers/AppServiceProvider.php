<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{

   
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        #- Estas lineas se colocan cuando el hosting es compartido para cambiar la carpeta de almacenammiento,
        #   ya que el hosting compartido no permite crear enlaces simbolicos.- Quitarlo para VPS (dedicados)
        $this->app->bind('path.public', function() {
                //return base_path().'/web'; #- para uso del cliente grouptmaq.cl
                return base_path(); #- para uso local
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('sino', function () {
            return "prueba funcionando";
            
           
            
        });
    }
}
