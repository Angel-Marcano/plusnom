import {useState,useEffect} from 'react';
import {InputGroup, Table,Alert,Button} from 'react-bootstrap';

const Tabla_profesion=()=>{
    const [error, setError] = useState(null);
    const [isLoaded, setIsLoaded] = useState(false);
    const [items, setItems] = useState({'BACHILLER':0,'TSU':0,'PROFESIONAL':0,'ESPECIALISTA':0,'MAESTRIA':0,'DOCTOR':0});
    const [update, setUpdate] = useState(false);
    const [save, setSave] = useState(false);
    const headers = { 'Content-Type': 'application/json' };

    const btnNone = {
      display: 'none', 
      
    };

    const btnBlock = {
      display: 'block', 
      
    };


    const guardar=()=>{

      fetch("http://127.0.0.1:8000/api/configuracion_profesion/set",{
      method: 'POST',headers,
      body: JSON.stringify({'items':items})})
        .then(res => res.json())
        .then(
          (result) => {
            setIsLoaded(true);
            setUpdate(false);
            if(result['mensaje']){
              setSave(true);
            }
          },
          
          (error) => {
            setIsLoaded(true);
            setError(error);
          }
        )
    
  
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {

     // repsuesta
    }

    }

    const actualizar=(e)=> {
      const {name,value} = e.target;
      setItems({...items,[name]:value});

      setUpdate(true);
      setSave(false);
    }

    useEffect(() => {
      fetch("http://127.0.0.1:8000/api/configuracion_profesion")
        .then(res => res.json())
        .then(
          (result) => {
            setIsLoaded(true);
            setItems(result);
            
          },
        
          (error) => {
            setIsLoaded(true);
            setError(error);
          }
        )
    }, [])
  
    if (error) {
      return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
      return <div>Loading...</div>;
    } else {
      return (
       
        <>
        { save? <Alert variant={
                "success"}>
                Guardado exito!
              </Alert>:'' }
         <Table striped bordered hover>
             <thead>
                 <tr>
                     <th>
                         Nivel Profesional
                     </th>
                     <th>
                         %
                     </th>
                 </tr>
             </thead>
             <tbody>
                 
                        <tr>
                            <td>
                             Bachiller
                            </td>
                            <td>
                              <InputGroup>
                              <input value={items.BACHILLER} name={"BACHILLER"} onChange={actualizar}></input>
                              </InputGroup>
                            </td>
                        </tr>
                        <tr>
                            <td>
                             TSU
                            </td>
                            <td>
                              <InputGroup>
                                <input value={items.TSU} name={"TSU"} onChange={actualizar}></input>
                              </InputGroup>
                            </td>
                        </tr>
                        <tr>
                            <td>
                             PROFESIONAL
                            </td>
                            <td>
                              <InputGroup>
                                <input value={items.PROFESIONAL} name={"PROFESIONAL"} onChange={actualizar}></input>
                              </InputGroup>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            ESPECIALISTA
                            </td>
                            <td>
                              
                              <InputGroup>
                                <input value={items.ESPECIALISTA} name={"ESPECIALISTA"} onChange={actualizar}></input>
                              </InputGroup>
                            
                            </td>
                        </tr>  
                        <tr>
                            <td>
                            MAESTRIA
                            </td>
                            <td>
                              <InputGroup>
                                <input value={items.MAESTRIA} name={"MAESTRIA"} onChange={actualizar}></input>
                              </InputGroup>
                            </td>
                        </tr>  
                        <tr>
                            <td>
                            DOCTOR
                            </td>
                            <td>
                              <InputGroup>
                                <input value={items.DOCTOR} name={"DOCTOR"} onChange={actualizar}></input>
                              </InputGroup>
                            </td>
                        </tr>            
                  
             </tbody>
         </Table>

<       Button style={ update? btnBlock: btnNone} onClick={guardar} variant="success"> Save</Button>
         </>
      );
    }


   
}

export default Tabla_profesion;