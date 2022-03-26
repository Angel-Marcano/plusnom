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
use App\Models\InvAlmacen;
use App\Http\Resources\Legacy\ReporteInventario;
use App\Http\Resources\Legacy\ReporteInventarioResource;
use App\Models\InvArticulos;

class InventarioExport implements FromCollection, WithHeadings, WithEvents
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
            'Código interno',
            'N° Parte artículo',
            'Nombre artículo',
            'Tipo de artículo',
            'Descripción artículo',
            'Stock total almacenes',
            'Stock almacén compras',
            'Stock almacén taller',
        ];
    }
    public function collection()
    {
        ReporteInventarioResource::withoutWrapping();
        $arts =  InvArticulos::with(['inv_stock_almacen', 'inv_stock_almacen.inv_almacen', 'inv_clasificacion'])
            ->whereNotIn('cclasificacion', [3, 4])->where('status', 1)->get();

        return $arts->map(function ($q) {
            $stock_total = "";
            foreach ($q->inv_stock_almacen as $item) {
                $stock_total = $item->cantidad;
            }

            return [
                'Código_interno'        => $q->carticulo,
                'N_Parte_artículo'      => $q->codigo2,
                'Nombre_artículo'       => $q->articulo,
                'Tipo_de_artículo'      => $q->inv_clasificacion['clasificacion'],
                'Descripción_artículo'  => $q->descripcion,
                'Stock_total_almacenes' => $stock_total,
            ];
        });
    }
}
