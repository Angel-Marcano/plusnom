<?php

use Illuminate\Support\Facades\Route;
use App\Models\calculation_data;
use App\Models\Employee;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;

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
    

return view('Welcome');
    

});

Route::get('Constancia', [EmployeeController::class, 'constancia'])->name('Constancia');

Route::get('Nomina', [EmployeeController::class, 'index'])->name('Co');
Route::get('txt', [PayrollController::class, 'txt'])->name('TXT');

Route::post('save_employee', [EmployeeController::class, 'store'])->name('save_employee');




Route::get('Empleados_data/{Grade}/{Level}', function ($Grade,$Level) {

    /*$a=calculation_data::find(1);
    $B=json_decode($a->data);
    
    return $B->$Grade->$Level;*/

});
