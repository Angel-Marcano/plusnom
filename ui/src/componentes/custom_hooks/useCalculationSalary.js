import {useState,useEffect} from 'react';


const round=(num,dec=2)=> {
  
    var exp = Math.pow(10, dec || 2); // 2 decimales por defecto
    var resp= parseInt(num * exp, 10) / exp;
 
  
    return resp;

   }

const useCalculationSalary=(Trabajador,data_calculation)=>{

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
export default useCalculationSalary;

