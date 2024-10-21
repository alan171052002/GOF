import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Swal from 'sweetalert2';
import withReactContent from 'sweetalert2-react-content';
import * as XLSX from 'xlsx';
import { saveAs } from 'file-saver';

const noti = withReactContent(Swal);

function EditarEliminarEnvio() {
  const [enviosLista, setEnvios] = useState([]);
  const [idEditar, setIdEditar] = useState(null);
  const [cliente, setCliente] = useState("");
  const [paqueteria, setPaqueteria] = useState("");
  const [observaciones, setObservaciones] = useState("");
  const [conEmb, setConEmb] = useState("");

  useEffect(() => {
    getEnvios();
  }, []);

  const getEnvios = () => {
    const token = localStorage.getItem('token'); // Obtener el token del localStorage
    axios.get("http://localhost:3001/envios", {
      headers: {
        'Authorization': token
      }
    }).then((response) => {
      setEnvios(response.data);
    }).catch((error) => {
      console.error('Error al obtener envíos:', error);
    });
  };

  const editarEnvio = (val) => {
    setIdEditar(val.id);
    setCliente(val.cliente);
    setPaqueteria(val.paqueteria);
    setObservaciones(val.observaciones);
    setConEmb(val.con_emb);
  };

  const actualizarEnvio = () => {
    const token = localStorage.getItem('token'); // Obtener el token del localStorage
    axios.put(`http://localhost:3001/update/${idEditar}`, {
      cliente,
      paqueteria,
      observaciones,
      con_emb: conEmb
    }, {
      headers: {
        'Authorization': token
      }
    }).then(() => {
      getEnvios();
      limpiarCampos();
      noti.fire({
        title: "<strong>Actualización exitosa!</strong>",
        html: `El Envío de <strong>${cliente}</strong> fue actualizado con éxito!`,
        icon: "success",
        timer: 6000
      });
    }).catch((error) => {
      noti.fire({
        icon: "error",
        title: "Oops...",
        text: "No se logró actualizar el envío",
        footer: error.message === "Network Error" ? "Intente más tarde" : error.message
      });
    });
  };

  const eliminarEnvio = (val) => {
    const token = localStorage.getItem('token'); // Obtener el token del localStorage
    noti.fire({
      title: "Confirmar eliminado",
      html: `Realmente desea eliminar el envío de: <strong>${val.cliente}</strong>`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Sí, Eliminar!"
    }).then((result) => {
      if (result.isConfirmed) {
        axios.delete(`http://localhost:3001/delete/${val.id}`, {
          headers: {
            'Authorization': token
          }
        })
        .then(() => {
          getEnvios();
          limpiarCampos();
          noti.fire({
            title: "Eliminado!",
            text: `El envío de ${val.cliente} fue eliminado.`,
            icon: "success",
            timer: 6000
          });
        })
        .catch((error) => {
          noti.fire({
            icon: "error",
            title: "Oops...",
            text: "No se logró eliminar el envío",
            footer: error.message === "Network Error" ? "Intente más tarde" : error.message
          });
        });
      }
    });
  };

  const limpiarCampos = () => {
    setIdEditar(null);
    setCliente("");
    setPaqueteria("");
    setObservaciones("");
    setConEmb("");
  };

  const exportarExcel = () => {
    const ws = XLSX.utils.json_to_sheet(enviosLista);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Envíos");

    // Obtener la fecha actual en formato YYYY-MM-DD
    const fechaActual = new Date().toISOString().split('T')[0];

    const excelBuffer = XLSX.write(wb, { bookType: "xlsx", type: "array" });
    const data = new Blob([excelBuffer], { type: "application/octet-stream" });
    saveAs(data, `envios_${fechaActual}.xlsx`);
  };

  return (
    <div className="container mt-4">
      <h1>Editar / Eliminar Envíos</h1>
      <button className="btn btn-success mb-3" onClick={exportarExcel}>Exportar a Excel</button>
      <table className="table table-dark table-striped">
        <thead>
          <tr>
            <th scope="col">Cliente</th>
            <th scope="col">Paquetería</th>
            <th scope="col">Observaciones</th>
            <th scope="col">Condiciones de Envío</th>
            <th scope="col">Acciones</th>
          </tr>
        </thead>
        <tbody>
          {enviosLista.map((val, key) => (
            <tr key={val.id}>
              <td>{val.cliente}</td>
              <td>{val.paqueteria}</td>
              <td>{val.observaciones}</td>
              <td>{val.con_emb}</td>
              <td>
                <div className="btn-group" role="group" aria-label="Basic mixed styles example">
                  <button type="button" onClick={() => editarEnvio(val)} className="btn btn-info">Editar</button>
                  <button type="button" onClick={() => eliminarEnvio(val)} className="btn btn-danger">Eliminar</button>
                </div>
              </td>
            </tr>
          ))}
        </tbody>
      </table>

      {idEditar !== null && (
        <div className="card mt-4">
          <div className="card-header">Editar Envío</div>
          <div className="card-body">
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
          </div>
          <div className="card-footer">
            <button className="btn btn-success me-2" onClick={actualizarEnvio}>Actualizar</button>
            <button className="btn btn-danger" onClick={limpiarCampos}>Cancelar</button>
          </div>
        </div>
      )}
    </div>
  );
}

export default EditarEliminarEnvio;
