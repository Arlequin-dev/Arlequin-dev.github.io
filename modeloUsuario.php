<?php
class ModeloUsuario
{
    private $db;

    public function __construct()
    {
        $this->db = new mysqli("localhost", "root", "", "prueba");
    }

    public function insertarUsuario($nombre,$rol, $email, $pswd, $tel)
    {
        $pswdHash = password_hash($pswd, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, rol ,email, pswd, tel) VALUES (? , ? , ?, ?, ?)");
        $stmt->bind_param("sssss", $nombre, $rol, $email, $pswdHash, $tel);

        if ($stmt->execute()) {
            return ['success' => true, 'email' => $email];
        } else {
            return ['error' => 'Error al insertar usuario: ' . $stmt->error];
        }
    }

    public function verificarCredenciales($email, $pswd)
    {
        $stmt = $this->db->prepare("SELECT nombre, pswd, estado FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            if ($usuario['estado'] !== 'activo') {
                return ['success' => false, 'error' => 'Tu cuenta aún no ha sido aceptada.'];
            }
            if (password_verify($pswd, $usuario['pswd'])) {
                return [
                    'success' => true,
                    'email' => $email,
                    'nombre' => $usuario['nombre']
                ];
            } else {
                return ['success' => false, 'error' => 'Contraseña incorrecta'];
            }
        } else {
            return ['success' => false, 'error' => 'Usuario no encontrado'];
        }
    }

    public function cambiarUsuario($email, $pswd_vieja, $pswd_nueva)
    {
        $stmt = $this->db->prepare("SELECT pswd FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $hash_guardado = $row["pswd"];
        if (!password_verify($pswd_vieja, $hash_guardado)) {
            return ['success' => false, 'message' => 'La contraseña actual es incorrecta'];
        }
        $pswd_hash = password_hash($pswd_nueva, PASSWORD_DEFAULT);
        $stmt_update = $this->db->prepare("UPDATE usuarios SET pswd = ? WHERE email = ?");
        $stmt_update->bind_param("ss", $pswd_hash, $email);
        $stmt_update->execute();
        if ($stmt_update->affected_rows === 1) {
            return ['success' => true, 'message' => 'Contraseña actualizada'];
        } else {
            return ['success' => false, 'message' => 'Error al actualizar la contraseña'];
        }
    }

    public function existeUsuario($email) {
    $stmt = $this->db->prepare("SELECT email FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}


    public function obtenerPendientes() {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE estado = 'pendiente'");
        $stmt->execute(); 
        $result = $stmt->get_result();
        $usuariosPendientes = [];
        while ($row = $result->fetch_assoc()) {
            $usuariosPendientes[] = $row;
        }
    
        return $usuariosPendientes;
    }

    public function aceptarPendiente($email)
    {
        $stmt = $this->db->prepare("UPDATE usuarios SET estado = 'activo' WHERE email = ?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Usuario aceptado correctamente'];
        } else {
            return ['success' => false, 'error' => 'Error al aceptar usuario: ' . $stmt->error];
        }
    }

    public function obtenerRol($email)
    {
        $stmt = $this->db->prepare("SELECT rol FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return ['success' => true, 'rol' => $row['rol']];
        } else {
            return ['success' => false, 'error' => 'Usuario no encontrado'];
        }
    }

    public function obtenerAprobados()
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE estado = 'activo'");
        if (!$stmt) {
            return ['success' => false, 'error' => 'Error en prepare: ' . $this->db->error];
        }
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $usuarios = [];
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
            return ['success' => true, 'usuarios' => $usuarios];
        } else {
            return ['success' => false, 'error' => 'No se encontraron usuarios aprobados'];
        }
    }
    
   public function crearDeuda($email, $titulo, $monto)
{

    if (!$this->existeUsuario($email)) {
        return ['success' => false, 'error' => 'El usuario no existe'];
    }

    if (!is_numeric($monto)) {
        return ['success' => false, 'error' => 'Monto inválido'];
    }

    $stmt = $this->db->prepare("INSERT INTO transacciones (usuario_email, titulo, tipo, monto) VALUES (?, ?, 'deuda', ?)");
    if (!$stmt) {
        return ['success' => false, 'error' => 'Error en prepare: ' . $this->db->error];
    }
    $stmt->bind_param("ssd", $email, $titulo, $monto);

    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Deuda creada correctamente'];
    } else {
        return ['success' => false, 'error' => 'Error al crear deuda: ' . $stmt->error];
    }
}

    public function obtenerDeudas($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM transacciones WHERE usuario_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $deudas = [];
            while ($row = $result->fetch_assoc()) {
                $deudas[] = $row;
            }
            return ['success' => true, 'deudas' => $deudas];
        } else {
            return ['success' => false, 'error' => 'No se encontraron deudas para este usuario'];
        }
    }
    public function eliminarDeuda($id, $email){
        $stmt = $this->db->prepare("DELETE FROM transacciones WHERE id = ? AND usuario_email = ?");
        $stmt->bind_param("is", $id, $email); // id debe ser int, email string
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Deuda eliminada correctamente'];
        } else {
            return ['success' => false, 'error' => 'Deuda no encontrada'];
        }
    }
}
