import React, { useState, } from 'react';
import { BrowserRouter as Router, Switch, Route, Link, Redirect, useHistory } from 'react-router-dom';
import 'bootstrap/dist/css/bootstrap.min.css';
import EditarEliminarEnvio from './EditarEliminarEnvio';
import VisualizarEnvios from './VisualizarEnvios';
import RegistroEnvio from './RegistroEnvio';
import Weather from './Weather';
import Login from './Login';
import Register from './Register';
import './App.css';


function App() {
  const [token, setToken] = useState(null);
  const history = useHistory();

  const handleLogout = () => {
    setToken(null);
    history.push('/login');
  };

  return (
    <Router>
      <div className="container mt-4">
        <nav className="navbar navbar-expand-lg navbar-light bg-light">
          <div className="container-fluid">
            <Link className="navbar-brand" to="/">Gestión de Envíos</Link>
            <button className="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span className="navbar-toggler-icon"></span>
            </button>
            <div className="collapse navbar-collapse" id="navbarNav">
              <ul className="navbar-nav">
                {token ? (
                  <>
                    <li className="nav-item">
                      <Link className="nav-link" to="/visualizar">Visualizar Envíos</Link>
                    </li>
                    <li className="nav-item">
                      <Link className="nav-link" to="/editar">Editar / Eliminar Envíos</Link>
                    </li>
                    <li className="nav-item">
                      <Link className="nav-link" to="/registro">Registrar Envío</Link>
                    </li>
                    <li className="nav-item">
                      <button className="nav-link btn btn-link" onClick={handleLogout}>Cerrar Sesión</button>
                    </li>
                  </>
                ) : (
                  <>
                    <li className="nav-item">
                      <Link className="nav-link" to="/login">Login</Link>
                    </li>
                    <li className="nav-item">
                      <Link className="nav-link" to="/register">Registrar</Link>
                    </li>
                  </>
                )}
              </ul>
            </div>
            {token && (
              <div className="App">
                <Weather />
              </div>
            )}
          </div>
        </nav>

        <Switch>
          <Route path="/login">
            <Login setToken={setToken} />
          </Route>
          <Route path="/register">
            <Register />
          </Route>
          <Route path="/visualizar">
            {token ? <VisualizarEnvios /> : <Redirect to="/login" />}
          </Route>
          <Route path="/editar">
            {token ? <EditarEliminarEnvio /> : <Redirect to="/login" />}
          </Route>
          <Route path="/registro">
            {token ? <RegistroEnvio /> : <Redirect to="/login" />}
          </Route>
          <Route path="/">
            <h1>Bienvenido a la Gestión de Envíos</h1>
          </Route>
        </Switch>
      </div>
    </Router>
  );
}

export default App;
