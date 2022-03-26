<?php

namespace App\Exports;

use App\Models\NomActividadesTrabajador;
use App\Models\NomFaltasTrabajador;
use App\Models\NomPermisosTrabajador;

use App\Utils\DateUtils;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;

//clientes
use App\Models\CliClientes;
use App\Models\CliMaquinas;
use App\Models\DataEntes;
use App\Utils\Rut;

class ListadoClientesExportExcel implements FromCollection, WithHeadings, WithEvents
{

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $s = $event->sheet->getDelegate();
                $s->getColumnDimension('A')->setWidth(15);
                $s->getColumnDimension('B')->setWidth(15);
                $s->getColumnDimension('C')->setWidth(15);
                $s->getColumnDimension('D')->setWidth(15);
                $s->getColumnDimension('E')->setWidth(30);
                $s->getColumnDimension('F')->setWidth(25);
                $s->getColumnDimension('G')->setWidth(25);
                $s->getColumnDimension('H')->setWidth(25);
                $s->getStyle('G2:G9999')->getAlignment()->setWrapText(true);
                $s->getStyle('A1:G1')->getFont()->setBold(true);
            }
        ];
    }


    public function headings(): array
    {

        return [
            'Código',
            'Rut',
            'Cliente',
            'Teléfono(s)',
            'Contacto',
            'Segmento',
            'Estatus',
        ];
    }
    public function collection()
    {
     

        $clientes = CliClientes::with([
            'data_entes',
            'eq_segmentos',
        ])->orderBy('ccliente', 'DESC')->get();

        
       return $clientes->map(function ($c) {
            
            return [
                'codigo' => $c->ccliente,
                'rut' => Rut::format($c->data_entes->code),
                'nombre' => $c->data_entes->data == '' ? 'N/A' : $c->data_entes->data,
                'telefonos' => $c->data_entes->tel_fijo . ' ' . $c->data_entes->tel_movil,
                'contacto' => $c->contacto,
                'segmento' => $c->eq_segmentos->segmento,
                'estatus' => $c->estatus,

            ];
        });

    }
}

