<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <!-- CSRF Token -->
        <title> Constancia </title>
        <style>
           body {
                font-family: roboto,sans-serif, serif;
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
            h1{
                text-align:center;
            }
            p{
                font-size: 18px;
            }
            
            .contenedor {
                background-color: teal;
                display: flex;
                align-items: center;
                justify-content: flex-end;
                height: 300px;
                width: 300px;
            }
            
            .contenedor-img {
                background-color: crimson;
                height: 120px;
                width: 120px;
                margin-right: 15px;
            }
        
        </style>
    </head>

    <body>
        <div class="header">
            <div class="sumatLOGO">
              <!--  <img src="{{ base_path().'/public/assets/images/sumat.png' }}" height="90px" width="230px" alt="sumatlogo"/>
        --> </div>
         
  
        </div>
        <div>
            <div>
                <h1> CONSTANCIA </h1>
                <p style="text-align:justify;">
                    La Suscrita Directora de Recursos Humanos de la Alcaldia del Municipio Bermúdez,
                    por medio de la presente hace constar, que el (la) ciudadano (a): {{ucwords($Employee->full_name)}} ,
                    titular de la Cédula de Identidad Nº {{number_format($Employee->document,0,',','.')}} ,
                    trabaja en esta institución desempeñándose como 
                    @if($Employee->paysheet->id==3)
                        EMPLEADO (A) CONTRATADO (A) 
                    @elseif($Employee->paysheet->id==4)
                        EMPLEADO (A) FIJO (A)

                    @elseif($Employee->paysheet->id==6)
                        OBRERO (A) CONTRATADO (A)

                    @elseif($Employee->paysheet->id==7)
                        OBRERO (A) FIJO (A)
                    @endif
                    
                    
                    con el cargo de {{$Employee->chargue}}, desde el {{$Employee->admission_date}} devengando un ingreso mensual de
                    Bs. {{$datos['Total']}} y un bono de alimentación de Bs.{{number_format($datos['feeding'],2,',','.')}}.
                    
                </p>
                
                <p style="margin-top:50px;text-align:justify;">
                    Constancia que se expide a solicitud de la parte interesada en la
                    ciudad de Carúpano, a los {{date('d')}} días del mes del
                    
                    {{$datos["Meses"][date('m')]}} de {{date('Y')}}.
                </p>
                <br>
                
            </div>


            <div>
                <p style="text-align:center; font-size:18px; margin-bottom:50px;">
                    Atentamente
                </p>
                <p style="text-align:center; margin:0;">
                    Lcda. Gilmelis vargas
                </p>
                <p style="text-align:center; margin:0;">
                    DIRECTORA DE RECURSOS HUMANOS
                </p>
                <p style="text-align:center; margin:0; margin-bottom:150px;">
                    BAJO RESOLUCION Nº07, GACETA Nº06-A FECHA: 01/12/2021
                </p>

                <p style="text-align:center;">
                    <img style="margin-left:0%;" src="data:image/png;base64, {{ base64_encode(QrCode::size(200)->generate('Mediante la presente yo, gilmelis vargas directora de recursos humano de la alcaldia del municipio bermudez valido los siguentes datos:'.$Employee->full_name.', ingreso:'.$Employee->admission_date.', Asignación mensual:'.$datos['Total'].', Cuenta con '.$Employee->number_children.' hijo(s) menores registrados, sus datos de calculo son: sueldo base:'.$datos['base'].', Prima por hijos:'.$datos['children_premium'].', prima por antiguadad:'.$datos['antiquity_premium'].', prima por profesion:'.$datos['profession_premium'].'. Documento se expide a fecha:'.date('d-m-Y'))) }} ">     
                </p>
            </div>
          
        </div>
     
    </body>
</html>
