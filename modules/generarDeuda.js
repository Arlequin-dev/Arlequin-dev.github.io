import alerts from './sweetAlerts.js';
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
      

      let data;
      try {
        data = JSON.parse(text);
      } catch (e) {

      }

      if (data.success || data.message === "Deuda creada correctamente") {
      console.log("deuda exitosa");
      alerts.success("Deuda creada correctamente", "Éxito");
       tituloInput.value = "";
       deuda.value = ""; 
      } else {
        alerts.error("Error al crear la deuda: " + (data.error || data.message), "Error");
      }
    } catch (error) {
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
