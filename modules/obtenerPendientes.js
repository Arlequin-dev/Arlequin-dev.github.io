export async function obtenerPendiente() {
    try {
        const response = await fetch("api.php?accion=pendientes", {
            method: 'GET',
            headers: {
                "Content-Type": "application/json",
            },
        });
        const data = await response.json();
        return data; 
    } catch (error) {
        console.error(error);
    }
}