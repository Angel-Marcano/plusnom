<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <!-- CSRF Token -->
        <title> Factura </title>
        <style>
           body {
                font-family: sans-serif, serif;
                font-size: 15px;
            }
            .header {
                width: 100%;
                font-size: 9px;
                position: relative;
                display: block;
            }
            .header div {
                display: inline-block;
            }
            #mayorLOGO {
                float: right;
            }
            table, td, th {
                border: 1px #000 dashed;
            }
            td {
                font-size: 13px;
                padding: 2px;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 5px;
            }
            .tables {
                display:block;
            }
            .bill-info {
                width: 100%;
                clear: both;
                font-weight: bold;
            }
            .col-bill-info {
                float: left;
                width: 50%;
                font-size: 15px;
            }
            .total-amount {
                text-align: right;
            }
            .miscellaneus {
                font-size: 12px;
            }
            caption {
                font-weight: bold;
            }
            th {
                font-size: 10px;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <div class="sumatLOGO">
                <img src="{{ base_path().'/public/assets/images/sumat.png' }}" height="90px" width="230px" alt="sumatlogo"/>
            </div>
            <div class="description">
               <p>
                REPÚBLICA BOLIVARIANA DE VENEZUELA<br>
                ESTADO SUCRE<br>
                ALCALDÍA DEL MUNICIPIO BERMÚDEZ<br>
                SUPERINTENDENCIA MUNICIPAL DE ADMINISTRACIÓN TRIBUTARIA<br>
                RIF: G-20000222-1<br>
                DIRECCIÓN: AV. CARABOBO, EDIFICIO MUNICIPAL
                </p>
            </div>
            <div id="mayorLOGO">
                <img src="{{ base_path().'/public/assets/images/logo.png' }}" height="70px" width="130px" alt="logo" />
            </div>
        </div>
        <div>
            <div>
                <p>
                    {{ $parameters->membrete }},
                    por medio de la presente hace constar, que el (la) ciudadano (a): YAJAIRA LEIVA ,
                    titular de la Cédula de Identidad Nº 5.884.779 ,
                    trabaja en esta institución desempeñándose como EMPLEADO (A) FIJO (A) con el cargo de
                    ASISTENTE ADMINISTRATIVO III, desde el 01-03-1997 devengando un ingreso mensual de
                    Bs. 5.607.360,00 y un bono de alimentación de Bs.1.200.000,00.
                </p>
                <p>
                    Constancia que se expide a solicitud de la parte interesada en la
                    ciudad de Carúpano, a los 29 días del mes de
                    Enero de Dos Mil Veintiuno.
                </p>
                <br>
                <p>
                    Atentamente
                </p>
            </div>
            <div>
                <p>{{ $parameters->director_name }}</p>
                <p>{{ $parameters->position }}</p>
                <p>{{ $parameters->resolution }}</p>
            </div>
        </div>
        <div>
            <p>{{ $parameters->address }}</p>
            <p>{{ $parameters->rif }}</p>
        </div>
    </body>
</html>
