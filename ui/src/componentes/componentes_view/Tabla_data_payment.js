import React,{ useState } from "react";
import {Table,Button,Modal,Tabs,Tab  } from "react-bootstrap";
import useCalculationSalary from '../custom_hooks/useCalculationSalary';

const {Provider,Consumer}=React.createContext();

const style_modal={
    background:'#EEEDED',
    //border:'0.5px solid black'
  };
const style_th={
    textAlign: 'center',
    //border:'0.5px solid black'
  };
  const style_td_table={
    textAlign: 'center'
  };



const round=(num,dec=2)=> {

  //console.log('entro :');
   //console.log(num);

  
   var exp = Math.pow(10, dec || 2); // 2 decimales por defecto
   var resp= parseInt(num * exp, 10) / exp;

   //console.log('->');
   //console.log(resp);
   return resp;

   // var m = Number((Math.abs(num) * 100).toPrecision(15));
   // return Math.round(m) / 100 * Math.sign(num);
 /* var m=0;
   
  
  

   if(!isNaN(num)){
    m=num.toString().match(/^-?\d+(?:\.\d{0,2})?/)[0];
   }
   
   */

  // console.log('->');
  // console.log(m);
   //return m;
  }

const caltulation_salary=(Trabajador,data_calculation)=>{
  var Empleados = [3,4];

  const { Calculo_empleados,Calculo_obreros,profession,Bonus_Standard,Antiguedad} = data_calculation.data;
 
  var day1 = new Date(Trabajador['admission_date']); 
  var day2 = new Date();

  var difference= Math.abs(day2-day1);
  var days = difference/(1000 * 3600 * 24)
  var anos=Math.trunc(days/365);


  
  //empleados
  if(Empleados.indexOf(Trabajador.paysheet.id)==1){
    var datos={
      'base':round(Calculo_empleados[Trabajador['grade']][Trabajador['level']]),
      'P_antiguedad':round(Calculo_empleados[Trabajador['grade']][Trabajador['level']]*(Antiguedad[anos]/100)),
      'P_hijos':Trabajador['number_children']*Bonus_Standard['Standard'],
      'P_Profesion':round(Calculo_empleados[Trabajador['grade']][Trabajador['level']]*(profession[Trabajador['level_profession']]/100)),
      'D_sso':round( ( (Calculo_empleados[Trabajador['grade']][Trabajador['level']]*(profession[Trabajador['level_profession']]/100)) *12/52) *0.04*2   )
    }
    return datos;
  }
  
}

const Table_data_payment=(props)=>{

    const {Trabajador,data_calculation}=props.data;    
    var result2=caltulation_salary(Trabajador,data_calculation);
    var result=useCalculationSalary(Trabajador,data_calculation);

    console.log('salario antigua manera');
    console.log(result);

    console.log('salario :');
    console.log(result);

    return(

        <Table  responsive bordered >
             <thead>
                 <tr style={style_modal}>
                     <th style={style_th}>
                         Base mensual
                    </th>
                     <th style={style_th}>
                         Prima de profesion
                    </th>
                    <th style={style_th}>
                         Prima de antiguedad
                    </th>
                    <th style={style_th}>
                         Prima de hijos
                    </th>
                    <th style={style_th}>
                         Total asignación
                    </th>     

                 </tr>
             </thead>
             <tbody>
                 
                        <tr>
                            <td style={style_td_table}>
                             {result.base}
                            </td>
                            <td style={style_td_table}>
                             {result.P_Profesion}
                            </td>
                            <td style={style_td_table}>
                             {result.P_antiguedad}
                            </td>
                            <td style={style_td_table}>
                             {result.P_hijos}
                            </td>
                            <td style={style_td_table}>
                             {round(result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)}
                            </td>
                        </tr>



                        <tr style={style_modal}>
                          <th style={style_th}>
                            Seguro social
                          </th>
                          <th style={style_th}>
                            Paro forzoso
                          </th>
                          <th style={style_th}>
                            F.A.O.V
                          </th>
                          <th style={style_th}>
                            Caja de ahorro
                          </th>
                          <th style={style_th}>
                            Total deducciones
                          </th>     

                        </tr>

                        <tr>
                            <td style={style_td_table}>
                            {round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*12/52)*0.04*2 )}
                            </td>
                            <td style={style_td_table}>
                            {round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*12/52)*0.005*2 )}
                            </td>
                            <td style={style_td_table}>
                            {round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*0.01)/2 )}
                            </td>
                            <td style={style_td_table}>
                            {0}
                            </td>
                            <td style={style_td_table}>
                            {
                              round(
                              round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*12/52)*0.04*2 )*2+
                              round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*12/52)*0.005*2 )*2+
                              round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*0.01) )
                              )
                            }
                            </td>
                        </tr>


                        <tr style={style_modal}>
                          <th style={style_th}>
                            Total mensual
                          </th>
                          <th style={style_th}>
                            Total quincenal
                          </th>
                          <th style={style_th}>
                            complemento quincenal
                          </th>
                          <th style={style_th}>
                            Alimentacion (final de mes)
                          </th>
                          <th style={style_th}>
                            Remuneración total quincenal
                          </th>     

                        </tr>

                        <tr>
                            <td style={style_td_table}>
                            {
                              round(result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos-
                              (
                                round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*12/52)*0.04*2 )*2+
                                round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*12/52)*0.005*2 )*2+
                                round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*0.01) )
                              ))

                            }
                            </td>
                            <td style={style_td_table}>
                            {
                              round(
                                (result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos-
                                (
                                  round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*12/52)*0.04*2 )*2+
                                  round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*12/52)*0.005*2 )*2+
                                  round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*0.01) )
                                ))/2
                                )
                            }
                            </td>
                            <td style={style_td_table}>
                            {
                              round((result.base+result.P_Profesion+result.P_antiguedad)*0.40) //data_calculation['Bonus_Standard']
                              
                            }
                            </td>
                            <td style={style_td_table}>
                            {data_calculation['data']['Bonus_Standard']['feeding']}
                            </td>
                            <td style={style_td_table}>
                            {//15
                             round(
                              (result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos-
                              (
                                round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*12/52)*0.04*2 )*2+
                                round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*12/52)*0.005*2 )*2+
                                round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*0.01) )
                              ))/2
                              +
                              round((result.base+result.P_Profesion+result.P_antiguedad)*0.40)
                             )
                             
                              
                            }
                              /   
                            { 
                            //30          
                             round(

                              (result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos-
                              (
                                round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*12/52)*0.04*2 )*2+
                                round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*12/52)*0.005*2 )*2+
                                round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*0.01) )
                              ))/2
                              +
                              round((result.base+result.P_Profesion+result.P_antiguedad)*0.40)+
                              data_calculation['data']['Bonus_Standard']['feeding']
                             )
                              
                            }
                            </td>
                        </tr>

 
             </tbody>

             
             
         </Table>

    )

}


export default Table_data_payment;