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
            return ['success' => true, 'id' => $stmt->insert_id];
        } else {
            return ['error' => 'Error al insertar usuario: ' . $stmt->error];
        }
    }

    public function verificarCredenciales($email, $pswd)
    {
        $stmt = $this->db->prepare("SELECT id, nombre, pswd FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            if (password_verify($pswd, $usuario['pswd'])) {
                return [
                    'success' => true,
                    'id' => $usuario['id'],
                    'nombre' => $usuario['nombre']
                ];
            } else {
                return ['success' => false, 'error' => 'Contraseña incorrecta'];
            }
        } else {
            return ['success' => false, 'error' => 'Usuario no encontrado'];
        }
    }
}
