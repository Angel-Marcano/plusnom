import {useState,useEffect} from 'react';



const useFetch=(url,type_response={})=>{

    const [data,setData] = useState(type_response)
    const [error,setError] = useState(null)
    const [loading,setLoading] = useState(true)

    useEffect(() => {
        (
            async function(){
                try{
                    setLoading(true)
                    const response = await fetch(url);

                    if(!response.ok){
                        throw {
                            err:true,
                            status:response,
                            statusText:!response.status ? 'ocurrio un error': response.status
                        }
                    }

                let data=await response.json();

                setLoading(true);
                setData(data);
                setError({err:false});

                }catch(err){
                    setError(err);
                    setLoading(false);
                   

                }finally{
                    setLoading(false)
                }
            }
        )()
    }, [url])

    return { data, error, loading }

}
export default useFetch;


/*
const useFecth=async(url)=>{

    const [error, setError] = useState(false);
    const [isPending, setIsPending] = useState(true);
    const [data, setData]= useState(null);   

    useEffect((url) => {
        
           

            try{
                let respuesta=await fetch('http://127.0.0.1:8000/api/configuracion_bone');

                if(!respuesta.ok){
                    throw {
                        err:true,
                        status:respuesta,
                        statusText:!respuesta.status ? 'ocurrio un error': respuesta.status
                    }
                }

                let data=await respuesta.json();

                setIsPending(false);
                setData(respuesta);
                setError({err:false});



            }
            catch(err){
                setIsPending(true);
                setError(err);

            }
           


        
        /*then(res => res.json())
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

    return {error,isPending,data}
    
}

export default useFecth;
     
*/