import {useState,useEffect} from 'react';
import {Table,InputGroup,Button,Alert} from 'react-bootstrap/';



const Tabla_bone=()=>{
    const [error, setError] = useState(null);
    const [isLoaded, setIsLoaded] = useState(false);
    const [items, setItems] = useState({'feeding':0,'Standard':0});
    const [update, setUpdate] = useState(false);
    const [save, setSave] = useState(false);
    const headers = { 'Content-Type': 'application/json' };

    const btnNone = {
      display: 'none', 
      
    };

    const btnBlock = {
      display: 'block', 
      
    };

    const actualizar=(e)=> {
      const {name,value} = e.target;
      setItems({...items,[name]:value});

      setUpdate(true);
      setSave(false);
    }

    const guardar=()=>{

      fetch("http://127.0.0.1:8000/api/configuracion_bone/set",{
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
  
   
    useEffect(() => {
      fetch("http://127.0.0.1:8000/api/configuracion_bone")
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
                         Concepto Bonificación
                     </th>
                     <th>
                         Monto
                     </th>
                 </tr>
             </thead>
             <tbody>
                 
                        <tr>
                            <td>
                             Bono por hijos
                            </td>
                            <td>
                            <InputGroup>
                              <input name='Standard' onChange={actualizar} value={items.Standard}/>
                            </InputGroup>
                               mesual c/u
                            </td>
                        </tr>
                        <tr>
                            <td>
                             Bono Alimentación
                            </td>
                            <td>
                            <InputGroup >
                              <input onChange={actualizar} name='feeding' value={items.feeding}/>
                            </InputGroup>
                               
                            </td>
                        </tr>                              
                  
             </tbody>
             
         </Table>
         <Button style={ update? btnBlock: btnNone} onClick={guardar} variant="success"> Save</Button>
         
         </>
      );
    }


   
}

export default Tabla_bone;