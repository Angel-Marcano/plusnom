<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;
use App\Models\calculation_data;

class CalculationDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Data_empleados=[
            'BI'=>[
                    '1'=>7.00,
                    '2'=>7.14,
                    '3'=>7.28,
                    '4'=>7.42,
                    '5'=>7.56,
                    '6'=>7.70,
                    '7'=>7.84
                ],
            
            'BII'=>[
                    '1'=>8.40,
                    '2'=>8.54,
                    '3'=>8.68,
                    '4'=>8.82,
                    '5'=>8.96,
                    '6'=>9.10,
                    '7'=>9.24
                ],
    
            'BIII'=>[
                    '1'=>9.80,
                    '2'=>9.94,
                    '3'=>10.08,
                    '4'=>10.22,
                    '5'=>10.36,
                    '6'=>10.50,
                    '7'=>10.64
                ],
    
            'TI'=>[
                    '1'=>11.76,
                    '2'=>11.90,
                    '3'=>12.04,
                    '4'=>12.18,
                    '5'=>12.32,
                    '6'=>12.46,
                    '7'=>12.60
                ],
            
            'TII'=>[
                    '1'=>13.72,
                    '2'=>13.86,
                    '3'=>14.00,
                    '4'=>14.14,
                    '5'=>14.28,
                    '6'=>14.42,
                    '7'=>14.56
                ],
            'PI'=>[
                    '1'=>15.96,
                    '2'=>16.10,
                    '3'=>16.24,
                    '4'=>16.38,
                    '5'=>16.52,
                    '6'=>16.66,
                    '7'=>16.80
                ],
            
            'PII'=>[
                    '1'=>18.20,
                    '2'=>18.34,
                    '3'=>18.48,
                    '4'=>18.62,
                    '5'=>18.76,
                    '6'=>18.90,
                    '7'=>19.04
                ],
    
            'PIII'=>[
                    '1'=>20.44,
                    '2'=>20.58,
                    '3'=>20.72,
                    '4'=>20.86,
                    '5'=>21.00,
                    '6'=>21.14,
                    '7'=>21.28
                ],
    
            ];

        $Data_obreros=[
                'MINIMO'=>[
                        '1' =>7.00,
                        '2' =>7.74,
                        '3' =>8.49,
                        '4' =>9.23,
                        '5' =>9.97,
                        '6' =>10.71,
                        '7' =>11.45,
                        '8' =>12.19,
                        '9' =>12.94,
                        '10'=>13.68,
                    ],
                
                'MAXIMO'=>[
                        '1' =>7.18,
                        '2' =>7.92,
                        '3' =>8.67,
                        '4' =>9.41,
                        '5' =>10.15,
                        '6' =>10.89,
                        '7' =>11.63,
                        '8' =>12.38,
                        '9' =>13.12,
                        '10'=>13.86,
                    ],
                ];
        $Data_antiquity=[
                    '0' =>0,
                    '1' =>2,
                    '2' =>4,
                    '3' =>6,
                    '4' =>8,
                    '5' =>10,
                    '6' =>12,
                    '7' =>15,
                    '8' =>17,
                    '9' =>20,
                    '10'=>22,
                    '11'=>25,
                    '12'=>28,
                    '13'=>30,
                    '14'=>33,
                    '15'=>36,
                    '16'=>39,
                    '17'=>42,
                    '18'=>46,
                    '19'=>49,
                    '20'=>52,
                    '21'=>56,
                    '22'=>59,
                    '23'=>60,
            ];
        $Data_managers=[
                'Ministros' =>31.36,
                'Viceministros' =>29.88,
                'Maxima_autoridad' =>28.48,
                'Director_general' =>27.08,
                'Director_linea' =>25.90,
                'Jefe' =>24.92,
                'Coodinador' =>23.80,
        ];

        $Data_profession=[
                'BACHILLER'   =>0,
                'TSU'         =>20,
                'PROFESIONAL' =>30,
                'ESPECIALISTA'=>40,
                'MAESTRIA'    =>50,
                'DOCTOR'      =>60
        ];

        $Data_Standard_bonus=[
            'feeding' =>3,
            'Standard'     =>1.75,
        ];

        
        calculation_data::create([
            'type_data' => 'Employee',
            'data' => json_encode($Data_empleados),
        ]);

        calculation_data::create([
            'type_data' => 'Worker',
            'data' => json_encode($Data_obreros),
        ]);

        calculation_data::create([
            'type_data' => 'Antiquity',
            'data' => json_encode($Data_antiquity),
        ]);

        calculation_data::create([
            'type_data' => 'Managers',
            'data' => json_encode($Data_managers),
        ]);

        calculation_data::create([
            'type_data' => 'Profession',
            'data' => json_encode($Data_profession),
        ]);

        calculation_data::create([
            'type_data' => 'Standard_bonus',
            'data' => json_encode($Data_Standard_bonus),
        ]);

/*
        calculation_data::create([
            'type_data' => 'Empleado',
            'data' => json_encode($Data_empleados),
        ]);

        */
    
        
        
    }
}
