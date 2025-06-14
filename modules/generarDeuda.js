export async function generarDeuda(email, tituloInput ,deuda) {
  if (email) {
    try {
      const response = await fetch("api.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          accion: "deuda",
          email: email,
          titulo: tituloInput.value, 
          monto: deuda.value,
        }),
      });

      const text = await response.text();
      console.log("Respuesta cruda:", text);

      let data;
      try {
        data = JSON.parse(text);
      } catch (e) {
        console.error("No se pudo parsear JSON:", e, text);
      }

      if (data.success || data.message === "Deuda creada correctamente") {
        console.log("deuda exitosa");
      } else {
        console.error("Error al crear deuda:", data.error || data.message);
      }
    } catch (error) {
      console.error("Error en la petición:", error);
    }
  }
}

export async function obtenerDeuda(email) {
  if (email) {
    try {
      const response = await fetch("api.php?accion=deudas", {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      });
      const data = await response.json();
      if (data.success) {
        return data.deudas;
      } else {
        console.error("Error al obtener deudas:", data.error);
        return null;
      }
    } catch (error) {
      console.error("Error en la petición:", error);
      return null;
    }
  }
}
