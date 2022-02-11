import Saludo from './componentes/Saludo';
import Configuracion from './componentes/view/Configuracion';
import Home from './componentes/view/Home';
import Constancia from './componentes/view/Contancia';
import Container from 'react-bootstrap/Container';
import Navegador from './componentes/Nav';
import { BrowserRouter, Route, Routes } from 'react-router-dom'



function App() {
  return (
    <BrowserRouter>
      <Navegador></Navegador>
      <Container fluid>
        
               
        
          <Routes>
            <Route exact path="/Saludo" element={<Saludo/>}/>
            <Route exact path="/Configuracion" element={<Configuracion/>}/>
            <Route exact path="/Home" element={<Home/>}/>
            <Route exact path="/Constancia" element={<Constancia/>}/>
            
          </Routes>
            

      </Container>
    </BrowserRouter>
  );
}

export default App;
