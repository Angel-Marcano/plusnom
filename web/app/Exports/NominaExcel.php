<?php

namespace App\Exports;


use App\Utils\DateUtils;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\calculation_data;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class NominaExcel implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithEvents
{
    private $data;

    public function __construct(iterable $data)
    {
        $this->data = $data;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $s = $event->sheet->getDelegate();
                $s->getColumnDimension('A')->setWidth(40);
                $s->getColumnDimension('B')->setWidth(14);
                $s->getColumnDimension('C')->setWidth(14);
                $s->getColumnDimension('D')->setWidth(30);
                $s->getColumnDimension('E')->setWidth(14);
                $s->getColumnDimension('F')->setWidth(14);
                $s->getColumnDimension('G')->setWidth(18);
                $s->getColumnDimension('H')->setWidth(24);
                $s->getColumnDimension('I')->setWidth(18);
                

                //$s->getStyle('C2:C9999')->getAlignment()->setWrapText(true);
                //$s->getStyle('D2:D9999')->getAlignment()->setWrapText(true);
                //$s->getStyle('K2:K9999')->getAlignment()->setWrapText(true);
                //$s->getStyle('A1:I1')->getAlignment()->setWrapText(true);
                $s->getStyle('A1:Z9')->getFont()->setBold(true);
                

            }
        ];
    }

    public function columnFormats(): array
    {
        return [
           /* 'C' => 'yyyy-mm-dd',
            'D' => 'yyyy-mm-dd',
            'G' => 'yyyy-mm-dd',
            'H' => '0.00',
            'I' => '0.00',*/
        ];
    }

    public function headings(): array
    {
        return [
          
        ];
    }

    public function map($e): array
    {
 
        return [
            
            'COLUMNA1'                => isset($e['COLUMNA1']) ? $e['COLUMNA1'] : "" ,
            'COLUMNA2'                => isset($e['COLUMNA2']) ? $e['COLUMNA2'] : "" ,
            'COLUMNA3'                => isset($e['COLUMNA3']) ? $e['COLUMNA3'] : "" ,
            'COLUMNA4'                => isset($e['COLUMNA4']) ? $e['COLUMNA4'] : "" ,
            'COLUMNA5'                => isset($e['COLUMNA5']) ? $e['COLUMNA5'] : "" ,
            'COLUMNA6'                => isset($e['COLUMNA6']) ? $e['COLUMNA6'] : "" ,
            'COLUMNA7'                => isset($e['COLUMNA7']) ? $e['COLUMNA7'] : "" ,
            'COLUMNA8'                => isset($e['COLUMNA8']) ? $e['COLUMNA8'] : "" ,
            'COLUMNA9'                => isset($e['COLUMNA9']) ? $e['COLUMNA9'] : "" ,
            'COLUMNA10'               => isset($e['COLUMNA10']) ? $e['COLUMNA10'] : "",
            'COLUMNA11'               => isset($e['COLUMNA11']) ? $e['COLUMNA11'] : "",
            'COLUMNA12'               => isset($e['COLUMNA12']) ? $e['COLUMNA12'] : "",
            'COLUMNA13'               => isset($e['COLUMNA13']) ? $e['COLUMNA13'] : "",
            'COLUMNA14'               => isset($e['COLUMNA14']) ? $e['COLUMNA14'] : "",
            'COLUMNA15'               => isset($e['COLUMNA15']) ? $e['COLUMNA15'] : "",
            'COLUMNA16'               => isset($e['COLUMNA16']) ? $e['COLUMNA16'] : "",
            'COLUMNA17'               => isset($e['COLUMNA17']) ? $e['COLUMNA17'] : "",
            'COLUMNA18'               => isset($e['COLUMNA18']) ? $e['COLUMNA18'] : "",
            'COLUMNA19'               => isset($e['COLUMNA19']) ? $e['COLUMNA19'] : "",
            'COLUMNA20'               => isset($e['COLUMNA20']) ? $e['COLUMNA20'] : "",
            'COLUMNA21'               => isset($e['COLUMNA21']) ? $e['COLUMNA21'] : "",
            'COLUMNA22'               => isset($e['COLUMNA22']) ? $e['COLUMNA22'] : "",
            'COLUMNA23'               => isset($e['COLUMNA23']) ? $e['COLUMNA23'] : "",
            'COLUMNA24'               => isset($e['COLUMNA24']) ? $e['COLUMNA24'] : "",
            'COLUMNA25'               => isset($e['COLUMNA25']) ? $e['COLUMNA25'] : "",
            'COLUMNA26'               => isset($e['COLUMNA26']) ? $e['COLUMNA26'] : "",
            'COLUMNA27'               => isset($e['COLUMNA27']) ? $e['COLUMNA27'] : "",
        ];
    }

    public function collection()
    {
        $array=[];

        /* datos para calculos generales*/
        $Bonus_Standard=json_decode(calculation_data::find(6)->data);
        $Antiquity=json_decode(calculation_data::find(3)->data);
        $profession=json_decode(calculation_data::find(5)->data);

        /*datos para calculos empleados */ 
        $data_c=json_decode(calculation_data::find(1)->data);


        /* Emcabezado */ 
        array_push($array,['COLUMNA1' =>"REPUBLICA BOLIVARIANA DE VENEZUELA"]);
        array_push($array,['COLUMNA1' =>"ALCALDIA DEL MUNICIPIO BERMUDEZ"]);
        array_push($array,['COLUMNA1' =>"CARUPANO - ESTADO SUCRE"]);
        array_push($array,['COLUMNA1' =>"NOMINA EMPLEADOS FIJOS"]);
        array_push($array,['COLUMNA1' =>"1RA QCNA ENERO 2022"]);

        array_push($array,['COLUMNA1' =>"Fecha"]);
        array_push($array,['COLUMNA1' =>"fecha"]);
        array_push($array,['COLUMNA1' =>""]);

        array_push($array,[
            
            'COLUMNA1'                => " Cedula ",
            'COLUMNA2'                => " Nombre Y apellido ",
            'COLUMNA3'                => " Cargo ",
            'COLUMNA4'                => " Fecha de Ingreso ",
            'COLUMNA5'                => " Nivel academico ",
            'COLUMNA6'                => " Rango academico ",
            'COLUMNA7'                => " Nivel ",
            'COLUMNA8'                => " Antiguedad ",
            'COLUMNA9'                => " nº de hijos ",
            'COLUMNA10'               => " Sueldo base mensual ",
            'COLUMNA11'               => " Sueldo base quincenal ",
            'COLUMNA12'               => " Prima profesion mensual ",
            'COLUMNA13'               => " Prima profesion quincenal ",
            'COLUMNA14'               => " Prima prima por hijo quincenal ",
            'COLUMNA15'               => " Prima prima de antiguedad % ",
            'COLUMNA16'               => " Prima prima de antiguedad mensual ",
            'COLUMNA17'               => " Prima prima de antiguedad quincenal ",
            'COLUMNA18'               => " Sueldo mensual con asignaciones ",
            'COLUMNA19'               => " Sueldo quincenal con asignaciones ",
            'COLUMNA20'               => " S.S.O ",
            'COLUMNA21'               => " P.F ",
            'COLUMNA22'               => " F.A.O.V ",
            'COLUMNA23'               => " F.P.J ",
            'COLUMNA24'               => " Caja AH ",
            'COLUMNA25'               => " Total deducciones ",
            'COLUMNA26'               => " Total quincenal ",
            'COLUMNA27'               => "  ",
        ]);



        foreach ($this->data as $data) {

            $Employee_Antiquity=date_diff(date_create($data['admission_date']),date_create(date('Y-m-d')) )->y;
            $Employee_Antiquity= $Employee_Antiquity>=23 ? 23: $Employee_Antiquity;
            $Employee_profesional=$data['level_profession'];
            $Grade=$data['grade'];
            $Level=$data['level']; 
            
            
            array_push($array,
            [
            'COLUMNA1' => $data['document'],
            'COLUMNA2' => $data['full_name'],
            'COLUMNA3' => $data['chargue'],
            'COLUMNA4' => $data['admission_date'],
            'COLUMNA5' => $data['level_profession'],
            'COLUMNA6' => $data['grade'],
            'COLUMNA7' => $data['level'],
            'COLUMNA8' => $Employee_Antiquity,
            'COLUMNA9' => $data['number_children'],
            'COLUMNA10'=> $data_c->$Grade->$Level,
            'COLUMNA11'=> $data_c->$Grade->$Level/2,
            'COLUMNA12'=> number_format($data_c->$Grade->$Level*($profession->$Employee_profesional/100),3,',','.'),
            'COLUMNA13'=> number_format(($data_c->$Grade->$Level*($profession->$Employee_profesional/100))/2,3,',','.'),
            'COLUMNA14'=> $data['number_children']*$Bonus_Standard->Standard,
            'COLUMNA15'=> $Antiquity[$Employee_Antiquity].'%',
            'COLUMNA16'=> number_format($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100),3,',','.'),
            'COLUMNA17'=> number_format(($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))/2,3,',','.'),
            'COLUMNA18'=> number_format(($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100)),2,',','.'),
            'COLUMNA19'=> number_format((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100)))/2,2,',','.'),
 /*sso*/    'COLUMNA20'=> ((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *12/52)*0.04*2,  //*12/52)*4%*2
            
 /*pf*/     'COLUMNA21'=> ((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *12/52)*0.005*2,
/*faov*/    'COLUMNA22'=> ((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *0.01/2),
/*fjubi*/   'COLUMNA23'=> ((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *0.03/2),
/*cajaAH*/  'COLUMNA24'=> ((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *0), //caja ahorro disable
            
            'COLUMNA25'=> 
            (((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *12/52)*0.04*2)+
            (((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *12/52)*0.005*2) +
            ((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *0.01/2) +
            ((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *0.03/2) +
            ((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *0) 
            ,
            
            'COLUMNA26'=>
            (($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100)))-
            
            (
            (((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *12/52)*0.04*2)+
            (((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *12/52)*0.005*2) +
            ((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *0.01/2) +
            ((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *0.03/2) +
            ((($data_c->$Grade->$Level)+($data['number_children']*$Bonus_Standard->Standard)+($data_c->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data_c->$Grade->$Level*($profession->$Employee_profesional/100))) *0) 
             
            )


            ]);
        }


        return collect($array);
        
        
        //$this->data; este es el array OJO
    }
}
