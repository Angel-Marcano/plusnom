<?php
use App\Models\calculation_data;


function salary_calculator($Employee){

    $Bonus_Standard=json_decode(calculation_data::find(6)->data);
    
    $Antiquity=json_decode(calculation_data::find(3)->data);
   
    $profession=json_decode(calculation_data::find(5)->data);

    $date1=date_create($Employee->admission_date);
    $date2=date_create(date('Y-m-d'));
    $Employee_Antiquity=date_diff($date1,$date2)->y;
    $Employee_profesional=$Employee->level_profession;
    
    if( in_array($Employee->paysheet->id,[3,4])){
        
        $calculation_data=calculation_data::find(1);
                
        $data=json_decode($calculation_data->data);
        $Grade=$Employee->grade;
        $Level=$Employee->level;
       
        $datos=[
            'base'=> $data->$Grade->$Level,
            'children_premium'=> $Employee->number_children*$Bonus_Standard->Standard,
            'antiquity_premium'=> number_format($data->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100),3,',','.'),
            'profession_premium'=> number_format($data->$Grade->$Level*($profession->$Employee_profesional/100),3,',','.'),
            'Total'=> number_format(($data->$Grade->$Level)+($Employee->number_children*$Bonus_Standard->Standard)+($data->$Grade->$Level*($Antiquity[$Employee_Antiquity]/100))+($data->$Grade->$Level*($profession->$Employee_profesional/100)),2,',','.'),
        ];
        

    }elseif( in_array($Employee->paysheet->id,[6,7])){
        $calculation_data=calculation_data::find(2);

        $data=json_decode($calculation_data->data);
        $Class=$Employee->class;
        $Rank=$Employee->rank;

        $datos=[
            'Total'=> number_format(($data->$Class->$Rank)+($Employee->number_children*$Bonus_Standard->Standard)+($data->$Class->$Rank*($Antiquity[$Employee_Antiquity]/100))+($data->$Class->$Rank*($profession->$Employee_profesional/100)),2,',','.'),
        ];
    }

    return $datos;
}

function data_for_calculation_salary(){

        $Bonus_Standard=json_decode(calculation_data::find(6)->data);
        
        $Antiquity=json_decode(calculation_data::find(3)->data);
       
        $profession=json_decode(calculation_data::find(5)->data);

        $C_EMPLEADOS=json_decode($calculation_data=calculation_data::find(1)->data);
        $C_OBREROS=json_decode($calculation_data=calculation_data::find(2)->data);

        $datos=[
            'Bonus_Standard'=>  $Bonus_Standard,
            'Antiguedad'=> $Antiquity,
            'profession'=> $profession,
            'Calculo_empleados'=>$C_EMPLEADOS,
            'Calculo_obreros'=>$C_OBREROS,
        ];

        return $datos;
}
function hols(){
    return 'hola';
}