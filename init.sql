-- Eliminar y crear la base de datos
DROP DATABASE IF EXISTS prueba;
CREATE DATABASE prueba;
USE prueba;

-- Tabla de usuarios
CREATE TABLE usuarios (
    email VARCHAR(255) PRIMARY KEY,
    rol ENUM('admin', 'tesorero', 'socio') DEFAULT 'socio',
    estado ENUM('pendiente', 'activo', 'rechazado') DEFAULT 'pendiente',
    nombre VARCHAR(100),
    pswd VARCHAR(100),
    tel VARCHAR(15)
);

-- Tabla de transacciones
CREATE TABLE transacciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100),
    usuario_email VARCHAR(255),
    tipo ENUM('pago', 'deuda'),
    monto DECIMAL(10, 2),
    fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_email) REFERENCES usuarios(email) ON DELETE CASCADE
);

-- Tabla de tareas
CREATE TABLE tareas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100),
    usuario_email VARCHAR(255),
    estado ENUM('completo', 'sc'),
    fecha_emision TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_limite DATETIME,
    FOREIGN KEY (usuario_email) REFERENCES usuarios(email) ON DELETE CASCADE
);

-- Tabla de deudas por usuario
CREATE TABLE deudas_usr (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255),
    monto_total DECIMAL(10, 2),
    fech_act DATETIME,
    FOREIGN KEY (email) REFERENCES usuarios(email) ON DELETE CASCADE
);

-- Tabla de horas de trabajo
CREATE TABLE hs_trabajos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sem_corrs VARCHAR(100),
    monto_inc DECIMAL(10, 2),
    hs_rabajo DECIMAL(5, 2),
    email VARCHAR(255),
    FOREIGN KEY (email) REFERENCES usuarios(email) ON DELETE CASCADE
);

-- Tabla de estadísticas semanales
CREATE TABLE est_sem (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hs_sem DECIMAL(5, 2)
);

-- Tabla de estado de semana
CREATE TABLE estado_semana (
    id INT AUTO_INCREMENT PRIMARY KEY,
    est_sem_id INT,
    estado ENUM('cumple', 'justificado', 'compensado', 'sc'),
    FOREIGN KEY (est_sem_id) REFERENCES est_sem(id) ON DELETE CASCADE
);

-- Tabla de unidades habitacionales
CREATE TABLE u_habi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    direccion VARCHAR(255)
);

-- Tabla de estado de contribución
CREATE TABLE est_con (
    id INT AUTO_INCREMENT PRIMARY KEY,
    est_sem_id INT,
    estado ENUM('ec', 'sc'),
    FOREIGN KEY (est_sem_id) REFERENCES est_sem(id) ON DELETE CASCADE
);

-- Tabla de asignación de unidad habitacional a usuario
CREATE TABLE asig_h (
    email VARCHAR(255),
    u_habi_id INT,
    PRIMARY KEY (email),
    FOREIGN KEY (email) REFERENCES usuarios(email) ON DELETE CASCADE,
    FOREIGN KEY (u_habi_id) REFERENCES u_habi(id) ON DELETE CASCADE
);
