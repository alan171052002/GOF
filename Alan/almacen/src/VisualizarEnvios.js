// VisualizarEnvios.js
import React, { useState, useEffect } from 'react';
import axios from 'axios';

function VisualizarEnvios() {
  const [enviosLista, setEnvios] = useState([]);

  useEffect(() => {
    const getEnvios = async () => {
      try {
        const token = localStorage.getItem('token');
        const response = await axios.get('http://localhost:3001/envios', {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        });
        setEnvios(response.data);
      } catch (error) {
        console.error('Error al obtener envíos:', error);
      }
    };

    getEnvios();
    const interval = setInterval(() => {
      getEnvios();
    }, 5000);

    return () => clearInterval(interval);
  }, []);

  const cambiarEstado = async (id, nuevoEstado) => {
    try {
      const token = localStorage.getItem('token');
      await axios.put(`http://localhost:3001/envios/${id}/estado`, { estado: nuevoEstado }, {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      });
      setEnvios(prevEnvios =>
        prevEnvios.map(envio =>
          envio.id === id ? { ...envio, estado: nuevoEstado } : envio
        )
      );
    } catch (error) {
      console.error('Error al cambiar estado del envío:', error);
    }
  };

  const getRowClass = (estado) => {
    switch (estado) {
      case 'completo':
        return 'table-success';
      case 'retrasado':
        return 'table-warning';
      case 'incompleto':
        return 'table-danger';
      default:
        return '';
    }
  };

  return (
    <div className="container mt-4">
      <h1 className="mb-4">Visualizar Envíos</h1>
      <table className='table table-dark table-striped'>
        <thead>
          <tr>
            <th scope='col'>Cliente</th>
            <th scope='col'>Paquetería</th>
            <th scope='col'>Observaciones</th>
            <th scope='col'>Condiciones de Envío</th>
            <th scope='col'>Estado</th>
          </tr>
        </thead>
        <tbody>
          {enviosLista.map((val) => (
            <tr key={val.id} className={getRowClass(val.estado)}>
              <td>{val.cliente}</td>
              <td>{val.paqueteria}</td>
              <td>{val.observaciones}</td>
              <td>{val.con_emb}</td>
              <td>
                <div className="btn-group">
                  <button
                    className='btn btn-success'
                    onClick={() => cambiarEstado(val.id, 'completo')}
                  >Completo</button>
                  <button
                    className='btn btn-warning'
                    onClick={() => cambiarEstado(val.id, 'retrasado')}
                  >Retrasado</button>
                  <button
                    className='btn btn-danger'
                    onClick={() => cambiarEstado(val.id, 'incompleto')}
                  >Incompleto</button>
                </div>
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}

export default VisualizarEnvios;
