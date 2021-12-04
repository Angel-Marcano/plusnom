<?php

use Illuminate\Support\Facades\Route;
use App\Models\calculation_data;

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
    
    

    $a=calculation_data::find(1);

    $B=json_decode($a->data);
    $Grade='BII';
    $Level='7';
    $anos=5;

    return $B->$Grade->$Level;

});


Route::get('Empleados_data/{Grade}/{Level}', function ($Grade,$Level) {

    /*$a=calculation_data::find(1);
    $B=json_decode($a->data);
    
    return $B->$Grade->$Level;*/

});
