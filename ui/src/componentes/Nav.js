import Navbar from 'react-bootstrap/Navbar';
import Container from 'react-bootstrap/Container';
import Nav from 'react-bootstrap/Nav';
import NavDropdown from 'react-bootstrap/NavDropdown';
import Button from 'react-bootstrap/Button';
import NavLink from 'react-bootstrap/NavLink';

import {Link } from 'react-router-dom';
import {LinkContainer } from 'react-router-bootstrap';

const Navegador=()=>{ 
  return(  
    <Navbar collapseOnSelect expand="lg" bg="dark" variant="dark">
    <Container>
    <Navbar.Brand href="#home">Plusnom Alfa 1.1.0</Navbar.Brand>
    <Navbar.Toggle aria-controls="responsive-navbar-nav" />
    <Navbar.Collapse id="responsive-navbar-nav">
      <Nav className="me-auto">
        <Nav.Link href="Constancia">Constancia</Nav.Link>
        <Nav.Link href="Nomina">Nomina</Nav.Link>
        <Nav.Link href="Home" >home</Nav.Link>
        <Nav.Link href="Configuracion">Configuracion</Nav.Link>
       
        
        
      </Nav>
      <Nav>
        <Nav.Link href="#deets">Salir</Nav.Link>
      </Nav>
    </Navbar.Collapse>
    </Container>
  </Navbar>
   
  );

}


export default Navegador;