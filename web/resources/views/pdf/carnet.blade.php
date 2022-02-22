

<table>

    <tr  style=" border:1px solid pink;padding:5px;">
        <td style="width:350px; border:1px solid red;">
            
            <div style="margin:20px; text-align:center; border:1px solid black;">

                <span style="color:#CDCDCD; font-size:25px;">O</span>

                <div style="text-align:center;margin:20px;">
                    <img src="data:image/png;base64,{{ base64_encode(QrCode::size(200)->generate('Cedula: '.$Trabajador['document'].' nombre: '.$Trabajador['full_name'].', departamento: '.$Trabajador['division'])) }}" />
                 </div>
                
                <p><strong>Cédula: </strong>{{number_format($Trabajador['document'],0,',','.')}} <p>
                <p><strong>Nombre: </strong> {{$Trabajador['full_name']}} <p>
                
                <p><strong>Tel: </strong> S/N <p>
                
            
                
        
            </div>

        </td>

        <td  style="width:350px; border:1px solid purple;">
            <div style="margin:20px; text-align:center; border:1px solid black;">

                <span style="color:#CDCDCD; font-size:25px;">O</span>
                
                <p style="font-size:15px;">SE LES AGRADECE A LAS AUTORIDADES COMPETENTES, PRESTAR LA MAYOR COLABORACIÓN
                    A NUESTROS TRABAJADORES, EN EL DESENPEÑO DE SUS FUNCIONES.
                    <p>

                <p style="font-size:13px;">Éste Carnet de Identificación es personal e instranferible.<p>
                <p style="font-size:13px;">En caso de usarlo una persona distinta a su propietario, se le recogerá y anulará<p>
                
                <p style="font-size:13px;">Si ha encontrado esta identificación por error, debe abstenerse de distribuirlo,
                    copiarlo o usarlo en cualquier sentido. Asimismo, le agradecemos realizar su entrega
                    en nuestras instalaciones.<p>

                <p style="font-size:13px;">___________________<p>

                <p style="font-size:15px;"> FIRMA AUTORIZADA <p>

            
                
        
            </div>

        </td>

       
    </tr>
    <tr>
        <td colspan="2">
            <br/>
            <strong style="color: red;">* El uso de este carnet es de caracter oblicatorio.</strong><br/>
            <strong style="color: red;">* El uso de este carnet no es transferible.</strong><br/>
            <strong style="color: red;">* En caso de extravio, reportarlo con la mayor rapidez posible.</strong>
            
            
        </td>
    </tr>

</table>



