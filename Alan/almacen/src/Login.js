import React, { useState } from 'react';
import axios from 'axios';
import { useHistory  } from 'react-router-dom';

const Login = ({ setToken }) => {
  const [formData, setFormData] = useState({
    user_name: '',
    password: ''
  });

  const history = useHistory(); // Importa y usa el hook useHistory

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
      const response = await axios.post('http://localhost:3001/login', formData);
      const token = response.data.token;
      setToken(token); // Envía el token al componente principal
      history.push('/envios'); // Redirige a la página principal
      alert('Login exitoso');
    } catch (error) {
      console.error('Error al iniciar sesión', error);
      alert('Error al iniciar sesión');
    }
  };

  return (
    <div>
      <h2>Login de Usuario</h2>
      <form onSubmit={handleSubmit}>
        <input type="text" name="user_name" placeholder="Nombre de usuario" onChange={handleChange} required />
        <input type="password" name="password" placeholder="Contraseña" onChange={handleChange} required />
        <button type="submit">Iniciar Sesión</button>
      </form>
    </div>
  );
};

export default Login;
