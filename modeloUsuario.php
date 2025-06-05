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
    public function cambiarUsuario($email, $pswd_vieja,$pswd_nueva)
    {
        $stmt = $this->db->prepare("SELECT pswd FROM prueba WHERE email = ?");
        $stmt ->bind_param("s",$email);
        $stmt->execute(); 
        $result = $stmt->get_result();
        $row = $result->fetch_assoc(); 
        $hash_guardado = $row["pswd"]; 
        if(!password_verify($pswd_vieja,$hash_guardado)){
            echo "La contraseña actual es incorrecta"; 
            return false; 
        }
        $pswd_hash =  password_hash($pswd_nueva,PASSWORD_DEFAULT); 
        $stmt_update = $this->db->prepare("UPDATE prueba SET pswd = ? WHERE email = ?"); 
        $stmt_update->bind_param("ss",$pswd_hash,$email); 
        $stmt_update->execute(); 
        if($stmt_update->affected_rows === 1){
            echo "Contraseña actualizada";
            return true; 
        }else{
            echo "Error grave"; 
            return false;
        }
    }
}
