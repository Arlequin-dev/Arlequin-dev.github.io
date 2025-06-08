<?php
class ModeloUsuario
{
    private $db;

    public function __construct()
    {
        $this->db = new mysqli("localhost", "root", "", "prueba");
    }

    public function insertarUsuario($nombre, $email, $pswd, $tel)
    {
        $pswdHash = password_hash($pswd, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, email, pswd, tel) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $email, $pswdHash, $tel);

        if ($stmt->execute()) {
            return ['success' => true, 'email' => $email];
        } else {
            return ['error' => 'Error al insertar usuario: ' . $stmt->error];
        }
    }

    public function verificarCredenciales($email, $pswd)
    {
        $stmt = $this->db->prepare("SELECT nombre, pswd FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
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

    public function crearDeuda($email, $monto)
    {
        $stmt = $this->db->prepare("INSERT INTO transacciones (usuario_email, tipo, monto) VALUES (?, 'deuda', ?)");
        if (!$stmt) {
            return ['success' => false, 'error' => 'Error en prepare: ' . $this->db->error];
        }
        $stmt->bind_param("sd", $email, $monto);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Deuda creada correctamente'];
        } else {
            return ['success' => false, 'error' => 'Error al crear deuda: ' . $stmt->error];
        }
    }
    public function obtenerDeudas($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM deudas WHERE email = ?");
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
}
