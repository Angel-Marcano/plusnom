<?php

use Illuminate\Support\Facades\Route;
use App\Models\calculation_data;
use App\Models\Employee;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    
    

   /* $a=calculation_data::find(1);
    $empleado=Employee::find(1);

    //dd($empleado);


    $B=json_decode($a->data);
    $Grade='BII';
    $Level='7';
    $anos=5;

    return $B->$Grade->$Level;
*/

return view('Welcome');
    

});

Route::get('Constancia', [EmployeeController::class, 'constancia'])->name('Constancia');

Route::get('Nomina', [EmployeeController::class, 'index'])->name('Co');




Route::get('Empleados_data/{Grade}/{Level}', function ($Grade,$Level) {

    /*$a=calculation_data::find(1);
    $B=json_decode($a->data);
    
    return $B->$Grade->$Level;*/

});
