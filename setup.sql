DROP DATABASE IF EXISTS prueba;
CREATE DATABASE prueba;
USE prueba;


CREATE TABLE usuarios (
    email VARCHAR(255) PRIMARY KEY,
    nombre VARCHAR(100),
    pswd VARCHAR(100),
    tel VARCHAR(15)
);


CREATE TABLE transacciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_email VARCHAR(255), 
    tipo ENUM('pago', 'deuda'),
    monto DECIMAL(10, 2),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_email) REFERENCES usuarios(email) ON DELETE CASCADE
);
