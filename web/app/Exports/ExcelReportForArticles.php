<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ExcelReportForArticles implements FromCollection, WithHeadings, WithEvents
{

    protected $response;
    public function __construct($response)
    {
        $this->response = $response;
    }

    public function headings(): array
    {

        return [
            'CODIGO',
            'CODIGO SECUNDARIO',
            'NOMBRE',
            'DESCRIPCIÓN',
            'DESCRIPCIÓN CLASIFICACIÓN',
            'UNIDAD',
            'CANTIDAD',
            'COSTO',
            'PRECIO VENTA',
            'CICLO VENTAS',
            'DETALLES ADICIONALES',
            'CATEGORIA',
            'SUBCATEGORIA',
            'FAMILIA',
            'PORCIÓN',
            'DIAS REVALORIZAR',
            'VENDER SIN STOCK',
            'MONEDA VENTA',
            'MONEDA COSTO',
            'COSTO SUGERIDO',
            'CODIGO PROVEEDOR',
            'TIPO VENTA',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // define el ancho de la columna
                $widths = [
                    'A' => 25,
                    'B' => 25,
                    'C' => 25,
                    'D' => 25,
                    'E' => 25,
                    'F' => 25,
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
                    'R' => 25,
                    'S' => 25,
                    'T' => 25,
                    'U' => 25,
                    'V' => 25,
                    'W' => 25,
                    'X' => 25,
                    'Y' => 25,
                    'Z' => 25,
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
                'codigo'                    => $r->carticulo,
                'codigo_secundario'         => $r->codigo2,
                'nombre'                    => $r->articulo,
                'descripcion'               => $r->descripcion,
                'descripcion_clasificacion' => $r->inv_clasificacion->clasificacion,
                'nombre_unidad'             => $r->inv_unidad_articulo->nombre,
                'cantidad'                  => $r->cantidad ?? 0,
                'costo'                     => $r->costo_prom,
                'precio_venta'              => $r->precio,
                'cicloVentas'               => $r->cicloVentas ?? 0,
                'detail_aditional'          => $r->detail_aditional,
                'categoria'                 => $r->categorias->first()->nombre ?? "",
                'subcategoria'              => $r->subcategorias->first()->nombre ?? "",
                'familia'                   => $r->familias->first()->nombre ?? "",
                'porcion'                   => $r->porcion,
                'diasRevalorizar'           => $r->dias_revalorizar,
                'puede_vender_sin_stock'    => $r->puede_vender_sin_stock,
                'moneda_venta'              => $r->moneda_venta->moneda ?? "",
                'moneda_costo'              => $r->moneda_costo->moneda ?? "",
                'tiene_costo_sugerido'      => $r->tiene_costo_sugerido ? "si" : "no",
                'tiene_codigo_proveedor'    => $r->tiene_codigo_proveedor ? "si" : "no",
                'tipo_venta'                => $r->tipo_venta
            ]);
        }
        return $response;
    }
}
