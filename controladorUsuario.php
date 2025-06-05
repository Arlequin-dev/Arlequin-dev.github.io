<?php
require_once 'modeloUsuario.php';

class ControladorUsuario {
    private $modelo;

    public function __construct() {
        $this->modelo = new ModeloUsuario();
    }

    public function crearUsuario($datos) {
        return $this->modelo->insertarUsuario($datos['nombre'], $datos['email'], $datos['pswd'], $datos["tel"]);
    }

    public function loginUsuario($datos){
        return $this->modelo->verificarCredenciales($datos['email'], $datos['pswd']);
    }

    public function cambiarUsuario($datos){
        return $this->modelo->cambiarUsuario($datos['email'], $datos['oldpswd'], $datos['newpswd']); 
    }
}