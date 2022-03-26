<?php

namespace App\Exports;


use App\Utils\DateUtils;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class OpClienteFacturasExcel implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, WithEvents
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
                $s->getColumnDimension('E')->setWidth(40);
                $s->getColumnDimension('F')->setWidth(14);
                $s->getColumnDimension('G')->setWidth(18);
                $s->getColumnDimension('H')->setWidth(24);
                $s->getColumnDimension('I')->setWidth(18);
                

                $s->getStyle('C2:C9999')->getAlignment()->setWrapText(true);
                $s->getStyle('D2:D9999')->getAlignment()->setWrapText(true);
                $s->getStyle('K2:K9999')->getAlignment()->setWrapText(true);
                $s->getStyle('L2:L9999')->getAlignment()->setWrapText(true);
                $s->getStyle('A1:O1')->getFont()->setBold(true);
                

            }
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => 'yyyy-mm-dd',
            'G' => '0.00',
            'H' => '0.00',
          //  'I' => 'yyyy-mm-dd',
        ];
    }

    public function headings(): array
    {
        return [
            'COT',
            'Correlativo de facturacion',
            'N factura',
            'Fecha factura',
            'Cliente',
            'Rut',
            'Neto total',
            'Total neto facturado',
            'Estado'
        ];
    }

    public function map($e): array
    {
        /** @var \App\Models\ServTrackSolicitudCompras $e */
        return [
            'COT'                          => $e["cot"]."/".$e["os"],
            'Correlativo de facturacion'   => $e["correlativo"],
            'N factura'                    => $e["factura"]===null ? "N/A":$e["factura"],
            'Fecha factura'                => $e["fecha_fac"]===null ? "N/A":$e["fecha_fac"],
            'Cliente'                      => $e["cliente"],
            'Rut'                          => $e["rut"],
            'Neto total'                   => "$".$e["neto_sub"],
            'Total neto facturado'         => $e["neto"]===null ? "-":"$".$e["neto"],
            'Estado'                       => $e["status"]==='PRO' ? "POR FACTURAR" : "FACTURADO"
          
        ];
    }

    public function collection()
    {
        return $this->data;
    }
}
