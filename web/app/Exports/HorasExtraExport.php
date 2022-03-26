<?php

namespace App\Exports;

use App\Models\CoCotizacionSub;
use App\Models\CoPlanificacion;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class HorasExtraExport implements FromCollection, WithHeadings, WithEvents
{

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $s = $event->sheet->getDelegate();
                $s->getColumnDimension('A')->setWidth(10);
                $s->getColumnDimension('B')->setWidth(10);
                $s->getColumnDimension('C')->setWidth(30);
                $s->getColumnDimension('D')->setWidth(30);
                $s->getColumnDimension('E')->setWidth(15);
                $s->getColumnDimension('F')->setWidth(25);
                $s->getColumnDimension('G')->setWidth(25);
                $s->getColumnDimension('H')->setWidth(15);
                $s->getColumnDimension('I')->setWidth(30);
                $s->getColumnDimension('J')->setWidth(35);

                $s->getStyle('I2:I9999')->getAlignment()->setWrapText(true);
                $s->getStyle('A1:J1')->getFont()->setBold(true);
            }
        ];
    }


    public function headings(): array
    {
        return [
            'COT',
            'OS',
            'Primer responsable técnico',
            'Último responsable técnico',
            'Horas cotizadas',
            'Horas extra mes actual',
            'Horas extra acumuladas',
            'Total horas extra',
            'Cumplimiento',
            'Asesor comercial'
        ];
    }

    public function collection()
    {
        $subcots = CoCotizacionSub::with([
            'co_planificacion.co_planificacion_det',
            'par_eq_trabajo',
            'adm_usuarios.nom_trabajadores.data_entes',
            'co_cotizacion.adm_nave_cotizacion' => function ($q) {
                $q->with(['nom_trabajadores.data_entes'])->whereHas('nom_trabajadores');
            }
        ])->get();

        $inicio_mes = new Carbon('first day of this month');
        $fin_mes = new Carbon('first day of next month');

        $subcots = $subcots->filter(function ($subcot) use ($inicio_mes, $fin_mes) {
            $plans = $subcot->co_planificacion;
            $plans_anteriores = $plans->where('finicio', '<', $inicio_mes);
            $plans_mes_actual = $plans->where('finicio', '>=', $inicio_mes)->where('ffin', '<', $fin_mes);
            $horas_acumuladas = $plans_anteriores->sum(function ($x) {
                return $this->calcularHorasExtra($x);
            });
            $horas_extra = $plans_mes_actual->sum(function ($x) {
                return $this->calcularHorasExtra($x);
            });

            return $horas_acumuladas > 0 || $horas_extra > 0;
        })->sortByDesc(function ($subcot) {
            return $subcot->co_cotizacion->crea_date;
        });


        return $subcots->map(function ($subcot) use ($inicio_mes, $fin_mes) {
            /** @var \App\Models\CoCotizacionSub $subcot */
            $plans = $subcot->co_planificacion;
            $equipo = $subcot->par_eq_trabajo;
            $cot = $subcot->co_cotizacion;
            $trabajo_naves = $cot->adm_nave_cotizacion;

            $primer_responsable = $trabajo_naves->count() > 0 ? $trabajo_naves->first()->nom_trabajadores->data_entes->data : 'N/A';
            $ultimo_responsable = $trabajo_naves->count() > 0 ? $trabajo_naves->last()->nom_trabajadores->data_entes->data : 'N/A';
            $crea_user = $subcot->adm_usuarios;
            $asesor = $crea_user && $crea_user->nom_trabajadores ? $crea_user->nom_trabajadores->data_entes->data : 'N/A';

            $plans_anteriores = $plans->where('finicio', '<', $inicio_mes);
            $plans_mes_actual = $plans->where('finicio', '>=', $inicio_mes)->where('ffin', '<', $fin_mes);
            $horas_extra = $horas_acumuladas = 0;
            $horas_acumuladas = $plans_anteriores->sum(function ($x) {
                return $this->calcularHorasExtra($x);
            });
            $horas_extra = $plans_mes_actual->sum(function ($x) {
                return $this->calcularHorasExtra($x);
            });

            return [
                'cot' => str_pad($cot->ccotizacion, 3, '0') . '-' . $subcot->correlativo,
                'os' => $cot->cordenservicio > 0 && $subcot->cordenservicio_sub != null ?
                    str_pad($cot->cordenservicio, 3, '0') . '-' . $subcot->cordenservicio_sub : 'N/A',
                'primer_responsable' => $primer_responsable,
                'ultimo_responsable' => $ultimo_responsable,
                'horas_cotizadas' => strval($equipo->trabs * $subcot->hh_tecnico),
                'horas_extra' => strval($horas_extra),
                'horas_acumuladas' => strval($horas_acumuladas),
                'total_horas' => strval($horas_acumuladas + $horas_extra),
                'cumplimiento' => '',
                'asesor' => $asesor
            ];
        });
    }

    public function calcularHorasExtra(CoPlanificacion $x)
    {
        // Si es fin de semana, se cuenta el periodo completo como extra
        if ($x->finicio->dayOfWeek == 0 || $x->finicio->dayOfWeek == 6) {
            return $x->finicio->diffInMinutes($x->ffin) / 60;
        }

        $inicio_jornada = $x->finicio->copy()->startOfDay()->hour(8)->minute(30);
        $fin_jornada = $x->finicio->copy()->startOfDay()->hour(17)->minute(30);

        // O si está fuera de la jornada laboral 8:30-17:30
        // if ($x->finicio >= $inicio_jornada && $x->ffin <= $fin_jornada) {
        //     return 0;
        // }
        $horas = 0;
        if ($x->finicio < $inicio_jornada) {
            $horas += $inicio_jornada->diffInMinutes($x->finicio) / 60;
        }
        if ($x->ffin < $fin_jornada) {
            $horas += $fin_jornada->diffInMinutes($x->ffin) / 60;
        }
        return $horas;
    }
}
