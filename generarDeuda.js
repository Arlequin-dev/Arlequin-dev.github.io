export async function generarDeuda(email, deuda) {
      if (email) {
    try {
      const response = await fetch('api.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          accion: 'deuda',
          email: email,
          monto: deuda,
        })
      });

      const text = await response.text();
      console.log('Respuesta cruda:', text);

      let data;
      try {
        data = JSON.parse(text);
      } catch (e) {
        console.error('No se pudo parsear JSON:', e, text);
      }

      if (data.success || data.message === 'Deuda creada correctamente') {
        console.log('deuda exitosa');
      } else {
        console.error('Error al crear deuda:', data.error || data.message);
      }
    } catch (error) {
      console.error('Error en la petición:', error);
    }
  }
}