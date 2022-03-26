<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ManageTokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('employees', EmployeeController::class);
    Route::apiResource('payrolls', PayrollController::class);
    // Route::get('employees/{employee}/proofs/download', 'EmployeeController@downloadProof');

    Route::get('logout', [ManageTokenController::class, 'revoke']);
    Route::apiResource('parameters', ParameterController::class)
        ->except(['index', 'store', 'destroy']);
});
Route::post('employees/import', [EmployeeController::class, 'importEmployees']);

Route::post('login', [ManageTokenController::class, 'login']);

*/

Route::post('employees/import', [EmployeeController::class, 'importEmployees']);
Route::post('Constancia_api', [EmployeeController::class, 'constancia'])->name('Constancia_api');

Route::get('configuracion_antiguedad', [PayrollController::class, 'configuracion_antiguedad'])->name('configuracion_antiguedad');
Route::get('configuracion_profesion', [PayrollController::class, 'configuracion_profesion'])->name('configuracion_profesion');
Route::get('configuracion_bone', [PayrollController::class, 'configuracion_bone'])->name('configuracion_bone');
Route::post('configuracion_bone/set', [PayrollController::class, 'configuracion_bone_set'])->name('configuracion_bone_set');
Route::post('configuracion_profesion/set', [PayrollController::class, 'configuracion_profesion_set'])->name('configuracion_profesion_set');
Route::post('employees/import', [EmployeeController::class, 'importEmployees']);
Route::post('employees/update', [EmployeeController::class, 'update']);
Route::post('Carnet', [EmployeeController::class, 'Carnet']);
Route::post('txt', [PayrollController::class, 'txt']);

Route::post('Nomina/', [EmployeeController::class, 'index']);

Route::get('data_calculation', [EmployeeController::class, 'data_calculation_salary']);

//Route::post('configuracion_bone/set', [PayrollController::class, 'configuracion_bone_set'])->name('configuracion_bone_set');