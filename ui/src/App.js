import Saludo from './componentes/Saludo';
import Configuracion from './componentes/view/Configuracion';
import Login from './componentes/view/Home';
import Constancia from './componentes/view/Contancia';
import Nomina from './componentes/view/Nomina';
import Container from 'react-bootstrap/Container';
import Navegador from './componentes/Nav';
import { BrowserRouter, Route, Routes } from 'react-router-dom';

function App() {
  
  return (
        
        <BrowserRouter>
      
          <Navegador></Navegador>
          <Container fluid>
            
  
            
              <Routes>
                <Route exact path="/Login/sanctum/csrf-cookie" element={<Login/>}/>
                <Route exact path="/Login" element={<Login/>}/>
                <Route exact path="/Saludo" element={<Saludo/>}/>
                <Route exact path="/Configuracion" element={<Configuracion/>}/>
                <Route exact path="/Home" element={<Login/>}/>
                <Route exact path="/Constancia" element={<Constancia/>}/>
                <Route exact path="/Nomina" element={<Nomina/>}/>
                
              </Routes>
                

          </Container>
        </BrowserRouter>
   
  );
}

export default App;
