<?php
require_once 'api.php';

class ModeloUsuario {
    private $db;

    public function __construct() {
        $this->db = new mysqli("localhost", "root","","prueba");
    }

    public function insertarUsuario($nombre, $email, $pswd, $tel) {
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, email,pswd,tel) VALUES (?, ?,?,?)");
       $stmt->bind_param("ssss", $nombre, $email, $pswd, $tel);

        if ($stmt->execute()) {
            return ['success' => true, 'id' => $stmt->insert_id];
        } else {
            return ['error' => 'Error al insertar usuario: ' . $stmt->error];
        }
    }
}
