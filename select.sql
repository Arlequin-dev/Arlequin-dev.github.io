use prueba; 
SELECT 
    usuarios.email,
    usuarios.nombre,
    usuarios.pswd,
    usuarios.tel,
    transacciones.id AS transaccion_id,
    transacciones.tipo,
    transacciones.monto,
    transacciones.fecha
FROM 
    usuarios
LEFT JOIN 
    transacciones
ON 
    usuarios.email = transacciones.usuario_email;
