<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = ['*',
    'api/Nomina','api/Constancia_api','save_employee','api/configuracion_bone/set','api/configuracion_profesion/set','api/configuracion_bone/set','api/employees/update','api/Carnet','api/txt'
        //
    ];
}
