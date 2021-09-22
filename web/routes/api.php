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
