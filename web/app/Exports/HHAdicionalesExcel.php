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

class HHAdicionalesExcel implements FromCollection, WithHeadings, WithColumnFormatting, WithEvents
{
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $s = $event->sheet->getDelegate();
                $s->getColumnDimension('A')->setWidth(10);
                $s->getColumnDimension('B')->setWidth(12);
                $s->getColumnDimension('C')->setWidth(16);
                $s->getColumnDimension('D')->setWidth(16);
                $s->getColumnDimension('F')->setWidth(40);
                $s->getColumnDimension('G')->setWidth(60);
                $s->getStyle('G2:G9999')->getAlignment()->setWrapText(true);
                $s->getStyle('A1:G1')->getFont()->setBold(true);
            }
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => 'yyyy-mm-dd hh:mm',
            'D' => 'yyyy-mm-dd hh:mm',
            'E' => '0.0'
        ];
    }

    public function headings(): array
    {
        return [
            'Registro',
            'Tipo',
            'Fecha inicio',
            'Fecha fin',
            'Horas',
            'Trabajador',
            'Descripción'
        ];
    }
    public function collection()
    {
        $permisos = NomPermisosTrabajador::with('nom_trabajadores.data_entes')->whereActivo(true)->get();
        $faltas = NomFaltasTrabajador::with('nom_trabajadores.data_entes')->whereActivo(true)->get();
        $actividades = NomActividadesTrabajador::with(['nom_actividades.nom_tipo_actividad', 'nom_trabajadores.data_entes'])
            ->whereHas('nom_actividades', function ($x) {
                $x->whereActivo(true);
            })->whereActivo(true)->get();

        $permisos = $permisos->map(function ($x) {
            /** @var \App\Models\NomPermisosTrabajador $x */
            return [
                'registro' => 'Permiso',
                'tipo' => NomPermisosTrabajador::mapEstado($x->tipo),
                'fecha_inicio' => DateUtils::carbonToExcel($x->fecha),
                'fecha_fin' => DateUtils::carbonToExcel($x->fecha->clone()->addHours($x->horas)),
                'horas' => $x->horas,
                'trabajador' => $x->nom_trabajadores->data_entes->data,
                'descripcion' => ''
            ];
        })->toArray();

        $faltas = $faltas->map(function ($x) {
            /** @var \App\Models\NomFaltasTrabajador $x */
            return [
                'registro' => 'Ausencia',
                'tipo' => NomFaltasTrabajador::mapEstado($x->tipo),
                'fecha_inicio' => DateUtils::carbonToExcel($x->fecha_inicio),
                'fecha_fin' => DateUtils::carbonToExcel($x->fecha_fin),
                'horas' => ($x->nom_trabajadores->horas / 5) * ($x->fecha_inicio->diffInDays($x->fecha_fin)),
                'trabajador' => $x->nom_trabajadores->data_entes->data,
                'descripcion' => ''
            ];
        })->toArray();

        $actividades = $actividades->map(function ($x) {
            /** @var \App\Models\NomActividadesTrabajador $x */
            return [
                'registro' => 'Actividad',
                'tipo' => ucfirst(mb_strtolower($x->nom_actividades->nom_tipo_actividad->nombre)),
                'fecha_inicio' => DateUtils::carbonToExcel($x->nom_actividades->fecha),
                'fecha_fin' => DateUtils::carbonToExcel($x->nom_actividades->fecha->addHours($x->nom_actividades->horas)),
                'horas' => $x->nom_actividades->horas,
                'trabajador' => $x->nom_trabajadores->data_entes->data,
                'descripcion' => $x->nom_actividades->descripcion
            ];
        })->toArray();

        $collection = collect(array_merge($permisos, $faltas, $actividades));
        $collection = $collection->sortByDesc(function ($x) {
            return $x['fecha_inicio'];
        });

        return $collection;
    }
}
