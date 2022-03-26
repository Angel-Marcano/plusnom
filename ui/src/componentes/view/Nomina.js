import React,{ useEffect, useState } from "react";
import {Table,Button,Modal,Tabs,Tab,Pagination,Alert,FormControl,InputGroup,Form } from "react-bootstrap";
import Tabla_data_payment from "../componentes_view/Tabla_data_payment";
import Tabla_data_payment_config from "../componentes_view/Tabla_data_payment_config";
import useFetch from "../custom_hooks/useFetch";

const style_th={
  textAlign: 'center',
  //border:'0.5px solid black'
};
const style_td_table={
  textAlign: 'center'
};


const {Provider,Consumer}=React.createContext();


const Paginacion=(props)=>{
  //var Current=4;
  //var Last=9;
  //var path='http://127.0.0.1:8000/api/Nomina';

  const {pag,handle} =props
  const {currentPage,lastPage,perPage,total}=pag;

  const setUrl=(num)=>{
    handle(num);
  };


  return(
    <Pagination>
      {console.log(pag)}
           
         <Pagination.First onClick={()=>{setUrl(1)}} />
         <Pagination.Prev onClick={()=>{setUrl(currentPage-1)}} />

         {(currentPage-3>=1)?<Pagination.Item onClick={()=>{setUrl(currentPage-3)}} >{currentPage-3}</Pagination.Item>:''}
         {(currentPage-2>=1)?<Pagination.Item onClick={()=>{setUrl(currentPage-2)}} >{currentPage-2}</Pagination.Item>:''}
         {(currentPage-1>=1)?<Pagination.Item onClick={()=>{setUrl(currentPage-1)}} >{currentPage-1}</Pagination.Item>:''}

         {<Pagination.Item active>{currentPage}</Pagination.Item>}

         {((currentPage+1)<=lastPage)?<Pagination.Item onClick={()=>{setUrl(currentPage+1)}}>{currentPage+1}</Pagination.Item>:''}
         {((currentPage+2)<=lastPage)?<Pagination.Item onClick={()=>{setUrl(currentPage+2)}}>{currentPage+2}</Pagination.Item>:''}
         {((currentPage+3)<=lastPage)?<Pagination.Item onClick={()=>{setUrl(currentPage+3)}}>{currentPage+3}</Pagination.Item>:''}

         {(currentPage<lastPage)?<Pagination.Next onClick={()=>{setUrl(currentPage+1)}} />:""}
         {((currentPage)<lastPage)?<Pagination.Last onClick={()=>{setUrl(lastPage)}} />: "" }
         
       </Pagination>

  )

}








const Example=(props)=> {
    const [show, setShow] = useState(false);
  
    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);

    const {Trabajador,data_calculation} = props;

    const download_carnet=()=>{

      let requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ Trabajador:Trabajador })
      };
    
    
      fetch('http://127.0.0.1:8000/api/Carnet', requestOptions)
      .then(response => response.blob())
      .then(function(myBlob) {
              // Create blob link to download
          const dir = window.URL.createObjectURL(
            new Blob([myBlob]),
          );
          const link = document.createElement('a');
          link.href = dir;
          link.setAttribute(
            'download',
            `FileName.pdf`,
          );

          // Append to html link element page
          document.body.appendChild(link);

          // Start download
          link.click();

          // Clean up and remove the link
          link.parentNode.removeChild(link);
      });
    
    };

    const download_constancia=()=>{

      let requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json','Access-Control-Allow-Origin': '*'},
        body: JSON.stringify({ cedula:Trabajador['document'] })
      };
    
    
      fetch('http://127.0.0.1:8000/api/Constancia_api', requestOptions)
      .then(response => response.blob())
      .then(function(myBlob) {
              // Create blob link to download
          const dir = window.URL.createObjectURL(
            new Blob([myBlob]),
          );
          const link = document.createElement('a');
          link.href = dir;
          link.setAttribute(
            'download',
            `FileName.pdf`,
          );

          // Append to html link element page
          document.body.appendChild(link);

          // Start download
          link.click();

          // Clean up and remove the link
          link.parentNode.removeChild(link);
      });
    };

   
     
    const style_modal={
      background:'#EEEDED'
    };

    
   

    return (
      <>
        <Button id={'modal_boton'} style={{display:'none'}} onClick={handleShow} >
          Ver 
        </Button>
  
        <Modal  size="lg" show={show} onHide={handleClose}>
          <Modal.Header closeButton>
            <Modal.Title><b>Detalles Trabajador</b></Modal.Title>
          </Modal.Header>
          <Modal.Body>
          <h5><b>{Trabajador.full_name} ( V-{ Intl.NumberFormat("de-DE").format(Trabajador.document) })</b></h5>

          <Tabs defaultActiveKey="DATA_PAYMENTS" id="uncontrolled-tab-example" className="mb-3">

            <Tab eventKey="DATA_PAYMENTS" title="Datos de pago">
                <Tabla_data_payment data={props} />
            </Tab>

            <Tab eventKey="CALCULATION_DATA" title="Datos de calculo">
                  
                <Tabla_data_payment_config data={props} handleClose={handleClose} />           
              
            </Tab>
            <Tab eventKey="CARNET" title="Carnet" >

                <Button variant={'primary'} onClick={download_carnet}>Descargar Carnet</Button>
                <br/>
                
                <Button variant={'primary'} onClick={download_constancia}>Descargar Constancia</Button>
                <br/>
                
                

                
            </Tab>
          </Tabs>


          </Modal.Body>


        </Modal>
      </>
    );
  }
  










  




const UseAlert=(props)=>{
  const {mensaje, variante,setFunction,valor} = props;
  const [show, setShow] = useState(valor);


    if (show) {
      return(
        <Alert variant={variante?variante:'success'} onClose={() => {setShow(false);setFunction(false);}} dismissible>
        {mensaje?mensaje:'Datos Guardados y Actualizados'}
        
        </Alert>
      )
    }

    return "";
  

}











  

const data_trabajador={"id":1,"document":"17956388","full_name":"Alcimar Oliveros","chargue":null,"division":null,"admission_date":"2019-02-01","level_profession":"PROFESIONAL","active":1,"cpaysheet":4,"cpayments":1,"rank":null,"class":null,"grade":"PIII","level":7,"type_employee":4,"discharge_date":null,"number_children":2,"bank_account":"01020647240100000206","account_type":"1","created_at":"2022-02-12T00:12:45.000000Z","updated_at":"2022-02-12T00:12:45.000000Z","deleted_at":null,"payrolls_count":0,"paysheet":{"id":4,"name":"Empleados fijos","created_at":"2022-02-11T23:23:48.000000Z","updated_at":"2022-02-11T23:23:48.000000Z"}}

const Nomina =()=>{

    /* effect */
    const [mostrar,setMostrar]=useState(false);
    const [personal,setPersonal]=useState([data_trabajador]);
    const [trabajador,setTrabajador]=useState(data_trabajador);
    const [actualizacion,setActualizacion]=useState(0);
    /* alerta  */
    const [alerta,setAlerta]=useState(false);

    /* paginado */
    const [url,setUrl]=useState(1);
    const handleUrl=(num)=>{
      setUrl(num);
    }

    /* filtro */
    const eqm_filtro={
      'nomina':4,
      'txt_busqueda':'',
      'sexo':'',
      'hijos':'',
    }
    const [filtro,setFiltro]=useState(eqm_filtro);


    const actualizar_filtro=(e)=>{
      const {name,value} = e.target;
      setFiltro({...filtro,[name]:value});
    }



    


    const actualidar_trabajador=(e)=> {
      const {name,value} = e.target;
      setTrabajador({...trabajador,[name]:value});  
    }

    const Guardar_cambios=(e)=>{
     // console.log("enviando");

     // console.log(trabajador);


      let requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ Trabajador:trabajador })
      };

    
    fetch('http://127.0.0.1:8000/api/employees/update', requestOptions)
        .then(response => response.json())
        .then(data => {
           setActualizacion(actualizacion+1);
           setAlerta(true);
                    
          });


    }

   
  const [pagination,setPagination]=useState({});



  useEffect( ()=>{

    let requestOptions = {
      method: 'post',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ filter:filtro,page:url })
    };

    fetch('http://127.0.0.1:8000/api/Nomina/',requestOptions)
    .then(response => response.json())
    .then(data => { 
              //  console.log('====') ;
                setPersonal(data.data); 

                setPagination(data.pagination);
                //pagination=data.pagination;

                setMostrar(true);
               // console.log(data); console.log('====');
                
              });

  },[url,actualizacion,filtro])
 
























   
    let data_response_calculation=useFetch('http://127.0.0.1:8000/api/data_calculation');


    const detallesTrabajador=(e)=>{
      setTrabajador(e);

      document.getElementById('modal_boton').click();
    }

    const download_txt=()=>{

      let requestOptions = {
        method: 'POST',
        headers: { 'Content-Type': 'application/json','Access-Control-Allow-Origin': '*'},
    
      };
    
    
      fetch('http://127.0.0.1:8000/api/txt', requestOptions)
      .then(response => response.blob())
      .then(function(myBlob) {
              // Create blob link to download
          const dir = window.URL.createObjectURL(
            new Blob([myBlob]),
          );
          const link = document.createElement('a');
          link.href = dir;
          link.setAttribute(
            'download',
            `pagoNomina.txt`,
          );

          // Append to html link element page
          document.body.appendChild(link);

          // Start download
          link.click();

          // Clean up and remove the link
          link.parentNode.removeChild(link);
      });
    };
  
     
     
    return(
      
        <Provider value={{Trabajadores:personal,Trabajador_set:actualidar_trabajador}}>


            <h2 style={{marginTop:'15px'}}>Nominas</h2>
         
             
              <UseAlert
                mensaje={"todo guardado"}
                variante={"success"}
                setFunction={setAlerta}
                valor={alerta}
              />
              <InputGroup className="mb-3">
   
                <FormControl
                  style={{maxWidth:'300px'}}
                  placeholder="Buscar"
                  aria-label="Buscar"
                  aria-describedby="basic-addon2"
                  name="txt_busqueda"
                  onChange={actualizar_filtro} 
                  value={filtro.txt_busqueda}
                />
                <Button style={{marginRight:'20px'}} variant="outline-primary" id="button-addon2">
                  Button
                </Button>

                <Form.Select style={{maxWidth:'240px',marginRight:'20px'}} aria-label="Nomina" name="nomina" onChange={actualizar_filtro} value={filtro.nomina}>
                  <option value={1}>Alto nivel</option>
                  <option value={2}>Directivos</option>
                  <option value={3}>Empleados contratados</option>
                  <option value={6}>Obreros contratados</option>
                  <option value={4}>Empleados fijos</option>
                  <option value={7}>Obreros fijos</option>
                  <option value={5}>Empleados jubilados</option>
                  <option value={8}>Obreros jubilados</option>
                </Form.Select>

                <Form.Select style={{maxWidth:'120px',marginRight:'20px'}} aria-label="sexo" name="sexo" onChange={actualizar_filtro} value={filtro.sexo}>
                  <option value=''>- - -</option>
                  <option value='M'>Mujeres</option>
                  <option value='H'>Hombres</option>
                </Form.Select>

                <Form.Select style={{maxWidth:'120px',marginRight:'20px'}} aria-label="hijos" name="hijos" onChange={actualizar_filtro} value={filtro.hijos}>
                  <option value=''>- - -</option>
                  <option value='0'>Sin hijos</option>
                  <option value='1'>Con hijos</option>
                </Form.Select>

              </InputGroup>


              

            <Button style={{float:'right',marginBottom:'15px'}} variant={'primary'} onClick={download_txt}>Descargar txt</Button>
                   
          
            
            <Table striped bordered hover>
                <thead>
                    <tr>
                        <th style={style_th}>
                            Cedula
                        </th>
                        <th style={style_th}>
                            Nombre y Apellido
                        </th>
                        <th style={style_th}>
                            Cargo
                        </th>
                        <th style={style_th}>
                            Fecha ingreso
                        </th>
                        <th style={style_th}>
                            Nivel academico
                        </th>
                        <th style={style_th}>
                            Numero de hijos
                        </th>
                        <th style={style_th}>
                            Monto quincenal
                        </th>
                        <th style={style_th}>
                            Acciones
                        </th>

                    </tr>
                </thead>
                <tbody>
          
                {mostrar? (
                  
                  personal.map((p,index)=>{
                    return(
                        <tr key={p.document}>
                        <td>
                          {p.document}
                        </td>
                        <td>
                            {p.full_name}
                        </td>
                        <td>
                            {p.charge?p.charge:'N/A'}
                        </td>
                        <td>
                            {p.admission_date}
                        </td>
                        <td>
                            {p.level_profession}
                        </td>
                        <td>
                            {p.number_children}
                        </td>
                        <td>
                        {
                             0
                            }
                        </td>
                        <td>
                            <Button variant="primary"  onClick={()=>{detallesTrabajador(p)}}>Detalles</Button>
                            
                        </td>
                      </tr>
                    )
                  })
                
                )
                :(<tr><td colSpan={9}>Cargando. . .</td></tr>)}
                                                
                      
                </tbody>
                
            </Table>
            

                     {/* MODAL  */}
            <Example
            
            Title="titulo"
            
            Trabajador={trabajador}
        
            data_calculation={data_response_calculation}

            test={actualidar_trabajador}

            guardar={Guardar_cambios}

            />



              {/* PAGINACION  */}

            {setMostrar? (  
            
            <Paginacion pag={pagination} handle={handleUrl}/>
            
            )
            
            
            :' . . . '}


              {/* Alerta  */}


         


         
       
        </Provider>
    )
}

export default Nomina;