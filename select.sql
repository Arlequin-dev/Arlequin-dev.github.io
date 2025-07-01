USE prueba;

SELECT 
    usuarios.email,
    usuarios.nombre,
    usuarios.pswd,
    usuarios.rol,
    usuarios.estado, 
    usuarios.tel,

    transacciones.id AS transaccion_id,
    transacciones.tipo AS transaccion_tipo,
    transacciones.titulo AS transaccion_titulo,
    transacciones.monto,
    transacciones.fecha AS transaccion_fecha,

    tareas.id AS tarea_id,
    tareas.titulo AS tarea_titulo,
    tareas.estado AS tarea_estado,
    tareas.fecha_emision AS tarea_fecha,
    tareas.fecha_limite AS tarea_limite

FROM 
    usuarios
LEFT JOIN 
    transacciones ON usuarios.email = transacciones.usuario_email
LEFT JOIN 
    tareas ON usuarios.email = tareas.usuario_email;


--UPDATE usuarios 
--SET rol = 'admin', estado = 'activo' 
--WHERE email = 'a@gmail.com';