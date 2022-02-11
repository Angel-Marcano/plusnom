import FormControl from 'react-bootstrap/FormControl';
import Tabla_antiguedad from '../componentes_view/Tabla_anguedad';
import Tabla_profesion from '../componentes_view/Tabla_profesion';
import Tabla_bone from '../componentes_view/Tabla_bone';
import { Form,Row, Col, Button } from "react-bootstrap";



const Configuracion =()=>{
    return(
        <div>
        <h3>Configuracion</h3>
        
        <Row>
            <Col xs={4}>
                <Tabla_antiguedad />
            </Col>
            <Col xs={4}>
                <Tabla_profesion />
            </Col>
            <Col xs={4}>
                <Tabla_bone />
            </Col>
        </Row>
        </div>
    )
}

export default Configuracion;