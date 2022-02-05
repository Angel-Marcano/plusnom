<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\paysheet;
use Illuminate\Http\Request;
use App\Models\calculation_data;
use PhpOffice\PhpSpreadsheet\Calculation\TextData\Format;

class PayrollController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $results = $request->perPage;
        $query = Payroll::with('employee');

        if ($request->has('filter')) {
            $filters = $request->filter;
            // Get fields
            if (array_key_exists('document', $filters)) {
                $query->whereLike('document', $filters['document']);
            }
        }

        return $query->paginate($results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function show(Payroll $payroll)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function edit(Payroll $payroll)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payroll $payroll)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payroll  $payroll
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payroll $payroll)
    {
        //
    }

    public function configuracion_antiguedad(){
        $resp=json_decode(calculation_data::find(3)->data);

       $array=array();
       for($i=0; $i<24;$i++){
            array_push($array,$resp->$i);
       }
       
      
        return json_encode($array);
    }

    public function configuracion_profesion(){
        $resp=json_decode(calculation_data::find(5)->data);
       
        return $resp;
    }
    
    public function configuracion_bone(){
        $resp=json_decode(calculation_data::find(6)->data);
       
        return $resp;
    }

    public function configuracion_bone_set(Request $request){
        $set=calculation_data::find(6);
    //return ($request->items);

       $set->data=$request->items;
       $set->save();
       return response()->json(['mensaje'=>'exito']);
    }

    public function configuracion_profesion_set(Request $request){
        $set=calculation_data::find(5);
        $set->data=$request->items;
        $set->save();
        return response()->json(['mensaje'=>'exito']);
    }
    

    public function salary_calculator($Employee){

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
                'antiquity_premium'=> number_format($data->$Grade->$Level*($Antiquity->$Employee_Antiquity/100),3,',','.'),
                'profession_premium'=> number_format($data->$Grade->$Level*($profession->$Employee_profesional/100),3,',','.'),
                'Total'=> number_format(($data->$Grade->$Level)+($Employee->number_children*$Bonus_Standard->Standard)+($data->$Grade->$Level*($Antiquity->$Employee_Antiquity/100))+($data->$Grade->$Level*($profession->$Employee_profesional/100)),2,',','.'),
            ];
            

        }elseif( in_array($Employee->paysheet->id,[6,7])){
            $calculation_data=calculation_data::find(2);

            $data=json_decode($calculation_data->data);
            $Class=$Employee->class;
            $Rank=$Employee->rank;

            $datos=[
                'Total'=> number_format(($data->$Class->$Rank)+($Employee->number_children*$Bonus_Standard->Standard)+($data->$Class->$Rank*($Antiquity->$Employee_Antiquity/100))+($data->$Class->$Rank*($profession->$Employee_profesional/100)),2,',','.'),
            ];
        }

        return $datos;
    }

    public function txt(Request $request)
    {

        $query = paysheet::with('Employye')
        ->where('id','=',4)->first();

        $Total_txt=0;
       
        foreach ($query->Employye as $Employee) {
            $salary=$this->salary_calculator($Employee);
            $Employee->mount=$salary;
            $salary['Total']=str_replace(",", ".", $salary['Total']);
            
            $Total_txt+=floatval($salary['Total']);
        }
        
        $Total_txt=str_replace(".",'', $Total_txt);
        $relleno="";
        $relleno_de_ceros=13-strlen($Total_txt);

        for ($i=0; $i < $relleno_de_ceros; $i++) { 
            $relleno=$relleno.'0';
        }

        $Total_txt=$relleno.$Total_txt;
       // dd($Total_txt);

        $file = fopen("txts/archivo.txt", "w");
        $nombre_institucion="H"."ALCALDIA BERMUDEZ                       ";//ojo con la cantidad de espacios
        $cuenta_empresa="01020438225578891433";
        $n_archivo="03";
        $fecha="15/01/22";
        $monto_total=$Total_txt;
        
        $codigo="03291 ";
        $codigo_employees='771';


        fwrite($file,$nombre_institucion.$cuenta_empresa.$n_archivo.$fecha.$monto_total.$codigo. PHP_EOL);

        foreach ($query->Employye as $Employee) {
            /* calculo para el monto con relleno*/ 
            $mount_employee=str_replace(",",'',$Employee->mount['Total']);
            $relleno='';
            $relleno_mount=11-strlen($mount_employee);
            for ($i=0; $i < $relleno_mount; $i++) { 
                $relleno=$relleno.'0';
            }
            $mount_employee=$relleno.$mount_employee;

            /*nombre con relleno*/ 
            $name_employee=$Employee->full_name;
            $relleno='';
            $relleno_name=40-strlen($name_employee);
            for ($i=0; $i < $relleno_name; $i++) { 
                $relleno=$relleno.' ';
            }
            $name_employee=$name_employee.$relleno;

            /*Cedula con relleno*/ 
            $document_employee=$Employee->document;
            $relleno='';
            $relleno_document=9-strlen($document_employee);
            for ($i=0; $i < $relleno_document; $i++) { 
                $relleno=$relleno.'0';
            }
            $document_employee=$relleno.$document_employee;

            
            $line=$Employee->account_type.$Employee->bank_account.$mount_employee.$Employee->account_type.$codigo_employees.$name_employee.'0'.$document_employee.'0'.$codigo;
            fwrite($file, $line. PHP_EOL);
        }

        fclose($file);

        $file_down= "txts/archivo.txt";

        $headers = array(
                  'Content-Type: application/txt',
                );
    
        return response()->download($file_down, 'filename.txt', $headers);
    }
}
