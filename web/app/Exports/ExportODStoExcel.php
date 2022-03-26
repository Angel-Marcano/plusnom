<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExportODStoExcel implements FromCollection, WithEvents, WithHeadings
{
    protected $response;
    public function __construct($response)
    {
        $this->response = $response;
    }

    public function headings(): array
    {

        return [
            "COTIZACIÓN",
            "ODS",
            "TIPO DE COTIZACIÓN",
            "CLIENTE",
            "SEGMENTO",
            "INICIO",
            "FIN",
            "HH VENDIDAS",
            "FECHA FACTURACIÓN",
            "HH PLANIFICADAS",
            "COSTO",
            "RENTABILIDAD",
            "TOTAL",
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // define el ancho de la columna
                $widths = [
                    'A' => 20,
                    'B' => 15,
                    'C' => 35,
                    'D' => 35,
                    'E' => 25,
                    'F' => 25,
                    'G' => 25,
                    'H' => 25,
                    'I' => 25,
                    'J' => 25,
                    'K' => 25,
                    'L' => 25,
                    'M' => 25,
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
