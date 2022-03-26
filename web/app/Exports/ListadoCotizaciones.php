<?php

namespace App\Exports;

use App\Models\CoCotizacion;
use App\Models\ComCotSer;
use App\Models\ServItemSolicitudArticulos;
use App\Utils\CotStatus;
use App\Utils\RequestUtils;
use Carbon\Carbon;

use App\Models\ParArriendoTaller;
use App\Models\ParValorHh;
use App\Models\ParEqTrabajo;
use App\Models\ParLugar;
use App\Models\ParVehiculos;
use App\Models\CoCotizacionSub;
use App\Utils\AppConstants;

use DB;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Request;

class ListadoCotizaciones implements FromCollection, WithHeadings, WithColumnFormatting, WithEvents, ShouldAutoSize
{

    protected $data;

    function __construct($data)
    {
        $this->data = $data;
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $s = $event->sheet->getDelegate();
                $s->mergeCells('A1:G1'); //Cotización
                $s->mergeCells('H1:L1'); //Planificación
                $s->mergeCells('M1:P1'); //Horas
                $s->mergeCells('Q1:W1'); //Facturación
                $s->mergeCells('X1:Y1'); //Instalación
                $s->mergeCells('Z1:AC1');
                $s->mergeCells('AD1:AG1');
                $s->mergeCells('AH1:AK1');
                $s->mergeCells('AL1:AO1');
                $s->getStyle('G2:G9999')->getAlignment()->setWrapText(true);
                $s->getStyle('A1:AO1')->getFont()->setBold(true);
                $s->getStyle('A1:AO1')->getAlignment()->setHorizontal('center');
                // $s->getStyle('S1:AO1')->getNumberFormat();
            }
        ];
    }

    public function columnFormats(): array
    {
        return [
            // 'X' => 'yyyy-mm-dd',
        ];
    }

    public function headings(): array
    {
        return [
            [
                'COTIZACION',
                '',
                '',
                '',
                '',
                '',
                '',
                'PLANIFICACION',
                '',
                '',
                '',
                '',
                'HORAS',
                '',
                '',
                '',
                'FACTURACION',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                // '', //Instalacion
                'REPUESTOS',
                '',
                '',
                '',
                'INSUMOS',
                '',
                '',
                '',
                'MAESTRANZA',
                '',
                '',
                '',
                'OTROS',
            ],
            [
                '# COT',
                '# ODS',
                'Tipo de COT',
                'Cliente',
                'Equipo',
                'Asesor Comercial',
                'Estado Orden',
                'Coordinador Tecnico',
                'Fecha Inicio Prog',
                'Fecha Fin Prog',
                'Fecha Inicio Serv',
                'Fecha Ultimo Serv',
                'Avance',
                'COT',
                'UTIL',

                'ADIC',
                'Factura',
                'Fecha Fac',

                'Subtotal',
                'Descuento',

                'Valor Neto',
                'Impuesto',
                'Valor Bruto',

                // 'Valor HH',
                'Descuento %',
                'Total Instalacion',
                'Costo',
                'Margen',
                'Descuento %',
                'Total',
                'Costo',
                'Margen',
                'Descuento %',
                'Total',
                'Costo',
                'Margen',
                'Descuento %',
                'Total',
                'Descuento otros %',
                'Misceleneo',
                'Traslado',
                'Total otros'
            ]
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $data = $this->data;

        if (!isset($data['fecha_desde']) && !isset($data['fecha_hasta'])) {
            $dateTo = date('d-m-Y');
            $date_new = strtotime('-2 year', strtotime($dateTo));
            $dateFrom = date('d-m-Y', $date_new);

            $data['fecha_desde'] = $dateFrom;
            $data['fecha_hasta'] = $dateTo;
        }

        $cotizaciones = CoCotizacionSub::where('co_cotizacion_sub.status', ($data['status'] == '-1' ? '!=' : '='), $data['status'])
            ->where('co_cotizacion_sub.crea_date', '>=', Carbon::parse($data['fecha_desde'])->format('Y-m-d'))
            ->where('co_cotizacion_sub.crea_date', '<=', Carbon::parse($data['fecha_hasta'])->format('Y-m-d'))
            ->orderBy('corigen', 'Desc')->get();

        return $cotizaciones->map(function ($c) {
            $cots = $c->co_cotizacion;
            $p = $c->co_planificacion;
            $ods = $cots->cordenservicio == 0 || $cots->cordenservicio == '' ? 'N/A' : $cots->cordenservicio . '-' . $c->cordenservicio_sub;
            $equipo_detail = $cots->cli_maquinas->eq_equipos->equipo . ' ' . $cots->cli_maquinas->eq_equipos->eq_marcas->marca . ' ' . $cots->cli_maquinas->eq_equipos->eq_marcas->modelo . ' ' . $cots->cli_maquinas->serial;

            $fecha_inicio_prog = Carbon::parse($c->co_cotizacion_sub_det->min('finicio'))->format('d-m-Y');
            $fecha_fin_prog = Carbon::parse($c->co_cotizacion_sub_det->max('ffin'))->format('d-m-Y');
            $fecha_inicio_serv = $p->count() > 0 ? Carbon::parse($p->min('finicio'))->format('d-m-Y') : 'N/A';
            $fecha_fin_serv = $p->count() > 0 ? Carbon::parse($p->max('ffin'))->format('d-m-Y') : 'N/A';
            $horas_taller = $c->co_cotizacion_sub_det->sum('hh_taller');
            $horas_terreno = $c->co_cotizacion_sub_det->sum('hh_terreno');
            $horas_total = $horas_taller + $horas_terreno;
            $horas_total = $horas_total > 0 ? $horas_total : 0;
            $mins_plan = 0;
            $col_plan = 0;
            $mins_adi = 0;
            $costoHoras = 0;
            $tecnico = 'N/A';
            foreach ($p as $pla) {
                $mins_plan += $pla->adi == 0 ? ($pla->ffin->diffInMinutes($pla->finicio) / 60) : 0;
                $mins_adi += $pla->adi == 1 ? ($pla->ffin->diffInMinutes($pla->finicio) / 60) : 0;
                $col_plan += $pla->adi == 0 ? $pla->co_planificacion_det->sum('col') / 60 : 0;
                $tecnico = $pla->co_planificacion_det->count() > 0 || $pla->co_planificacion_det != null ? $pla->co_planificacion_det->first()->nom_trabajadores->data_entes->data : 'N/A';
            }
            $trabs = $c->par_eq_trabajo->trabs <= 0 || $c->par_eq_trabajo->trabs == '' ? 1 : $c->par_eq_trabajo->trabs;
            $avance =  $horas_total < 1 ? '0' : bcdiv(floatval(((($mins_plan - $col_plan) / $trabs) * 100) / $horas_total), 2);
            $ocupado = $horas_total < 1 ? '0' : bcdiv(floatval(($mins_plan - $col_plan) / $trabs), 2);
            $adic = $horas_total < 1 ? '0' : bcdiv(floatval($mins_adi / $trabs), 2);
            $factura = $c->cfactura > 0 ? $c->cfactura : 'N/A';
            $fecha_factura = $c->cfactura > 0 ? Carbon::parse($c->fecha_fac)->format('d-m-Y') : 'N/A';

            $subTotal = round($c->m_subt);
            $descuentoFactura = $c->m_desc == 0 ? "0" : $c->m_desc;
            $netoFactura = round($c->m_neto);
            $impuestosFactura  = round($c->m_imp);
            $brutoFactura = round($c->m_bruto);

            // $horasHombres = 0;

            $descuentoInstalacion = $c->descuento_servicio_instalacion == 0 ? "0" : round($c->descuento_servicio_instalacion);
            $totalInstalacion = $c->m_serv == 0 ? "0" : round($c->m_serv);

            $descuentoRepuesto = $c->descuento_suministro_repuesto == 0 ? "0" : round($c->descuento_suministro_repuesto);
            $costoRepuesto =  $c->m_rep / (1 + ($c->mar_rep / 100));
            $margenRepuesto = ($c->mar_rep * $costoRepuesto) / 100;
            $totalRepuesto = $c->m_rep == 0 ? "0" : round($c->m_rep);

            $descuentoInsumo = $c->descuento_suministro_repuesto == 0 ? "0" : round($c->descuento_suministro_repuesto);
            $costoInsumo = $c->m_ins / (1 + ($c->mar_ins / 100));
            $margenInsumo = ($c->mar_ins * $costoInsumo) / 100;
            $totalInsumo = $c->m_ins == 0 ? "0" : round($c->m_ins);

            $descuentoServicioTercero = $c->descuento_servicio_maestranza == 0 ? "0" : round($c->descuento_servicio_maestranza);
            $costoServicioTercero = $c->m_stt / (1 + ($c->mar_stt / 100));
            $margenServicioTercero = ($c->mar_stt * $costoServicioTercero) / 100;
            $totalServicioTercero  = $c->m_stt == 0 ? "0" : round($c->m_stt);

            $descuentoOtros   = $c->descuento_otros == 0 ? "0" : round($c->descuento_otros);
            $totalMiscelaneos = $c->m_misc == 0 ? "0" : round($c->m_misc);
            $totalTraslado = $c->m_tra == 0 ? "0" : round($c->m_tra);
            $totalOtros = $totalMiscelaneos + $totalTraslado;
            $totalOtros = $c->totalOtros == 0 ? "0" : $c->totalOtros;


            return [
                '# COT'                 => $c->corigen . '-' . $c->correlativo,
                '# ODS'                 => $ods,
                'Tipo de COT'           => $c->co_tipos->tipo,
                'Cliente'               => $cots->cli_maquinas->cli_clientes->data_entes->data,
                'Equipo'                => $equipo_detail,
                'Asesor Comercial'      => isset($cots->crea_user) ? $cots->crea_user : "",
                'Estado Orden'          => CotStatus::description($c->status),
                'Coordinador Tecnico'   => $tecnico,
                'Fecha Inicio Prog'     => $fecha_inicio_prog,
                'Fecha Fin Prog'        => $fecha_fin_prog,
                'Fecha Inicio Serv'     => $fecha_inicio_serv,
                'Fecha Ultimo Serv'     => $fecha_fin_serv,
                'Avance'                => $avance,
                'COT'                   => $horas_total,
                'UTIL'                  => $ocupado,
                'ADIC'                  => $adic,
                'Factura'               => $factura,
                'Fecha Fac'             => $fecha_factura,

                'Subtotal'              => $subTotal,
                'Descuento'             => $descuentoFactura,
                'Valor Neto'            => $netoFactura,
                'Impuestos'             => $impuestosFactura,
                'Valor Bruto'           => $brutoFactura,

                // 'Horas Hombre'          => $horasHombres == 0 ? "0" : round($horasHombres),

                'Descuento instalacion' => $descuentoInstalacion,
                'Total INS'             => $totalInstalacion,

                'Costo R'               => $costoRepuesto,
                'Margen R'              => $margenRepuesto,
                'Descuento Repuestos'   => $descuentoRepuesto,
                'Total R'               => $totalRepuesto,

                'Costo I'               => $costoInsumo,
                'Margen I'              => $margenInsumo,
                'descuento I'           => $descuentoInsumo,
                'Total I'               => $totalInsumo,

                'Costo ST'              => $costoServicioTercero,
                'Margen ST'             => $margenServicioTercero,
                'Descuento servicio maestranza' => $descuentoServicioTercero,
                'Total ST'              => $totalServicioTercero,

                'Descuento otros'       => $descuentoOtros,
                'Total MSE'             => $totalMiscelaneos,
                'Total TRAS'            => $totalTraslado,
                'Total Otros'           => $totalOtros
            ];
        })->reject(function ($cs) {
            $result = false;
            if ($cs == null) {
                $result = true;
            } elseif (is_array($cs)) {
                if (count($cs) <= 0) {
                    $result = true;
                }
            }
            return $result;
        });
    }


    public function formato($value)
    {
        $fortmatNumber = number_format($value, 0, ".", " ");
        return str_replace(' ', '.', str_replace('.', ',', (string)$fortmatNumber));
    }
}
