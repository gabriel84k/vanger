<?php

namespace App\Exports;

use App\db\Sucursales;
use App\db\Sector;
use App\db\Puesto;
use App\db\Equipo;

use Illuminate\Support\Facades\Auth;
use PHPExcel_Worksheet_Drawing;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Events\AfterSheet;


use Illuminate\Support\Collection as Collection;

class SucursalSheet implements  WithTitle,WithHeadings, WithEvents,FromCollection, WithCustomStartCell, WithColumnFormatting
{
    protected $sucursal;
    protected $cant;
    protected $user;
   
    function __construct($s, $user){
        setlocale(LC_TIME, "spanish");
        date_default_timezone_set('America/Argentina/Buenos_Aires');
        
        $this->sucursal=$s;
        $this->user=$user;
    }
    /**
     * @return Builder
     */
    public function collection()
    {
        
        
        try {
          
            $this->cant=7;
            $sectores=(new Sector)::where('Sucursales_id',$this->sucursal->id)
            ->get(); 
            
            
            $Val_Sectores=array();
            foreach ($sectores as $key_sectores => $value_sectores) {
                
                $puestos=$value_sectores->puesto()->orderby('nroPuesto')->get();
                
                $Val_Puestos= array();
            
                foreach ($puestos as $key => $value_insp) {
                    $rowtype=$value_insp->row_type;
                    $tipopuesto=$value_insp->$rowtype;
                    
                    $Val_Puestos[$key]['sector']=$value_sectores->nombre;           #- Sectores.-
                    $Val_Puestos[$key]['N°']=$value_insp->nroPuesto;
                    $Val_Puestos[$key]['ubicacion']=$value_insp->ubicacion;         #- Puestos.-
                    switch ($value_insp->habilitado) {
                        case 1:
                            $Val_Puestos[$key]['habilitado']='Si';
                            break;
                        
                        case 0:
                            $Val_Puestos[$key]['habilitado']='No';
                            break;
                    }
                    
                    $Val_Puestos[$key]['tipodepuesto']=strtoupper(str_replace(['segusur','egusur'],['',' de Derrame'],$value_insp->row_type)); 
                    #-[Datos de los Puestos]-#
                    
                  
                    if ($value_insp){
                        if ($tipopuesto->codigoElemento){
                            $Val_Puestos[$key]['elemento']=$tipopuesto->codigoElemento;
                        }else{
                            $elemetno=$tipopuesto->elemento()->first(); //Elemento::find($value_insp->elemento_id);

                            if ($elemetno){
                                $rtype=$elemetno->row_type;
                                $elemetno=$elemetno->$rtype()->first();
                             
                                if($rtype=='equipos'){
                                    $Val_Puestos[$key]['elemento']='['.$elemetno->nro_equipo_evolution.'] - '.$elemetno->tipo.' - '.$elemetno->capacidad.' '.$elemetno->unidad;
                                }elseif($rtype=='mangueras'){
                                    $Val_Puestos[$key]['elemento']='['.$elemetno->numeroManguera.'] - '.$elemetno->boquillanombre. ' - '.$elemetno->uniones;
                                }
                                
                            }else{
                                $Val_Puestos[$key]['elemento']='no tiene';
                            }
                        }
                    }
                    $this->cant++;
                }
                
                $Val_Sectores[$key_sectores] = $Val_Puestos;
            
            }
        
            return Collection::make($Val_Sectores);
         
        } catch (\Throwable $th) {
            dd($th );
        }
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->sucursal->nombre;
    }
   
    public function startCell(): string
    {
        return 'A7';
    }
    public function headings(): array
    {
        return [
            'Sector','N°','Ubicación', 'Habilitado','Tipo de Puesto','Elemento'

        ];
    }
    public function registerEvents(): array
    {
       
       return [
                AfterSheet::class    => function(AfterSheet $event) 
                {
                    
                        $styleArrayMedio = [
                            'borders' => [
                                'outline' => [
                                    'borderStyle' =>  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                                    'color' => ['argb' => '000000'],
                                    'width' => '5px',
                                    
                                ],
                            ],
                        ];
                        $styleArrayfino = [
                            'borders' => [
                                'outline' => [
                                    'borderStyle' =>  \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                    'color' => ['argb' => 'white'],
                                    'width' => '5px',
                                    
                                ],
                            ],
                        ];
                       
                        $ColumnAutoSize=['A','C','I','H','G'];
                        foreach ($ColumnAutoSize as $key => $value) {
                            $event->sheet->getDelegate()->getColumnDimension($value)->setAutoSize(true);
                        }
                        $event->sheet->getStyle('A:I')->getFill()
                        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('ffffffff');
                        $event->sheet->getStyle('A1:I5')->applyFromArray($styleArrayfino);
                        $event->sheet->mergeCells('A1:C5');
                        
                        #----------------------------------------------------------------------------
                        $event->sheet->getStyle('D1:H1')->applyFromArray($styleArrayfino);
                        $event->sheet->setCellValue('D1',"DOTACIÓN DE EXTINTORES"); 
                        $event->sheet->mergeCells('D1:H1');
                        $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(false);
                        $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(10);
                        $event->sheet->getDelegate()->getStyle('D1:H1')->getFont()->setSize(18);
                        $event->sheet->getDelegate()->getStyle('D1:H1')->getFont()->setName('Arial');
                        $event->sheet->getDelegate()->getStyle('D1:H1')->getFont()->setBold(true);
                        #----------------------------------------------------------------------------
                        $event->sheet->getStyle('I1:I1')->applyFromArray($styleArrayfino);
                        $event->sheet->setCellValue('I1',"REG 750.05");
                        $event->sheet->getDelegate()->getStyle('I1')->getFont()->setSize(10);
                        $event->sheet->getDelegate()->getStyle('I1')->getFont()->setName('Arial'); 
                        #----------------------------------------------------------------------------
                        $event->sheet->getStyle('D2:H2')->applyFromArray($styleArrayfino);
                        $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(8.57);
                        $event->sheet->setCellValue('D2',"Cliente:"); 
                        
                        $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(true);
                        $event->sheet->setCellValue('E2',$this->user->name); 
                        $event->sheet->mergeCells('E2:H2');
                        $event->sheet->setCellValue('I2'," Rev.: 01"); 
                        $event->sheet->getStyle('I2')->applyFromArray($styleArrayfino);
                        
                        #----------------------------------------------------------------------------
                        $event->sheet->setCellValue('D3',"Sucursal:"); 
                        $event->sheet->getStyle('D3:H3')->applyFromArray($styleArrayfino);
                        $event->sheet->setCellValue('E3',$this->sucursal->nombre); 
                        $event->sheet->mergeCells('E3:H3');
                        #----------------------------------------------------------------------------
                        $event->sheet->setCellValue('D4',"Dirección:"); 
                        $event->sheet->getStyle('D4:H4')->applyFromArray($styleArrayfino);
                        $event->sheet->setCellValue('E4',$this->sucursal->domicilio);
                        $event->sheet->mergeCells('E4:H4'); 
                        #----------------------------------------------------------------------------
                        $event->sheet->setCellValue('D5',"Fecha de actualización:"); 
                        $event->sheet->getStyle('D5:H5')->applyFromArray($styleArrayfino);
                       
                        $event->sheet->mergeCells('D5:F5');
                        
                        $fecha_hoy=$this->traductor(date('d-m-Y'),'Dia-mes-Año');
                     
                        $event->sheet->setCellValue('G5',$fecha_hoy); 
                        $event->sheet->mergeCells('G5:H5');
                        $event->sheet->getDelegate()->getStyle('D5:H5')->getFont()->setSize(10);
                        $event->sheet->getDelegate()->getStyle('D5:H5')->getFont()->setName('Arial');
                        #-----------------------------------------------------------------------------
                       
                        $event->sheet->getDelegate()->getColumnDimension("F")->setAutoSize(true);
                        for ($i=7; $i <= $this->cant ; $i++) { 
                            if ($i==7){
                                $event->sheet->getStyle('A'.$i.':I'.$i)->applyFromArray($styleArrayMedio);
                            }
                            
                            if ($i!=7){
                                $event->sheet->getStyle('A'.$i.':I'.$i)->applyFromArray($styleArrayfino);
                            }

                        }
                        
                        $event->sheet->getDelegate()->getStyle('A7:I'.$this->cant)->getFont()->setSize(8);
                        $event->sheet->getDelegate()->getStyle('A7:I'.$this->cant)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('A7:I'.$this->cant)->getFont()->setName('Arial');
                        #----- LOGO ------#
                        $event->sheet->setCellValue('A1',"Vanger"); 
                        $event->sheet->getDelegate()->getStyle('A1:A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('A1:A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                        $event->sheet->getDelegate()->getStyle('A1:A1')->applyFromArray([
                            'font' => [
                                'name' => 'Bauhaus 93',
                                'size' => 30,
                                'color' => [
                                    'argb' => '595959'
                                ]
                               
                            ]
                        ]);
                },
            ];
    }
    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_DATE_XLSX17,
            'H' => NumberFormat::FORMAT_DATE_XLSX17,
            
        ];
    }
    
    public function traductor($date,$str){
        $fecha = substr($date, 0, 10);
        $nombreMesanio ='';
        
        $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        switch ($str) {
            case 'mes-AÑO':
                $meses_ES = array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Agos", "Sept", "Oct", "Nov", "Dic");
                $mes = date('F', strtotime($fecha));
                $anio = date('Y', strtotime($fecha));
               
                $nombreMesanio = str_replace($meses_EN, $meses_ES, $mes).'-'.$anio;
                break;
            
            case 'Dia-mes-Año':
                $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                $dia = date('L', strtotime($fecha));
                $mes = date('F', strtotime($fecha));
                $anio = date('Y', strtotime($fecha));
               
                $nombreMesanio = $dia.'-'.str_replace($meses_EN, $meses_ES, $mes).'-'.$anio;
                break;
            default:
                # code...
                break;
        }
       
        return  $nombreMesanio ;
    }
}

