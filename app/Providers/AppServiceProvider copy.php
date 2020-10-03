<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
            //return base_path().'/htdocs'; #- para uso local /public ; para uso production /public_html
            return base_path().'/web'; #- para uso del cliente grouptmaq.cl
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }
}
