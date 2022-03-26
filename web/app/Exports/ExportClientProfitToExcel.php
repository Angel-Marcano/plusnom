<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportClientProfitToExcel implements FromCollection, WithEvents, WithHeadings
{

    protected $response;
    public function __construct($response)
    {
        $this->response = $response;
    }

    public function headings(): array
    {

        return [
            "CÓDIGO",
            "CLIENTE",
            "SEGMENTO",
            "CANTIDAD ODS",
            "HH VENDIDAS",
            "HH PLANIFICADAS",
            "INSUMOS",
            "% INSUMOS",
            "REPUESTOS",
            "%REPUESTOS",
            "MAESTRANZA /STT",
            "% MAESTRANZA",
            'HH INSTALACIÓN',
            '% HH INSTALACIÓN',
            'RENTABILIDAD TOTAL',
            'COSTO',
            'TOTAL NETO'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // define el ancho de la columna
                $widths = [
                    'A' => 20,
                    'B' => 35,
                    'C' => 35,
                    'D' => 15,
                    'E' => 20,
                    'F' => 20,
                    'G' => 25,
                    'H' => 25,
                    'I' => 25,
                    'J' => 25,
                    'K' => 25,
                    'L' => 25,
                    'M' => 25,
                    'N' => 25,
                    'O' => 25,
                    'P' => 25,
                    'Q' => 25,
                ];
                foreach ($widths as $k => $v) {
                    // establecer ancho de columna
                    $event->sheet->getDelegate()->getColumnDimension($k)->setWidth($v);
                }
            },
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->response;
    }
}
