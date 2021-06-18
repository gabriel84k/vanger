<?php
/**
 *      El controlador de PDF contiene 5 funciones. Para probar estas funciones 
 *        quitar la linea que esta comentada //return view.... , con esto podemos
 *        visualizar el pdf en la exproador.
 *      Opciones del PDF:
 *                   ->setPaper('a4', 'portrait')
 *                           •a4 = 'tamaño hoja'
 *                           •[portrait= vertical, landscape=horizontal]
 *                   ->setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
 *                           •rootDir : "{directorio_aplicaciones} / vendor / dompdf / dompdf"
 *                           •tempDir : "/ tmp" (disponible en config / dompdf.php)
 *                           •fontDir : "{directorio_aplicaciones} / storage / fonts /" (disponible en config / dompdf.php)
 *                           •fontCache : "{directorio_aplicaciones} / storage / fonts /" (disponible en config / dompdf.php)
 *                           •chroot : "{app_directory}" (disponible en config / dompdf.php)
 *                           •logOutputFile : "/tmp/log.htm"
 *                           •defaultMediaType : "pantalla" (disponible en config / dompdf.php)
 *                           •defaultPaperSize : "a4" (disponible en config / dompdf.php)
 *                           •defaultFont : "serif" (disponible en config / dompdf.php)
 *                           •dpi : 96 (disponible en config / dompdf.php)
 *                           ••fontHeightRatio : 1.1 (disponible en config / dompdf.php)
 *                           •isPhpEnabled : false (disponible en config / dompdf.php)
 *                           •isRemoteEnabled : true (disponible en config / dompdf.php)
 *                           •isJavascriptEnabled : true (disponible en config / dompdf.php)
 *                           •isHtml5ParserEnabled : false (disponible en config / dompdf.php)
 *                           •isFontSubsettingEnabled : false (disponible en config / dompdf.php)
 *                           •debugPng : falso
 *                           •debugKeepTemp : false
 *                           •debugCss : false
 *                           •debugLayout : falso
 *                           •debugLayoutLines : true
 *                           •debugLayoutBlocks : verdadero
 *                           •debugLayoutInline : true
 *                           •debugLayoutPaddingBox : true
 *                           •pdfBackend : "CPDF" (disponible en config / dompdf.php)
 *                           •pdflibLicense : ""
 *                           •adminUsername : "usuario"
 *                           •adminPassword : "contraseña"
 *                      
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use App\db\Sucursales;
use App\Exports\Planillas\CertCarga;
use App\Exports\Planillas\Inutilizacion;
use App\Exports\Planillas\Operatividad;
use App\Exports\Planillas\CertificadoPH;
use App\Exports\Planillas\Inspecciones;
use Maatwebsite\Excel\Facades\Excel;



class PdfController extends Controller
{
    

        public function __construct(){
            ini_set('max_execution_time', 300); //300 seconds = 5 minutes
            ini_set('memory_limit', '3000M'); //This might be too large, but depends on the data set
            PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        }
        public function Equipos(Request $request, $tipo){
            set_time_limit(300); 
            
            $filtros=[];
            foreach (request()->all() as $key => $value) {
                if ($value!=''){
                    $filtros[$key]=$value;
                }
            };
            if (request('sucursal')){ 
                $sucnombre=Sucursales::where('id',request('sucursal'))->first();
                $filtros['sucursalnombre']=$sucnombre->nombre;
            }
            $datos=(new ElementoController)->show_pdf($tipo);
            //return view('PDF.Equipos',['datos'=>$datos],['datos'=>$datos, 'filtros'=>$filtros]);
            if($tipo==0){
                $pdf = PDF::loadView('PDF.Equipos',['datos'=>$datos, 'filtros'=>$filtros])->setPaper('a4', 'portrait')->setWarnings(false);
                return $pdf->download('Listado Extintores.pdf');
            }else{
                $pdf = PDF::loadView('PDF.Mangueras',['datos'=>$datos, 'filtros'=>$filtros])->setPaper('a4', 'portrait')->setWarnings(false);
                return $pdf->download('Listado Mangueras.pdf');
            }
            
        }
       
        public function certificadocarga_all($datos, $tipo){
            set_time_limit(300); 
            $datos=(new ServiciosController)->show_pdf($datos);
            
            switch ($tipo) {
                case 'PDF':
                    $pdf = PDF::loadView('PDF.grupocarga',['datos'=>$datos])->setPaper('a4', 'portrait')->setWarnings(false);
                    return $pdf->download('Certificado_de_carga.pdf');
                
                case 'XLS':
                    return (new CertCarga($datos))->download('Certificado_de_carga.xls',\Maatwebsite\Excel\Excel::XLS);

                case 'XLSX':
                    return (new CertCarga($datos))->download('Certificado_de_carga.xlsx',\Maatwebsite\Excel\Excel::XLSX);
                
                case 'CSV':
                    return (new CertCarga($datos))->download('Certificado_de_carga.csv',\Maatwebsite\Excel\Excel::CSV);
                
                case 'HTML':
                    return (new CertCarga($datos))->download('Certificado_de_carga.html',\Maatwebsite\Excel\Excel::HTML);

                case 'ODS':
                    return (new CertCarga($datos))->download('Certificado_de_carga.ods',\Maatwebsite\Excel\Excel::ODS);
                default:
                   
                    break;
            }
          
            
        }
        public function Inutilizacion($datos, $tipo){
            set_time_limit(300); 
            $datos=(new ServiciosController)->show_pdf($datos);
            
            //return view('PDF.grupocarga',['datos'=>$datos]);
            switch ($tipo) {
                case 'PDF':
                    $pdf = PDF::loadView('PDF.inutilizacion',['datos'=>$datos])->setPaper('a4', 'portrait')->setWarnings(false);
                   
                    return $pdf->stream('inutilizacion.pdf');
                
                case 'XLS':
                    return (new Inutilizacion($datos))->download('Inutilizacion.xls',\Maatwebsite\Excel\Excel::XLS);

                case 'XLSX':
                    return (new Inutilizacion($datos))->download('Inutilizacion.xlsx',\Maatwebsite\Excel\Excel::XLSX);
                
                case 'CSV':
                    return (new Inutilizacion($datos))->download('Inutilizacion.csv',\Maatwebsite\Excel\Excel::CSV);
                
                case 'HTML':
                    return (new Inutilizacion($datos))->download('Inutilizacion.html',\Maatwebsite\Excel\Excel::HTML);

                case 'ODS':
                    return (new Inutilizacion($datos))->download('Inutilizacion.ods',\Maatwebsite\Excel\Excel::ODS);
                default:
                   
                    break;
            }
            
        }
        public function operatividad($datos, $tipo){
            set_time_limit(300); 
            $datos=(new ServiciosController)->show_pdf($datos);
            //return view('PDF.operatividad',['datos'=>$datos]);
            switch ($tipo) {
                case 'PDF':
                    $pdf = PDF::loadView('PDF.operatividad',['datos'=>$datos])->setPaper('a4', 'portrait')->setWarnings(false);
                    return $pdf->download('Operatividad.pdf');
                
                case 'XLS':
                    return (new Operatividad($datos))->download('Operatividad.xls',\Maatwebsite\Excel\Excel::XLS);

                case 'XLSX':
                    return (new Operatividad($datos))->download('Operatividad.xlsx',\Maatwebsite\Excel\Excel::XLSX);
                
                case 'CSV':
                    return (new Operatividad($datos))->download('Operatividad.csv',\Maatwebsite\Excel\Excel::CSV);
                
                case 'HTML':
                    return (new Operatividad($datos))->download('Operatividad.html',\Maatwebsite\Excel\Excel::HTML);

                case 'ODS':
                    return (new Operatividad($datos))->download('Operatividad.ods',\Maatwebsite\Excel\Excel::ODS);
                default:
                   
                    break;
            }
           
        }
        public function certificadoPH($datos,$equipo_id=0, $tipo){
            
            set_time_limit(300); 
            $datos=(new ServiciosController)->show_pdf($datos);
            //return view('PDF.certificadoPH',['datos'=>$datos,'salto'=>'2', 'idequipo'=>$equipo_id]);
            
            switch ($tipo) {
                case 'PDF':
                    $pdf = PDF::loadView('PDF.certificadoPH',['datos'=>$datos, 'salto'=>'2', 'idequipo'=>$equipo_id])->setPaper('a4', 'portrait')->setWarnings(false);        
                    return $pdf->download('certificadoPH.pdf');
                
                case 'XLS':
                    //return (new CertificadoPH($datos,$equipo_id))->download('Operatividad.xls',\Maatwebsite\Excel\Excel::XLS);

                case 'XLSX':
                    //return (new CertificadoPH($datos,$equipo_id))->download('Operatividad.xlsx',\Maatwebsite\Excel\Excel::XLSX);
                
                case 'CSV':
                    //return (new CertificadoPH($datos,$equipo_id))->download('Operatividad.csv',\Maatwebsite\Excel\Excel::CSV);
                
                case 'HTML':
                    //return (new CertificadoPH($datos,$equipo_id))->download('Operatividad.html',\Maatwebsite\Excel\Excel::HTML);

                case 'ODS':
                    //return (new CertificadoPH($datos,$equipo_id))->download('Operatividad.ods',\Maatwebsite\Excel\Excel::ODS);
                default:
                   
                    break;
            }
           
            
        }
   
        public function inspecciones($datos,$nrocontrol, $tipo){
            set_time_limit(300); 
            $datos=(new RevisionPeriodicaController)->general(request(),$datos,$nrocontrol);
            //return view('PDF.inspecciones',['datos'=>$datos,'salto'=>'2','control'=>$nrocontrol]);
            switch ($tipo) {
                case 'PDF':
                    $pdf = PDF::loadView('PDF.inspecciones',['datos'=>$datos,'control'=>$nrocontrol])->setPaper('a4', 'portrait')->setWarnings(false);        
                    return $pdf->download('inspecciones.pdf');
                
                case 'XLS':
                    return (new Inspecciones($datos,$nrocontrol))->download('inspecciones.xls',\Maatwebsite\Excel\Excel::XLS);

                case 'XLSX':
                    return (new Inspecciones($datos,$nrocontrol))->download('inspecciones.xlsx',\Maatwebsite\Excel\Excel::XLSX);
                
                case 'CSV':
                    return (new Inspecciones($datos,$nrocontrol))->download('inspecciones.csv',\Maatwebsite\Excel\Excel::CSV);
                
                case 'HTML':
                    return (new Inspecciones($datos,$nrocontrol))->download('inspecciones.html',\Maatwebsite\Excel\Excel::HTML);

                case 'ODS':
                    return (new Inspecciones($datos,$nrocontrol))->download('inspecciones.ods',\Maatwebsite\Excel\Excel::ODS);
                default:
                   
                    break;
            }
            
        }
        public function inspeccionesportipo($datos,$key){
            set_time_limit(300); 
            $datos=(new RevisionPeriodicaController)->pdftipopuesto(request(),$datos,$key);        
            $nombre="inspecciones.pdf";
            switch ($key) {
                case 'inspeccionbie':
                    $nombre="inspeccion_bie.pdf";
                    //return view('PDF.TipoInspeccion.inspeccionbie',['datos'=>$datos,'control'=>$key]);
                    $pdf = PDF::loadView('PDF.TipoInspeccion.inspeccionbie',['datos'=>$datos,'control'=>'falta'])->setPaper('a4', 'landscape')->setWarnings(false);        
                    break;
                case 'inspeccionkitsegusur':
                    $nombre="inspeccion_kit.pdf";
                    //return view('PDF.TipoInspeccion.inspeccionkit',['datos'=>$datos,'control'=>$key]);
                    $pdf = PDF::loadView('PDF.TipoInspeccion.inspeccionkit',['datos'=>$datos,'control'=>'falta'])->setPaper('a4', 'landscape')->setWarnings(false);        
                    break;
                case 'inspeccionduchasegusur':
                    $nombre="inspeccion_ducha.pdf";
                    //return view('PDF.TipoInspeccion.inspeccionducha',['datos'=>$datos,'control'=>$key]);
                    $pdf = PDF::loadView('PDF.TipoInspeccion.inspeccionducha',['datos'=>$datos,'control'=>'falta'])->setPaper('a4', 'portrait')->setWarnings(false);        
                    break;
                case 'inspeccionecasegusur':
                    $nombre="inspeccion_eca.pdf";
                    //return view('PDF.TipoInspeccion.inspeccioneca',['datos'=>$datos,'control'=>$key]);
                    $pdf = PDF::loadView('PDF.TipoInspeccion.inspeccioneca',['datos'=>$datos,'control'=>'falta'])->setPaper('a4', 'portrait')->setWarnings(false);        
                    break;
                case 'inspeccionescalerasegusur':
                    $nombre="inspeccion_escalera.pdf";
                    //return view('PDF.TipoInspeccion.inspeccionescalerasegusur',['datos'=>$datos,'control'=>$key]);
                    $pdf = PDF::loadView('PDF.TipoInspeccion.inspeccionescalera',['datos'=>$datos,'control'=>'falta'])->setPaper('a4', 'portrait')->setWarnings(false);        
                    break;
                case 'inspeccionpuertasegusur':
                        $nombre="inspeccion_puerta.pdf";
                        //return view('PDF.TipoInspeccion.inspeccionescalerasegusur',['datos'=>$datos,'control'=>$key]);
                        $pdf = PDF::loadView('PDF.TipoInspeccion.inspeccionpuerta',['datos'=>$datos,'control'=>'falta'])->setPaper('a4', 'portrait')->setWarnings(false);        
                        break;
                case 'inspeccionextintor':
                    $nombre="inspeccion_extintor.pdf";
                        //return view('PDF.TipoInspeccion.inspeccionescalerasegusur',['datos'=>$datos,'control'=>$key]);
                        $pdf = PDF::loadView('PDF.TipoInspeccion.inspeccionextintor',['datos'=>$datos,'control'=>'falta'])->setPaper('a4', 'landscape')->setWarnings(false);        
                        break;
                default:
                    return 'No Existe la Página';
                    break;
            }
            
            
            return $pdf->download($nombre);
        }
}
