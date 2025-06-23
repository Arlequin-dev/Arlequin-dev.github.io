export async function obtenerAprobados() {
    try {
        const response = await fetch("api.php?accion=aprobados", {
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