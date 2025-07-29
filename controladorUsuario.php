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

    public function obtenerPendientes(){
        return $this->modelo->obtenerPendientes(); 
    }

    public function aceptarPendiente($email){
        return $this->modelo->aceptarPendiente( $email); 
    }

    public function obtenerAprobados() {
        return $this->modelo->obtenerAprobados();
    }
    public function obtenerRol($email) {
        return $this->modelo->obtenerRol($email);
    }

    public function crearDeuda($email,$titulo, $monto) {
        return $this->modelo->crearDeuda($email, $titulo,$monto);
    }
    public function obtenerDeudas($email) {
        return $this->modelo->obtenerDeudas($email);
    }

    public function eliminarDeuda($id,$email){
        return $this->modelo->eliminarDeuda($id,$email); 
    }
    public function crearTarea($titulo,$email,$feclim){
        return $this->modelo->crearTarea($titulo,$email,$feclim);
    }
    public function obtenerTareas($email) {
        return $this->modelo->obtenerTareas($email);
    }
    public function completarTarea($id) {
        return $this->modelo->completarTarea($id);
    }
}