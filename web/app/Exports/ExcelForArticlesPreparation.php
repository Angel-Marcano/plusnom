<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExcelForArticlesPreparation implements FromCollection, WithHeadings, WithEvents
{

    protected $response;
    public function __construct($response)
    {
        $this->response = $response;
    }

    public function headings(): array
    {

        return [
            'SKU PREPARADO',
            'NOMBRE PREPARADO',
            'SKU CONSUMIDOS',
            'NOMBRE CONSUMIDO',
            'UNIDAD',
            'PORCIÓN PRODUCTO',
            'PORCIÓN RECETA',
            'CANTIDAD'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // define el ancho de la columna
                $widths = [
                    'A' => 17,
                    'B' => 40,
                    'C' => 17,
                    'D' => 40,
                    'E' => 17,
                    'F' => 18,
                    'G' => 17,
                    'H' => 17,
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
        $response = new Collection();

        foreach ($this->response as $r) {
            $response->push((object)[
                'SKU_Preparado'     => " ".$r["skuPreparado"],
                'nombre_preparado'  => $r["nombrePreparado"],
                'SKU_consumido'     => " ".$r["skuConsumido"],
                'nombre consumido'  => $r["nombreConsumido"],
                'unidad'            => $r["unidad"],
                'porcion_producto'  => $r["porcionProducto"],
                'porcion_receta'    => $r["porcionConsumido"],
                'cantidad'          => $r["cantidad"]
            ]);
        }
        return $response;
    }
}
