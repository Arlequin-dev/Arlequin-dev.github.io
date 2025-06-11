<?php
require_once 'modeloUsuario.php';

class ControladorUsuario {
    private $modelo;

    public function __construct() {
        $this->modelo = new ModeloUsuario();
    }

    public function crearUsuario($datos) {
        return $this->modelo->insertarUsuario(
            $datos['nombre'],
            $datos['rol'],      
            $datos['email'],   
            $datos['pswd'],
            $datos['tel']
        );
    }

    public function loginUsuario($datos){
        return $this->modelo->verificarCredenciales($datos['email'], $datos['pswd']);
    }

    public function cambiarUsuario($datos){
        return $this->modelo->cambiarUsuario($datos['email'], $datos['oldpswd'], $datos['newpswd']); 
    }
    public function crearDeuda($email,$titulo, $monto) {
        return $this->modelo->crearDeuda($email, $titulo,$monto);
    }
    public function obtenerDeudas($email) {
        return $this->modelo->obtenerDeudas($email);
    }
}