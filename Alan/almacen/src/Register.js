// src/Register.js
import React, { useState } from 'react';
import axios from 'axios';

const Register = () => {
  const [formData, setFormData] = useState({
    user_name: '',
    Nombre: '',
    Departamento: '',
    password: ''
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    try {
      await axios.post('http://localhost:3001/register', formData);
      alert('Usuario registrado exitosamente');
    } catch (error) {
      console.error('Error al registrar el usuario', error);
    }
  };

  return (
    <div>
      <h2>Registro de Usuario</h2>
      <form onSubmit={handleSubmit}>
        <input type="text" name="user_name" placeholder="Nombre de usuario" onChange={handleChange} required />
        <input type="text" name="Nombre" placeholder="Nombre" onChange={handleChange} required />
        <input type="text" name="Departamento" placeholder="Departamento" onChange={handleChange} required />
        <input type="password" name="password" placeholder="Contraseña" onChange={handleChange} required />
        <button type="submit">Registrar</button>
      </form>
    </div>
  );
};

export default Register;
