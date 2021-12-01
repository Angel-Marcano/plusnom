<?php

use Illuminate\Support\Facades\Route;

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
    //return view('welcome');

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

        ];

    return $Data_empleados['TII'][4];

});
