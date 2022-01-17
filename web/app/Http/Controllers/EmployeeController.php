<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Imports\EmployeesImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\calculation_data;
use PDF;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $results = $request->perPage;
        $query = Employee::withCount('payrolls');

        if ($request->has('filter')) {
            $filters = $request->filter;
            // Get fields
            if (array_key_exists('document', $filters)) {
                $query->whereLike('document', $filters['document']);
            }
            if (array_key_exists('name', $filters)) {
                $query->whereLike('name', $filters['name']);
            }
            if (array_key_exists('surname', $filters)) {
                $query->whereLike('surname', $filters['surname']);
            }
            if (array_key_exists('chargue', $filters)) {
                $query->whereLike('chargue', $filters['chargue']);
            }
            if (array_key_exists('division', $filters)) {
                $query->whereLike('division', $filters['division']);
            }
        }

        return $query->paginate($results);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /* colo car validadciones */ 

        $Employee = new Employee;


        $Employee->document=$request->document;                 // cedula
        $Employee->full_name=$request->full_name;               // nombre completo
        $Employee->chargue=$request->chargue;                   // cargo
        $Employee->division=$request->division;                 // division
        $Employee->admission_date=$request->admission_date;     // fecha de ingreso
        $Employee->level_profession=$request->level_profession; // nivel profesional
        $Employee->cpaysheet=$request->cpaysheet;               // codigo nomina
        $Employee->cpayments=$request->cpayments;               // codigo de pago
        $Employee->rank=$request->rank;                         // codigo de rango
        $Employee->class=$request->class;                       // codigo de clase
        $Employee->grade=$request->grade;                       // codigo de grado
        $Employee->level=$request->level;                       // codigo de nivel
        $Employee->type_employee=$request->type_employee;       // codigo de pago
        $Employee->number_children=$request->number_children;   // numero de hijos
        $Employee->bank_account=$request->bank_account;         // cuenta bancaria
        $Employee->account_type=$request->account_type;         // tipo de cuenta

        $Employee->save();

        return $Employee;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    public function importEmployees(Request $request)
    {
        $file = $request->file;

        Excel::import(new EmployeesImport, $file);

        return response()->json([
            'data' => 'Employees uploaded successfully.'
        ]);
    }

    public function downloadProof(Employee $employee)
    {
        $vars = ['employee'];
        $pdf = PDF::loadView('pdf.constancia');

        return $pdf->stream('constancia.pdf');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    public function constancia(Request $request){

        
        
        $Employee=Employee::with([
            'paysheet',
        ])->Where('document','=',$request->cedula)->first();

        
        if(!is_null($Employee)){
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
                        'feeding'=>$Bonus_Standard->feeding,
                        'Meses'=>['nulo jeje','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
                    ];
                    

                }elseif( in_array($Employee->paysheet->id,[6,7])){
                    $calculation_data=calculation_data::find(2);

                    $data=json_decode($calculation_data->data);
                    $Class=$Employee->class;
                    $Rank=$Employee->rank;

                // dd($data->$Class->$Rank);
                    $datos=[
                        'base'=> $data->$Class->$Rank,
                        'children_premium'=> $Employee->number_children*$Bonus_Standard->Standard,
                        'antiquity_premium'=> number_format($data->$Class->$Rank*($Antiquity->$Employee_Antiquity/100),3,',','.'),
                        'profession_premium'=> number_format($data->$Class->$Rank*($profession->$Employee_profesional/100),3,',','.'),
                        'Total'=> number_format(($data->$Class->$Rank)+($Employee->number_children*$Bonus_Standard->Standard)+($data->$Class->$Rank*($Antiquity->$Employee_Antiquity/100))+($data->$Class->$Rank*($profession->$Employee_profesional/100)),2,',','.'),
                        'feeding'=>$Bonus_Standard->feeding,
                        'Meses'=>['nulo jeje','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre']
                    ];
                }

                // return $datos;
                $pdf = PDF::loadView('pdf.constancia',compact('datos','Employee'));

                return $pdf->stream('constancia.pdf');

        }else{
            abort(403);
        }
        

      
      
        
        
    }


    public function qr(){

        return view('welcome');
      
        //return  {!! QrCode::size(250)->generatewww.google.com !!};
         
    }



}
