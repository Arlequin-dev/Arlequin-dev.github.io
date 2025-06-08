export async function obtenerEmailUsuario() {
  try {
    const response = await fetch("api.php?accion=verificar", {
      method: "GET",
      headers: {
        "Content-Type": "application/json"
      },
    });
    const data = await response.json();
    if (data.success) {
      return data.email;
    } else {
      console.error("Error:", data.error);
      return null;
    }
  } catch (error) {
    console.error("Error en la petición:", error);
    return null;
  }
}
