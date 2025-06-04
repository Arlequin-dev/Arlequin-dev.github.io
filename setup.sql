DROP DATABASE IF EXISTS prueba; 
CREATE DATABASE prueba;
USE prueba;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    email VARCHAR(100),
    pswd VARCHAR(100),
    tel VARCHAR(100)
);
