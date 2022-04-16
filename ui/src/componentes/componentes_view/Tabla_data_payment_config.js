import React,{ useState } from "react";
import {Table,Button,Modal,Tabs,Tab,Form, InputGroup  } from "react-bootstrap";

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
  
   var exp = Math.pow(10, dec || 2); // 2 decimales por defecto
   var resp= parseInt(num * exp, 10) / exp;

 
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
  var Empleados = [3,'3',4,'4'];

  const { Calculo_empleados,Calculo_obreros,profession,Bonus_Standard,Antiguedad} = data_calculation.data;
 
  var day1 = new Date(Trabajador['admission_date']); 
  var day2 = new Date();

  var difference= Math.abs(day2-day1);
  var days = difference/(1000 * 3600 * 24)
  var anos=Math.trunc(days/365);


  
  //empleados
  if(Empleados.indexOf(Trabajador.paysheet.id)>=0){
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

const Table_data_payment_config=(props)=>{

    const {Trabajador,data_calculation,test,guardar,msj_guardado}=props.data;

    console.log("A => ",Trabajador);
    console.log("B => ",data_calculation);
    console.log("C => ",test);
    console.log("D => ",guardar);
    console.log("E => ",msj_guardado);

    
    const [mod, setMod] = useState(false);

    const actualizar=(e)=>{
      setMod(true);
      test(e);
    }

    const guardar_local=(e)=>{
      guardar(e);
      setMod(false);
      props.handleClose();
    }

    const validar_grade=(e)=>{
      console.log(Trabajador.level_profession+' y '+Trabajador.grade);

        if(Trabajador.level_profession=='BACHILLER' && (Trabajador.grade=="BI" || Trabajador.grade=="BII" || Trabajador.grade=="BIII")){
          actualizar(e);
        }

        if(Trabajador.level_profession=='TSU' && (Trabajador.grade=="TI" || Trabajador.grade=="TII")){
          actualizar(e);
        }

        if(Trabajador.level_profession=='PROFESIONAL' && (Trabajador.grade=="PI" || Trabajador.grade=="PII" || Trabajador.grade=="PIII")){
          actualizar(e);
        }
    }
    
    var result=caltulation_salary(Trabajador,data_calculation);

    return(
      <>
        <Table  responsive bordered >
             <thead>
                 <tr style={style_modal}>
                     <th style={style_th}>
                         Fecha de ingreso
                    </th>
                     <th colSpan={2} style={style_th}>
                         Profesión
                    </th>
                    <th colSpan={2} style={style_th}>
                        Numero de hijos
                    </th>
                    
                 </tr>
             </thead>
             <tbody>
                 
                        <tr>
                            <td style={style_td_table}>
                              <InputGroup>
                                <input style={{witd:"100%",height:"100%"}} type="date" name='admission_date' onChange={actualizar} value={Trabajador.admission_date}/>
                              </InputGroup>
                            </td>
                            <td colSpan={2} style={style_td_table}>
                              <Form.Select aria-label="Nivel academico" name="level_profession" onChange={actualizar} value={Trabajador.level_profession}>
                                <option value="BACHILLER">BACHILLER</option>
                                <option value="TSU">TSU</option>
                                <option value="PROFESIONAL">PROFESIONAL</option>
                                <option value="ESPECIALISTA">ESPECIALISTA</option>
                                <option value="DOCTOR">DOCTOR</option>
                              </Form.Select>
                            </td>
                            <td colSpan={2} style={style_td_table}>
                                <Form.Select aria-label="Numero de hijos" name="number_children" onChange={actualizar} value={Trabajador.number_children}>
                                  <option value="0">Sin hijos</option>
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                  <option value="6">6</option>
                                  <option value="7">7</option>
                                  <option value="8">8</option>
                                </Form.Select>
                            </td>
                            
                        </tr>



                        <tr style={style_modal}>
                          <th colSpan={2} style={style_th}>
                            Grado
                          </th>
                          <th colSpan={2} style={style_th}>
                            Nivel
                          </th>

                          {
                              Trabajador.rank ?
                              <>
                              <th colSpan={2} style={style_th}>
                                Rango
                              </th>
                              <th colSpan={2} style={style_th}>
                                Clase
                              </th>
                              </>:<></>

                          }
                          
                              

                        </tr>

                        <tr>
                            <td colSpan={2} style={style_td_table}>
                           
                            <Form.Select aria-label="Numero de hijos" name="grade" onChange={actualizar} value={Trabajador.grade}>
                                

                                 {
                                 
                                 (Trabajador.level_profession=='BACHILLER')?
                                 
                                 <>
                                 <option value="BI">BI</option>
                                 <option value="BII">BII</option>
                                 <option value="BIII">BIII</option>
                                 </>
                                 :<></>
                                
                                } 

                                {
                                 (Trabajador.level_profession=='TSU')?
                                 
                                 <>
                                  <option value="TI">TI</option>
                                  <option value="TII">TII</option>
                                 </>
                                 :<></>
                                
                                }

                                {
                                 (Trabajador.level_profession=='PROFESIONAL' || Trabajador.level_profession=='ESPECIALISTA' || Trabajador.level_profession=='DOCTOR')?
                                 
                                 <>
                                  <option value="PI">PI</option>
                                  <option value="PII">PII</option>
                                  <option value="PIII">PIII</option>
                                 </>
                                 :<></>

                                 

                                
                                } 
                                  
                                
                            </Form.Select>

                            </td>
                            <td colSpan={2} style={style_td_table}>
                            
                            <Form.Select aria-label="Nivel" name="level" onChange={actualizar} value={Trabajador.level}>
                  
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                  <option value="6">6</option>
                                  <option value="7">7</option>
                          
                            </Form.Select>

                            </td>
                              
                            {
                              Trabajador.rank ?
                              <>
                              <td style={style_td_table}>
                              {round(((result.base+result.P_Profesion+result.P_antiguedad+result.P_hijos)*0.01)/2 )}
                              </td>


                              <td style={style_td_table}>
                              {0}
                              </td>
                              </> : <></>

                          }
                            
                        </tr>
                        

                        

                        
                        <tr >
                          <th colSpan={4}  >
                                Vista Previa
                          </th>
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
                            
                        </tr>

 
             </tbody>

             
         </Table>

          {mod?(<Button onClick={guardar_local} variant={"success"} style={{float:'right'}}>Guardar</Button>):''}

      </>

    )

}


export default Table_data_payment_config;