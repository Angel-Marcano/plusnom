import {Form,Col } from "react-bootstrap";


export const Input_Form=(props)=>{

    const {tag,date,label,type,uptedate,xs,placeholder}=props;

   

    return (
        
        <Col xs={xs?xs:null}>
          <Form.Group className="mb-3" >
          <Form.Label>{label}</Form.Label>
          <Form.Control placeholder={placeholder?placeholder:null}  name={tag} onChange={uptedate} value={date.tag} type={type}  />
          </Form.Group>
        </Col>
    )

}


export const Select_Form=(props)=>{

  const {tag,date,label,uptedate,xs,items,disabled}=props;

  return (
      
      <Col xs={props.xs?props.xs:null}>
         <label >{label}</label> <br/>
        <Form.Select style={{marginTop:'8px',marginRight:'20px',marginBottom:'5px'}}  disabled={disabled?disabled:false} name={tag} onChange={uptedate} value={date.tag}>
        {
        items.map((item)=>{
                return(<option value={item.value}>{item.label}</option>)                 
                })
          }          
        </Form.Select>
      </Col>
  )

}


