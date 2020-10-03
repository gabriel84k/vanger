<?php

namespace App\db;

use Illuminate\Database\Eloquent\Model;

class Inspeccionbie extends Model
{
    Protected $table='inspeccionbies';
    public $timestamps = false;
    /**
    * Los atributos que son asignables en masa.
    *
    * @var array
    */
   protected $fillable = [
    'idManguera', 
    'union', 
    'estadoUnion', 
    'junta', 
    'tieneLanza', 
    'lanza', 
    'tieneBoquilla', 
    'boquilla', 
    'boquilla_id', 
    'estadoGabinete', 
    'estadoVidrio', 
    'requierePintura', 
    'requiereReemplazoGabinete', 
    'tieneMedioDeRuptura', 
    'cuerpo', 
    'tapaValvula', 
    'volante', 
    'tuerca', 
    'cantidadLlavesDeAjuste', 
    'comentarioLlaveDeAjuste', 
    'reduccionPresente', 
    'requiereReemplazoValvula', 
    'asiento', 
    'vastago', 
    'nichoHidrante', 
    'rompaVidrio', 
    'controles', 
    'inspeccion_id'
     
   ];


   /**
    * Los atributos que deben ocultarse para las matrices.
    *
    * @var array
    */
   protected $hidden = [
      
   ];

   /**
    * Los atributos que se deben convertir a los tipos nativos.
    *
    * @var array
    */
   protected $casts = [
       
   ];
   /*
    *    Tipo= [cumple,string,int,bool]
    *            cumple --> muestra {cumple, no cumple, no aplica, no apreciable }
    *            bool --> muestra {Si o No}
    *            int  --> muestra un valor numerico
    *            string --> muestra el valor string
    *    Visible= {true o false} --> muestra u oculta la columna de la vuetable
    *    Name= la propiedad del objeto
    *    Muestra= muestra el valor a mostrar en las columnas
    *    Verdetalle= {true o false} --> se muestra en el detalle de la inspeccion
   */

   public $column = [
    'name'=>'Bie',
    #- [•Columnas locales•] -#
        'idManguera'=> ['tipo'=>'int','visible'=>false,'name'=>'idManguera','muestra'=>'Id','verdetalle'=>false],
        'union'=> ['tipo'=>'string','visible'=>true,'name'=>'union','muestra'=>'Unión','verdetalle'=>true],
        'estadoUnion'=> ['tipo'=>'cumple','visible'=>true,'name'=>'estadoUnion','muestra'=>'Estado de Union','verdetalle'=>true],
        'junta'=> ['tipo'=>'cumple','visible'=>true,'name'=>'junta','muestra'=>'Junta','verdetalle'=>true],
        'tieneLanza'=> ['tipo'=>'bool','visible'=>true,'name'=>'tieneLanza','muestra'=>'Tiene Lanza','verdetalle'=>true],
        'lanza'=> ['tipo'=>'cumple','visible'=>true,'name'=>'lanza','muestra'=>'Lanza','verdetalle'=>true],
        'tieneBoquilla'=> ['tipo'=>'bool','visible'=>true,'name'=>'tieneBoquilla','muestra'=>'Tiene Boquilla','verdetalle'=>true],
        'boquilla'=> ['tipo'=>'cumple','visible'=>true,'name'=>'boquilla','muestra'=>'Boquilla','verdetalle'=>true],
        'estadoGabinete'=> ['tipo'=>'int','visible'=>true,'name'=>'estadoGabinete','muestra'=>'Estado del Gabinete','verdetalle'=>true],
        'estadoVidrio'=> ['tipo'=>'int','visible'=>true,'name'=>'estadoVidrio','muestra'=>'Estado del Vidrio','verdetalle'=>true],
        'requierePintura'=> ['tipo'=>'bool','visible'=>true,'name'=>'requierePintura','muestra'=>'Requiere Pintura','verdetalle'=>true],
        'requiereReemplazoGabinete'=> ['tipo'=>'bool','visible'=>true,'name'=>'requiereReemplazoGabinete','muestra'=>'Requiere Reemplazo Gabinete','verdetalle'=>true],
        'tieneMedioDeRuptura'=> ['tipo'=>'bool','visible'=>true,'name'=>'tieneMedioDeRuptura','muestra'=>'Tiene Medio de Ruptura','verdetalle'=>true],
        'cuerpo'=> ['tipo'=>'int','visible'=>true,'name'=>'cuerpo','muestra'=>'Cuerpo','verdetalle'=>true],
        'tapaValvula'=> ['tipo'=>'cumple','visible'=>true,'name'=>'tapaValvula','muestra'=>'Tapa Valvula','verdetalle'=>true],
        'volante'=> ['tipo'=>'cumple','visible'=>true,'name'=>'volante','muestra'=>'Volante','verdetalle'=>true],
        'tuerca'=> ['tipo'=>'cumple','visible'=>true,'name'=>'tuerca','muestra'=>'Tuerca','verdetalle'=>true],
        'cantidadLlavesDeAjuste'=> ['tipo'=>'int','visible'=>true,'name'=>'cantidadLlavesDeAjuste','muestra'=>'Cantidad Llaves de Ajuste','verdetalle'=>true],
        'comentarioLlaveDeAjuste'=> ['tipo'=>'bool','visible'=>true,'name'=>'comentarioLlaveDeAjuste','muestra'=>'Comentario Llave de Ajuste','verdetalle'=>true],
        'reduccionPresente'=> ['tipo'=>'int','visible'=>true,'name'=>'reduccionPresente','muestra'=>'Reduccion Presente','verdetalle'=>true],
        'requiereReemplazoValvula'=> ['tipo'=>'bool','visible'=>true,'name'=>'requiereReemplazoValvula','muestra'=>'Requiere Reemplazo de Valvula','verdetalle'=>true],
        'asiento'=> ['tipo'=>'cumple','visible'=>true,'name'=>'asiento','muestra'=>'Asiento','verdetalle'=>true],
        'vastago'=> ['tipo'=>'cumple','visible'=>true,'name'=>'vastago','muestra'=>'Vastago','verdetalle'=>true],
        'nichoHidrante'=> ['tipo'=>'cumple','visible'=>true,'name'=>'nichoHidrante','muestra'=>'Nicho Hidrante','verdetalle'=>true],
        'rompaVidrio'=> ['tipo'=>'int','visible'=>true,'name'=>'rompaVidrio','muestra'=>'Rompa Vidrio','verdetalle'=>true],
        'controles'=> ['tipo'=>'int','visible'=>true,'name'=>'controles','muestra'=>'controles','verdetalle'=>true],
    
        
   ];
}
