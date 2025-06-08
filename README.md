# Arlequin-dev.github.io

Repositorio del sitio web estático y backend básico para gestión de usuarios desarrollado con HTML, CSS, JavaScript y PHP.

---

## Descripción

Este proyecto es un sitio web que incluye funcionalidades de inicio de sesión, visualización y edición de perfil de usuario, y administración básica mediante una API en PHP que interactúa con la base de datos. 

El objetivo es ofrecer una plataforma simple para manejar usuarios con un frontend amigable y un backend ligero.

---

## Estructura del proyecto

- **Frontend:**
  - `index.html` - Página principal de bienvenida.
  - `login.html` - Formulario para que los usuarios inicien sesión.
  - `pagina-principal.html` - Dashboard o página principal luego de iniciar sesión.
  - `usuario.html` - Página para mostrar y editar información del usuario.
  - Carpeta `scripts/` - Archivos JavaScript para interacción dinámica (`main.js`, `revealinfo.js`).
  - Carpeta `styles/` - Archivos CSS para estilos (`principal.css`, `style.css`, `styles.css`).

- **Backend:**
  - `api.php` - Punto de entrada para peticiones API relacionadas con usuarios.
  - `controladorUsuario.php` - Controlador que contiene la lógica de negocio para operaciones con usuarios.
  - `modeloUsuario.php` - Modelo para la interacción directa con la base de datos.
  - Scripts SQL (`setup.sql`, `select.sql`) para crear y consultar la base de datos.

---

## Requisitos

- Servidor web con soporte PHP (Apache, Nginx con PHP-FPM, etc.).
- Base de datos MySQL o compatible (MariaDB).
- Navegador web moderno para el frontend.

---

## Instalación

1. Clona este repositorio en tu servidor local o remoto:

   ```bash
   git clone https://github.com/Arlequin-dev/Arlequin-dev.github.io.git
   cd Arlequin-dev.github.io
Configura tu servidor web para servir el contenido desde esta carpeta.
Importa la base de datos usando el script SQL:
mysql -u usuario -p nombre_base_de_datos < setup.sql
Ajusta la configuración de conexión a la base de datos en modeloUsuario.php si es necesario (host, usuario, contraseña, nombre de la base).
Asegúrate que el servidor tenga permisos para ejecutar los archivos PHP.

### Uso
Abre index.html para acceder a la página principal.
Navega a login.html para iniciar sesión con un usuario registrado.
Tras autenticación exitosa, se redirige a pagina-principal.html.
Desde ahí, puedes acceder a tu perfil en usuario.html para ver o modificar datos.
Las operaciones con usuarios se gestionan mediante la API en api.php.
