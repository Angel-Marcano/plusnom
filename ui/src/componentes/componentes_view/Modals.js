import {useState,useEffect} from 'react';
import {Table,Button,Modal,Tabs,Tab,Pagination,Alert,FormControl,InputGroup,Form,Col,Row } from "react-bootstrap";
import {Input_Form,Select_Form} from './TestForm';


function  Modals(props) {
  const [show, setShow] = useState(false);

  const handleClose = () => setShow(false);
  const handleShow = () => setShow(true);

  const esqma_dataRegistro={
    'cpaysheet':4,
    'full_name':'',
    'document':'',
    'sexo':'Masculino',
    'number_children':0,
    'level_profession':'BACHILLER',
    'grade':'BI',
    'level':'1',
    'admission_date':'',
    'chargue':'',
    'bank_account':'',
    'division':'',
    'rank':null,
    'class':null,
    'account_type':'0',
    'blood_type':'O+',
    'phone':'',
    'photo':'',

  }
  const [dataRegistro,setdataRegistro]=useState(esqma_dataRegistro);
  
    const actualizar_dataRegistro=(e)=>{
      const {name,value} = e.target;
      setdataRegistro({...dataRegistro,[name]:value});
      mostar();
    }

    const mostar=()=>{
     console.log(dataRegistro);
    }

    const Guardar_trabajador=(e)=>{
      let requestOptions = {
       method: 'POST',
       headers: { 'Content-Type': 'application/json' },
       body: JSON.stringify({ Trabajador:dataRegistro })
     };

   
   fetch('http://127.0.0.1:8000/api/employees/create', requestOptions)
       .then(response => response.json())
       .then(data => {
         
         if(data==="exitoso"){
           alert("Empleado guardado");
           window.location.replace('');    
         }else{
           alert("Documento de identidad ya existe.");
         }
        });


   }



  return (
    <>
      <Button style={{float:'right',marginBottom:'15px', marginRight :'5px'}} variant="primary" onClick={handleShow}>
      {props.label_boton}
      </Button>

      <Modal show={show} onHide={handleClose}>
        <Modal.Header closeButton>
          <Modal.Title>{props.titulo}</Modal.Title>
        </Modal.Header>
        <Modal.Body>
                          <Row>
                              <Input_Form
                                uptedate={actualizar_dataRegistro}
                                date={dataRegistro}
                                tag={'full_name'}
                                label={'nombre y apellido'}
                                placeholder={'Nombre y apellido'}
                                type={'text'}
                                
                              />

                              <Input_Form
                                uptedate={actualizar_dataRegistro}
                                date={dataRegistro}
                                tag={'document'}
                                label={'Cedula'}
                                placeholder={'cedula'}
                                type={'text'}
                              />
                          
                          </Row>
                          <Row>
                              <Input_Form
                                    uptedate={actualizar_dataRegistro}
                                    date={dataRegistro}
                                    tag={'admission_date'}
                                    label={'fecha de ingreso'}
                                    type={'date'}
                                  />


                                  <Select_Form
                                    uptedate={actualizar_dataRegistro}
                                    date={dataRegistro}
                                    tag={'cpaysheet'}
                                    label={'Nomina perteniciente'}
                                    
                                    items={
                                      [{'value':'1','label':'Alto nivel'},
                                    ,{'value':'2','label':'Directivos'},
                                    {'value':'3','label':'Empleados contratados'},
                                    {'value':'4','label':'Obreros contratados'},
                                    {'value':'5','label':'Empleados fijos'},
                                    {'value':'6','label':'Obreros fijos'},
                                    {'value':'7','label':'Empleados jubilados'},
                                    {'value':'8','label':'Obreros jubilados'}]
                                    
                                    }
                                  />

                          </Row>
                          <Row>
                                    
                                 <Select_Form
                                    uptedate={actualizar_dataRegistro}
                                    date={dataRegistro}
                                    tag={'level_profession'}
                                    label={'Nivel Profesional'}
                                    
                                    items={
                                      [{'value':'BACHILLER','label':'BACHILLER'},
                                    ,{'value':'TSU','label':'TSU'},
                                    {'value':'PROFESIONAL','label':'PROFESIONAL'},
                                    {'value':'ESPECIALISTA','label':'ESPECIALISTA'},
                                    {'value':'DOCTOR','label':'DOCTOR'},
                                   ]
                                    
                                    }
                                  />


                                  <Col>
                                    
                                  <label>Grado</label>
                                  <Form.Select style={{marginTop:'8px', maxWidth:'240px',marginRight:'20px',marginBottom:'5px'}} aria-label="Numero de hijos" name="grade" onChange={actualizar_dataRegistro} value={dataRegistro.grade}>
                                    {
                                    (dataRegistro.level_profession=='BACHILLER')?
                                    
                                    <>
                                    <option value="BI">BI</option>
                                    <option value="BII">BII</option>
                                    <option value="BIII">BIII</option>
                                    </>
                                    :<></>
                                    
                                    } 

                                    {
                                    (dataRegistro.level_profession=='TSU')?
                                    
                                    <>
                                      <option value="TI">TI</option>
                                      <option value="TII">TII</option>
                                    </>
                                    :<></>
                                    
                                    }

                                    {
                                    (dataRegistro.level_profession=='PROFESIONAL' || dataRegistro.level_profession=='ESPECIALISTA' || dataRegistro.level_profession=='DOCTOR')?
                                    
                                    <>
                                      <option value="PI">PI</option>
                                      <option value="PII">PII</option>
                                      <option value="PIII">PIII</option>
                                    </>
                                    :<></>
                                    
                                    } 
                                   
                
                                </Form.Select>

                                </Col>
                                 
                          </Row>
                          <Row>

                               <Select_Form
                                    uptedate={actualizar_dataRegistro}
                                    date={dataRegistro}
                                    tag={'level'}
                                    label={'Nivel'}
                                    
                                    items={
                                      [{'value':'1','label':'1'},
                                      ,{'value':'2','label':'2'},
                                      {'value':'3','label':'3'},
                                      {'value':'4','label':'4'},
                                      {'value':'5','label':'5'},
                                      {'value':'6','label':'6'},
                                      {'value':'7','label':'7'},
                                   ]
                                    
                                    }
                                  />

                                  <Select_Form
                                    uptedate={actualizar_dataRegistro}
                                    date={dataRegistro}
                                    tag={'number_children'}
                                    label={'N° de hijos'}
                                    
                                    items={
                                      [{'value':'0','label':'0'},
                                      {'value':'1','label':'1'},
                                      {'value':'2','label':'2'},
                                      {'value':'3','label':'3'},
                                      {'value':'4','label':'4'},
                                      {'value':'5','label':'5'},
                                      {'value':'6','label':'6'},
                                      {'value':'7','label':'7'},
                                      {'value':'8','label':'8'},
                                      {'value':'7','label':'9'},
                                   ]
                                    
                                    }
                                  />

                          </Row>
                          <Row>
                              <Select_Form
                                    uptedate={actualizar_dataRegistro}
                                    date={dataRegistro}
                                    tag={'sexo'}
                                    label={'Genero'}
                                    
                                    items={
                                      [{'value':'Masculino','label':'Masculino'},
                                      ,{'value':'Femenino','label':'Femenino'},
                                     
                                   ]
                                    
                                    }
                                  />

                                <Input_Form
                                    uptedate={actualizar_dataRegistro}
                                    date={dataRegistro}
                                    tag={'chargue'}
                                    label={'Cargo'}
                                    type={'text'}
                                  />
                          </Row>
                          <Row>
                            <Input_Form
                                    uptedate={actualizar_dataRegistro}
                                    date={dataRegistro}
                                    tag={'division'}
                                    label={'Pertenece a la divición de:'}
                                    type={'text'}
                                  />

                            <Select_Form
                                    uptedate={actualizar_dataRegistro}
                                    date={dataRegistro}
                                    tag={'account_type'}
                                    label={'Tipo de cuenta'}
                                    
                                    items={
                                      [{'value':'0','label':'Ahorro'},
                                      ,{'value':'1','label':'Corriente'},
                                     
                                   ]
                                    
                                    }
                                  />
                          </Row>

                          <Row>
                          
        
        
                            <Input_Form
                                    uptedate={actualizar_dataRegistro}
                                    date={dataRegistro}
                                    tag={'bank_account'}
                                    label={'N° de cuenta bancaria'}
                                    type={'text'}
                                  />

                              <Input_Form
                                    uptedate={actualizar_dataRegistro}
                                    date={dataRegistro}
                                    tag={'phone'}
                                    label={'N° de telefono'}
                                    type={'text'}
                                  />

                          </Row>
                          <Row>
                          <Select_Form
                                    uptedate={actualizar_dataRegistro}
                                    date={dataRegistro}
                                    tag={'blood_type'}
                                    label={'Tipo de Sangre'}
                                    
                                    items={
                                      [{'value':'A+','label':'A+'},
                                       {'value':'A-','label':'A-'},
                                       {'value':'B+','label':'B+'},
                                       {'value':'B-','label':'B-'},
                                       {'value':'O+','label':'O+'},
                                       {'value':'O-','label':'O-'},
                                     
                                   ]
                                    
                                    }
                                  />
                          
                            </Row>
     
        </Modal.Body>
        <Modal.Footer>
          <Button variant="secondary" onClick={handleClose}>
            Close
          </Button>
          <Button variant="primary" onClick={Guardar_trabajador}>
            Save Changes
          </Button>
        </Modal.Footer>
      </Modal>
    </>
  );
}

export default Modals;