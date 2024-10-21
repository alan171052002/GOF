import React, { useState } from 'react';
import axios from 'axios';
import Swal from 'sweetalert2';
import withReactContent from 'sweetalert2-react-content';

const noti = withReactContent(Swal);

function RegistroEnvio() {
  const [cliente, setCliente] = useState("");
  const [paqueteria, setPaqueteria] = useState("");
  const [observaciones, setObservaciones] = useState("");
  const [conEmb, setConEmb] = useState("");

  const add = () => {
    const token = localStorage.getItem('token'); // Obtener el token del localStorage
    axios.post("http://localhost:3001/create", {
      cliente,
      paqueteria,
      observaciones,
      con_emb: conEmb
    }, {
      headers: {
        'Authorization': token
      }
    }).then(() => {
      limpiarCampos();
      noti.fire({
        title: "<strong>Registro exitoso!</strong>",
        html: `El Envío de <strong>${cliente}</strong> fue registrado con éxito!`,
        icon: "success",
        timer: 6000
      });
    }).catch((error) => {
      noti.fire({
        icon: "error",
        title: "Oops...",
        text: "No se logró registrar el envío",
        footer: error.message === "Network Error" ? "Intente más tarde" : error.message
      });
    });
  };

  const limpiarCampos = () => {
    setCliente("");
    setPaqueteria("");
    setObservaciones("");
    setConEmb("");
  };

  return (
    <div className="container mt-4">
      <h1>Registro de Envío</h1>
      <div className="mb-3">
        <label className="form-label">Cliente</label>
        <input type="text" className="form-control" value={cliente} onChange={(e) => setCliente(e.target.value)} />
      </div>
      <div className="mb-3">
        <label className="form-label">Paquetería</label>
        <input type="text" className="form-control" value={paqueteria} onChange={(e) => setPaqueteria(e.target.value)} />
      </div>
      <div className="mb-3">
        <label className="form-label">Observaciones</label>
        <input type="text" className="form-control" value={observaciones} onChange={(e) => setObservaciones(e.target.value)} />
      </div>
      <div className="mb-3">
        <label className="form-label">Condiciones de Envío</label>
        <input type="text" className="form-control" value={conEmb} onChange={(e) => setConEmb(e.target.value)} />
      </div>
      <button className="btn btn-primary" onClick={add}>Registrar Envío</button>
    </div>
  );
}

export default RegistroEnvio;
