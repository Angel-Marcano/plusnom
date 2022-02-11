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

Route::get('Constancia_api/{cedula}', [EmployeeController::class, 'constancia'])->name('Constancia_api');

Route::get('configuracion_antiguedad', [PayrollController::class, 'configuracion_antiguedad'])->name('configuracion_antiguedad');
Route::get('configuracion_profesion', [PayrollController::class, 'configuracion_profesion'])->name('configuracion_profesion');
Route::get('configuracion_bone', [PayrollController::class, 'configuracion_bone'])->name('configuracion_bone');
Route::post('configuracion_bone/set', [PayrollController::class, 'configuracion_bone_set'])->name('configuracion_bone_set');
Route::post('configuracion_profesion/set', [PayrollController::class, 'configuracion_profesion_set'])->name('configuracion_profesion_set');
Route::post('employees/import', [EmployeeController::class, 'importEmployees']);

//Route::post('configuracion_bone/set', [PayrollController::class, 'configuracion_bone_set'])->name('configuracion_bone_set');