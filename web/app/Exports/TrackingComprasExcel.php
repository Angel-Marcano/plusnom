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

class TrackingComprasExcel implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithEvents
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
                $s->getColumnDimension('A')->setWidth(10);
                $s->getColumnDimension('B')->setWidth(14);
                $s->getColumnDimension('C')->setWidth(14);
                $s->getColumnDimension('D')->setWidth(40);
                $s->getColumnDimension('E')->setWidth(14);
                $s->getColumnDimension('F')->setWidth(14);
                $s->getColumnDimension('G')->setWidth(14);
                $s->getStyle('D2:D9999')->getAlignment()->setWrapText(true);
                $s->getStyle('A1:G1')->getFont()->setBold(true);
            }
        ];
    }

    public function columnFormats(): array
    {
        return ['B' => 'yyyy-mm-dd'];
    }

    public function headings(): array
    {
        return ['ID Único', 'Fecha solicitud', 'N° Parte', 'Nombre Parte', 'Cantidad', 'Neto unidad', 'Neto total'];
    }

    public function map($e): array
    {
        /** @var \App\Models\ServTrackSolicitudCompras $e */
        return [
            'id_solicitud' => $e->id,
            'fecha' => DateUtils::carbonToExcel($e->serv_item_solicitud_articulos->serv_solicitud_articulos->crea_date),
            'id_parte' => $e->serv_item_solicitud_articulos->inv_articulos->codigo2,
            'nombre_parte' => $e->serv_item_solicitud_articulos->inv_articulos->articulo,
            'cantidad' => $e->serv_item_solicitud_articulos->cantidad
        ];
    }

    public function collection()
    {
        return $this->data;
    }
}
