import {useState,useEffect} from 'react';
import {InputGroup, Table} from 'react-bootstrap';

const Tabla_antiguedad=()=>{
    const [error, setError] = useState(null);
    const [isLoaded, setIsLoaded] = useState(false);
    const [items, setItems] = useState([]);
    const [update, setUpdate] = useState(false);
    const [save, setSave] = useState(false);
    var cont=-1;

    const headers = { 'Content-Type': 'application/json' };

    const btnNone = {
      display: 'none', 
      
    };

    const btnBlock = {
      display: 'block', 
      
    };

    const actualizar=(e)=> {
      const {name,value} = e.target;

      //console.log(items[name]['valor']);

     // const n_items={'valor':value,'antiguedad':name};

      setItems(...items);

      console.log(items);
     // setUpdate(true);
     // setSave(false);
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
      fetch("http://127.0.0.1:8000/api/configuracion_antiguedad")
        .then(res => res.json())
        .then(
          (result) => {
            setIsLoaded(true);
            setItems(result);
            console.log(result);
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
            console.log(items);
      return (
         <Table striped bordered hover>
             <thead>
                 <tr>
                     <th>
                         Antiguedad
                     </th>
                     <th>
                         %
                     </th>
                 </tr>
             </thead>
             <tbody>
             { 
             
                items.map((e)=>{
                  {cont++;}
                  return(
                    <tr key={e}>
                      <th>
                          {cont} años
                      </th>
                      <th>
                          {e}
                         
                      </th>
                  </tr>
                 )
                 
                })
                }
    
             </tbody>
         </Table>
      );
    }


   
}

export default Tabla_antiguedad;