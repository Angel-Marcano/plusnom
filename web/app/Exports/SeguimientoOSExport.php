<?php

namespace App\Exports;

use App\Models\CoCotizacionSub;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class SeguimientoOSExport implements FromCollection, WithHeadings, WithEvents
{

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $s = $event->sheet->getDelegate();
                $s->getColumnDimension('A')->setWidth(10);
                $s->getColumnDimension('B')->setWidth(10);
                $s->getColumnDimension('C')->setWidth(15);
                $s->getColumnDimension('D')->setWidth(30);
                $s->getColumnDimension('E')->setWidth(35);
                $s->getColumnDimension('F')->setWidth(30);
                $s->getColumnDimension('G')->setWidth(30);
                $s->getColumnDimension('H')->setWidth(20);
                $s->getColumnDimension('I')->setWidth(20);
                $s->getColumnDimension('J')->setWidth(15);
                $s->getColumnDimension('K')->setWidth(15);
                $s->getColumnDimension('L')->setWidth(15);
                $s->getColumnDimension('M')->setWidth(80);

                $s->getStyle('G2:G9999')->getAlignment()->setWrapText(true);
                $s->getStyle('A1:G1')->getFont()->setBold(true);
            }
        ];
    }


    public function headings(): array
    {
        return [
            'COT',
            'OS',
            'Estado OS',
            'Tipo',
            'Razón Social',
            'Equipo',
            'Modelo',
            'Marca',
            'HH Estimadas',
            'HH Planificadas',
            'HH Por planificar',
            'Avance (%)',
            'Observaciones'
        ];
    }

    public function collection()
    {
        $subservicios = CoCotizacionSub::with([
            'co_tipos',
            'co_cotizacion',
            'co_cotizacion.cli_maquinas',
            'co_cotizacion.cli_maquinas.cli_clientes',
            'co_cotizacion.cli_maquinas.cli_clientes.data_entes',
            'co_cotizacion.cli_maquinas.eq_equipos',
            'co_cotizacion.cli_maquinas.eq_equipos.eq_marcas',
            'co_cotizacion_sub_det.par_eq_trabajo',
            'co_planificacion' => function ($q) {
                $q->whereHas('co_planificacion_det')->where('status', 1);
            },
            'co_planificacion.co_etapa_trabajo',
            'co_planificacion.co_planificacion_det',
            'par_eq_trabajo'
        ])->orderByDesc('corigen')
            ->whereStatus('PRO')
            ->whereHas('co_cotizacion_sub_det', function ($q) {
                $q->where(function ($w) {
                    $w->where('hh_taller', '>', 0)->orWhere('hh_terreno', '>', 0);
                });
            })->get();

        // $mapped = [];
        /** @var \App\Models\CoCotizacionSub */
        return $subservicios->map(function ($s) {
            // foreach ($subservicios as $s) {
            $tipo = $s->co_tipos;
            $cot = $s->co_cotizacion;
            $maquina = $cot->cli_maquinas;
            $cliente = $maquina->cli_clientes;
            $equipo = $maquina->eq_equipos;
            $equipot = $s->par_eq_trabajo;
            $plans = $s->co_planificacion;

            $horas = $s->co_cotizacion_sub_det->sum(function ($x) {
                /** @var \App\Models\CoCotizacionSubDet $x */
                return ($x->hh_taller + $x->hh_terreno) * $x->par_eq_trabajo->trabs ;
            });

            $ocupadas = $plans->sum(function ($x) {
                /** @var \App\Models\CoPlanificacion $x */
                $col = $x->co_planificacion_det->sum(function ($x) {
                    return $x->col;
                });
                return ($x->ffin->diffInMinutes($x->finicio) * $x->co_planificacion_det->count() - $col) / 60;
            });

            $plans_group_etapa = $plans->filter(function ($x) {
                return $x->codigo_etapa_trabajo != 1;
            })->groupBy(function ($x) {
                return $x->codigo_etapa_trabajo;
            });

            $plans_group_map = $plans_group_etapa->map(function ($x) {
                return [
                    'id' => $x[0]->codigo_etapa_trabajo,
                    'nombre' => $x[0]->co_etapa_trabajo->nombre,
                    'cuenta' => $x->sum(function ($x) {
                        $col = $x->co_planificacion_det->sum(function ($x) {
                            return $x->col;
                        });
                        return ($x->ffin->diffInMinutes($x->finicio) * $x->co_planificacion_det->count() - $col) / 60;
                    })
                ];
            })->toArray();

            $cuentas = array_values($plans_group_map);

            // TODO: Contar colación

            return [
                'COT'               => $cot->ccotizacion . " - " . $s->cordenservicio_sub,
                'OS'                => $cot->cordenservicio . " - " . $s->correlativo,
                'Estado_OS'         => $s->status === 'PRO' ? "PROCESADO" : "FACTURADO",
                'Tipo'              => $tipo->tipo,
                'Razón_Social'      => $cliente->data_entes->data,
                'Equipo'            => $equipo->equipo,
                'Modelo'            => $equipo->modelo,
                'Marca'             => $equipo->eq_marcas->marca,
                'HH_Estimadas'      => floatval($horas),
                'HH_Planificadas'   => floatval($ocupadas),
                'HH_Por_planificar' => floatval(0),
                'Avance'            => floatval($horas) === 0 ? 0 : (bcdiv((floatval($ocupadas) / floatval($horas)) * 100, '1', 2)) . " %",
                'Observaciones'     =>  $s->notas
            ];
        });
    }
}
