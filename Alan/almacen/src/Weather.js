// src/Weather.js
import React, { useEffect, useState } from 'react';
import axios from 'axios';

const Weather = () => {
  const [weatherData, setWeatherData] = useState(null);
  const appId = '3f48b4c5'; // Reemplaza con tu APP_ID
  const appKey = '1c33f6144f063cfa87a777723d85d688'; // Reemplaza con tu APP_KEY

  useEffect(() => {
    const fetchWeather = async () => {
      try {
        const response = await axios.get(
          `http://api.weatherunlocked.com/api/current/19.043,-98.198?app_id=${appId}&app_key=${appKey}`
        );
        setWeatherData(response.data);
      } catch (error) {
        console.error('Error fetching the weather data', error);
      }
    };

    fetchWeather();
  }, []);

  return (
    <div>
      <h1>Clima en Puebla</h1>
      {weatherData ? (
        <div>
          <p>Temperatura: {weatherData.temp_c}°C</p>
          <p>Clima: {weatherData.wx_desc}</p>
        </div>
      ) : (
        <p>Loading...</p>
      )}
    </div>
  );
};

export default Weather;
