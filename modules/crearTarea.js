import alerts from './sweetAlerts.js'
export async function crearTarea(titulo,email,fecha_limite){
    if(email){
        try{
            const response = await fetch("api.php",{
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    accion: "tarea",
                    titulo: titulo, 
                    email: email,
                    fecha_limite: fecha_limite,
                }),
            });
            const text = await response.text(); 
            let data; 
            try{
                data = JSON.parse(text); 
            }catch(e){
                console.log(text)
                console.error(e)
            }
            if(data.success || data.message === "Tarea creada correctamente"){
                console.log("tarea exitosa"); 
                alerts.success("Tarea correctamente creada", "Éxito",{
                    reloadOnSuccess: true
                });
            }else{
                alerts.error("Error al crear la tarea: " + (data.error || data.message), "Error")
            }
        }catch(e){
            console.error(e)
        }
    }
}

export async function obtenerTareas(email) {
    if (email) {
        try {
            const response = await fetch("api.php?accion=tareas", {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                },
            });
            const data = await response.json();
            if (data.success) {
                return data.tareas;
            } else {
                console.error("Error al obtener tareas:", data.error);
                return null;
            }
        } catch (error) {
            console.error("Error en la petición:", error);
        }
    }
}
export async function completarTarea(id) {
    try {
        const response = await fetch("api.php", {
            method: "PUT",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                accion: "completarTarea",
                id: id,
            }),
        });
        const data = await response.json();
        if (data.success) {
            alerts.success("Tarea completada correctamente", "Éxito", {
                reloadOnSuccess: true
            });
        } else {
            alerts.error("Error al completar la tarea: " + (data.error || data.message), "Error");
        }
    } catch (error) {
        console.error("Error al completar la tarea:", error);
    }
}