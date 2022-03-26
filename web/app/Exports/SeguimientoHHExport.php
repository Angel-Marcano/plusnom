<?php

namespace App\Exports;

use App\Models\CoPlanificacion;
use App\Utils\Rut;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use App\Http\Resources\Data\HH_tecnicos;

class SeguimientoHHExport implements FromCollection, WithHeadings, WithColumnFormatting, WithEvents
{
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $s = $event->sheet->getDelegate();
                $s->getColumnDimension('A')->setWidth(15);
                $s->getColumnDimension('B')->setWidth(10);
                $s->getColumnDimension('C')->setWidth(10);
                $s->getColumnDimension('D')->setWidth(15);
                $s->getColumnDimension('E')->setWidth(30);
                $s->getColumnDimension('F')->setWidth(40);
                $s->getColumnDimension('G')->setWidth(30);
                $s->getColumnDimension('H')->setWidth(15);
                $s->getColumnDimension('I')->setWidth(20);
                $s->getColumnDimension('J')->setWidth(20);
                $s->getColumnDimension('K')->setWidth(20);
                $s->getColumnDimension('L')->setWidth(20);
                $s->getColumnDimension('M')->setWidth(20);
                $s->getColumnDimension('N')->setWidth(15);
                $s->getColumnDimension('O')->setWidth(15);
                $s->getColumnDimension('P')->setWidth(15);
                $s->getColumnDimension('Q')->setWidth(15);
                $s->getColumnDimension('R')->setWidth(80);
                $s->getColumnDimension('S')->setWidth(80);

                $s->getStyle('G2:G9999')->getAlignment()->setWrapText(true);
                $s->getStyle('A1:S1')->getFont()->setBold(true);
            }
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => 'yyyy-mm-dd',
        ];
    }

    public function headings(): array
    {
        return [
            'Fecha planificación',
            'COT',
            'OS',
            'Estado OS',
            'Tipo',
            'Técnico',
            'Razón social',
            'Rut',
            'Equipo',
            'Modelo',
            'Marca',
            'N° Serie',
            'Lugar',
            'HH Estimadas',
            'HH Planificadas',
            'HH por planificar',
            'Avance (%)',
            'Observaciones cotización',
            'Observaciones planificación'
        ];
    }

    public function collection()
    {



        $plans = CoPlanificacion::with([
            'co_cotizacion_sub.co_tipos',
            'co_cotizacion_sub.par_lugar',
            'co_cotizacion_sub.par_eq_trabajo',
            'co_cotizacion_sub.co_cotizacion',
            'co_cotizacion_sub.co_cotizacion.cli_maquinas',
            'co_cotizacion_sub.co_cotizacion.cli_maquinas.cli_clientes',
            'co_cotizacion_sub.co_cotizacion.cli_maquinas.cli_clientes.data_entes',
            'co_cotizacion_sub.co_cotizacion.cli_maquinas.eq_equipos',
            'co_cotizacion_sub.co_cotizacion.cli_maquinas.eq_equipos.eq_marcas',
            'co_cotizacion_sub.co_cotizacion_sub_det.par_eq_trabajo',
            'co_planificacion_det',
            'co_planificacion_det.co_planificacion',
            'co_planificacion_det.nom_trabajadores',
            'co_planificacion_det.nom_trabajadores.data_entes'
        ])
            // ->join('co_planificacion_det', 'co_planificacion_det.cplanificacion', '=', 'co_planificacion.cplanificacion')
            ->where('status', 1)
            // ->where('cordenservicio_sub', '726')
            // ->where('co_planificacion.cplanificacion', '2369')
            ->orderByDesc('cordenservicio_sub')
            ->orderBy('finicio')
            ->get();

        $totalPorPlanificar = 0;
        $totalPorcentPlanificado = 0;
        $servicioAnterior = null;

        /** @var \App\Models\CoPlanificacion */
        return $plans->map(function ($p) use (&$totalPorPlanificar, &$servicioAnterior, &$totalPorcentPlanificado) {
            $cs = $p->co_cotizacion_sub;
            $tipo = $cs->co_tipos;
            $cot = $cs->co_cotizacion;
            $maquina = $cot->cli_maquinas;
            $cliente = $maquina->cli_clientes;
            $equipo = $maquina->eq_equipos;

            $horas_cotizadas = $cs->co_cotizacion_sub_det->sum(function ($hh) {
                if (isset($hh->par_eq_trabajo->trabs)) {
                    $total = $hh->horas_hombres_tecnico * $hh->par_eq_trabajo->trabs;
                    return $total;
                }
        
                if ($hh->numero_trabajadores_especialistas > 0) {
                    $total = $hh->horas_hombres_tecnico * $hh->numero_trabajadores_especialistas;
                    return $total;
                }
        
            });


            $cordenservicio = $cot->cordenservicio . '-' . $cs->correlativo;
            if ($servicioAnterior != $cordenservicio) {
                $totalPorPlanificar = $horas_cotizadas;
                $servicioAnterior = $cordenservicio;
                $totalPorcentPlanificado = 0;
            }

            // TODO: Contar colación
            $detCount = $p->co_planificacion_det->count();
            $mapped = [];
            foreach ($p->co_planificacion_det as $t) {
                $col = $t->col;
                $ocupadas = ($p->ffin->diffInMinutes($p->finicio) - $col) / 60;

                if (($servicioAnterior == $cordenservicio)) {
                    $totalPorPlanificar = ($totalPorPlanificar - $ocupadas);
                    $totalPorcentPlanificado += floatval($horas_cotizadas) == 0 ? 0 : (bcdiv((floatval($ocupadas) / floatval($horas_cotizadas)) * 100, '1', 2));
                }
                $data = [
                    'Fecha_planificación'           => date('Y-m-d', strtotime($p->finicio)),
                    'COT'                           => $cot->ccotizacion . '-' . $cs->correlativo,
                    'OS'                            => $cot->cordenservicio . '-' . $cs->cordenservicio_sub,
                    'Estado_OS'                     => $cs->status === 'PRO' ? "PROCESADO" : "FACTURADO",
                    'Tipo'                          => $tipo->tipo,
                    'Técnico'                       => $t->nom_trabajadores->data_entes->data,
                    // 'Técnico'                       => $t->ctrabajador,
                    'Razón_social'                  => $cliente->data_entes->data,
                    'Rut'                           => Rut::Format($cliente->data_entes->code),
                    'Equipo'                        => $equipo->equipo,
                    'Modelo'                        => $equipo->modelo,
                    'Marca'                         => $equipo->eq_marcas->marca,
                    'N_Serie'                       => $maquina->serial,
                    'Lugar'                         => $cs->par_lugar->lugar,
                    'Modelo'                        => $equipo->modelo,
                    'Marca'                         => $cot->cordenservicio,
                    'Lugar'                         => $servicioAnterior,
                    'HH_Estimadas'                  => floatval($horas_cotizadas),
                    'HH_Planificadas'               => floatval($ocupadas),
                    'HH_Por_planificar'             => floatval($totalPorPlanificar),
                    'Avance'                        => floatval($totalPorcentPlanificado) . " %",
                    'Observaciones_cotización'      => $cs->notas,
                    'Observaciones_planificación'   => $t->co_planificacion->notas
                ];
                $mapped[] = $data;
            }
            return $mapped;
        });
    }
}
