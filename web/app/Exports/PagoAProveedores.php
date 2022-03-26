<?php

namespace App\Exports;

use App\Http\Controllers\Legacy\ParametrosController;
use App\Http\Controllers\Transactions\OrdenesCompra;
use App\Models\AdmParametro;
use App\Models\ComOrdenCompra;
use App\Models\Empresa;
use App\Models\ProProveedores;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Utils\AppConstants;
use Request;

class PagoAProveedores implements FromCollection, WithHeadings, WithEvents
{
    protected $response;
    public function __construct($response)
    {
        $this->response = json_decode($response->getContent());
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {

        return [
            'CORRELATIVO',
            'ESTADO',
            'Nº FACTURA O BH',
            'OC',
            'RAZÓN SOCIAL',
            'RUT',
            'FECHA EMISIÓN',
            'FECHA VENCIMIENTO',
            'FORMA DE PAGO',

            'TOTAL A PAGAR',
            'PENDIENTE DE PAGO',
            'MONTO ABONADO',

            //'CONCEPTO',
            'FECHA DE PAGO',
            //'GLOSA DE',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // define el ancho de la columna
                $widths = [
                    'A' => 15,
                    'B' => 20,
                    'C' => 20,
                    'D' => 15,
                    'E' => 35,
                    'F' => 20,
                    'G' => 20,
                    'H' => 20,
                    'I' => 20,
                    'J' => 20,
                    'K' => 20,
                    'L' => 15,
                    'M' => 20,
                    //'N' => 15,
                    //'O' => 20,
                ];
                foreach ($widths as $k => $v) {
                    // establecer ancho de columna
                    $event->sheet->getDelegate()->getColumnDimension($k)->setWidth($v);
                }
            },
        ];
    }
    public function collection()
    {
        $response = new Collection();
        $iva  = AdmParametro::where('parametro', 'VALOR_IMP')->first()->valor / 100;

        $params = AppConstants::toArray([
            'impuesto' => 'VALOR_IMP'
        ]);

        foreach ($this->response as $r) {
            $res = 0;

            $total_pagar = 0;
            $abonado = 0;

            foreach ($r->subordenes as $value) {
                $total_pagar += $value->costo_total;
            }

            if (count($r->pago_proveedor->abonos)) {

                $formaPago = $r->pago_proveedor->abonos[0]->forma_pago_nombre;

                foreach ($r->pago_proveedor->abonos as $value) {
                    $abonado += $value->amount;
                }

            }
            
            $response->push((object)[
                $r->id,
                $r->pago_proveedor->status == "PAG" ? "PAGADO" : "PENDIENTE",
                implode(", ", $r->inventario),
                $r->id,
                $r->proveedor->nombre,
                $r->proveedor->rut,
                $r->fecha_solicitud ? date('d-m-Y', strtotime($r->fecha_solicitud)) : "",
                $r->fecha_entrega ? date('d-m-Y', strtotime($r->fecha_entrega)) : "",
                $r->forma_pago = $formaPago,
                $r->total_pagar = round((1 + $params["impuesto"]/100) * $total_pagar),
                $r->pendiente_pago = round((1 + $params["impuesto"]/100) * $total_pagar) - $abonado,
                $r->abonado = $abonado,
                $r->pago_proveedor->fecha ? date('d-m-Y', strtotime($r->pago_proveedor->fecha)) : "",
            ]);
            $formaPago = "";
        }
        return $response;
    }
}
